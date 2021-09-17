<?php
$lang = array();

// UK LANG
include 'lang/uk.php';
include 'lang/us.php';
include 'lang/ch.php';

// Language change 
function change_lang($string) {
	global $lang;
	if(isset($_GET['locale'])) {
		// array check
		$locate = $_GET['locale'];
		if($locate == 'US'){
			$locale = 'US';
		}
		if($locate == 'CH'){
			$locale = 'CH';
		}
	}else {
		$locale = "UK";
	}

	if(isset($lang[$locale][$string])){
		return $lang[$locale][$string];
	}else{
		return $string;
	}
}

// Server Level User authentication
// if (!isset($_SERVER['PHP_AUTH_USER']) || $_SERVER['PHP_AUTH_USER'] !='admin' || $_SERVER['PHP_AUTH_PW'] != 'Yeaz{bq^') {
//     header('WWW-Authenticate: Basic realm="My Realm"');
//     header('HTTP/1.0 401 Unauthorized');
//     echo 'Invalid Input';
//     exit;
// }
// GET IP ADDRESS
if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
    $ip = $_SERVER['HTTP_CLIENT_IP'];
} else if (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
    $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
} else if (!empty($_SERVER['REMOTE_ADDR'])) {
    $ip = $_SERVER['REMOTE_ADDR'];
} else {
    $ip = false;
}

// CALL THE WEBSERVICE
$ip_info = unserialize(file_get_contents('http://www.geoplugin.net/php.gp?ip='.$ip));
// var_dump($ip_info);
$locale = $ip_info['geoplugin_countryCode'];
$locate_get = $_GET['locale'];
if($ip_info['geoplugin_countryCode'] == 'US' || $locate_get == 'US'){
	echo '<script type="text/javascript">
    		localStorage.setItem("country","USD");	    		
    		localStorage.setItem("currency","$");
	    </script>';
}elseif($ip_info['geoplugin_countryCode'] == 'CH' || $locate_get == 'CH'){ 
	echo '<script type="text/javascript">
    		localStorage.setItem("country","USD");	    		
    		localStorage.setItem("currency","$");
	    </script>';
}elseif( $ip_info['geoplugin_countryCode'] == 'UK' || $locate_get == 'UK'){ 
	echo '<script type="text/javascript">
    		localStorage.setItem("country","GBP");	    		
    		localStorage.setItem("currency","£");
	    </script>';
}else{
	echo '<script type="text/javascript">
    		localStorage.setItem("country","GBP");	    		
    		localStorage.setItem("currency","£");
	    </script>';
} 
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="viewport" content="width=device-width, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">
	<meta http-equiv="Content-Type" content="text/html;charset=utf-8">
	<!-- Meta Tags -->
	<meta name="description" content="hostworld provides great value web hosting, reseller hosting, NVMe SSD VPS, dedicated servers and domain names. UK & US data centre & 24/7 support.">
	<meta name="keywords" content="hostworld, uk ssd hosting, uk hosting, web hosting, ssd web hosting, hosting, ssd reseller hosting, reseller hosting, uk reseller ssd, uk reseller, reseller, linux vps, website hosting, uk web host, web host, cpanel">
	<title><?=change_lang('Hostworld UK - Order Your VPS ')?></title>
	<!-- Favicon 16 x 16 -->
	<link rel="icon" type="image/png" sizes="16x16" href="images/favicon.png">
	<!-- Preload for poppins font -->
	<link rel="preload" href="fonts/poppins.css" as="font" onload="this.onload=null;this.rel='stylesheet'">
	<noscript><link rel="stylesheet" href="fonts/poppins.css"></noscript>
	<!-- Main css -->
	<!--<link rel="preload" href="css/header-custom.css?time=<?php echo time(); ?>" as="style" onload="this.onload=null;this.rel='stylesheet'">-->
	<!--<noscript><link rel="stylesheet" href="css/header-custom.css?time=<?php echo time(); ?>"></noscript>-->
	<link rel="stylesheet" href="css/header-custom.css?time=<?php echo time(); ?>" >
	<!-- plus a jQuery UI theme, here I use "flick" -->
	<link rel="preload" href="https://code.jquery.com/ui/1.10.4/themes/flick/jquery-ui.css" as="style" onload="this.onload=null;this.rel='stylesheet'">
	<noscript><link rel="stylesheet" href="https://code.jquery.com/ui/1.10.4/themes/flick/jquery-ui.css"></noscript>

	<link rel="preload" href="css/jquery-ui-slider-pips.css" as="style" onload="this.onload=null;this.rel='stylesheet'">
	<noscript><link rel="stylesheet" href="css/jquery-ui-slider-pips.css"></noscript>

	<link rel="preload" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" as="style" onload="this.onload=null;this.rel='stylesheet'">
	<noscript><link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"></noscript>
	<!-- include the jQuery and jQuery UI scripts -->
	<script src="https://code.jquery.com/jquery-2.1.1.js"></script>
	<script src="https://code.jquery.com/ui/1.11.1/jquery-ui.js" defer="defer"></script>	                
	<script type="text/javascript" src="js/jquery-ui-slider-pips.js" defer="defer"></script>
	<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-163959882-1"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'UA-163959882-1');
  gtag('config', 'AW-954658804');
</script>
<script type='text/javascript'>
  window.smartlook||(function(d) {
    var o=smartlook=function(){ o.api.push(arguments)},h=d.getElementsByTagName('head')[0];
    var c=d.createElement('script');o.api=new Array();c.async=true;c.type='text/javascript';
    c.charset='utf-8';c.src='https://rec.smartlook.com/recorder.js';h.appendChild(c);
    })(document);
    smartlook('init', '035f647fc943e46e584700935672c6ae75cc4d72');
