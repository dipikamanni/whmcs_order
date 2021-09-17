// Always load param first
var urlParams;
(window.onpopstate = function () {
    var match,
        pl     = /\+/g, 
        search = /([^&=]+)=?([^&]*)/g,
        decode = function (s) { return decodeURIComponent(s.replace(pl, " ")); },
        query  = window.location.search.substring(1);

    urlParams = {};
    while (match = search.exec(query))
       urlParams[decode(match[1])] = decode(match[2]);
})();

function ToSeoUrl(url) {        
  // make the url lowercase         
  var encodedUrl = url.toString().toLowerCase(); 
  // replace & with and           
  encodedUrl = encodedUrl.split(/\&+/).join("-and-");
  // remove invalid characters 
  encodedUrl = encodedUrl.split(/[^a-z0-9]/).join("-");       
  // remove duplicates 
  encodedUrl = encodedUrl.split(/-+/).join("-");
  // trim leading & trailing characters 
  encodedUrl = encodedUrl.trim('-');
  return encodedUrl; 
}

// Global vars for selections
var currentData = {
    'price' : 61,
    'location' : false,
    'controlPanel' : false,
    'operatingSystem' : false,
    'cpanel' : false,
    'backupPlan' : false,
    'value-ram-select' : false,
    'value-storage-select' : false,
    'value-core-select' : false,
    'value-ram' : false,
    'value-storage' : false,
    'value-core' : false,
    'IPv4_additional' : false,
    'IPv6_additional' : false

};
var currentPricing = {
    'monthly' : {},
    'quarterly' : {},
    'semiannually' : {},
    'annually' : {},
}
var currentBillingCycle = 'monthly';
var currency_code = localStorage.getItem('country');
var currency_symbol = localStorage.getItem('currency');
var price_hidden_input = '';

function calculateTotalPricing() {
    console.log('%cBilling Cycle: ' + currentBillingCycle, 'background: #000; color: #ff0000');
    for (var key in currentData) {
        if (currentData.hasOwnProperty(key)) {
            //console.log(key + " -> " + currentData[key]);

            if( currentData[key] != false ) {
                if( $('[name="'+key+'"]').is("input") ) {
                    $('[name="'+key+'"]').each(function(i, obj) {
                        if( $(this).val() == currentData[key] ){
                            Object.assign(currentPricing.monthly, {[key]: $(this).attr('data-monthly')});
                            Object.assign(currentPricing.quarterly, {[key]: $(this).attr('data-quarterly')});
                            Object.assign(currentPricing.semiannually, {[key]: $(this).attr('data-semiannually')});
                            Object.assign(currentPricing.annually, {[key]: $(this).attr('data-annually')});
                        }
                    });
                } else if( $('[name="'+key+'"]').is("select") ) {
                    $('[name="'+key+'"] option').each(function(i, obj) {
                        if( $(this).val() == currentData[key] ){
                            Object.assign(currentPricing.monthly, {[key]: $(this).attr('data-monthly')});
                            Object.assign(currentPricing.quarterly, {[key]: $(this).attr('data-quarterly')});
                            Object.assign(currentPricing.semiannually, {[key]: $(this).attr('data-semiannually')});
                            Object.assign(currentPricing.annually, {[key]: $(this).attr('data-annually')});
                        }
                    });
                }
            }
        }
    }

    for (var cycle in currentPricing) {
        if (currentPricing.hasOwnProperty(cycle)) {
            // cycle!
            var total = 0;
            for (var key in currentPricing[cycle]) {
                if (currentPricing[cycle].hasOwnProperty(key)) {
                    if (typeof currentPricing[cycle][key] !== 'undefined' && key != 'total') {
                        total = total + parseFloat(currentPricing[cycle][key]);
                        
                    }
                }
            }

            Object.assign(currentPricing[cycle], { 'total': total.toFixed(2) });
        }
    }
    $('.amount_product_update').text(currency_symbol+currentPricing.monthly.total);
    console.log(currentPricing);
}

$(document).ready(function(){
    $("#second-process-continue-button").click(function(event){
        calculateTotalPricing();
        $('#subscription_duration_1').parent().find('.location-block .inner-heading').text(currency_symbol+currentPricing.monthly.total+' Monthly');
        $('#subscription_duration_2').parent().find('.location-block .inner-heading').text(currency_symbol+currentPricing.quarterly.total+' Quarterly');
        $('#subscription_duration_3').parent().find('.location-block .inner-heading').text(currency_symbol+currentPricing.semiannually.total+' Semi Annually');
        $('#subscription_duration_4').parent().find('.location-block .inner-heading').text(currency_symbol+currentPricing.annually.total+' Annually');
        $('#subscription_duration_1').trigger('click');
    });
    $("#login-button").click(function(event){
        ValidateLogin();
    });
    $('#register-button').click(function(event){
        AddClient();
    });
    
    // Main API call
    GetProducts();

});
// --------------DEFINING ALL FUNCTIONS---------------- 

    // Sidebar_funtion
