<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html lang="sl" xml:lang="sl" xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<!--BOOTSTRAP LINK-->
		<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
		
		<script type="text/javascript" src="//use.typekit.net/rha7jnl.js"></script>
		<script type="text/javascript">try{Typekit.load();}catch(e){}</script>
		<meta property="fb:admins" content="1092820016" />
		<meta http-equiv="Content-type" content="text/html;charset=UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.0/jquery.min.js" type="text/javascript"></script>
		<script type="text/javascript" src="<?php bloginfo('template_url'); ?>/js/jquery.truncate.min.js"></script>
		<script type="text/javascript" src="<?php bloginfo('template_url'); ?>/js/myScripts.js?v=3.11248945"></script>
		<!-- <link rel="stylesheet" href="<?php bloginfo('stylesheet_directory'); ?>/style.css?v=3.311143211540831" type="text/css" media="screen" />-->
		<title><?php wp_title('&laquo;', true, 'right'); ?><?php bloginfo('name'); ?></title>
		<link rel="stylesheet" href="<?php bloginfo('stylesheet_directory'); ?>/home.css" type="text/css" media="screen">
		<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">

		<!-- ZA FLATICON IKONE
		<a href="https://www.flaticon.com/free-icons/instagram" title="instagram icons">Instagram icons created by edt.im - Flaticon</a>
		<a href="https://www.flaticon.com/free-icons/facebook" title="facebook icons">Facebook icons created by Freepik - Flaticon</a>
		-->
		<!--MAILCHIMP-->
		<script id="mcjs">!function(c,h,i,m,p){m=c.createElement(h),p=c.getElementsByTagName(h)[0],m.async=1,m.src=i,p.parentNode.insertBefore(m,p)}(document,"script","https://chimpstatic.com/mcjs-connected/js/users/ec659440ad9688227c81bf275/5de604a6b886ac4f1b4c9830e.js");</script>

		
		<!--<style>
			
			.socialnaOmrezjaMenu {
				float: right;
			}
		
		</style>-->

<!-- favicons -- >
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


		<!-- <link href="<?php bloginfo('template_url'); ?>/js/flex/flexslider.css" rel="stylesheet" type="text/css" /> -->
		<!-- <script src="<?php bloginfo('template_url'); ?>/js/flex/jquery.flexslider-min.js"></script> -->
		<script>
			/*
		function getSliderItemWidth() {
			return $('#newsBulletin').width() / 5;
		}
		$(window).load(function() {
			$('.flexslider').flexslider({
				animation: "slide",
				pauseOnHover: true,
				minItems: 5,
				maxItems: 5,
				//itemWidth: getSliderItemWidth(),
				itemWidth: 100,
				itemMargin: 20
			})
		});
		*/
		</script>


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
		
<?php wp_head(); ?>
		<?php require "mySilktideCookieConsent.php"; ?>
	</head>
<?php
$bkg = '';
if (is_home() || is_front_page()) {
	//$bkg = 'gray-background';
	$bkg = 'white-background';
} elseif (is_single()) {
	$bkg = 'white-background';
} else {
}

/* za knjige? */
$queryTax  = $wp_query->query_vars['taxonomy'];
$queryTerm = $wp_query->query_vars['term'];

if ($queryTax == "zbirka" and isset($queryTerm)) {
	$series = $queryTerm;
}
/* za knjige? */
?>
	<body <?php body_class("sans $bkg"); ?>>
		<div id="myTopStripeContainer" class="relative text-outer">
			<div class="">
				<div id="myTopStripe" class="newlit-css-transition-hide show-when-touched font-size-3">
					<div class="center center-margins show-only-on-small-screen font-size-3" style="line-height: 3em">
						<a class="font-size-2 light" href="<?php echo home_url(); ?>">LUD Literatura</a>
						<i class="touch-to-show fa fa-bars"></i>
					</div>
					<?php wp_nav_menu( array( 'container_class' => 'menu-menu-ena-container font-size-1', 'theme_location' => 'menu_one', 'menu_class' => 'menu clearfix' ) ); ?>
				</div>
			</div>
		</div>
		<div id="container" class="clearfix">
<?php 
//if (is_home()) {
if (is_front_page() || is_home()) {
	get_template_part('slide'); 
}
?>
