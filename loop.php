<?php

global $post;
global $wp_query;
//global $wpdb;
global $request;
global $newlitTempCustomLength;

$myIterator = 0;
global $myNumberOfPosts;
$myNumberOfPosts = 20;

$args = array_merge(
	$wp_query->query,
	array(
		'posts_per_page' => $myNumberOfPosts,
		'paged' => get_query_var('paged'),
		'category__not_in' => array(3902, 3846, 3848) //dodal izpostavljeno – ker je kao samo ena, in to na coverju
	)
);

$myCurrentLoop = new WP_Query($args);

$myCoverStoriesNum = 10;

require('loop-articles.php');

?>