function sidebar_update_function(select_input_name,billing_cycle="monthly"){
    // Total Price
    var product_price = $('.amount_product').text();
    product_price = product_price.split(currency_symbol);
    product_price = product_price[1];

    if(select_input_name == 'location'){
        var name_location = $('input[name=location]:checked').attr('data-locaname');
        $('.location-api').text(name_location);
        var name_location_country = $('input[name=location]:checked').attr('data-countryname');
        $('.location-country').text(name_location_country);

        currentData.location = $('input[name=location]:checked').val();
        calculateTotalPricing();

    }else if( select_input_name == 'cpanel'){
        var name_cp = $('select[name=cpanel]').children('option:selected').attr('data-name');
        $('.cp_name').text(name_cp);
        var price_cp = $('select[name=cpanel]').children('option:selected').attr('data-'+billing_cycle);
        $('.cp_price').text(currency_symbol+price_cp);      
        $('#controlPanel_final').val(price_cp);

        currentData.cpanel = $('select[name=cpanel]').children('option:selected').val();
        calculateTotalPricing();
    }
    else if( select_input_name == 'controlPanel'){
        var special_cpanel_count = $('input[name=controlPanel]:checked').parent().children('.location-block').children('.img-location').children('.select-cpanel-cat').length;
        if(special_cpanel_count == 1){
            var name_cp = $('select[name=cpanel]').children('option:selected').attr('data-name');
            $('.cp_name').text(name_cp);
            var price_cp = $('select[name=cpanel]').children('option:selected').attr('data-'+billing_cycle);
            $('.cp_price').text(currency_symbol+price_cp);      
            $('#controlPanel_final').val(price_cp);
            currentData.cpanel = $('select[name=cpanel]').children('option:selected').val();
            calculateTotalPricing();
        }else{
            $('.select-cpanel-cat select').hide();
            var name_cp = $('input[name=controlPanel]:checked').attr('data-name');
            $('.cp_name').text(name_cp);
            var price_cp = $('input[name=controlPanel]:checked').attr('data-'+billing_cycle);
            $('.cp_price').text(currency_symbol+price_cp);      
            $('#controlPanel_final').val(price_cp);
            currentData.controlPanel = $('input[name=controlPanel]:checked').val();
            calculateTotalPricing();
        }
    }
    else if(select_input_name == 'operatingSystem_centos' || select_input_name == 'operatingSystem_ubuntu' || select_input_name == 'operatingSystem_debian' || select_input_name == 'operatingSystem_fedora' || select_input_name == 'operatingSystem_webuzo' || select_input_name == 'operatingSystem_windows'){            
        var name_OS = $('select[name='+select_input_name+']').children('option:selected').attr('data-nameos');
        var price_OS = $('select[name='+select_input_name+']').children('option:selected').attr('data-'+billing_cycle);
        var config_OS = $('select[name='+select_input_name+']').children('option:selected').attr('data-config');
        var val_OS = $('select[name='+select_input_name+']').children('option:selected').val();
        $('.OS_name').text(name_OS);
        $('.OS_price').text(currency_symbol+price_OS);
        $('#operatingSystem_final').val(price_OS);
        $('#operatingSystem_final').attr('data-config',config_OS); 
        $('#operatingSystem_final').attr('data-id',val_OS); 

        currentData.operatingSystem = select_input_name;
        Object.assign(currentData, {[select_input_name]: val_OS});
        calculateTotalPricing();
    }
    else if(select_input_name == 'backupPlan'){            
        var name_cp = $('input[name=backupPlan]:checked').attr('data-name');
        $('.bp_name').text(name_cp);
        var price_cp = $('input[name=backupPlan]:checked').attr('data-'+billing_cycle);
        $('.bp_price').text(currency_symbol+price_cp);
        var product_price_static = $('.amount_product').text();
        $('#backupPlan_final').val(price_cp);

        currentData.backupPlan = $('input[name=backupPlan]:checked').val();
        calculateTotalPricing();
    }
    else if(select_input_name == 'value-core-select'){       
        var name_cp = $('select[name='+select_input_name+']').children('option:selected').attr('data-monthly');
        var price_as = name_cp;
        price_as = price_as;
        var vcs = $('select[name='+select_input_name+']').children('option:selected').val();
        name_cp = '2.39 x '+vcs+' = '+price_as;
        $('.AC_name').text(name_cp);
        $('.AC_price').text(currency_symbol+price_as);
        $('.AC_price').parent().parent().show();
        $("input[name=value-core]").val(vcs);
        $("#core_final").val(price_as);

        Object.assign(currentData, {[select_input_name]: vcs});
        calculateTotalPricing();
    }
    else if(select_input_name == 'value-storage-select'){
        var name_cp = $('select[name='+select_input_name+']').children('option:selected').attr('data-monthly');
        var price_as = name_cp;
        price_as = price_as;
        var vcs = $('select[name='+select_input_name+']').children('option:selected').val();
        name_cp = '0.17 x '+vcs+' = '+price_as;
        $('.AS_name').text(name_cp);
        $('.AS_price').text(currency_symbol+price_as);
        $('.AS_price').parent().parent().show();
        $("input[name=value-storage]").val(vcs);

        Object.assign(currentData, {[select_input_name]: vcs});
        calculateTotalPricing();
    }
    else if(select_input_name == 'value-ram-select'){
        var name_cp = $('select[name='+select_input_name+']').children('option:selected').attr('data-monthly');
        var name_cp = $('select[name='+select_input_name+']').children('option:selected').attr('data-name');
        $('.AR_name').text(name_cp);
        var price_cp = $('select[name='+select_input_name+']').children('option:selected').attr('data-'+billing_cycle);
        var config_RAM = $('select[name='+select_input_name+']').children('option:selected').attr('data-config');
        var val_RAM = $('select[name='+select_input_name+']').children('option:selected').attr('data-id');
        $('.AR_price').text(currency_symbol+price_cp);
        $('.AR_price').parent().parent().show();
        $('#ram_final').val(price_cp);
        $('#ram_final').attr('data-config',config_RAM); 
        $('#ram_final').attr('data-id',val_RAM); 

        var vcs = $('select[name='+select_input_name+']').children('option:selected').val();
        Object.assign(currentData, {[select_input_name]: vcs});
        calculateTotalPricing();
    }
    else if(select_input_name == 'value-ram'){   
        var name_cp = $('input[name=value-ram]').attr('data-name');
        $('.AR_name').text(name_cp);
        var price_cp = $('input[name=value-ram]').attr('data-'+billing_cycle);
        var config_RAM = $('input[name=value-ram]').attr('data-config');
        var val_RAM = $('input[name=value-ram]').attr('data-id');
        $('.AR_price').text(currency_symbol+price_cp);
        $('.AR_price').parent().parent().show();
        $('#ram_final').val(price_cp);
        $('#ram_final').attr('data-config',config_RAM); 
        $('#ram_final').attr('data-id',val_RAM); 

        $('input[name=value-ram]').val(select_input_name);
        Object.assign(currentData, {[select_input_name]: select_input_name});
        calculateTotalPricing();
    }
    else if(select_input_name == 'value-storage'){   
        var name_cp = $('input[name=value-storage]').val();
        var price_as = 0.17 * $('input[name=value-storage]').val();
        price_as = price_as.toFixed(2);
        name_cp = '0.17 x '+name_cp+' = '+price_as;
        $('#storage_final').val(price_as);
        $('.AS_name').text(name_cp);
        $('.AS_price').text(currency_symbol+price_as);
        $('.AS_price').parent().parent().show();

        $('input[name=value-storage]').val(select_input_name);
        Object.assign(currentData, {[select_input_name]: select_input_name});
        calculateTotalPricing();
    }
    else if(select_input_name == 'value-core'){   
        var name_cp = $('input[name=value-core]').val();
        var price_as = 2.39 * $('input[name=value-core]').val();
        price_as = price_as.toFixed(2);
        name_cp = '2.39 x '+name_cp+' = '+price_as;
        $('.AC_name').text(name_cp);
        $('.AC_price').text(currency_symbol+price_as);
        $('.AC_price').parent().parent().show();
        $("#core_final").val(price_as);

        $('input[name=value-core]').val(select_input_name);
        Object.assign(currentData, {[select_input_name]: select_input_name});
        calculateTotalPricing();
    }
    else if(select_input_name == 'IPv4_additional'){   
        var name_cp = $('input[name=IPv4_additional]:checked').attr('data-name');
        $('.AIP4_name').text(name_cp);
        var price_cp = $('input[name=IPv4_additional]:checked').attr('data-'+billing_cycle);
        $('.AIP4_price').text(currency_symbol+price_cp);
        $('.AIP4_price').parent().parent().show();
        $('#IPv4_final').val(price_cp);  

        Object.assign(currentData, {[select_input_name]: $('input[name=IPv4_additional]:checked').val()});
        calculateTotalPricing();
    }
    else if(select_input_name == 'IPv6_additional'){   
        var name_cp = $('input[name=IPv6_additional]:checked').attr('data-name');
        $('.AIP6_name').text(name_cp);
        var price_cp = $('input[name=IPv6_additional]:checked').attr('data-'+billing_cycle);
        $('.AIP6_price').text(currency_symbol+price_cp);
        $('.AIP6_price').parent().parent().show();
        $('#IPv6_final').val(price_cp);  

        Object.assign(currentData, {[select_input_name]: $('input[name=IPv6_additional]:checked').val()});
        calculateTotalPricing();
    }
    else if(select_input_name == 'subscription_duration'){
        var cycle = $('input[name=subscription_duration]:checked').attr('data-billingcycle');
        calculateTotalPricing();

        $('.amount_product_static').text(currency_symbol+currentPricing[cycle].price);
        if(currency_symbol+currentPricing[cycle].controlPanel != currency_symbol+'undefined'){
            $('.cp_price').text(currency_symbol+currentPricing[cycle].controlPanel);
        }
        if(currency_symbol+currentPricing[cycle].cpanel != currency_symbol+'undefined'){
            $('.cp_price').text(currency_symbol+currentPricing[cycle].cpanel);
        }
        var storage_amount_now = currentPricing[cycle]['value-storage'];
        storage_amount_now = parseFloat(storage_amount_now).toFixed(2);
        
        var core_amount_now = currentPricing[cycle]['value-core'];
        core_amount_now = parseFloat(core_amount_now).toFixed(2);
        
        $('.text-cycle').text('pay '+cycle);
        $('.bp_price').text(currency_symbol+currentPricing[cycle].backupPlan);
        
        $('.AR_price').text(currency_symbol+currentPricing[cycle]['value-ram']);
        $('.AS_price').text(currency_symbol+storage_amount_now);
        $('.AC_price').text(currency_symbol+core_amount_now);
        // mobile
        if ($(window).width() <= 500){
            var core_amount_now_mobile = currentPricing[cycle]['value-core-select'];
            core_amount_now_mobile = parseFloat(core_amount_now_mobile).toFixed(2);
            $('.AR_price').text(currency_symbol+currentPricing[cycle]['value-ram-select']);
            $('.AS_price').text(currency_symbol+currentPricing[cycle]['value-storage-select']);
            $('.AC_price').text(currency_symbol+core_amount_now_mobile);
        }
        
        $('.AIP4_price').text(currency_symbol+currentPricing[cycle].IPv4_additional);
        $('.AIP6_price').text(currency_symbol+currentPricing[cycle].IPv6_additional);
        $('.amount_product_update').text(currency_symbol+currentPricing[cycle].total);
    }
    // On billing sub click get the 
    
    var c_p_price = $('#controlPanel_final').val();
    var o_s_price = $('#operatingSystem_final').val();
    var bk_p_price = $('#backupPlan_final').val();
    var ram_price = $('#ram_final').val();
    var storage_price = $('#storage_final').val();
    var core_price = $('#core_final').val();
    var ipv4_price = $('#IPv4_final').val();
    var ipv5_price = $('#IPv6_final').val();

    var static_product_price = $('.amount_product_static').text();
    static_product_price = static_product_price.split(currency_symbol);
    static_product_price = static_product_price[1];

    var total_price = parseFloat(static_product_price) + parseFloat(c_p_price) + parseFloat(o_s_price) + parseFloat(bk_p_price) + parseFloat(ram_price) + parseFloat(storage_price) + parseFloat(core_price) + parseFloat(ipv4_price) + parseFloat(ipv5_price);
    
    total_price = total_price.toFixed(2);
    // $('.amount_product_update').text(currency_symbol+total_price);
    
}
function GetProducts(){
    var gid = 4;
    $.ajax({
        url:"https://hostworld.uk/order/api/index.php",
        type:"POST",
        dataType:"JSON",
        data:{action:"GetProducts", gid: gid},
        success:function(response) {
            var product_array = response.products.product;
            // Remove custom product
            product_array.splice(1,1);
            product_array = product_array.slice(0, 7);
            $.each(product_array, function( index, value ) {
                var single_product =  product_array[index] ;
                var product_ID = single_product.pid;

                var product_name = single_product.name;
                var product_description = single_product.description;
                window.prefix = single_product.pricing[currency_code].prefix;
                window.suffix = single_product.pricing[currency_code].suffix;
                var product_description = product_description.replace("\n", "<br/>");
                product_description = product_description.replace(")", ")<br/>");
                product_description = product_description.replace("</em>", "</em><br/>");
                var product_pricing = single_product.pricing;
                var product_pricing_full = single_product.pricing;
                var product_pricing = product_pricing[currency_code].monthly;

                // OPTIONS
                window.productID = product_ID;

                var label_content = `<li class="splide__slide" style="width:340px;margin: 20px;">
                                        <label for="`+product_ID+`" data-product-id="`+product_ID+`">
                                            <input type="radio" name="price" id="`+product_ID+`" value="`+product_ID+`" data-monthly="`+product_pricing_full[currency_code].monthly+`" data-quarterly="`+product_pricing_full[currency_code].quarterly+`" data-semiannually="`+product_pricing_full[currency_code].semiannually+`" data-annually="`+product_pricing_full[currency_code].annually+`" style="display: none;">
                                            <div class="inner-first-slide">
                                                <p class="header-para-slides">`+product_name+`</p>
                                                <h3>`+prefix + product_pricing+`<span>/month</span></h3>
                                                <hr class="white-hr" />
                                                <div class="product-features">
                                                    <p class="product_description">`+product_description+`</p>
                                                </div>
                                                <span class="hide-plan-details">Select Plan</span>
                                            </div>
                                        </label>
                                    </li>`;
                $('.splide__list').append(label_content);
            });

            new Splide( '.splide', {
                // type     : 'loop',
                autoWidth: true,
                focus    : 'center',
            } ).mount();

            setTimeout(function(){

            // Select default product before loader is hidden
            if("pid" in urlParams) {
                // pid is available
                var defaultPID = parseInt(urlParams['pid']);
                jQuery('label[data-product-id='+defaultPID+'] input').attr('checked', true);
                jQuery('label[data-product-id='+defaultPID+'] input').trigger('click');
                currentData.price = defaultPID;
            }else{
                // On load click first plan
                jQuery('label[data-product-id='+currentData.price+'] input').attr('checked', true);
                jQuery('label[data-product-id='+currentData.price+'] input').trigger('click');
            }
    
            setTimeout(function(){
                jQuery(".loader").fadeOut("slow");
                jQuery("#overlayer").fadeOut("slow");
                    setTimeout(function() {
                        jQuery("body").removeClass('body-preloader');
                }, 1000);
            }, 500);
    
            jQuery('#call_promo_api').click(function(event){
                VerifyPromo();
            });
    
        }, 500);
    }
    });
}
$('body').on('click','input[name=price]', function(){
    $('.main-slider').fadeOut(500);
    setTimeout(function(){
        $('.selected_plan').fadeIn(500);   
        $('#location-section-wrap').text('');
        $('#controlPanel-section-wrap').text('');
        $('#specifications-data').text('');
        $('select[name=operatingSystem_windows]').text('');
        $('select[name=operatingSystem_webuzo]').text('');
        $('select[name=operatingSystem_fedora]').text('');
        $('select[name=operatingSystem_debian]').text('');
        $('select[name=operatingSystem_ubuntu]').text('');
        $('select[name=operatingSystem_centos]').text('');
        $('#backupPlan').text('');
        $('#IPv4_content').text('');
        $('#IPv6_content').text('');
        $('#pricing_time').text('');      
    }, 100);
    // Product Options
    var product_id = $('input[name=price]:checked').val();
    
    currentData.price = product_id;
    calculateTotalPricing();
    
    // Ajax call for options
    $.ajax({
        url:"https://hostworld.uk/order/api/index.php",
        type:"POST",
        dataType:"JSON",
        data:{action:"GetProducts", pid: product_id},
        success:function(response) {
            var all_options = response[0].configoptions.configoption;
            // Options Setup
            $.each(all_options, function( index, value ) {
                var single_option = all_options[index];
                if(single_option.name == 'Location'){
                    var location_option_id = single_option.id;
                    var inner_options = single_option.options.option;
                    $.each(inner_options, function( index, value ) {
                        var inner_loop_location_option = inner_options[index];
                        var ID = inner_loop_location_option.id;
                        var name = inner_loop_location_option.name;
                        var name = name.split(', ');
                        var option_heading = name[1];
                        var option_sub_heading = name[0];
                        var option_image = ToSeoUrl(option_sub_heading);                        
                        var monthly_price = inner_loop_location_option.pricing[currency_code].monthly;
                        var quarterly_price = inner_loop_location_option.pricing[currency_code].quarterly;
                        var semiannually_price = inner_loop_location_option.pricing[currency_code].semiannually;
                        var annually_price = inner_loop_location_option.pricing[currency_code].annually;
                        var location_html_content = `<label for="`+ID+`">
                                                        <input type="radio" name="location" id="`+ID+`" value="`+ID+`" data-config="`+single_option.id+`" data-locaName="`+option_heading+`" data-countryName="`+option_sub_heading+`" data-monthly="`+monthly_price+`" data-quarterly="`+quarterly_price+`" data-semiannually="`+semiannually_price+`" data-annually="`+annually_price+`" style="display: none;">
                                                        <div class="location-block">
                                                            <div class="img-location">
                                                                <div class="image-section-loc">
                                                                    <img src="images/`+option_image+`.jpg">
                                                                </div>
                                                                <div class="location-name">
                                                                    <h5 class="inner-heading">`+option_heading+`</h5>
                                                                    <p>`+option_sub_heading+`</p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </label>`;
                        $("#location-section-wrap").append(location_html_content);                      
                    });                 
                }else if(single_option.name == 'Control Panel'){                    
                    var location_option_id = single_option.id;
                    var inner_options = single_option.options.option;
                    $.each(inner_options, function( index, value ) {
                        var inner_loop_location_option = inner_options[index];
                        var ID = inner_loop_location_option.id;
                        var name = inner_loop_location_option.name;
                        var option_image = ToSeoUrl(name);
                        var monthly_price = inner_loop_location_option.pricing[currency_code].monthly;
                        var quarterly_price = inner_loop_location_option.pricing[currency_code].quarterly;
                        var semiannually_price = inner_loop_location_option.pricing[currency_code].semiannually;
                        var annually_price = inner_loop_location_option.pricing[currency_code].annually;
                        var controlPanel_html_content = `<label for="`+ID+`">
                                                            <input type="radio" name="controlPanel" id="`+ID+`" value="`+ID+`" data-config="`+single_option.id+`" data-name="`+name+`" data-monthly="`+monthly_price+`" data-quarterly="`+quarterly_price+`" data-semiannually="`+semiannually_price+`" data-annually="`+annually_price+`" style="display: none;">
                                                            <div class="location-block">
                                                                <div class="img-location">
                                                                    <div class="image-section-loc">
                                                                        <img src="images/`+option_image+`.png">
                                                                    </div>
                                                                    <div class="location-name">
                                                                        <h5 class="inner-heading">`+name+`</h5>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </label>`;
                        var controlPanel_html_content_none = `<label for="`+ID+`">
                                                            <input type="radio" name="controlPanel" id="`+ID+`" value="`+ID+`" data-config="`+single_option.id+`" data-name="`+name+`" data-monthly="`+monthly_price+`" data-quarterly="`+quarterly_price+`" data-semiannually="`+semiannually_price+`" data-annually="`+annually_price+`" style="display: none;">
                                                            <div class="location-block">
                                                                <div class="img-location">
                                                                    <div class="location-name">
                                                                        <h5 class="inner-heading">`+name+`</h5>
                                                                    </div>
                                                                </div>
                                                            </div>`;
                        if(name== 'None'){
                            $("#controlPanel-section-wrap").append(controlPanel_html_content_none);
                        }else if(name.includes("cPanel")){
                            if($('.cpanel_label').length == 0){
                                var select_box_cpanel = `<label for="cp_none" class="cpanel_label">
                                                            <input type="radio" name="controlPanel" id="cp_none" value="cp_none"  style="display: none;">
                                                            <div class="location-block">
                                                                <div class="img-location">
                                                                    <div class="image-section-loc">
                                                                        <img src="images/cpanel-solo-1-account-.png">
                                                                    </div>
                                                                    <div class="location-name">
                                                                        <h5 class="inner-heading">cPanel</h5>
                                                                    </div>
                                                                    <div class="select-cpanel-cat" id="cpanel">
                                                                        <select name="cpanel">
                                                                            
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </label>`;
                                $("#controlPanel-section-wrap").append(select_box_cpanel);
                            }
                            var cpanel_select_box = `<option value="`+ID+`" data-config="`+single_option.id+`" data-name="`+name+`" data-monthly="`+monthly_price+`" data-quarterly="`+quarterly_price+`" data-semiannually="`+semiannually_price+`" data-annually="`+annually_price+`">`+name+`</option>`;
                            $("#cPanel select").append(cpanel_select_box);
                        }
                        else{
                            $("#controlPanel-section-wrap").append(controlPanel_html_content);
                        }                   
                        
                    });                 
                }else if(single_option.name == 'Operating System'){
                    var location_option_id = single_option.id;
                    var inner_options = single_option.options.option;
                    $.each(inner_options, function( index, value ) {
                        var inner_loop_location_option = inner_options[index];
                        var ID = inner_loop_location_option.id;
                        var name = inner_loop_location_option.name;
                        var result_image = name.split(' ');
                        var option_image = ToSeoUrl(result_image[0]);
                        var monthly_price = inner_loop_location_option.pricing[currency_code].monthly;
                        var quarterly_price = inner_loop_location_option.pricing[currency_code].quarterly;
                        var semiannually_price = inner_loop_location_option.pricing[currency_code].semiannually;
                        var annually_price = inner_loop_location_option.pricing[currency_code].annually;

                        if(option_image == 'centos'){
                            var centos_content_select_box = `<option value="`+ID+`" data-config="`+single_option.id+`" data-nameOS="`+name+`" data-monthly="`+monthly_price+`" data-quarterly="`+quarterly_price+`" data-semiannually="`+semiannually_price+`" data-annually="`+annually_price+`">`+name+`</option>`;
                            $("#centos select").append(centos_content_select_box);
                        }else if(option_image == 'ubuntu'){
                            var ubuntu_content_select_box = `<option value="`+ID+`" data-config="`+single_option.id+`" data-nameOS="`+name+`" data-monthly="`+monthly_price+`" data-quarterly="`+quarterly_price+`" data-semiannually="`+semiannually_price+`" data-annually="`+annually_price+`">`+name+`</option>`;
                            $("#ubuntu select").append(ubuntu_content_select_box);
                        }else if(option_image == 'debian'){
                            var debian_content_select_box = `<option value="`+ID+`" data-config="`+single_option.id+`" data-nameOS="`+name+`" data-monthly="`+monthly_price+`" data-quarterly="`+quarterly_price+`" data-semiannually="`+semiannually_price+`" data-annually="`+annually_price+`">`+name+`</option>`;
                            $("#debian select").append(debian_content_select_box);
                        }else if(option_image == 'fedora'){
                            var fedora_content_select_box = `<option value="`+ID+`" data-config="`+single_option.id+`" data-nameOS="`+name+`" data-monthly="`+monthly_price+`" data-quarterly="`+quarterly_price+`" data-semiannually="`+semiannually_price+`" data-annually="`+annually_price+`">`+name+`</option>`;
                            $("#fedora select").append(fedora_content_select_box);
                        }else if(option_image == 'webuzo'){
                            var webuzo_content_select_box = `<option value="`+ID+`" data-config="`+single_option.id+`" data-nameOS="`+name+`" data-monthly="`+monthly_price+`" data-quarterly="`+quarterly_price+`" data-semiannually="`+semiannually_price+`" data-annually="`+annually_price+`">`+name+`</option>`;
                            $("#webuzo select").append(webuzo_content_select_box);
                        }else if(option_image == 'windows'){
                            var windows_content_select_box = `<option value="`+ID+`" data-config="`+single_option.id+`" data-nameOS="`+name+`" data-monthly="`+monthly_price+`" data-quarterly="`+quarterly_price+`" data-semiannually="`+semiannually_price+`" data-annually="`+annually_price+`">`+name+`</option>`;
                            $("#windows select").append(windows_content_select_box);
                        }               
                        
                    });                 
                }else if(single_option.name == 'Your Backup Plan'){
                    var backup_plan_option_id = single_option.id;
                    var inner_options = single_option.options.option;
                    $.each(inner_options, function( index, value ) {
                        var inner_loop_backup_option = inner_options[index];
                        var monthly_price = inner_loop_backup_option.pricing[currency_code].monthly;
                        var quarterly_price = inner_loop_backup_option.pricing[currency_code].quarterly;
                        var semiannually_price = inner_loop_backup_option.pricing[currency_code].semiannually;
                        var annually_price = inner_loop_backup_option.pricing[currency_code].annually;
                        if(inner_loop_backup_option.name.includes("Included") && monthly_price == 0.00){
                            var backup_content = `<label for="`+inner_loop_backup_option.id+`" class="active-now without-after-element">
                                                    <input type="radio" name="backupPlan" data-config="`+single_option.id+`" checked="checked" id="`+inner_loop_backup_option.id+`" data-name="`+inner_loop_backup_option.name+`" data-monthly="`+monthly_price+`" data-quarterly="`+quarterly_price+`" data-semiannually="`+semiannually_price+`" data-annually="`+annually_price+`" value="`+inner_loop_backup_option.id+`" style="display: none;">
                                                    <div class="location-block">
                                                        <div class="img-location">                              
                                                            <div class="location-name">
                                                                <h5 class="inner-heading">`+inner_loop_backup_option.name+`</h5>
                                                            </div>
                                                        </div>                                  
                                                    </div>
                                                </label>`;
                            $('.bp_name').text(inner_loop_backup_option.name);
                            $('.bp_name').css("visibility", "hidden");
                        }else{
                            var backup_content = `<label for="`+inner_loop_backup_option.id+`">
                                                    <input type="radio" name="backupPlan" data-config="`+single_option.id+`" id="`+inner_loop_backup_option.id+`" data-name="`+inner_loop_backup_option.name+`" data-monthly="`+monthly_price+`" data-quarterly="`+quarterly_price+`" data-semiannually="`+semiannually_price+`" data-annually="`+annually_price+`" value="`+inner_loop_backup_option.id+`" style="display: none;">
                                                    <div class="location-block">
                                                        <div class="img-location">                              
                                                            <div class="location-name">
                                                                <h5 class="inner-heading">`+inner_loop_backup_option.name+`</h5>
                                                            </div>
                                                        </div>                                  
                                                    </div>
                                                </label>`;
                        }
                        $('#backupPlan').append(backup_content);
                    });
                }else if(single_option.name == 'Additional RAM'){
                    var add_ram_plan_option_id = single_option.id;
                    var inner_options = single_option.options.option;
                    var doubleLabelsRAM = [];
                    $.each(inner_options, function( index, value ) {
                        var inner_loop_add_ram_option = inner_options[index];
                        var id = inner_loop_add_ram_option.id;
                        var monthly_price = inner_loop_add_ram_option.pricing[currency_code].monthly;
                        var quarterly_price = inner_loop_add_ram_option.pricing[currency_code].quarterly;
                        var semiannually_price = inner_loop_add_ram_option.pricing[currency_code].semiannually;
                        var annually_price = inner_loop_add_ram_option.pricing[currency_code].annually;
                        var mb_ram = inner_loop_add_ram_option.name;
                        var add_ram_content = `<option data-config="`+single_option.id+`" data-id="`+id+`" data-monthly="`+monthly_price+`" data-quarterly="`+quarterly_price+`" data-semiannually="`+semiannually_price+`" data-annually="`+annually_price+`" value="`+inner_loop_add_ram_option.id+`">
                                                    `+inner_loop_add_ram_option.name+` - `+currency_symbol+monthly_price+`
                                                </option>`;
                        $('#value-ram-mobile').append(add_ram_content);
                        doubleLabelsRAM.push(`<i>`+currency_symbol+monthly_price+`</i><span data-config="`+single_option.id+`" data-id="`+id+`" data-monthly="`+monthly_price+`" data-quarterly="`+quarterly_price+`" data-semiannually="`+semiannually_price+`" data-annually="`+annually_price+`">`+mb_ram+`</span>`);                        
                    });
                    $("#double-label-slider-ram").slider({
                            max: 7,
                            min: 0,
                            value: 0,
                            animate: 400,
                            slide: function(event, ui) {
                                var value = ui.value;
                                var RAM = $('#double-label-slider-ram [data-value="'+value+'"] span').text();
                                var price = $('#double-label-slider-ram [data-value="'+value+'"] i').text();
                                var monthly_price = $('#double-label-slider-ram [data-value="'+value+'"] span').attr('data-monthly');
                                var quarterly_price = $('#double-label-slider-ram [data-value="'+value+'"] span').attr('data-quarterly');
                                var semiannually_price = $('#double-label-slider-ram [data-value="'+value+'"] span').attr('data-semiannually');
                                var annually_price = $('#double-label-slider-ram [data-value="'+value+'"] span').attr('data-annually');
                                var config_id_ram = $('#double-label-slider-ram [data-value="'+value+'"] span').attr('data-config');
                                var config_id = $('#double-label-slider-ram [data-value="'+value+'"] span').attr('data-id');

                                $("input[name=value-ram]").val(RAM);
                                $("input[name=value-ram]").attr('data-name',RAM);
                                $("input[name=value-ram]").attr('data-monthly',monthly_price);
                                $("input[name=value-ram]").attr('data-quarterly',quarterly_price);
                                $("input[name=value-ram]").attr('data-semiannually',semiannually_price);
                                $("input[name=value-ram]").attr('data-annually',annually_price);
                                $("input[name=value-ram]").attr('data-config',config_id_ram);
                                $("input[name=value-ram]").attr('data-id',config_id);
                                sidebar_update_function('value-ram');
                            }
                        }).slider("pips", {
                            rest: "label",
                            labels: doubleLabelsRAM                 
                    });
                    /* init input */
                    var value = $("#double-label-slider-ram").slider("values", 0);
                    $("[name=value-ram]").val(value);
                }else if(single_option.name == 'Additional Storage (GB)'){
                    var add_storage_plan_option_id = single_option.id;
                    var inner_options = single_option.options.option;
                    var doubleLabelsStorage = [];
                    $.each(inner_options, function( index, value ) {
                        var inner_loop_add_storage_option = inner_options[index];
                        var id = inner_loop_add_storage_option.id;
                        var amount = inner_loop_add_storage_option.pricing[currency_code].monthly;
                        var quarterly_price = inner_loop_add_storage_option.pricing[currency_code].quarterly;
                        var semiannually_price = inner_loop_add_storage_option.pricing[currency_code].semiannually;
                        var annually_price = inner_loop_add_storage_option.pricing[currency_code].annually;
                        var mb_storage = inner_loop_add_storage_option.name;
                        var i;
                        for (i = 0; i <= 200; ++i) {
                            var repeat_number = i;
                            var amount_final = amount*repeat_number;
                            amount_final = amount_final.toFixed(2);
                            quarterly_price_final = quarterly_price * repeat_number;
                            semiannually_price_final = semiannually_price * repeat_number;
                            annually_price_final = annually_price * repeat_number;
                            var add_storage_content = `<option data-config="`+id+`" id="`+i+`" data-monthly="`+amount_final+`" data-quarterly="`+quarterly_price_final+`" data-semiannually="`+semiannually_price_final+`" data-annually="`+annually_price_final+`" value="`+i+`">
                                                    `+repeat_number+` - `+currency_symbol+amount_final+`
                                                </option>`;
                            $('#value-storage-mobile').append(add_storage_content);
                        }
                        for (i = 0; i <= 200; ++i) {
                            var repeat_number = i;
                            var amount = 0.17*repeat_number;
                            amount = amount.toFixed(2);
                            doubleLabelsStorage.push(`<i></i><span class="mb_storage" data-config="`+single_option.id+`" data-id="`+id+`" data-monthly="`+amount+`" data-quarterly="`+quarterly_price+`" data-semiannually="`+semiannually_price+`" data-annually="`+annually_price+`">`+mb_storage+repeat_number+`</span>`);
                        }
                    });
                    $("#double-label-slider-storage").slider({
                        max: 200,
                        min: 0,
                        value: 0,
                        animate: 400,
                        slide: function(event, ui) {
                            var value = ui.value;
                            amount = 0.17;
                            storage_amount = amount * value;
                            storage_amount = storage_amount.toFixed(2);
                            var quarterly_price = $('span.mb_storage').attr('data-quarterly');
                            var semiannually_price = $('span.mb_storage').attr('data-semiannually');
                            var annually_price = $('span.mb_storage').attr('data-annually');
                            var config_id_storage = $('span.mb_storage').attr('data-config');
                            var config_id = $('span.mb_storage').attr('data-id');
                            
                            $("input[name=value-storage]").val(value);
                            $("input[name=value-storage]").attr('data-name',value);
                            $("input[name=value-storage]").attr('data-monthly',amount*value);
                            $("input[name=value-storage]").attr('data-quarterly',quarterly_price*value);
                            $("input[name=value-storage]").attr('data-semiannually',semiannually_price*value);
                            $("input[name=value-storage]").attr('data-annually',annually_price*value);
                            $("input[name=value-storage]").attr('data-config',config_id_storage);
                            $("input[name=value-storage]").attr('data-id',config_id);
                            sidebar_update_function('value-storage');
                        }
                    }).slider("pips", {
                        rest: "label",
                        labels: doubleLabelsStorage                 
                    });
                    /* init input */
                    var value = $("#double-label-slider-storage").slider("values", 0);
                    $("[name=value-storage]").val(value);
                    // Double Label Storage Range slider -- Ends
                }else if(single_option.name == 'Additional vCPU cores'){
                    var add_vCPU_plan_option_id = single_option.id;
                    var inner_options = single_option.options.option;
                    var doubleLabelsCore = [`<span>0</span>`];
                    $.each(inner_options, function( index, value ) {
                        var inner_loop_add_cores_option = inner_options[index];
                        var id = inner_loop_add_cores_option.id;
                        var amount = inner_loop_add_cores_option.pricing[currency_code].monthly;
                        var quarterly_price = inner_loop_add_cores_option.pricing[currency_code].quarterly;
                        var semiannually_price = inner_loop_add_cores_option.pricing[currency_code].semiannually;
                        var annually_price = inner_loop_add_cores_option.pricing[currency_code].annually;
                        var mb_cores = inner_loop_add_cores_option.name;
                        var i;
                        for (i = 0; i <= 10; ++i) {
                            var repeat_number = i;
                            var amount_final = amount*repeat_number;
                            amount_final = amount_final.toFixed(2);
                            quarterly_price_final = quarterly_price * repeat_number;
                            semiannually_price_final = semiannually_price * repeat_number;
                            annually_price_final = annually_price * repeat_number;
                            var add_storage_content = `<option data-config="`+id+`" id="`+i+`" data-monthly="`+amount_final+`" data-quarterly="`+quarterly_price_final+`" data-semiannually="`+semiannually_price_final+`" data-annually="`+annually_price_final+`" value="`+i+`">
                                                    `+repeat_number+` - `+currency_symbol+amount_final+`
                                                </option>`;
                            $('#value-core-mobile').append(add_storage_content);
                        }
                        for (i = 1; i <= 10; ++i) {
                            var repeat_number = i;
                            var amount = amount*repeat_number;
                            amount = amount.toFixed(2);
                            doubleLabelsCore.push(`<i>`+currency_symbol+amount+`</i><span class="mb_core" data-config="`+single_option.id+`" data-id="`+id+`" data-monthly="`+amount+`" data-quarterly="`+quarterly_price+`" data-semiannually="`+semiannually_price+`" data-annually="`+annually_price+`">`+repeat_number+`</span>`);
                        }
                    });
                    $("#double-label-slider-core").slider({
                            max: 10,
                            min: 0,
                            value: 0,
                            animate: 400,
                            slide: function(event, ui) {
                                var value = ui.value;
                                var storage = $('#double-label-slider-core [data-value="'+value+'"] span').text();
                                var price = $('#double-label-slider-core [data-value="'+value+'"] i').text();
                                $("input[name=value-core]").val(value);
                                var monthly_price = $('span.mb_core').attr('data-monthly');
                                var quarterly_price = $('span.mb_core').attr('data-quarterly');
                                var semiannually_price = $('span.mb_core').attr('data-semiannually');
                                var annually_price = $('span.mb_core').attr('data-annually');
                                var config_id_storage = $('span.mb_core').attr('data-config');
                                var config_id = $('span.mb_core').attr('data-id');
                                
                                $("input[name=value-core]").val(value);
                                $("input[name=value-core]").attr('data-name',value);
                                $("input[name=value-core]").attr('data-monthly',monthly_price*value);
                                $("input[name=value-core]").attr('data-quarterly',quarterly_price*value);
                                $("input[name=value-core]").attr('data-semiannually',semiannually_price*value);
                                $("input[name=value-core]").attr('data-annually',annually_price*value);
                                $("input[name=value-core]").attr('data-config',config_id_storage);
                                $("input[name=value-core]").attr('data-id',config_id);
                                sidebar_update_function('value-core');
                            }
                        }).slider("pips", {
                            rest: "label",
                            labels: doubleLabelsCore                    
                    });
                    /* init input */
                    var value = $("#double-label-slider-core").slider("values", 0);
                    $("[name=value-core]").val(value);
                    // Double Label Storage Range slider -- Ends
                }else if(single_option.name == 'Additional IPv4 addresses (justification required prior to allocation)'){
                    var IPv4_option_id = single_option.id;
                    var inner_options = single_option.options.option;
                    var id_cust = 0;
                    $.each(inner_options, function( index, value ) {
                        id_cust++;
                        var inner_loop_IPv4_option = inner_options[index];
                        var ID = inner_loop_IPv4_option.id;
                        var name = inner_loop_IPv4_option.name;
                        var monthly_price = inner_loop_IPv4_option.pricing[currency_code].monthly;
                        var quarterly_price = inner_loop_IPv4_option.pricing[currency_code].quarterly;
                        var semiannually_price = inner_loop_IPv4_option.pricing[currency_code].semiannually;
                        var annually_price = inner_loop_IPv4_option.pricing[currency_code].annually;
                        var IPv4_content_label = `<label for="`+id_cust+ID+`">
                                                    <input type="radio" name="IPv4_additional" id="`+id_cust+ID+`" data-config="`+single_option.id+`" value="`+ID+`" data-name="`+name+`" data-monthly="`+monthly_price+`" data-quarterly="`+quarterly_price+`" data-semiannually="`+semiannually_price+`" data-annually="`+annually_price+`" style="display: none;">
                                                    <div class="location-block">
                                                        <div class="img-location">                              
                                                            <div class="IPv4-name">
                                                                <h5 class="inner-heading">`+name+`</h5>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </label>`;
                        $('#IPv4_content').append(IPv4_content_label);
                    });
                }else if(single_option.name == 'Quantity of IPv6 addresses'){
                    var IPv6_option_id = single_option.id;
                    var inner_options = single_option.options.option;
                    $.each(inner_options, function( index, value ) {
                        var inner_loop_IPv6_option = inner_options[index];
                        var ID = inner_loop_IPv6_option.id;
                        var name = inner_loop_IPv6_option.name;
                        var monthly_price = inner_loop_IPv6_option.pricing[currency_code].monthly;
                        var quarterly_price = inner_loop_IPv6_option.pricing[currency_code].quarterly;
                        var semiannually_price = inner_loop_IPv6_option.pricing[currency_code].semiannually;
                        var annually_price = inner_loop_IPv6_option.pricing[currency_code].annually;
                        var IPv6_content_label = `<label for="`+ID+`">
                                                    <input type="radio" name="IPv6_additional" id="`+ID+`" data-config="`+single_option.id+`" value="`+ID+`" data-name="`+name+`" data-monthly="`+monthly_price+`" data-quarterly="`+quarterly_price+`" data-semiannually="`+semiannually_price+`" data-annually="`+annually_price+`" style="display: none;">
                                                    <div class="location-block">
                                                        <div class="img-location">                              
                                                            <div class="IPv6-name">
                                                                <h5 class="inner-heading">`+name+`</h5>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </label>`;
                        $('#IPv6_content').append(IPv6_content_label);
                    });
                }
            });
            // Pricing billing cycle
            var product_details = response[0];
            var amount_pricing = product_details.pricing[currency_code];
            var monthly_rate = amount_pricing.monthly;
            var quarterly_rate = amount_pricing.quarterly;
            var semiannually_rate = amount_pricing.semiannually;
            var annually_rate = amount_pricing.annually;
            var content_pricing_monthly = `<label for="subscription_duration_1">
                                <input type="radio" name="subscription_duration" id="subscription_duration_1" value="`+monthly_rate+`" data-billingCycle="monthly" data-amount="`+monthly_rate+`" style="display: none;">
                                <div class="location-block">
                                    <div class="img-location">                              
                                        <div class="IPv4-name">
                                            <h5 class="inner-heading">`+currency_symbol+monthly_rate+ currency_code+` Monthly</h5>
                                        </div>
                                    </div>
                                </div>
                            </label>`;
            $('#pricing_time').append(content_pricing_monthly);
            var content_pricing_quarter = `<label for="subscription_duration_2">
                                <input type="radio" name="subscription_duration" id="subscription_duration_2" data-billingCycle="quarterly" value="`+quarterly_rate+`" data-amount="`+quarterly_rate+`"  style="display: none;">
                                <div class="location-block">
                                    <div class="img-location">                              
                                        <div class="IPv4-name">
                                            <h5 class="inner-heading">`+currency_symbol+quarterly_rate+ currency_code+` Quarterly</h5>
                                        </div>
                                    </div>
                                </div>
                            </label>`;
            $('#pricing_time').append(content_pricing_quarter);
            var content_pricing_semiannually = `<label for="subscription_duration_3">
                                <input type="radio" name="subscription_duration" id="subscription_duration_3" value="`+semiannually_rate+`" data-billingCycle="semiannually" data-amount="`+semiannually_rate+`" style="display: none;">
                                <div class="location-block">
                                    <div class="img-location">                              
                                        <div class="IPv4-name">
                                            <h5 class="inner-heading">`+currency_symbol+semiannually_rate+ currency_code+` Semi Annually</h5>
                                        </div>
                                    </div>
                                </div>
                            </label>`;
            $('#pricing_time').append(content_pricing_semiannually);
            var content_pricing_annually = `<label for="subscription_duration_4">
                                <input type="radio" name="subscription_duration" id="subscription_duration_4" value="`+annually_rate+`" data-billingCycle="annually" data-amount="`+annually_rate+`" style="display: none;">
                                <div class="location-block">
                                    <div class="img-location">                              
                                        <div class="IPv4-name">
                                            <h5 class="inner-heading">`+currency_symbol+annually_rate+ currency_code+` Annually</h5>
                                        </div>
                                    </div>
                                </div>
                            </label>`;
            $('#pricing_time').append(content_pricing_annually);

            // Compressed Selected plan
            var name_divide = product_details.name.split('-');
            var name_break_down = name_divide[2].split(',');
            var break_down_content = '<b>'+name_divide[0]+'  '+name_divide[1]+'</b> - '+name_break_down[0]+' / '+name_break_down[1]+' / '+name_break_down[2]+' <b>/ '+currency_symbol+monthly_rate+'/monthly</b>';
            $('#specifications-data').append(break_down_content);
            $('#specifications-data').attr('data-productName',name_divide[0]+'  '+name_divide[1]);
            $('#specifications-data').attr('data-price',monthly_rate);

            var fetch_product_name = $('#specifications-data').attr('data-productName');
            var fetch_product_price = $('#specifications-data').attr('data-price');
            $('.product_name').text(fetch_product_name);
            $('.total-cost-highlight .amount_product').text(currency_symbol+fetch_product_price);
            $('.total-cost-highlight .amount_product_static').text(currency_symbol+fetch_product_price);
            

            // Pricing area -- sidebar -- order summary
            $('.currency_type').text(currency_code);

        }
    });
});