</script>
</head>
<body class="body-preloader">
	<!-- Preloader -->
	<div id="overlayer" style="width: 100%;
    height: 100%;
    position: fixed;
    z-index: 99;
    background: linear-gradient(
154deg
, #e100a4, #243369);
    overflow: hidden;">
		<h3><img src="images/host-world-logo-white.png"/></h3>
		<p><?=change_lang('Please wait while we load our VPS order form...')?></p>
	</div>
	<span class="loader">
		<span class="loader-inner"></span>
	</span>
	<div class="main-wrap-hw"><!-- Main Wrapper Section -->
		<div class="head-section"><!-- Header Section -->
			<div class="logo-left-sec">
				<a href="https://hostworld.uk/"><img src="images/host-world-logo.png" title="<?=change_lang('Host World logo')?>" alt="<?=change_lang('Host World Logo')?>" /></a>
			</div>
			<div class="exit-right-sec">
				<a href="https://hostworld.uk/" class=""><img src="images/exit-arrow.png" title="<?=change_lang('Exit Arrow')?>" alt="<?=change_lang('Exit Arrow')?>" /> <span class="exit-span"><?=change_lang('Exit')?></span></a>
			</div>
		</div><!-- Header Section Ends -->		
		
		<div class="process-banner" style="background-image: url('images/banner-hero.jpg');"><!-- Process Banner Section -->
			<h2 class="head-process for-mobile" style="display: none;"><?=change_lang('Configure')?></h2>
			<div class="steps-inner-area">
				<div class="process-first active-bar">
					<label for="process-1">
						<input type="radio" name="processBar" id="process-1" value="1" style="display: none;">
						<h2><?=change_lang('Build')?></h2>
						<p>1</p>
					</label>
				</div>
				<div class="process-second">
					<label for="process-2">
						<input type="radio" name="processBar" id="process-2" value="2" style="display: none;">
						<h2><?=change_lang('Enhance')?></h2>
						<p>2</p>
					</label>
				</div>
				<div class="process-third">
					<label for="process-3">
					<input type="radio" name="processBar" id="process-3" value="3" style="display: none;">
						<h2><?=change_lang('Summary')?></h2>
						<p>3</p>
					</label>
				</div>
				<div class="process-fourth">
					<label for="process-4">
					<input type="radio" name="processBar" id="process-4" value="4" style="display: none;">
						<h2><?=change_lang('Payment')?></h2>
						<p>4</p>
					</label>
				</div>
				<div class="process-fifth">
					<label for="process-5">
					<input type="radio" name="processBar" id="process-5" value="5" style="display: none;">
						<h2><?=change_lang('Order confirmation')?></h2>
						<p>5</p>
					</label>
				</div>
			</div>
		</div><!-- Process Banner Section Ends -->
		<form action="" id="hostProcessSubmit">
			<div class="first-process-hw"><!-- First Process -- BUILD -->
				<div class="main-process-replace-wrap"><!-- Main Process Replace Wrap -- STARTS -->
					<div class="build-right-section" id="1-process"><!-- Build Process Right First Process -- STARTS -->
						<!-- Configure your Virtual Private Server Instance --- Section -->
						<h1><span><img src="images/server-cloud.svg"></span> <?=change_lang('Configure your Virtual Private Server Instance')?></h1>
						<p><?=change_lang('Choose from one of our optimised plans below or continure with your current selection.')?></p>				
						<div class="pricing-slides-section"><!-- Pricing Slides -->
							<div class="main-slider">								
								<div class="splide">
									<div class="splide__track">
										<ul class="splide__list">
											
										</ul>
									</div>
								</div>				
							  	<!-- <div class="slider">
								    <input type="radio" name="slide-switches" id="slide_text_new" checked="checked" class="slide-switch">
								    <label for="slide_text_new" class="slide-label">Slide Text</label>
								    <div class="slide-content" id="first_content_silde">
								    	<div class="main-silder-sec-wrap">								    		
											<div class="arrow-continue-left" id="go_to_fourth_slide"><span><i class="fa fa-arrow-left"></i></span></div>
											<div class="arrow-continue-right" id="go_to_sec_slide"><span><i class="fa fa-arrow-right"></i></span></div>	
								    		
									    </div>
								    </div>
								    <input type="radio" name="slide-switches" id="slide_image" class="slide-switch">
								    <label for="slide_image" class="slide-label">Slide Image</label>
								    <div class="slide-content" id="second_content_silde">
								    	<div class="main-silder-sec-wrap">
								    		<div class="arrow-continue-left" id="go_to_first_slide"><span><i class="fa fa-arrow-left"></i></span></div>
											<div class="arrow-continue-right" id="go_to_third_slide"><span><i class="fa fa-arrow-right"></i></span></div>
								    		
									    </div>
								    </div>
								    <input type="radio" name="slide-switches" id="slide_video" class="slide-switch">
								    <label for="slide_video" class="slide-label">Slide Video</label>
								    <div class="slide-content" id="third_content_silde">
								    	<div class="main-silder-sec-wrap">								    		
											<div class="arrow-continue-left" id="go_to_sec_slide"><span><i class="fa fa-arrow-left"></i></span></div>
											<div class="arrow-continue-right" id="go_to_fourth_slide"><span><i class="fa fa-arrow-right"></i></span></div>
								    		
									    </div>
								    </div>
								    <input type="radio" name="slide-switches" id="slide_last" class="slide-switch">
								    <label for="slide_last" class="slide-label">Slide last</label>
								    <div class="slide-content" id="fourth_content_silde">
								    	<div class="main-silder-sec-wrap">								    		
											<div class="arrow-continue-left" id="go_to_third_slide"><span><i class="fa fa-arrow-left"></i></span></div>
											<div class="arrow-continue-right" id="go_to_first_slide"><span><i class="fa fa-arrow-right"></i></span></div>
								    		
									    </div>
								    </div>
								</div>	 -->							
							</div>
							<!--  After product selected show this -->
							<div class="selected_plan" style="display: none;">
								<div class="essential-details">
									<span><span id="specifications-data">
										<!-- API DAta -->
									</span></span>
								</div>
								<div class="edit-button">
									<span><b>Edit</b></span>
								</div>
							</div>
						</div><!-- Pricing Slides Ends -->

						<!-- <div class="pricing-slides-section for-mobile" style="display: none;">

							<div class="main-slider">
							  <div class="slider">							    
							  </div>
							</div>
						</div> -->
						<!-- Pricing Slides Ends -->
						<!-- Configurable Options --- Section -->
						<h1><span><img src="images/settings-icon.svg"></span> <?=change_lang('Configurable Options')?></h1>
						<p><?=change_lang('We allow full customisation of our VPS servers and provide lots of configurable options. ')?></p>

						<h5 class="inner-heading"><?=change_lang('Datacentre Location')?></h5>
						<p><?=change_lang('You can host your VPS at any of Hostworlds network of datacentres. Please select your preferred datacentre from the options below:')?></p>
						<div class="location-section-wrap location-pad" id="location-section-wrap">
							<label for="1101">
								<input type="radio" name="controlPanel" id="1101" value="1101" style="display: none;">
								<div class="location-block">
									<div class="img-location">
										<div class="location-name">
											<h5 class="inner-heading">None</h5>
										</div>
									</div>
								</div>
							</label>
							<!-- API DATA -->
						</div>
						<input type="hidden" name="location_final" id="location_final">

						<h5 class="inner-heading"><?=change_lang('Control Panel')?></h5>
						<p><?=change_lang('We offer a range of free and paid application licenses for your VPS. Please make your selection from the options below:')?></p>
						<div class="location-section-wrap add-pad" id="controlPanel-section-wrap">							
							<!-- API DATA -->
						</div>
						<input type="hidden" name="controlPanel_final" id="controlPanel_final" value="0.00">

						<h5 class="inner-heading"><?=change_lang('Operating System')?></h5>
						<p><?=change_lang('Choose from the most popular operating systems below: ')?></p>
						<p><?=change_lang('*please note when choosing Windows you must purchase a VPS 1 or larger due to the RAM requirements. ')?></p>
						<div class="location-section-wrap add-pad" id="operatingSystem-section-wrap">
							<label for="operatingSystem_ID_1">
								<input type="radio" name="operatingSystem" id="operatingSystem_ID_1" value="1" style="display: none;">
								<div class="location-block">
									<div class="img-location">
										<div class="image-section-loc">
											<img src="images/centos-small.png">
										</div>
										<div class="location-name">
											<h5 class="inner-heading">CentOS</h5>
										</div>
									</div>
									<div class="select-sub-cat" id="centos">
										<select name="operatingSystem_centos">
											
										</select>
									</div>
								</div>
							</label>
							<label for="operatingSystem_ID_2">
								<input type="radio" name="operatingSystem" id="operatingSystem_ID_2" value="2" style="display: none;">
								<div class="location-block">
									<div class="img-location">
										<div class="image-section-loc">
											<img src="images/ubuntu.png">
										</div>
										<div class="location-name">
											<h5 class="inner-heading">Ubuntu</h5>
										</div>
									</div>
									<div class="select-sub-cat" id="ubuntu">
										<select name="operatingSystem_ubuntu">
											
										</select>
									</div>
								</div>
							</label>
							<label for="operatingSystem_ID_3">
								<input type="radio" name="operatingSystem" id="operatingSystem_ID_3" value="3" style="display: none;">
								<div class="location-block">
									<div class="img-location">
										<div class="image-section-loc">
											<img src="images/debian.png">
										</div>
										<div class="location-name">
											<h5 class="inner-heading">Debian</h5>
										</div>
									</div>
									<div class="select-sub-cat" id="debian">
										<select name="operatingSystem_debian">

										</select>
									</div>
								</div>
							</label>
							<label for="operatingSystem_ID_4">
								<input type="radio" name="operatingSystem" id="operatingSystem_ID_4" value="4" style="display: none;">
								<div class="location-block">
									<div class="img-location">
										<div class="image-section-loc">
											<img src="images/Fedora.png">
										</div>
										<div class="location-name">
											<h5 class="inner-heading">Fedora</h5>
										</div>
									</div>
									<div class="select-sub-cat" id="fedora">
										<select name="operatingSystem_fedora">
											
										</select>
									</div>
								</div>
							</label>
							<label for="operatingSystem_ID_5">
								<input type="radio" name="operatingSystem" id="operatingSystem_ID_5" value="5" style="display: none;">
								<div class="location-block">
									<div class="img-location">
										<div class="image-section-loc">
											<img src="images/webuzo.png">
										</div>
										<div class="location-name">
											<h5 class="inner-heading">Webuzo</h5>
										</div>
									</div>
									<div class="select-sub-cat" id="webuzo">
										<select name="operatingSystem_webuzo">
											
										</select>
									</div>
								</div>
							</label>
							<label for="operatingSystem_ID_6">
								<input type="radio" name="operatingSystem" id="operatingSystem_ID_6" value="5" style="display: none;">
								<div class="location-block">
									<div class="img-location">
										<div class="image-section-loc">
											<img src="images/windows.png">
										</div>
										<div class="location-name">
											<h5 class="inner-heading">Windows</h5>
										</div>
									</div>
									<div class="select-sub-cat" id="windows">
										<select name="operatingSystem_windows">
											
										</select>
									</div>
								</div>
							</label>
						</div>
						<input type="hidden" name="operatingSystem_final" id="operatingSystem_final" value="0.00">

						<div class="continue-back-button"><!-- Continue & Back Buttons -- STARTS -->
							<div class="continue">
								<button type="button" id="first-process-continue-button"><?=change_lang('Continue')?> <img src="images/right-arrow.svg"></button>
							</div>
						</div><!-- Continue & Back Buttons -- ENDS -->
					</div><!-- Build Process Right First Process -- ENDS -->
					<div class="build-right-section" id="2-process" style="display: none;"><!-- Build Process Right Second Process -- STARTS -->
						<h1><span><img src="images/access-settings.svg"></span> <?=change_lang('Access Settings')?></h1>
						<p><?=change_lang('Please enter a hostname or server name and password. Your hostname is just so you can identify your server and does not need to be anything specific: ')?></p>
						<div class="access-settings-details-fetch">
							<div class="hostname">
								<label for="host-name">
									<h5 class="inner-heading"><?=change_lang('Hostname')?></h5>
								</label>
								<input type="text" name="host-name" id="host-name" placeholder="servername.yourdomain.com">
								<p id="random-host">Generate Host Name</p>
							</div>
							<div class="root-password">
								<label for="root-password ">
									<h5 class="inner-heading"><?=change_lang('Root Password')?></h5>
								</label>
								<input type="text" name="root-password" id="root-password" autocomplete="off" placeholder="Enter Root Password">
								<p id="random-root-pass">Generate Root Password</p>
								<p class="red-now" style="display: none;"><?=change_lang('Your root password must be between 6 and 20 characters. It must contain a mixture of upper and lower case letters, and at least one number or symbol')?></p>
							</div>
													
						</div>
						<h1><span><img src="images/additional-setting-icon.svg"></span> <?=change_lang('Additional Resources')?></h1>
						<p><?=change_lang('')?></p>
						<h5 class="inner-heading"><?=change_lang('Backup Plan')?></h5>
						<p><?=change_lang('For ultimate peace of mind, the Automated Backup operation takes all the stress of out generating backups of your instances, allowing them to be restored in one click. We include backups as standard but you can increase the amount and frequency below:')?></p>
						<div class="location-section-wrap add-pad" id="backupPlan">
							<!-- API DATA -->
						</div>
						<input type="hidden" name="backupPlan_final" id="backupPlan_final" value="0.00">

						<h5 class="inner-heading"><?=change_lang('Additional RAM')?></h5>
						<p><?=change_lang('Increase the RAM available on your VPS by adding additional memory:')?></p>
						<!-- Content Silder Additional Ram -->
						<div class="select_ram_mobile" style="display: none;">
							<select id="value-ram-mobile" name="value-ram-select">
								
							</select>
						</div>
						<div class="ram-slider">
							<div id="double-label-slider-ram"></div>
							<input type="text" name="value-ram" style="display: none;" data-name="0MB" data-monthly="0.00" data-quarterly="0.00" data-semiannually="0.00" data-annually="0.00">		
						</div>
						<input type="hidden" name="ram_final" id="ram_final" value="0.00">

						<h5 class="inner-heading"><?=change_lang('Additional Storage (£0.17/GB)')?></h5>
						<p><?=change_lang('Increase the storage space available on your VPS by adding an additional NVMe storage:')?></p>
						<!-- Content Silder Additional Storage -->
						<div class="select_ram_mobile" style="display: none;">
							<select id="value-storage-mobile" name="value-storage-select">
								
							</select>
						</div>
						<div class="ram-slider">
							<div id="double-label-slider-storage"></div>
							<input type="text" name="value-storage" style="display: none;" data-name="0MB" data-monthly="0.00" data-quarterly="0.00" data-semiannually="0.00" data-annually="0.00">						
						</div>
						<input type="hidden" name="storage_final" id="storage_final" value="0.00">

						<h5 class="inner-heading"><?=change_lang('Addition vCPU Cores')?></h5>
						<p><?=change_lang('Increase your CPU power by adding additional vCPU Cores to your VPS:')?></p>
						<!-- Content Silder Additional Ram -->
						<div class="select_ram_mobile" style="display: none;">
							<select id="value-core-mobile" name="value-core-select">
								
							</select>
						</div>
						<div class="ram-slider">
							<div id="double-label-slider-core"></div>
							<input type="hidden" name="value-core" style="display: none;" data-name="0MB" data-monthly="0.00" data-quarterly="0.00" data-semiannually="0.00" data-annually="0.00">						
						</div>
						<input type="hidden" name="core_final" id="core_final" value="0.00">

						<h5 class="inner-heading"><?=change_lang('Additional IPv4')?></h5>
						<p><?=change_lang('Each VPS comes with its own IP address but you can add an additional IP to your order. Please contact support if you require more than 2 IP addresses.')?></p>
						<div class="add-IPv4-section-wrap" id="IPv4_content">
								<!-- API DATA  -->
						</div>
						<input type="hidden" name="IPv4_final" id="IPv4_final" value="0.00">
						<h5 class="inner-heading"><?=change_lang('Additional IPv6')?></h5>
						<p><?=change_lang('If you require IPv6 support we can add this to oyur VPS.')?></p>
						<div class="add-IPv6-section-wrap" id="IPv6_content">				
						</div>
						<input type="hidden" name="IPv6_final" id="IPv6_final" value="0.00">
						<div class="continue-back-button"><!-- Continue & Back Buttons -- STARTS -->
							<div class="continue">
							    <button type="button" id="second-process-back-button"><img src="images/right-arrow.svg" style="transform: rotate(180deg);margin-left: 0;margin-right: 5px;"> <?=change_lang('Back')?></button>
								<button type="button" id="second-process-continue-button"><?=change_lang('Continue')?> <img src="images/right-arrow.svg"></button>
							</div>
						</div><!-- Continue & Back Buttons -- ENDS -->
					</div><!-- Build Process Right Second Process -- ENDS -->
					<div class="build-right-section" id="3-process"  style="display: none;"><!-- Build Process Right Third Process -- STARTS -->
						<h1><span><img src="images/order-summary.svg"></span> <?=change_lang('Order Summary')?></h1>
						<p><?=change_lang('Please select the desired payment frequency for your VPS server:')?></p>
						<div class="add-IPv4-section-wrap" id="pricing_time">
						</div>

						<h1><span><img src="images/payment-gateway.svg"></span> Payment Gateway</h1>
						<p>Select a payment method from the following options:</p>
						<div class="add-IPv4-section-wrap" id="payment-gateway">
							<label for="payment_method_1">
								<input type="radio" name="payment_method" id="payment_method_1" value="paypal" style="display: none;">
								<div class="location-block">
									<div class="img-location">								
										<div class="payment-name">
											<h5 class="inner-heading"><span><img src="images/payPal.png"></span></h5>
										</div>
									</div>
								</div>
							</label>
							<label for="payment_method_2">
								<input type="radio" name="payment_method" id="payment_method_2" value="stripe" style="display: none;">
								<div class="location-block">
									<div class="img-location">								
										<div class="payment-name">
											<h5 class="inner-heading"><span><img src="images/Visa_1.png"></span></h5>
										</div>
									</div>
								</div>
							</label>
							<label for="payment_method_3">
								<input type="radio" name="payment_method" id="payment_method_3" value="blockonomics" style="display: none;">
								<div class="location-block">
									<div class="img-location">								
										<div class="payment-name">
											<h5 class="inner-heading"> <span><img src="images/Bitcoin_png.png"></span></h5>
										</div>
									</div>
								</div>
							</label>
							<label for="payment_method_4">
								<input type="radio" name="payment_method" id="payment_method_4" value="payssionalipaycn" style="display: none;">
								<div class="location-block">
									<div class="img-location">								
										<div class="payment-name">
											<h5 class="inner-heading"><span><img src="images/Alipay_.png"></span></h5>
										</div>
									</div>
								</div>
							</label>
							<label for="payment_method_5">
								<input type="radio" name="payment_method" id="payment_method_5" value="Unionpay" style="display: none;">
								<div class="location-block">
									<div class="img-location">								
										<div class="payment-name">
											<h5 class="inner-heading"><span><img src="images/unionpaypal.png"></span></h5>
										</div>
									</div>
								</div>
							</label>
						</div>

						<h1><span><img src="images/promocode.svg"></span> <?=change_lang('Enter Promocode')?></h1>
						<p><?=change_lang('Enter Promocode')?></p>
						<div class="main-sum-price">
							<div class="promocode-area">
								<label for="promocode-id">
									<img src="images/promocode-icon.svg">
									<input id="promocode-id" type="text" name="promocode" placeholder="<?=change_lang('Enter A Promo Code')?>">
									<button type="button" id="call_promo_api"><span><i class="fa fa-arrow-right"></i></span></button>
								</label>								
							</div>
						</div>
						<div class="continue-back-button"><!-- Continue & Back Buttons -- STARTS -->
							<div class="continue">
							    <button type="button" id="prev-process-back-button"><img src="images/right-arrow.svg" style="transform: rotate(180deg);margin-left: 0;margin-right: 5px;"> <?=change_lang('Back')?></button>
								<button type="button" id="third-process-continue-button"><?=change_lang('Continue')?> <img src="images/right-arrow.svg"></button>
							</div>
						</div><!-- Continue & Back Buttons -- ENDS -->
					</div><!-- Build Process Right Third Process -- ENDS -->
				</div><!-- Main Process Replace Wrap -- STARTS -->

				<div class="sidebar-left-section"><!-- Side Bar -- STARTS -->
	 				<div class="top-order-summary-heading">
	 					<h3><?=change_lang('Order Summary')?></h3>
	 					<span class="right-pull-price"><?=change_lang('Price in')?> (<span class="currency_type">GBP</span>)</span>
					</div>
					<div class="main-sumup-wrapp">
						<div class="location-sumup">
							<div class="item-section-left">
								<h5><?=change_lang('Location')?> <span  class="location-api">London</span></h5>
								<p class="location-country">United Kingdom</p>
							</div>
							<div class="item-count-right flex-end">
								<span class="total-cost-highlight"><span class="text-cycle"><?=change_lang('Pay Monthly')?></span></span>
							</div>
						</div>
						<div class="starter-sumup">
							<div class="item-section-left">
								<h5 class="product_name">Starter</h5>
								<div class="item-count-right flex-end">
									<span class="total-cost-highlight"><span class="amount_product_static">0.00</span></span>
								</div>
							</div>
							<hr class="white-hr" />				                                                             	
							<div class="item-section-left">
								<p><?=change_lang('Control Panel')?></p>
								<div class="item-count-right">
									<span class="cp_name"> </span>
									<span class="cp_price"> 0.00</span>
								</div>
							</div>
							<hr class="white-hr" />					
							<div class="item-section-left">
								<p><?=change_lang('Operating System')?></p>
								<div class="item-count-right">
									<span class="OS_name"> </span>
									<span class="OS_price"> 0.00</span>
								</div>
							</div>	
							<hr class="white-hr" />					
							<div class="item-section-left">
								<p><?=change_lang('Backup Plan')?></p>
								<div class="item-count-right">
									<span class="bp_name"> </span>
									<span class="bp_price"> 0.00</span>
								</div>
							</div>
							<hr class="white-hr" />					
							<div class="item-section-left" style="display: none;">
								<p><?=change_lang('Additional RAM')?></p>
								<div class="item-count-right">
									<span class="AR_name"> </span>
									<span class="AR_price"> 0.00</span>
								</div>
							</div>	
							<hr class="white-hr" />					
							<div class="item-section-left" style="display: none;">
								<p><?=change_lang('Additional Storage (£0.17/GB)')?></p>
								<div class="item-count-right">
									<span class="AS_name"> </span>
									<span class="AS_price"> 0.00</span>
								</div>
							</div>	
							<hr class="white-hr" />					
							<div class="item-section-left" style="display: none;">
								<p><?=change_lang('Addition vCPU Cores')?></p>
								<div class="item-count-right">
									<span class="AC_name"> </span>
									<span class="AC_price"> 0.00</span>
								</div>
							</div>
							<hr class="white-hr" />					
							<div class="item-section-left" style="display: none;">
								<p><?=change_lang('Additional IPv4')?></p>
								<div class="item-count-right">
									<span class="AIP4_name"> </span>
									<span class="AIP4_price"> 0.00</span>
								</div>
							</div>
							<hr class="white-hr" />					
							<div class="item-section-left" style="display: none;">
								<p><?=change_lang('Additional IPv6')?></p>
								<div class="item-count-right">
									<span class="AIP6_name"> </span>
									<span class="AIP6_price"> 0.00</span>
								</div>
							</div>						
						</div>
						<div class="total-sumup">
							<div class="item-section-left">
								<h3><?=change_lang('Total')?></h3>
								<p><?=change_lang('Total to be paid today (excl. Tax)')?></p>
							</div>
							<div class="item-count-right flex-end">
								<span class="total-cost-highlight"><span class="amount_product_update">0.00</span></span>
							</div>
						</div>
						<hr class="white-hr" />	
						<div class="total-next-sumup">
							<div class="item-section-left">
								<h3><?=change_lang('Next Payment')?></h3>
								<p><?=change_lang('Total to be paid (excl. Tax)')?></p>
							</div>
							<div class="item-count-right flex-end">
								<span class="total-cost-highlight-next-month"><span class="amount_product_update">0.00</span></span>
							</div>
						</div>
						<div class="tax-text-sumup">						
							<p class="pink-tax-text"><?=change_lang('Tax will be calculated once your location has been verified.')?></p>
						</div>
					</div>
					<h3 class="payment-we-accept"><?=change_lang('You can pay with')?></h3>
					<div class="payment-gateway">
						<div class="paypal">
							<span><img src="images/payPal.png"></span>
						</div>
						<div class="debit-credit-card">
							<span><img src="images/Visa_1.png"></span>
						</div>
						<div class="bitcoin">
							<span><img src="images/Bitcoin_png.png"></span>
						</div>
						<div class="alipay">
							<span><img src="images/Alipay_.png"></span>
						</div>
						<div class="unionpay">
							<span><img src="images/unionpaypal.png"></span>
						</div>
					</div>				
				</div><!-- Side Bar -- ENDS -->
			</div><!-- First Process Ends -- BUILD -->

			<div class="register-login-wrap" style="display: none;">
				<div class="left-login-section">
					<div class="logo-section">
						<img src="images/host-world-logo.png" />
					</div>
					<div class="content-section-login">
						<h1><?=change_lang('LOGIN NOW >>')?></h1>
						<p><?=change_lang('This area is for hostworld customers')?></p>
						<label for="email-address">
							<span><?=change_lang('Email Address')?></span>
							<input type="text" name="email-add" id="email-address" class="change" placeholder="<?=change_lang('Enter email address')?>">	
						</label>
						<label for="password">
							<span><?=change_lang('Password')?></span>
							<input type="password" name="password" id="password"  class="change" placeholder="Enter Password">	
						</label>
						<button type="button" class="login-button" id="login-button"><?=change_lang('LOGIN NOW')?></button>
						<div class="success_login">
							<p></p>
							<span><i class="fa fa-refresh fa-spin"></i></span>
						</div>
						<div class="failure_login">
							<p></p>
							<span><i class="fa fa-times"></i></span>
						</div>
						<p class="remove-bottom"><?=change_lang('Be the part of our awesome team<br/> and have fun with us!')?></p>	
						<button type="button" id="third-process-back-button"><img style="transform: rotate(180deg);margin-left: 0;" src="images/right-arrow.svg"> <?=change_lang('Back')?></button>
					</div>
				</div>
				<div class="right-register-section">
					<h1><?=change_lang('SIGNUP NOW >>')?></h1>
					<div class="main-register-section">
						<div class="personal-info-section">
							<p><?=change_lang('Personal Information')?></p>
							<div class="input-area-register">
								<div class="first-section-input">
									<label for="first-name">
										<span><?=change_lang('FirstName')?></span>
										<input type="text" name="first-name-user" id="first-name" class="change" placeholder="<?=change_lang('Enter firstname')?>">	
									</label>
									<label for="last-name">
										<span><?=change_lang('Lastname')?></span>
										<input type="text" name="last-name-user" id="last-name" class="change" placeholder="<?=change_lang('Enter lastname')?>">	
									</label>
								</div>
								<div class="second-section-input">
									<label for="email-address-register">
										<span><?=change_lang('Email Address')?></span>
										<input type="text" name="email-add-register" id="email-address-register" class="change" placeholder="Enter email address">	
									</label>
									<label for="phone-number">
										<span><?=change_lang('Phone Number')?></span>
										<input type="text" name="phone-number-user" id="phone-number-user" class="change" placeholder="<?=change_lang('Enter phone number')?>">	
									</label>
								</div>
							</div>
						</div>
						<div class="account-security-section">
							<p><?=change_lang('Account Security')?></p>
							<div class="input-area-register">
								<div class="first-section-input">
									<label for="password-first">
										<span><?=change_lang('Password')?></span>
										<input type="password" name="password-user" id="password-first" class="change" placeholder="<?=change_lang('Enter password')?>">	
									</label>
									<label for="confirm-pass">
										<span><?=change_lang('Confirm Password')?></span>
										<input type="password" name="confirm-pass-user" id="confirm-pass" class="change" placeholder="<?=change_lang('Enter confirm password')?>">	
									</label>
								</div>
								<div class="second-section-input">
									<label for="inputSecurityQId">
										<span><?=change_lang('Please choose a security question')?></span>
										<select name="securityqid" id="inputSecurityQId" class="field">
                                        	<option value=""><?=change_lang('Please choose a security question')?></option>
                                            <option value="1">
                                                <?=change_lang('What was your childhood nickname?')?>
                                            </option>
                                            <option value="2">
                                                <?=change_lang('What is the name of your favourite childhood friend?')?>
                                            </option>
                                            <option value="3">
                                                <?=change_lang('What is the middle name of your oldest child?')?>
                                            </option>
                                            <option value="4">
                                                <?=change_lang('In what town was your first job?')?>
                                            </option>
                                            <option value="5">
                                               <?=change_lang('What is your pets name?')?>
                                            </option>
                                            <option value="6">
                                                <?=change_lang('What year was you born?')?>
                                            </option>
                                             <option value="7">
                                                <?=change_lang('What was the name of the company where you had your first job?')?>
                                            </option>
                                            <option value="8">
                                                <?=change_lang('What is your favourite colour?')?>
                                            </option>
                                        </select>
									</label>
									<label for="s_ans">
										<span style="visibility: hidden;">Phone Number</span>
										<input type="text" name="s_ans-user" id="s_ans" class="change" placeholder="<?=change_lang('Please enter an answer')?>">	
									</label>
								</div>
							</div>
						</div>
						<div class="billing-address-section">
							<p><?=change_lang('Billing Address')?></p>
							<div class="input-area-register">
								<div class="first-section-input">
									<label for="inputCompanyName">
										<span><?=change_lang('Company Name')?> <span style="text-transform: capitalize;font-size: 12px;">(<?=change_lang('Optional')?>)</span></span>
										<input type="text" name="companyname" id="inputCompanyName" class="change" placeholder="Enter company name">	
									</label>
									<label for="inputAddress1">
										<span><?=change_lang('Street Address')?></span>
										<input type="text" name="inputAddress1-user" id="inputAddress1" class="change" placeholder="<?=change_lang('Enter Street Address')?>">	
									</label>
								</div>
								<div class="first-section-input">
									<label for="inputAddress2">
										<span><?=change_lang('Street Address 2')?></span>
										<input type="text" name="inputAddress2-user" id="inputAddress2" class="change" placeholder="<?=change_lang('Street Address 2')?>">	
									</label>
									<label for="inputCity">
										<span><?=change_lang('City')?></span>
										<input type="text" name="inputCity-user" id="inputCity" class="change" placeholder="<?=change_lang('Enter City')?>">	
									</label>
								</div>
								<div class="first-section-input">
									<label for="stateselect">
										<span><?=change_lang('State')?></span>
										<select name="state" id="stateselect" required="required">
											<option value=""><?=change_lang('Select City')?></option><option>Avon</option><option>Aberdeenshire</option><option>Angus</option><option>Argyll and Bute</option><option>Barking and Dagenham</option><option>Barnet</option><option>Barnsley</option><option>Bath and North East Somerset</option><option>Bedfordshire</option><option>Berkshire</option><option>Bexley</option><option>Birmingham</option><option>Blackburn with Darwen</option><option>Blackpool</option><option>Blaenau Gwent</option><option>Bolton</option><option>Bournemouth</option><option>Bracknell Forest</option><option>Bradford</option><option>Brent</option><option>Bridgend</option><option>Brighton and Hove</option><option>Bromley</option><option>Buckinghamshire</option><option>Bury</option><option>Caerphilly</option><option>Calderdale</option><option>Cambridgeshire</option><option>Camden</option><option>Cardiff</option><option>Carmarthenshire</option><option>Ceredigion</option><option>Cheshire</option><option>Cleveland</option><option>City of Bristol</option><option>City of Edinburgh</option><option>City of Kingston upon Hull</option><option>City of London</option><option>Clackmannanshire</option><option>Conwy</option><option>Cornwall</option><option>Coventry</option><option>Croydon</option><option>Cumbria</option><option>Darlington</option><option>Denbighshire</option><option>Derby</option><option>Derbyshire</option><option>Devon</option><option>Doncaster</option><option>Dorset</option><option>Dudley</option><option>Dumfries and Galloway</option><option>Dundee City</option><option>Durham</option><option>Ealing</option><option>East Ayrshire</option><option>East Dunbartonshire</option><option>East Lothian</option><option>East Renfrewshire</option><option>East Riding of Yorkshire</option><option>East Sussex</option><option>Eilean Siar (Western Isles)</option><option>Enfield</option><option>Essex</option><option>Falkirk</option><option>Fife</option><option>Flintshire</option><option>Gateshead</option><option>Glasgow City</option><option>Gloucestershire</option><option>Greenwich</option><option>Gwynedd</option><option>Hackney</option><option>Halton</option><option>Hammersmith and Fulham</option><option>Hampshire</option><option>Haringey</option><option>Harrow</option><option>Hartlepool</option><option>Havering</option><option>Herefordshire</option><option>Hertfordshire</option><option>Highland</option><option>Hillingdon</option><option>Hounslow</option><option>Inverclyde</option><option>Isle of Anglesey</option><option>Isle of Wight</option><option>Islington</option><option>Kensington and Chelsea</option><option>Kent</option><option>Kingston upon Thames</option><option>Kirklees</option><option>Knowsley</option><option>Lambeth</option><option>Lancashire</option><option>Leeds</option><option>Leicester</option><option>Leicestershire</option><option>Lewisham</option><option>Lincolnshire</option><option>Liverpool</option><option>London</option><option>Luton</option><option>Manchester</option><option>Medway</option><option>Merthyr Tydfil</option><option>Merton</option><option>Merseyside</option><option>Middlesbrough</option><option>Middlesex</option><option>Midlothian</option><option>Milton Keynes</option><option>Monmouthshire</option><option>Moray</option><option>Neath Port Talbot</option><option>Newcastle upon Tyne</option><option>Newham</option><option>Newport</option><option>Norfolk</option><option>North Ayrshire</option><option>North East Lincolnshire</option><option>North Lanarkshire</option><option>North Lincolnshire</option><option>North Somerset</option><option>North Tyneside</option><option>North Yorkshire</option><option>Northamptonshire</option><option>Northumberland</option><option>North Humberside</option><option>Nottingham</option><option>Nottinghamshire</option><option>Oldham</option><option>Orkney Islands</option><option>Oxfordshire</option><option>Pembrokeshire</option><option>Perth and Kinross</option><option>Peterborough</option><option>Plymouth</option><option>Poole</option><option>Portsmouth</option><option>Powys</option><option>Reading</option><option>Redbridge</option><option>Renfrewshire</option><option>Rhondda Cynon Taff</option><option>Richmond upon Thames</option><option>Rochdale</option><option>Rotherham</option><option>Rutland</option><option>Salford</option><option>Sandwell</option><option>Sefton</option><option>Sheffield</option><option>Shetland Islands</option><option>Shropshire</option><option>Slough</option><option>Solihull</option><option>Somerset</option><option>South Ayrshire</option><option>South Humberside</option><option>South Gloucestershire</option><option>South Lanarkshire</option><option>South Tyneside</option><option>Southampton</option><option>Southend-on-Sea</option><option>Southwark</option><option>South Yorkshire</option><option>St. Helens</option><option>Staffordshire</option><option>Stirling</option><option>Stockport</option><option>Stockton-on-Tees</option><option>Stoke-on-Trent</option><option>Suffolk</option><option>Sunderland</option><option>Surrey</option><option>Sutton</option><option>Swansea</option><option>Swindon</option><option>Tameside</option><option>Telford and Wrekin</option><option>The Scottish Borders</option><option>The Vale of Glamorgan</option><option>Thurrock</option><option>Torbay</option><option>Torfaen</option><option>Tower Hamlets</option><option>Trafford</option><option>Tyne and Wear</option><option>Wakefield</option><option>Walsall</option><option>Waltham Forest</option><option>Wandsworth</option><option>Warrington</option><option>Warwickshire</option><option>West Midlands</option><option>West Dunbartonshire</option><option>West Lothian</option><option>West Sussex</option><option>West Yorkshire</option><option>Westminster</option><option>Wigan</option><option>Wiltshire</option><option>Windsor and Maidenhead</option><option>Wirral</option><option>Wokingham</option><option>Wolverhampton</option><option>Worcestershire</option><option>Wrexham</option><option>York</option><option>Co. Antrim</option><option>Co. Armagh</option><option>Co. Down</option><option>Co. Fermanagh</option><option>Co. Londonderry</option><option>Co. Tyrone</option>
										</select>
									</label>
									<label for="inputPostcode">
										<span><?=change_lang('Postcode')?></span>
										<input type="text" name="inputPostcode" id="inputPostcode" class="change" placeholder="<?=change_lang('Enter postcode')?>">	
									</label>
								</div>
								<div class="first-section-input">
									<label for="inputCountry">
										<span><?=change_lang('Country')?></span>
										<select name="country" id="inputCountry">
                                                            <option value="AF">
					                                    Afghanistan
					                                </option>
					                                                            <option value="AX">
					                                    Aland Islands
					                                </option>
					                                                            <option value="AL">
					                                    Albania
					                                </option>
					                                                            <option value="DZ">
					                                    Algeria
					                                </option>
					                                                            <option value="AS">
					                                    American Samoa
					                                </option>
					                                                            <option value="AD">
					                                    Andorra
					                                </option>
					                                                            <option value="AO">
					                                    Angola
					                                </option>
					                                                            <option value="AI">
					                                    Anguilla
					                                </option>
					                                                            <option value="AQ">
					                                    Antarctica
					                                </option>
					                                                            <option value="AG">
					                                    Antigua And Barbuda
					                                </option>
					                                                            <option value="AR">
					                                    Argentina
					                                </option>
					                                                            <option value="AM">
					                                    Armenia
					                                </option>
					                                                            <option value="AW">
					                                    Aruba
					                                </option>
					                                                            <option value="AU">
					                                    Australia
					                                </option>
					                                                            <option value="AT">
					                                    Austria
					                                </option>
					                                                            <option value="AZ">
					                                    Azerbaijan
					                                </option>
					                                                            <option value="BS">
					                                    Bahamas
					                                </option>
					                                                            <option value="BH">
					                                    Bahrain
					                                </option>
					                                                            <option value="BD">
					                                    Bangladesh
					                                </option>
					                                                            <option value="BB">
					                                    Barbados
					                                </option>
					                                                            <option value="BY">
					                                    Belarus
					                                </option>
					                                                            <option value="BE">
					                                    Belgium
					                                </option>
					                                                            <option value="BZ">
					                                    Belize
					                                </option>
					                                                            <option value="BJ">
					                                    Benin
					                                </option>
					                                                            <option value="BM">
					                                    Bermuda
					                                </option>
					                                                            <option value="BT">
					                                    Bhutan
					                                </option>
					                                                            <option value="BO">
					                                    Bolivia
					                                </option>
					                                                            <option value="BA">
					                                    Bosnia And Herzegovina
					                                </option>
					                                                            <option value="BW">
					                                    Botswana
					                                </option>
					                                                            <option value="BR">
					                                    Brazil
					                                </option>
					                                                            <option value="IO">
					                                    British Indian Ocean Territory
					                                </option>
					                                                            <option value="BN">
					                                    Brunei Darussalam
					                                </option>
					                                                            <option value="BG">
					                                    Bulgaria
					                                </option>
					                                                            <option value="BF">
					                                    Burkina Faso
					                                </option>
					                                                            <option value="BI">
					                                    Burundi
					                                </option>
					                                                            <option value="KH">
					                                    Cambodia
					                                </option>
					                                                            <option value="CM">
					                                    Cameroon
					                                </option>
					                                                            <option value="CA">
					                                    Canada
					                                </option>
					                                                            <option value="CV">
					                                    Cape Verde
					                                </option>
					                                                            <option value="KY">
					                                    Cayman Islands
					                                </option>
					                                                            <option value="CF">
					                                    Central African Republic
					                                </option>
					                                                            <option value="TD">
					                                    Chad
					                                </option>
					                                                            <option value="CL">
					                                    Chile
					                                </option>
					                                                            <option value="CN">
					                                    China
					                                </option>
					                                                            <option value="CX">
					                                    Christmas Island
					                                </option>
					                                                            <option value="CC">
					                                    Cocos (Keeling) Islands
					                                </option>
					                                                            <option value="CO">
					                                    Colombia
					                                </option>
					                                                            <option value="KM">
					                                    Comoros
					                                </option>
					                                                            <option value="CG">
					                                    Congo
					                                </option>
					                                                            <option value="CD">
					                                    Congo, Democratic Republic
					                                </option>
					                                                            <option value="CK">
					                                    Cook Islands
					                                </option>
					                                                            <option value="CR">
					                                    Costa Rica
					                                </option>
					                                                            <option value="CI">
					                                    Cote D'Ivoire
					                                </option>
					                                                            <option value="HR">
					                                    Croatia
					                                </option>
					                                                            <option value="CU">
					                                    Cuba
					                                </option>
					                                                            <option value="CW">
					                                    Curacao
					                                </option>
					                                                            <option value="CY">
					                                    Cyprus
					                                </option>
					                                                            <option value="CZ">
					                                    Czech Republic
					                                </option>
					                                                            <option value="DK">
					                                    Denmark
					                                </option>
					                                                            <option value="DJ">
					                                    Djibouti
					                                </option>
					                                                            <option value="DM">
					                                    Dominica
					                                </option>
					                                                            <option value="DO">
					                                    Dominican Republic
					                                </option>
					                                                            <option value="EC">
					                                    Ecuador
					                                </option>
					                                                            <option value="EG">
					                                    Egypt
					                                </option>
					                                                            <option value="SV">
					                                    El Salvador
					                                </option>
					                                                            <option value="GQ">
					                                    Equatorial Guinea
					                                </option>
					                                                            <option value="ER">
					                                    Eritrea
					                                </option>
					                                                            <option value="EE">
					                                    Estonia
					                                </option>
					                                                            <option value="ET">
					                                    Ethiopia
					                                </option>
					                                                            <option value="FK">
					                                    Falkland Islands (Malvinas)
					                                </option>
					                                                            <option value="FO">
					                                    Faroe Islands
					                                </option>
					                                                            <option value="FJ">
					                                    Fiji
					                                </option>
					                                                            <option value="FI">
					                                    Finland
					                                </option>
					                                                            <option value="FR">
					                                    France
					                                </option>
					                                                            <option value="GF">
					                                    French Guiana
					                                </option>
					                                                            <option value="PF">
					                                    French Polynesia
					                                </option>
					                                                            <option value="TF">
					                                    French Southern Territories
					                                </option>
					                                                            <option value="GA">
					                                    Gabon
					                                </option>
					                                                            <option value="GM">
					                                    Gambia
					                                </option>
					                                                            <option value="GE">
					                                    Georgia
					                                </option>
					                                                            <option value="DE">
					                                    Germany
					                                </option>
					                                                            <option value="GH">
					                                    Ghana
					                                </option>
					                                                            <option value="GI">
					                                    Gibraltar
					                                </option>
					                                                            <option value="GR">
					                                    Greece
					                                </option>
					                                                            <option value="GL">
					                                    Greenland
					                                </option>
					                                                            <option value="GD">
					                                    Grenada
					                                </option>
					                                                            <option value="GP">
					                                    Guadeloupe
					                                </option>
					                                                            <option value="GU">
					                                    Guam
					                                </option>
					                                                            <option value="GT">
					                                    Guatemala
					                                </option>
					                                                            <option value="GG">
					                                    Guernsey
					                                </option>
					                                                            <option value="GN">
					                                    Guinea
					                                </option>
					                                                            <option value="GW">
					                                    Guinea-Bissau
					                                </option>
					                                                            <option value="GY">
					                                    Guyana
					                                </option>
					                                                            <option value="HT">
					                                    Haiti
					                                </option>
					                                                            <option value="HM">
					                                    Heard Island &amp; Mcdonald Islands
					                                </option>
					                                                            <option value="VA">
					                                    Holy See (Vatican City State)
					                                </option>
					                                                            <option value="HN">
					                                    Honduras
					                                </option>
					                                                            <option value="HK">
					                                    Hong Kong
					                                </option>
					                                                            <option value="HU">
					                                    Hungary
					                                </option>
					                                                            <option value="IS">
					                                    Iceland
					                                </option>
					                                                            <option value="IN">
					                                    India
					                                </option>
					                                                            <option value="ID">
					                                    Indonesia
					                                </option>
					                                                            <option value="IR">
					                                    Iran, Islamic Republic Of
					                                </option>
					                                                            <option value="IQ">
					                                    Iraq
					                                </option>
					                                                            <option value="IE">
					                                    Ireland
					                                </option>
					                                                            <option value="IM">
					                                    Isle Of Man
					                                </option>
					                                                            <option value="IL">
					                                    Israel
					                                </option>
					                                                            <option value="IT">
					                                    Italy
					                                </option>
					                                                            <option value="JM">
					                                    Jamaica
					                                </option>
					                                                            <option value="JP">
					                                    Japan
					                                </option>
					                                                            <option value="JE">
					                                    Jersey
					                                </option>
					                                                            <option value="JO">
					                                    Jordan
					                                </option>
					                                                            <option value="KZ">
					                                    Kazakhstan
					                                </option>
					                                                            <option value="KE">
					                                    Kenya
					                                </option>
					                                                            <option value="KI">
					                                    Kiribati
					                                </option>
					                                                            <option value="KR">
					                                    Korea
					                                </option>
					                                                            <option value="KW">
					                                    Kuwait
					                                </option>
					                                                            <option value="KG">
					                                    Kyrgyzstan
					                                </option>
					                                                            <option value="LA">
					                                    Lao People's Democratic Republic
					                                </option>
					                                                            <option value="LV">
					                                    Latvia
					                                </option>
					                                                            <option value="LB">
					                                    Lebanon
					                                </option>
					                                                            <option value="LS">
					                                    Lesotho
					                                </option>
					                                                            <option value="LR">
					                                    Liberia
					                                </option>
					                                                            <option value="LY">
					                                    Libyan Arab Jamahiriya
					                                </option>
					                                                            <option value="LI">
					                                    Liechtenstein
					                                </option>
					                                                            <option value="LT">
					                                    Lithuania
					                                </option>
					                                                            <option value="LU">
					                                    Luxembourg
					                                </option>
					                                                            <option value="MO">
					                                    Macao
					                                </option>
					                                                            <option value="MK">
					                                    Macedonia
					                                </option>
					                                                            <option value="MG">
					                                    Madagascar
					                                </option>
					                                                            <option value="MW">
					                                    Malawi
					                                </option>
					                                                            <option value="MY">
					                                    Malaysia
					                                </option>
					                                                            <option value="MV">
					                                    Maldives
					                                </option>
					                                                            <option value="ML">
					                                    Mali
					                                </option>
					                                                            <option value="MT">
					                                    Malta
					                                </option>
					                                                            <option value="MH">
					                                    Marshall Islands
					                                </option>
					                                                            <option value="MQ">
					                                    Martinique
					                                </option>
					                                                            <option value="MR">
					                                    Mauritania
					                                </option>
					                                                            <option value="MU">
					                                    Mauritius
					                                </option>
					                                                            <option value="YT">
					                                    Mayotte
					                                </option>
					                                                            <option value="MX">
					                                    Mexico
					                                </option>
					                                                            <option value="FM">
					                                    Micronesia, Federated States Of
					                                </option>
					                                                            <option value="MD">
					                                    Moldova
					                                </option>
					                                                            <option value="MC">
					                                    Monaco
					                                </option>
					                                                            <option value="MN">
					                                    Mongolia
					                                </option>
					                                                            <option value="ME">
					                                    Montenegro
					                                </option>
					                                                            <option value="MS">
					                                    Montserrat
					                                </option>
					                                                            <option value="MA">
					                                    Morocco
					                                </option>
					                                                            <option value="MZ">
					                                    Mozambique
					                                </option>
					                                                            <option value="MM">
					                                    Myanmar
					                                </option>
					                                                            <option value="NA">
					                                    Namibia
					                                </option>
					                                                            <option value="NR">
					                                    Nauru
					                                </option>
					                                                            <option value="NP">
					                                    Nepal
					                                </option>
					                                                            <option value="NL">
					                                    Netherlands
					                                </option>
					                                                            <option value="AN">
					                                    Netherlands Antilles
					                                </option>
					                                                            <option value="NC">
					                                    New Caledonia
					                                </option>
					                                                            <option value="NZ">
					                                    New Zealand
					                                </option>
					                                                            <option value="NI">
					                                    Nicaragua
					                                </option>
					                                                            <option value="NE">
					                                    Niger
					                                </option>
					                                                            <option value="NG">
					                                    Nigeria
					                                </option>
					                                                            <option value="NU">
					                                    Niue
					                                </option>
					                                                            <option value="NF">
					                                    Norfolk Island
					                                </option>
					                                                            <option value="MP">
					                                    Northern Mariana Islands
					                                </option>
					                                                            <option value="NO">
					                                    Norway
					                                </option>
					                                                            <option value="OM">
					                                    Oman
					                                </option>
					                                                            <option value="PK">
					                                    Pakistan
					                                </option>
					                                                            <option value="PW">
					                                    Palau
					                                </option>
					                                                            <option value="PS">
					                                    Palestine, State of
					                                </option>
					                                                            <option value="PA">
					                                    Panama
					                                </option>
					                                                            <option value="PG">
					                                    Papua New Guinea
					                                </option>
					                                                            <option value="PY">
					                                    Paraguay
					                                </option>
					                                                            <option value="PE">
					                                    Peru
					                                </option>
					                                                            <option value="PH">
					                                    Philippines
					                                </option>
					                                                            <option value="PN">
					                                    Pitcairn
					                                </option>
					                                                            <option value="PL">
					                                    Poland
					                                </option>
					                                                            <option value="PT">
					                                    Portugal
					                                </option>
					                                                            <option value="PR">
					                                    Puerto Rico
					                                </option>
					                                                            <option value="QA">
					                                    Qatar
					                                </option>
					                                                            <option value="RE">
					                                    Reunion
					                                </option>
					                                                            <option value="RO">
					                                    Romania
					                                </option>
					                                                            <option value="RU">
					                                    Russian Federation
					                                </option>
					                                                            <option value="RW">
					                                    Rwanda
					                                </option>
					                                                            <option value="BL">
					                                    Saint Barthelemy
					                                </option>
					                                                            <option value="SH">
					                                    Saint Helena
					                                </option>
					                                                            <option value="KN">
					                                    Saint Kitts And Nevis
					                                </option>
					                                                            <option value="LC">
					                                    Saint Lucia
					                                </option>
					                                                            <option value="MF">
					                                    Saint Martin
					                                </option>
					                                                            <option value="PM">
					                                    Saint Pierre And Miquelon
					                                </option>
					                                                            <option value="VC">
					                                    Saint Vincent And Grenadines
					                                </option>
					                                                            <option value="WS">
					                                    Samoa
					                                </option>
					                                                            <option value="SM">
					                                    San Marino
					                                </option>
					                                                            <option value="ST">
					                                    Sao Tome And Principe
					                                </option>
					                                                            <option value="SA">
					                                    Saudi Arabia
					                                </option>
					                                                            <option value="SN">
					                                    Senegal
					                                </option>
					                                                            <option value="RS">
					                                    Serbia
					                                </option>
					                                                            <option value="SC">
					                                    Seychelles
					                                </option>
					                                                            <option value="SL">
					                                    Sierra Leone
					                                </option>
					                                                            <option value="SG">
					                                    Singapore
					                                </option>
					                                                            <option value="SK">
					                                    Slovakia
					                                </option>
					                                                            <option value="SI">
					                                    Slovenia
					                                </option>
					                                                            <option value="SB">
					                                    Solomon Islands
					                                </option>
					                                                            <option value="SO">
					                                    Somalia
					                                </option>
					                                                            <option value="ZA">
					                                    South Africa
					                                </option>
					                                                            <option value="GS">
					                                    South Georgia And Sandwich Isl.
					                                </option>
					                                                            <option value="ES">
					                                    Spain
					                                </option>
					                                                            <option value="LK">
					                                    Sri Lanka
					                                </option>
					                                                            <option value="SD">
					                                    Sudan
					                                </option>
					                                                            <option value="SR">
					                                    Suriname
					                                </option>
					                                                            <option value="SJ">
					                                    Svalbard And Jan Mayen
					                                </option>
					                                                            <option value="SZ">
					                                    Swaziland
					                                </option>
					                                                            <option value="SE">
					                                    Sweden
					                                </option>
					                                                            <option value="CH">
					                                    Switzerland
					                                </option>
					                                                            <option value="SY">
					                                    Syrian Arab Republic
					                                </option>
					                                                            <option value="TW">
					                                    Taiwan
					                                </option>
					                                                            <option value="TJ">
					                                    Tajikistan
					                                </option>
					                                                            <option value="TZ">
					                                    Tanzania
					                                </option>
					                                                            <option value="TH">
					                                    Thailand
					                                </option>
					                                                            <option value="TL">
					                                    Timor-Leste
					                                </option>
					                                                            <option value="TG">
					                                    Togo
					                                </option>
					                                                            <option value="TK">
					                                    Tokelau
					                                </option>
					                                                            <option value="TO">
					                                    Tonga
					                                </option>
					                                                            <option value="TT">
					                                    Trinidad And Tobago
					                                </option>
					                                                            <option value="TN">
					                                    Tunisia
					                                </option>
					                                                            <option value="TR">
					                                    Turkey
					                                </option>
					                                                            <option value="TM">
					                                    Turkmenistan
					                                </option>
					                                                            <option value="TC">
					                                    Turks And Caicos Islands
					                                </option>
					                                                            <option value="TV">
					                                    Tuvalu
					                                </option>
					                                                            <option value="UG">
					                                    Uganda
					                                </option>
					                                                            <option value="UA">
					                                    Ukraine
					                                </option>
					                                                            <option value="AE">
					                                    United Arab Emirates
					                                </option>
					                                                            <option value="GB" selected="selected">
					                                    United Kingdom
					                                </option>
					                                                            <option value="US">
					                                    United States
					                                </option>
					                                                            <option value="UM">
					                                    United States Outlying Islands
					                                </option>
					                                                            <option value="UY">
					                                    Uruguay
					                                </option>
					                                                            <option value="UZ">
					                                    Uzbekistan
					                                </option>
					                                                            <option value="VU">
					                                    Vanuatu
					                                </option>
					                                                            <option value="VE">
					                                    Venezuela
					                                </option>
					                                                            <option value="VN">
					                                    Viet Nam
					                                </option>
					                                                            <option value="VG">
					                                    Virgin Islands, British
					                                </option>
					                                                            <option value="VI">
					                                    Virgin Islands, U.S.
					                                </option>
					                                                            <option value="WF">
					                                    Wallis And Futuna
					                                </option>
					                                                            <option value="EH">
					                                    Western Sahara
					                                </option>
					                                                            <option value="YE">
					                                    Yemen
					                                </option>
					                                                            <option value="ZM">
					                                    Zambia
					                                </option>
					                                                            <option value="ZW">
					                                    Zimbabwe
					                                </option>
					                                                    </select>	
									</label>
								</div>
								<button type="button" class="login-button" id="register-button"><?=change_lang('SIGNUP NOW')?></button>					
							</div>
						</div>						
					</div>
				</div>
				<div class="error-fraud-order">
				    <h3>Your Order has been flagged</h3>
				    <p>Your order has been flagged as suspicious this can be due to using a VPN or your details have been added to our Fraud Database. Please <a href="/contact-us">contact support</a> by opening a ticket.</p>
				</div>
			</div>
		</form>		
	</div><!-- Main Wrapper Section -- ENDS -->	
	<script type="text/javascript" src="js/custom_api.js?time=<?php echo time(); ?>" defer="defer"></script>
	<script type="text/javascript" src="js/custom_front_end.js?time=<?php echo time(); ?>" defer="defer"></script>
	<script src="https://cdn.jsdelivr.net/npm/@splidejs/splide@latest/dist/js/splide.min.js"></script>
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@splidejs/splide@latest/dist/css/splide.min.css">
</body>
</html>