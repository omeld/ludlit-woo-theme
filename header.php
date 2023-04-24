<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html lang="sl" xml:lang="sl" xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta property="fb:admins" content="1092820016" />
		<meta http-equiv="Content-type" content="text/html;charset=UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.0/jquery.min.js" type="text/javascript"></script>
		<script type="text/javascript" src="<?php bloginfo('template_url'); ?>/js/jquery.truncate.min.js"></script>
		<script type="text/javascript" src="<?php bloginfo('template_url'); ?>/js/myScripts.js?v=3.11248945"></script>
		<title><?php wp_title('&laquo;', true, 'right'); ?><?php bloginfo('name'); ?></title>
		<link rel="stylesheet" href="<?php bloginfo('stylesheet_directory'); ?>/home.css" type="text/css" media="screen">
		<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">

		<!-- favicons -->
		<link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png?v=jw7Kjj52yv">
		<link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png?v=jw7Kjj52yv">
		<link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png?v=jw7Kjj52yv">
		<link rel="manifest" href="/site.webmanifest?v=jw7Kjj52yv">
		<link rel="mask-icon" href="/safari-pinned-tab.svg?v=jw7Kjj52yv" color="#007a8a">
		<link rel="shortcut icon" href="/favicon.ico?v=jw7Kjj52yv">
		<meta name="apple-mobile-web-app-title" content="LUD Literatura">
		<meta name="application-name" content="LUD Literatura">
		<meta name="msapplication-TileColor" content="#ffc40d">
		<meta name="msapplication-TileImage" content="/mstile-144x144.png?v=jw7Kjj52yv">
		<meta name="theme-color" content="#ffdc00">
		<!-- end favicons -->
		
		<?php wp_head(); ?>
		<?php //require "mySilktideCookieConsent.php"; ?>
	</head>
	<body <?php body_class("sans"); ?>>

	
		<div class="ludlit_wc_manual_menu is-layout-flex">
			<p><a href="<?php echo home_url(); ?>"><strong>LUD Literatura</strong></a></p>
			<div class="is-layout-flex">
				<div class="ludlit_wc_manual_search">
					<?php echo do_shortcode('[ivory-search id="69895" title="Default Search Form"]'); ?>
				</div>
				<div class="ludlit_wc_manual_woocommerce_menu">
					<ul class="is-layout-flex">
						<li><a href="<?php echo wc_get_cart_url();?>"><i class="fa-solid fa-cart-shopping"></i></a></li>
						<li><a href="<?php echo wc_get_page_permalink('myaccount');?>"><i class="fa-solid fa-user"></i></a></li>
					</ul>
				</div>
				<div class="ludlit_wc_manual_social_menu">
					<ul class="is-layout-flex">
						<li><a href="https://facebook.com/ludliteraturazalozba"><i class="fa-brands fa-facebook"></i></a></li>
						<li><a href="https://www.instagram.com/ludliteratura/"><i class="fa-brands fa-instagram"></i></a></li>
						<li><a href="https://www.twitter.com/ludliteratura/"><i class="fa-brands fa-twitter"></i></a></li>
					</ul>
				</div>
			</div>
		</div>
	


	<div class="ludlit_wc_header_template_part">
		<?php block_template_part('ludlit-wc-header'); ?>
	</div>
	
	<div id="container" class="clearfix">