function AddOrder(clientEmail) {
    var productPid=$("input[name=price]:checked").val();
    var cycle=$("input[name=subscription_duration]:checked").data("billingcycle");
    var promoCode= $("input[name=promocode]").val();
    // Get all the config options
    var location = $('input[name=location]:checked').val();
    var location_config_id = $('input[name=location]:checked').attr('data-config');

    var backupPlan = $('input[name=backupPlan]:checked').val();
    var backupPlan_config_id = $('input[name=backupPlan]:checked').attr('data-config');

    var cPanel_check = $('select[name=cpanel]').children('option:selected').attr('data-name');

    var cPanel_check_2 = $('input[name=controlPanel]:checked').val();
    if(cPanel_check_2 != '' && cPanel_check_2 != 'cp_none'){
        var controlPanel = $('input[name=controlPanel]:checked').val();
        var controlPanel_id = $('input[name=controlPanel]:checked').attr('data-config');
    }else{
        var controlPanel = $('select[name=cpanel]').children('option:selected').val();
        var controlPanel_id = $('select[name=cpanel]').children('option:selected').attr('data-config');
    }
    var op_val = $('#operatingSystem_final').attr('data-id'); 
    var op_config_id = $('#operatingSystem_final').attr('data-config');

    var ram_val = $('#ram_final').attr('data-id'); 
    var ram_config_id = $('#ram_final').attr('data-config');

    var ivp4_val = $('input[name=IPv4_additional]:checked').val(); 
    var ivp4_config_id = $('input[name=IPv4_additional]:checked').attr('data-config');

    var ivp6_val = $('input[name=IPv6_additional]:checked').val(); 
    var ivp6_config_id = $('input[name=IPv6_additional]:checked').attr('data-config');

    var storage_val = $('input[name=value-storage]').attr('data-name');
    var storage_config_id = 41;

    var core_val = $("input[name=value-core]").attr('data-name');
    var core_config_id = 45;

    var options_array = {};
    var options_array = { [location_config_id] : location, [backupPlan_config_id] :backupPlan, [controlPanel_id] : controlPanel, [op_config_id] : op_val, [ram_config_id] : ram_val, [storage_config_id]: storage_val , [core_config_id] : core_val, [ivp4_config_id] : ivp4_val, [ivp6_config_id] : ivp6_val};
    // console.log(options_array);
    // return false;
    var client_id = localStorage.getItem("client_id");
    var paymentm = $('input[name=payment_method]:checked').val();
    var client_email = clientEmail;
    var host_name = $("input[name=host-name]").val();
    var root_password = $("input[name=root-password]").val();
    $.ajax({
        url:"https://hostworld.uk/order/api/index.php",
        type:"POST",
        dataType:"JSON",
        data:{ action:"AddOrder", hostname:host_name, rootpw:root_password, clientid:client_id, pid:productPid, billingcycle:cycle, configoptions:options_array, promocode:promoCode, paymentmethod: paymentm, email: client_email},
        success:function(response) {
            if (response.status=="success") {
                $('.success_login').fadeOut(500);
                var url_redirect = response.url;
                var invoice_val = response.value.invoiceid;
                window.location.href= url_redirect;
            }else{
                $('.success_login').fadeOut(500);
                $('.error-fraud-order').fadeIn(500);

                $("#login-button").html('LOGIN NOW');
                $("#login-button").removeAttr('disabled');

                $('#register-button').html('SIGNUP NOW');
                $('#register-button').removeAttr('disabled');
            }
        }
    });
}

