<?php
/*
Template Name: seznam po avtorju
*/

wp_head();

global $wp_query, $wpdb, $post;



$myauthor = $_GET['a'];

$args = array(
	'status' => 'publish',
	'posts_per_page' => -1,
	'post_type' => 'post',
	'tax_query' => array(
		array(
			'taxonomy' => 'ime_avtorja',
			'field'    => 'slug',
			'terms'    => $myauthor
		),
	),
	'orderby' => 'date',
	'order' => 'DESC'
);

$authorsposts = new WP_Query($args);
$myurls = array();

if ($authorsposts->have_posts()) :
	echo "<pre>";
	while ($authorsposts->have_posts()) : $authorsposts->the_post();
		$_mycategories = get_the_category();
		$mycategories = array();
		foreach ($_mycategories as $mycat) :
			$mycategories[] = $mycat->name;
		endforeach;

		$mystring = get_the_title() 
			. "	" 
			. join('/', $mycategories)
			. "	"
			. get_the_date('Y') 
			. "	" 
			. get_the_permalink();

		echo $mystring . "\n";
	endwhile;
	echo "</pre>";
else :
	echo "<p>No posts to show</p>";
endif;

?>
