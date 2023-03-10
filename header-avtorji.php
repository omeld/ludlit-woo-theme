<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<script type="text/javascript" src="//use.typekit.net/rha7jnl.js"></script>
		<script type="text/javascript">try{Typekit.load();}catch(e){}</script>

		<meta http-equiv="Content-type" content="text/html;charset=UTF-8" />
		<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.3/jquery.min.js"></script>
		<script type="text/javascript" src="<?php bloginfo('template_url'); ?>/js/jquery.truncate.min.js"></script>
		<script type="text/javascript" src="<?php bloginfo('template_url'); ?>/js/jquerycyclelite.js"></script>
		<script type="text/javascript" src="<?php bloginfo('template_url'); ?>/js/myScripts.js"></script>
		<title><?php wp_title('&laquo;', true, 'right'); ?><?php bloginfo('name'); ?></title>
		<link rel="stylesheet" href="<?php bloginfo('stylesheet_url'); ?>" type="text/css" media="screen" />
		<link rel="stylesheet" href="<?php bloginfo('stylesheet_directory'); ?>/home.css" type="text/css" media="screen">
		<?php wp_head(); ?>
		<?php require "mySilktideCookieConsent.php"; ?>
	</head>

	<body <?php body_class('sans avtor'); ?>>
		<div id="myTopStripeContainer" class="relative text-outer">
			<div class="">
				<div id="myTopStripe" class="">
					<div class="floatRight" style="/*height: 40px;*/ ">
						<ul id="mySidebar5" class=" sideBarLiContent" style="/*display: table-cell; vertical-align: middle; height: 40px*/">
	<?php dynamic_sidebar(5); ?>
						</ul>
					</div>
					<?php wp_nav_menu( array( 'theme_location' => 'menu_one', 'menu_class' => 'menu clearfix' ) ); ?>
				</div>
			</div>
		</div>
		<div id="container" class="clearfix">
<!--
			<div id="myTopStripe">
				<h1 class="" style=""><a id="topStripeLink" href="<?php bloginfo('url'); ?>" title="<?php bloginfo('name'); ?>"><img src="<?php bloginfo('template_url'); ?>/ludlitlogo.gif"></a></h1><p><?php echo get_bloginfo('description'); ?></p>
			</div>
-->


<?php //get_template_part('slide', 'knjige'); ?>
<?php

$queryTax  = $wp_query->query_vars['taxonomy'];
$queryTerm = $wp_query->query_vars['term'];

if ($queryTax == "zbirka" and isset($queryTerm)) {
	$series = $queryTerm;
}
?>
<!--
<div id="booksMenu" class="float">
	<div style="padding: 10px">
		<div id="sideBarDivRight" class="">
			<ul id="mySidebar4" class="sideBarLiContent">
				<li class="widget" id="recentIssuesContainer">
				<h2 class="widgettitle">Vsi naslovi <?php echo ($queryTerm ? " zbirke" : "");?></h2>
<?php //myTitlesList($series); ?>
				</li>
				<li class="widget" class="recentIssuesContainer">
					<h2 class="widgettitle">Vsi avtorji knjig</h2>
<?php //myAuthorsList("avtor knjig") ?>
				</li>
			</ul>
		</div>
	</div>
</div>
<div style="clear: both; height: 0px"></div>
-->

