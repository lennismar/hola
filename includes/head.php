<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html lang="<?php echo $lng; ?>">
<head>
	<base href="/">
	<meta charset="utf-8">
	<meta name="HandheldFriendly" content="True">
	<meta name="MobileOptimized" content="320">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="robots" content="<?php echo $meta_index; ?>index,<?php echo $meta_follow; ?>follow">
	<title><?php echo $meta_title; ?></title>
	<meta name="description" content="<?php echo $meta_description; ?>">
	<meta name="keywords" content="<?php echo $meta_keywords; ?>" />

    <!-- Google Tag Manager -->
    <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
                new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
            j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
            'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
        })(window,document,'script','dataLayer','GTM-ZMMB');</script>
    <!-- End Google Tag Manager -->

    <?php if(isset($rel_canonical)) echo $rel_canonical; ?>

	<!-- Meta: Open Graph protocol -->

	<?php echo linkHreflang($lng); ?>

	<meta property="og:site_name" content="<?php echo ((empty($og_site_name))?APP_NAME:$og_site_name); ?>">
	<meta property="og:title" content="<?php echo ((empty($og_title))?$meta_title:$og_title); ?>" />
	<meta property="og:type" content="website" />
	<meta property="og:url" content="<?php echo ((empty($og_url))?URL_BASE.$_SERVER['REQUEST_URI']:$og_url);?>" />
	<meta property="og:image" content="<?php if(empty($og_image)) { echo URL_BASE."images/uploads/home/planes2-home.jpg"; } else echo $og_image; ?>" />
    <meta property="og:locale" content="es_ES"/>
    <meta property="og:locale:alternate" content="ca_ES" />
    <meta property="og:locale:alternate" content="en_GB" />
    <meta property="og:locale:alternate" content="fr_FR" />
	<!--
    <meta property="og:description" content="" />
    <meta property="og:country-name" content="España"/>
    <meta property="og:locale" content=""/>
    <meta property="og:latitude" content=""/> 
    <meta property="og:longitude" content=""/>     
    <meta property="og:street-address" content=""/>     
    <meta property="og:locality" content=""/> 
    <meta property="og:region" content=""/>    
	-->

	<meta name="apple-mobile-web-app-capable" content="yes" />
	<meta name="apple-mobile-web-app-status-bar-style" content="black" />

	<link rel="shortcut icon" href="<?php echo CDN_BASE; ?>assets/img/favicon.ico" />
	<link rel="apple-touch-icon" href="<?php echo CDN_BASE; ?>assets/img/apple-touch-icon.png" />
	<link rel="image_src" href="<?php echo CDN_BASE; ?>assets/img/img_src.jpg" />

	<link href='https://fonts.googleapis.com/css?family=Open+Sans:400italic,700italic,400,700&subset=latin' rel='stylesheet' type='text/css'>

	<!-- CSS -->
	<link href="assets/css/main.min.css?v=<?php echo LIBRARIES_VERSION; ?>" rel="stylesheet">
	<link href="<?php echo CDN_BASE; ?>assets/css/custom.css?v=<?php echo LIBRARIES_VERSION; ?>" rel="stylesheet">

    <?php
    if(isset($enable_calendar) && $enable_calendar) {
        ?>
        <!-- CSS Booking Calendar -->
        <link rel="stylesheet" type="text/css" href="assets/js/BookingCalendar/css/jquery.dop.BookingCalendar.css"/>
        <!--<link rel="stylesheet" type="text/css" href="assets/js/BookingCalendar/css/css-reset.css"/>-->
        <link rel="stylesheet" type="text/css" href="assets/js/BookingCalendar/css/jquery.dop.Select.css"/>
        <link rel="stylesheet" type="text/css" href="assets/js/BookingCalendar/css/jquery.dop.BackendBookingCalendarPRO.css"/>
        <link rel="stylesheet" type="text/css" href="assets/js/BookingCalendar/css/jquery.dop.FrontendBookingCalendarPRO.css"/>
        <?php
        }
    ?>

	<!-- JS -->

    <!-- Modernizr  -->
    <script async src="<?php echo CDN_BASE; ?>assets/js/modernizr.custom.js"></script>

    <!-- jQuery  -->

    <script src="assets/js/jquery-2.2.4.min.js"></script>
    
    <script src="<?php echo CDN_BASE; ?>assets/js/jquery-ui.min.js"></script>

	<script src="assets/js/somrurals.min.js?v=<?php echo LIBRARIES_VERSION; ?>"></script>
	<!--<script src="assets/js/init.js"></script>-->
	<script src="<?php echo CDN_BASE; ?>assets/js/scripts.min.js?v=<?php echo LIBRARIES_VERSION; ?>"></script>

	<!-- Vendors  -->


	<!-- /scripts compliados -->

	<!--<script src="<?php echo CDN_BASE; ?>assets/js/somrurals_merged.min.js?v=<?php echo LIBRARIES_VERSION; ?>"></script>-->
	<!--<script src="assets/js/vendors/tabs.js"></script>-->

    <?php
    if(isset($enable_gmaps) && $enable_gmaps) {
        ?>
	<!-- GOOGLE MAPS -->
	<script src="https://maps.googleapis.com/maps/api/js?key=<?php echo GOOGLE_MAPS_API_KEY; ?>"></script>
        <?php
    }
    ?>

	<!-- Google Analytics -->
	<!-- Global site tag (gtag.js) - Google Analytics -->
	 <script async src="https://www.googletagmanager.com/gtag/js?id=UA-32728228-1"></script>
	 <script>
	 
	 

 
	  window.dataLayer = window.dataLayer || [];
	  function gtag(){dataLayer.push(arguments)};
	  gtag('js', new Date());

	  gtag('config', 'UA-32728228-1');
	  gtag('config', 'AW-873759961');
	 </script>


    <?php

    if ( null === ENVIRONMENT) {

    	echo $debugbarRenderer->renderHead(); 

    }



     //if(isset( ENVIRONMENT) && !empty(ENVIRONMENT) && ENVIRONMENT != 'production') echo $debugbarRenderer->renderHead(); ?> 
</head>
  
 
