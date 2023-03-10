<?php
/*
Template Name: Stran za arhive
 */
?>

<?php get_header('home'); ?>

<!-- archive.php v2 -->
<!-- LOOP -->
<?php
global $post, $wpdb, $my_query, $paged, $wp_query; // brez tega ne dela get_post_meta
global $myNumberOfPosts;
$myNumberOfPosts = 20;
$myCoverStoriesNum = 10;
//$my_loop_args = array('category__not_in' => array(3902), 'cat' => '-3902', 'posts_per_page' => 12, 'posts_per_archive_page' => 12, 'paged' => get_query_var('paged'));
//$myCurrentLoop = new WP_Query($my_loop_args);

$args = array_merge(
	$wp_query->query,
	array(
		'category__not_in' => array(3902), 
		'posts_per_page' => $myNumberOfPosts, 
		'posts_per_archive_page' => $myNumberOfPosts, 
		'paged' => get_query_var('paged')
	)
);

$myCurrentLoop = new WP_Query($args);

?>

<!-- LOOP x-->

<div id="main" class="clearfix">
<?php require('loop-articles.php'); ?>

<?php get_footer(); ?>
