<!DOCTYPE html>
<html lang='sl'>
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

global $posts;

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
			<div class="padding">
				<!--<div><?php wp_loginout(); ?></div>-->
<?php if ($proceedings->have_posts()) : $posts = $proceedings->get_posts(); ?>
				<ul class="light">
<?php foreach ($posts as $post) : ?>
					<li>
						<h6><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h6>
						<p class="post_date"><?php the_time('j. F Y'); ?></p>
					</li>
<?php endforeach; ?>
				</ul>
			</div>
<?php endif; ?>
		</div>
<!--<div id="proceedings-container" class="darker-background">
	<div id="proceedings-item" class="white-background">
<?php
	/*
	if ($proceedings->have_posts()) : 
		$latest = apply_filters('the_content', $posts[0]->post_content);
		$latest = str_replace(']]>', ']]&gt;', $latest);
		echo $latest;
	endif; 
	 */
?>
	</div>
</div>-->


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
				<div style="padding: 1em 2em;  " class="gray darker-background">
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
