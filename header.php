<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<script type="text/javascript" src="//use.typekit.net/rha7jnl.js"></script>
		<script type="text/javascript">try{Typekit.load();}catch(e){}</script>
		<meta property="fb:admins" content="1092820016" />
		<meta http-equiv="Content-type" content="text/html;charset=UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.0/jquery.min.js" type="text/javascript"></script>
		<script type="text/javascript" src="<?php bloginfo('template_url'); ?>/js/jquery.truncate.min.js"></script>
		<script type="text/javascript" src="<?php bloginfo('template_url'); ?>/js/myScripts.js?v=2.1"></script>
		<title><?php wp_title('&laquo;', true, 'right'); ?><?php bloginfo('name'); ?></title>
		<link rel="stylesheet" href="<?php bloginfo('stylesheet_directory'); ?>/style.css?v=2" type="text/css" media="screen" />
		<link rel="stylesheet" href="<?php bloginfo('stylesheet_directory'); ?>/home.css?v=3.1" type="text/css" media="screen">
		<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">

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
		
<?php wp_head(); ?>
		<?php require "mySilktideCookieConsent.php"; ?>
	</head>
<?php
$bkg = '';
if (is_home() || is_front_page()) {
	$bkg = 'gray-background';
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