function ValidateLogin(){
    var email= $("input[name=email-add]").val();
    var password=$("input[name=password]").val();

    $("#login-button").html('Processing');
    $("#login-button").attr('disabled','disabled');

    $.ajax({
        url:"https://hostworld.uk/order/api/index.php",
        type:"POST",
        dataType:"JSON",
        data:{action:"ValidateLogin", email:email, password:password},
        success:function(response) {
            if (response.status=="success") {
                var client_id = response.clientid;
                var client_email = $("input[name=email-add]").val();
                // save in local
                localStorage.setItem("client_id",client_id);
                $('.success_login p').text('You are logged in successfully');
                $('.success_login').fadeIn();                   
                AddOrder(client_email);
            } else {
                $("#login-button").html('LOGIN NOW');
                $("#login-button").removeAttr('disabled');

                $('.failure_login p').text('Invalid Username or Password');
                $('.failure_login').fadeIn();
                setTimeout(function(){ 
                    $('.failure_login').fadeOut(500);
                }, 4000);
            }
        }
    });
}

function AddClient(){
    var fname= $("input[name=first-name-user]").val();
    var lname= $("input[name=last-name-user]").val();
    var phone= $("input[name=phone-number-user]").val();
    var email= $("input[name=email-add-register]").val();
    var password= $("input[name=confirm-pass-user]").val();
    var securityQuestion= $("#inputSecurityQId option:selected").val();
    var securityAnswer= $("input[name=s_ans-user]").val();
    var companyName= $("input[name=companyname]").val();
    var address1= $("input[name=inputAddress1-user]").val();
    var address2= $("input[name=inputAddress2-user]").val();
    var city= $("input[name=inputCity-user]").val();
    var state= $("#stateselect option:selected").val();
    var postCode= $("input[name=inputPostcode]").val();
    var country= $("#inputCountry option:selected").val();
    var currency= localStorage.getItem("country");
    var currency_code;
    if(currency == 'GBP'){
        currency_code = 1;
    }else if(currency == 'USD'){
        currency_code = 2;
    }else if(currency == 'CH'){
        currency_code = 2;
    }else if(currency == 'EUR'){
        currency_code = 3;
    }else{
        currency_code = 1;
    }

    $('#register-button').html('Processing');
    $('#register-button').attr('disabled', 'disabled');

    var clientInfo={email:email, currency:currency_code, password:password, fname:fname, lname:lname, phone:phone, securityQuestion:securityQuestion, securityAnswer:securityAnswer, companyName:companyName, address1:address1, city:city, state:state, postCode:postCode, country:country};
    $.ajax({
        url:"https://hostworld.uk/order/api/index.php",
        type:"POST",
        dataType:"JSON",
        data:{action:"AddClient", clientInfo:clientInfo},
        success:function(response) {
            if (response.status=="error" && response.exist==true) {
                alert("Email already registered.Please login...");

                // reset register
                $('#register-button').html('SIGNUP NOW');
                $('#register-button').removeAttr('disabled');
            }
            else if (response.status=="success") {
                alert("Signup successfully");
                var client_id = response.clientid;
                // save in local
                localStorage.setItem("client_id",client_id);
                AddOrder(email);
            } else {
                alert("Error ! Please try again");
                $('#register-button').html('SIGNUP NOW');
                $('#register-button').removeAttr('disabled');
            }
        }
    });
}

