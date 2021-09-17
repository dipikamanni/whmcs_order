var currentTab = 1;
var allowedTabs = 1;

$( document ).ready(function() {
    // Trigger Slides
    $('body').on('click','#go_to_sec_slide', function(){
        $('#slide_image').trigger('click');
    });
    $('body').on('click','#go_to_first_slide', function(){
        $('#slide_text_new').trigger('click');
    });
    $('body').on('click','#go_to_third_slide', function(){
        $('#slide_video').trigger('click');
    });
    $('body').on('click','#go_to_fourth_slide', function(){
        $('#slide_last').trigger('click');
    });    
	// Check to add class  pricing radio			
    $('body').on('click','.edit-button', function(){
        $('.selected_plan').fadeOut(500);
		setTimeout(function(){
			$('.main-slider').fadeIn(500);            
        }, 100);				
    });
    // Check to add class -- location radio
    $('body').on('click','input[name=location]', function(){
        $('input[name=location]:not(:checked)').parent().removeClass("active-now");
        $('input[name=location]:not(:checked)').parent().removeClass('without-after-element');
        $('input[name=location]:checked').parent().addClass("active-now");
        setTimeout(function(){
        	$('input[name=location]:checked').parent().addClass('without-after-element');            
            sidebar_update_function('location');
        }, 1000);
    }); 
    // Check to add class -- Control Panel radio
    $('body').on('click','input[name=controlPanel]', function(){
        $('input[name=controlPanel]:not(:checked)').parent().removeClass("active-now");
        $('input[name=controlPanel]:not(:checked)').parent().removeClass('without-after-element');
        $('input[name=controlPanel]:checked').parent().addClass("active-now");
        setTimeout(function(){
        	$('input[name=controlPanel]:checked').parent().addClass('without-after-element');
        	
        	if($('select', $('input[name=controlPanel]:checked').parent()).length > 0) {
        	    $('select', $('input[name=controlPanel]:checked').parent()).trigger('change');
        	}
        	
            // $('.select-cpanel-cat select').fadeIn();
            sidebar_update_function('controlPanel');
        }, 1000);
    });
    $('body').on('click','#cp_none', function(){
        $('.select-cpanel-cat select').fadeIn();
        console.log('hi');
    });
    // Check to add class -- Operating System 
    $('body').on('click','input[name=operatingSystem]', function(){
    	$('.select-sub-cat').fadeOut(500);
        $('input[name=operatingSystem]:not(:checked)').parent().removeClass("active-now");
        $('input[name=operatingSystem]:not(:checked)').parent().removeClass('without-after-element');
        $('input[name=operatingSystem]:checked').parent().addClass("active-now");
        setTimeout(function(){
        	$('input[name=operatingSystem]:checked').parent().addClass('without-after-element');
        	
        	if($('select', $('input[name=operatingSystem]:checked').parent()).length > 0) {
        	    $('select', $('input[name=operatingSystem]:checked').parent()).trigger('change');
        	}
        	
        	var next_class = $('input[name=operatingSystem]:checked').next().children().eq(1).fadeIn(500);
            // sidebar_update_function('operatingSystem');
        }, 1000);
    });
    $('body').on('change','select[name=cpanel]', function(){
        sidebar_update_function('cpanel');
    });
    $('body').on('change','select[name=operatingSystem_centos]', function(){
        sidebar_update_function('operatingSystem_centos');
    });
    $('body').on('change','select[name=operatingSystem_ubuntu]', function(){
        sidebar_update_function('operatingSystem_ubuntu');
    });
    $('body').on('change','select[name=operatingSystem_debian]', function(){
        sidebar_update_function('operatingSystem_debian');
    });
    $('body').on('change','select[name=operatingSystem_fedora]', function(){
        sidebar_update_function('operatingSystem_fedora');
    });
    $('body').on('change','select[name=operatingSystem_webuzo]', function(){
        sidebar_update_function('operatingSystem_webuzo');
    });
    $('body').on('change','select[name=operatingSystem_windows]', function(){
        sidebar_update_function('operatingSystem_windows');
    });
    // Check to add class -- Backup Plan
    $('body').on('click','input[name=backupPlan]', function(){
        $('input[name=backupPlan]:not(:checked)').parent().removeClass("active-now");
        $('input[name=backupPlan]:not(:checked)').parent().removeClass('without-after-element');
        $('input[name=backupPlan]:checked').parent().addClass("active-now");
        setTimeout(function(){
        	$('input[name=backupPlan]:checked').parent().addClass('without-after-element');
            sidebar_update_function('backupPlan');
        }, 1000);
    });
    // Check to add class -- Additional Ram
    $('body').on('change','select[name=value-core-select]', function(){
        sidebar_update_function('value-core-select');
    });
    $('body').on('change','select[name=value-storage-select]', function(){
        sidebar_update_function('value-storage-select');
    });
    $('body').on('change','select[name=value-ram-select]', function(){
        sidebar_update_function('value-ram-select');
    });
    // Check to add class -- IPv4_additional
    $('body').on('click','#IPv4_content label', function(){
        $('input[name=IPv4_additional]:not(:checked)').parent().removeClass("active-now");
        $('input[name=IPv4_additional]:not(:checked)').parent().removeClass('without-after-element');
        $('input[name=IPv4_additional]:checked').parent().addClass("active-now");
        setTimeout(function(){
            $('input[name=IPv4_additional]:checked').val();
        	$('input[name=IPv4_additional]:checked').parent().addClass('without-after-element');
            sidebar_update_function('IPv4_additional');
        }, 1000);
    });
    // Check to add class -- IPv6_additional
    $('body').on('click','input[name=IPv6_additional]', function(){
        $('input[name=IPv6_additional]:not(:checked)').parent().removeClass("active-now");
        $('input[name=IPv6_additional]:not(:checked)').parent().removeClass('without-after-element');
        $('input[name=IPv6_additional]:checked').parent().addClass("active-now");
        setTimeout(function(){
        	$('input[name=IPv6_additional]:checked').parent().addClass('without-after-element');
            sidebar_update_function('IPv6_additional');
        }, 1000);		        
    });		    
    // Check to add class -- Subscription Duration
    $('body').on('click','input[name=subscription_duration]', function(){
        $('input[name=subscription_duration]:not(:checked)').parent().removeClass("active-now");
        $('input[name=subscription_duration]:not(:checked)').parent().removeClass('without-after-element');
        $('input[name=subscription_duration]:checked').parent().addClass("active-now");
        setTimeout(function(){
        	$('input[name=subscription_duration]:checked').parent().addClass('without-after-element');
        	var value_sub = $('input[name=subscription_duration]:checked').attr('data-billingcycle');
        	sidebar_update_function('subscription_duration');
        }, 1000);		        
    });
    $('input[name=payment_method]').on('click',function(){
        $('input[name=payment_method]:not(:checked)').parent().removeClass("active-now");
        $('input[name=payment_method]:not(:checked)').parent().removeClass('without-after-element');
        $('input[name=payment_method]:checked').parent().addClass("active-now");
        setTimeout(function(){
            $('input[name=payment_method]:checked').parent().addClass('without-after-element');
        }, 1000);               
    });
    function changeTab( tabIndex ) {
		currentTab = tabIndex;
		if(tabIndex > allowedTabs){
			return false;
		}else{
			var completedIndex = tabIndex-1;
			$('input[name=processBar]').parent().parent().removeClass("active-bar");
    		$('#process-'+tabIndex).parent().parent().addClass("active-bar");
    		$('#process-'+completedIndex).next().next().html('<i class="fa fa-check"></i>');
    		$('#process-'+completedIndex).parent().parent().addClass('done-step');
			$('.build-right-section').fadeOut(0, function(){
				$('#process-'+tabIndex).fadeIn(0,function(){
					$('#process-'+tabIndex).hide();
					$('#'+tabIndex+'-process').show();							
					$("html, body").animate({ scrollTop: 120 }, "slow");
				});
			});
		}				
	}
    // Check to add class -- Process Bar
    $('input[name=processBar]').click(function () {
    	var select_process = $('input[name=processBar]:checked').val();
    	changeTab(select_process);
    });
    // Continue button next step
    $('#first-process-continue-button').click(function () {
    	$('input').parent().parent().removeClass('required-field-back');
    	$('.required-fields').hide();
     	var product_id = $('input[name=price]:checked').val();
     	var location   = $('input[name=location]:checked').val();
     	var controlPanel   = $('select[name=cpanel]:checked').val();
     	var operatingSystem   = $('input[name=operatingSystem]:checked').val();
     	if(isNaN(product_id)){		     		
     		$("html, body").animate({ scrollTop: 420 }, "slow");
     		$('<div class="required-fields"><p>All fields are required</p></div>').insertBefore('#1-process').delay(5000).fadeIn(500);	     		
     		return false;					
     	}else if(isNaN(location)){
     		$('input[name=location]').parent().parent().addClass('required-field-back');
     		$("html, body").animate({ scrollTop: 900 }, "slow");
     		return false;
     	}else if(isNaN(operatingSystem)){
     		$('input[name=operatingSystem]').parent().parent().addClass('required-field-back');
     		$("html, body").animate({ scrollTop: 1500 }, "slow");
     		return false;
     	}else{
     		tabIndex = 2;
     		allowedTabs = 2;
        	changeTab(tabIndex);
        	$('.bp_name').css("visibility", "visible");
     	}		     	
    });
    $('#second-process-continue-button').click(function () {
    	$('input').parent().parent().removeClass('required-field-back');
    	$('input').parent().removeClass('required-field-back');
    	var host_name = $('input[name=host-name]').val();
    	var root_password = $('input[name=root-password]').val();
    	var backupPlan = $('input[name=backupPlan]:checked').val();
    	var value_ram = $('input[name=value-ram]').val();
    	var value_storage = $('input[name=value-storage]').val();
    	var value_core = $('input[name=value-core]').val();
    	var IPv4_additional = $('input[name=IPv4_additional]:checked').val();
    	var IPv6_additional = $('input[name=IPv6_additional]:checked').val();
    	if(host_name == ''){	     		
     		$("html, body").animate({ scrollTop: 420 }, "slow");
     		$('input[name=host-name]').parent().parent().addClass('required-field-back');
     		return false;					
     	}else if(root_password == ''){
     		$("html, body").animate({ scrollTop: 420 }, "slow");
     		$('input[name=host-name]').parent().parent().addClass('required-field-back');
     		return false;
     	}else if(isNaN(backupPlan)){
     		$('input[name=backupPlan]').parent().parent().addClass('required-field-back');
     		$("html, body").animate({ scrollTop: 800 }, "slow");
     		return false;
     	}else if(root_password != ''){
     		var OSName="Unknown OS";
			if (navigator.appVersion.indexOf("Win")!=-1) OSName="Windows";
			if (navigator.appVersion.indexOf("Mac")!=-1) OSName="MacOS";
			if (navigator.appVersion.indexOf("X11")!=-1) OSName="UNIX";
			if (navigator.appVersion.indexOf("Linux")!=-1) OSName="Linux";
			if(OSName == 'Windows'){
				var upperCase= new RegExp('[A-Z]');
				var lowerCase= new RegExp('[a-z]');
				var numbers = new RegExp('[0-9]');
                var regExp = /[_\-!\@#\$%\^&\*+\=?]/;
				if( root_password.match(upperCase) == null  || root_password.match(upperCase).length == 0 || root_password.match(lowerCase)  == null  || root_password.match(lowerCase).length == 0 || root_password.match(numbers) == null  || root_password.match(numbers).length == 0 || !regExp.test(root_password) )  
				{
					$("html, body").animate({ scrollTop: 420 }, "slow");
				 	$('input[name=host-name]').parent().parent().addClass('required-field-back');
					$('.red-now').show();
					return false;						    
				}else{
                    // fetch data
                    var starter_price = $('.main-sumup-wrapp').html();
                    $('.fetch_field_price').html(starter_price);
					tabIndex = 3;
				    allowedTabs = 3;
				    changeTab(tabIndex);
					return true;
				}
			}else{
                // fetch data
                var starter_price = $('.main-sumup-wrapp').html();
                $('.fetch_field_price').html(starter_price);
                tabIndex = 3;
                allowedTabs = 3;
                changeTab(tabIndex);
                return true;
            }		     		
     	}else{
            // fetch data
            var starter_price = $('.main-sumup-wrapp').html();
            $('.fetch_field_price').html(starter_price);
     		tabIndex = 3;
		    allowedTabs = 3;
		    changeTab(tabIndex);
     	}	    	
    });
    $('#third-process-continue-button').click(function () {
    	var subscription_duration = $('input[name=subscription_duration]:checked').val();
    	if(isNaN(subscription_duration)){
     		$('input[name=subscription_duration]').parent().parent().addClass('required-field-back');
     		$("html, body").animate({ scrollTop: 420 }, "slow");
     		return false;
     	}else{
	     	tabIndex = 3;
	     	allowedTabs = 3;
	        changeTab(tabIndex);
	        // Hide Every thing and show process 4 i.e., register and login page
        	$(".head-section").hide();
        	$(".process-banner").hide();
        	$(".first-process-hw").hide();
        	$(".register-login-wrap").show();
     	}
    });
    $('#second-process-back-button').click(function () {
        $("html, body").animate({ scrollTop: 120 }, "slow");
        $('.process-first').trigger('click');
    	$(".process-first").addClass('active-bar');
    	$(".process-second").removeClass('active-bar');
    	$('#2-process').hide();
    	$('#1-process').show();
    });
    $('#prev-process-back-button').click(function () {
        $("html, body").animate({ scrollTop: 120 }, "slow");
        $('.process-second').trigger('click');
    	$(".process-second").addClass('active-bar');
    	$(".process-third").removeClass('active-bar');
    	$('#3-process').hide();
    	$('#2-process').show();
    });
    $('#third-process-back-button').click(function () {
        	$(".head-section").show();
        	$(".process-banner").show();
        	$(".first-process-hw").show();
        	$(".register-login-wrap").hide();
        	$(".process-third").trigger('click');
        	$(".process-third").addClass('active-bar');
        	$(".process-fourth").removeClass('active-bar');
        	$('#3-process').show();
    });
    $('#random-host').click(function() {
        var random_hostname = 'hostworld-'+Math.floor((Math.random() * 100000) + 1);
        $('#host-name').val(random_hostname);
    });
    $('#random-root-pass').click(function() {
        var randPassword = Array(10).fill("0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz").map(function(x) { return x[Math.floor(Math.random() * x.length)] }).join('');
        randPassword_SPECIAL = Array(2).fill("!@#$%^&*").map(function(x) { return x[Math.floor(Math.random() * x.length)] }).join('');
        $('#root-password').val(randPassword+randPassword_SPECIAL);
    });
    var maxWidth = $(document).width();
    if(maxWidth <= 500){
    	$("#slide_text").trigger('click');
    }else{
    	$("#slide_text_new").trigger('click');
    }		    
});