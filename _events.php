<?php
/*
Template Name: stran za koledar
 */
?>

<?php get_header(); ?>


<!-- SINGLE POST -->

<?
if (isset($_GET['id'])) {
	$args = array('p' => $_GET['id']);
	$my_posts = get_posts($args);
	foreach ($my_posts as $post) : setup_postdata($post); ?>
		<h2><a href="./wptest.php?id=<?php the_ID(); ?>" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a></h2>
		<p class="block"><?php the_content(); ?></p>
<?php
	endforeach;
} else {
		
?>
<!-- POSTS -->

<?php

	$post_types=get_post_types('','names'); 
	$categories = get_categories();

	foreach ($categories as $category) {
		/*
			TODO:
			if cat = empty!!!
		 */

		echo "<h1>" . $category->cat_name . "</h1>";
		$args = array('category' => $category->cat_ID, 'post_type' => 'knjiga');
		//$args = array('category' => $category->cat_ID, 'orderby' => 'meta_value_num', 'meta_key' => 'vzpored');
		$my_posts = get_posts($args);
		foreach ($my_posts as $post) : setup_postdata($post); ?>
			<div class="content">
				<h2><a href="<?php the_permalink() ?>" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a></h2>
				<div class="twoCol oneColMargin">
					<?php echo 'The post type is: '.get_post_type( $post->ID ); ?>
					<?php the_excerpt(); ?>
				</div>
			</div>
<?php
		endforeach;
		
	}
}
?>



<div id="sideBarDiv">
<ul id="sidebar">
<?php
if (function_exists(dynamic_sidebar())) : 
	dynamic_sidebar(); 
endif; 
?>
</ul>
</div>


