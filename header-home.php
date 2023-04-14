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
		
		<!--MAILCHIMP-->
		<script id="mcjs">!function(c,h,i,m,p){m=c.createElement(h),p=c.getElementsByTagName(h)[0],m.async=1,m.src=i,p.parentNode.insertBefore(m,p)}(document,"script","https://chimpstatic.com/mcjs-connected/js/users/ec659440ad9688227c81bf275/5de604a6b886ac4f1b4c9830e.js");</script>

		
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


<?php
// custom scripts & styles
if (($myCustomHeader = get_post_meta($post->ID, 'my-custom-header', true)) != false) {
	echo $myCustomHeader;
}
if (($myCustomScript = get_post_meta($post->ID, 'my-custom-script', true)) != false) {
	echo "<script type='text/javascript'>
		$(document).ready(function() { 
			" . $myCustomScript . "
		})
		</script>";
}

if (($myCustomStyle = get_post_meta($post->ID, 'my-custom-style', true)) != false) {
	echo "<style type='text/css'>" . $myCustomStyle . "</style>";
}

?>
		
	</head>
	<body <?php body_class("sans $bkg"); ?>>
		<div id="myTopSocialContainer" class="relative text-outer" style="background-color: #648AAA;">
			<div class="mySocialStripeMenu" style="display: flex; justify-content: space-between; align-items: center; height: 65px;">
				<a class="font-size-3 hide-title" href="<?php echo home_url(); ?>" style="font-weight: bold;">LUD Literatura</a>

				<div style="display: flex; justify-content: space-between; align-items: center; gap: 20px;">
					<div style="list-style: none; position: sticky;">
						<?php dynamic_sidebar('newlit-iskanjesitewide-widget'); ?>
				 	</div>
					<div style="display: inline-block;"> <!-- kličejo se podobne kot za true liquid block inner css class-->
						<?php wp_nav_menu(array( 'container_class' => 'menu-social-container font-size-1', 'theme_location' => 'menu_social', 'menu_class' => 'menu za socialna omrezja social-icons' ) ); ?>
					</div>
				</div>
			</div>
		</div>		
		
		<div id="myTopStripeContainer" class="relative text-outer" style="background-color: white;">	
			<div class="myTopStripeMenu">
				<div id="myTopStripe" class="newlit-css-transition-hide show-when-touched font-size-3">
					<div class="center center-margins show-only-on-small-screen font-size-3" style="line-height: 3em">
						<a class="font-size-2 light" href="<?php echo home_url(); ?>">LUD Literatura</a>
						<i class="touch-to-show fa fa-bars"></i>
					</div>
					<?php wp_nav_menu( array( 'container_class' => 'menu-menu-ena-container font-size-1', 'theme_location' => 'menu_one', 'menu_class' => 'menu clearfix' ) ); ?>
				</div>
			</div>
		</div>
		<hr style="height:2px; width:100%; border-width:0; color:grey;">
		<div id="container" class="clearfix">