function VerifyPromo(){
    $('#call_promo_api').attr('disabled', true);
    $('#call_promo_api').addClass('active-now-promo');
    $('#call_promo_api span').hide();
    var productPid=$("input[name=price]").val();
    var cycle=$("input[name=subscription_duration]:checked").data("billingcycle");
    var promoCode= $("input[name=promocode]").val();
    if (promoCode !=false) {
        $.ajax({
            url:"https://hostworld.uk/order/api/index.php",
            type:"POST",
            dataType:"JSON",
            data:{action:"VerifyPromo", promoCode:promoCode, productPid:productPid, cycle:cycle},
            success:function(response) {
                if(response.status == 'error'){
                    $('.promocode-area').parent().css("border", "2px solid red");
                    $('#call_promo_api').removeClass('active-now-promo');
                    $('#call_promo_api span').show();
                    $('#call_promo_api').attr('disabled', false);
                }
                if(response.status == 'success'){
                    var type = response.type;
                    if(type == 'Percentage'){
                        var promocode_amount = response.value;
                        promocode_amount = parseFloat(promocode_amount);
                        promocode_amount = promocode_amount/100;
                        var total_price = $('.amount_product_update').text();
                        total_price = total_price.split(currency_symbol);
                        total_price = total_price[1];
                        total_price = parseFloat(total_price);
                        var reduced_amt = total_price - promocode_amount;
                        reduced_amt = reduced_amt.toFixed(2);
                        $('.amount_product_update').text(currency_symbol+reduced_amt);
                        $('.promocode-area').parent().css('border',"2px solid green");
                        $('#call_promo_api').removeClass('active-now-promo');
                        $('#call_promo_api span').html('<p style="color: green;font-size: 12px;padding: 0;margin: 0;">Coupon Applied!</p>');
                        $('#call_promo_api span').show();
                    }else if('Fixed Amount'){

                    }else if('Price Override'){

                    }else if('Free Setup'){

                    }                   
                }
            }
        });
    } else {
        alert("Please Enter Promo Code");
    }
}
