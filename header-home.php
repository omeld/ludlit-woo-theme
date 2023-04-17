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
	
	<!--
	<div style="display: flex; justify-content: space-between; align-items: center; gap: 20px;">
		<div style="list-style: none; position: sticky;">
			<?php //dynamic_sidebar('newlit-iskanjesitewide-widget'); ?>
		</div>
	</div>
-->
	<?php block_template_part('ludlit-wc-header'); ?>
	
	<div id="container" class="clearfix">