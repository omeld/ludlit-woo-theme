<!DOCTYPE html>
<html lang='sl'>
<!-- SINGLE -->
	<head>
		<title>Zapisniki</title>
		<meta charset="UTF-8">
		<script src="http://code.jquery.com/jquery-latest.min.js" type="text/javascript"></script>
		<link href='http://fonts.googleapis.com/css?family=Alegreya+Sans:100,400,700,100italic,400italic,700italic&subset=latin,latin-ext' rel='stylesheet' type='text/css'>
		<link rel="stylesheet" href="<?php bloginfo('stylesheet_directory'); ?>/zapisniki.css" type="text/css" media="screen">
		<script src="<?php bloginfo('stylesheet_directory'); ?>/js/zapisniki.js" type="text/javascript"></script>
		<?php wp_head(); ?>
	</head>
<?php

//global $posts;
//global $wp_query;

if ( is_user_logged_in() ) {
	$args = array(
		'post_type' => 'newlit_proceedings',
		'num_posts' => -1,
		'status' => 'publish'
	);
	$proceedings = new WP_Query($args);
?>
	<body <?php body_class('really-dark-background'); ?>>
		<div id="list-of-proceedings" class="really-dark-background">
<?php if ($proceedings->have_posts()) : ?>
			<ul class="light">
<?php while ($proceedings->have_posts()) : $proceedings->the_post(); ?>
				<li>
					<h6><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h6>
					<p class="post_date gray"><?php the_time('j. F Y'); ?></p>
				</li>
<?php endwhile; ?>
			</ul>
<?php endif; ?>
<?php wp_reset_postdata(); ?>
		</div>
		<div id="main-container" class="relative clearFix darkest-background no-overflow">
			<div id="proceedings-container" class=" darkest-background">
				<div id="controls" class="clearFix light" style="overflow-x: hidden">
				<!--<div id="controls" class="float dark-background light equalize-height">-->
					<div class="container">
						<div class="float button-container">
							<div id="_loginout" class="contained button white-background">
<?php wp_loginout(); ?>
							</div>
						</div>
						<div class="float button-container">
							<div class="contained button white-background" id="show-list">
								<span id="" class="">Seznam</span>
							</div>
						</div>
					</div>
				</div>
				<div id="proceedings-item" class="white-background">
					<div class="padding">
						<div class="text-container">
<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
<?php //if ($wp_query->have_posts()) : $wp_query->the_post(); ?>
							<h1><?php the_title(); ?></h1>
							<h2><?php the_time('j. F Y'); ?></h2>
<?php
			the_content();
			endwhile;
		endif; 
?>
						</div>
					</div>
				</div>
			</div>
		</div>


<?php
} else {
?>
	<body <?php body_class('lightest-background'); ?>>
		<div class="my-login-form thin">
			<div>
				<div style="padding: 1em 2em; " class="dark-background gray">
					<h1>LUD Literatura</h1>
					<h2>Zapisniki</h2>
				</div>
				<div>
<?php wp_login_form(); ?>
				</div>
				<div style="padding: 1em 2em;  " class="gray darkest-background">
					<p>Za ogled je potrebna prijava.</p>
				</div>
			</div>
		</div>
<?php
}
?>
		<?php wp_footer(); ?>
	</body>
</html>
