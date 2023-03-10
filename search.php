<?php
/*
Template Name: Stran za iskanje
 */
?>

<?php get_header('home'); ?>

<!-- archive.php -->
<!-- LOOP -->
<?php
global $post, $wpdb, $my_query, $paged; // brez tega ne dela get_post_meta
global $myNumberOfPosts;
$myNumberOfPosts = 24;
$myCoverStoriesNum = 0;
$my_loop_args = array('posts_per_page' => 24, 'posts_per_archive_page' => 24, 'paged' => get_query_var('paged'));
//$myCurrentLoop = new WP_Query($my_loop_args);
/* preserve passed arguments, eg. the search string */
$myCurrentLoop = new WP_Query(array_merge($wp_query->query, $my_loop_args));

?>
<!-- LOOP -->

<div id="main" class="clearfix">
<?php if ($myCurrentLoop->have_posts()) : ?>
<div class="mobile-override top-stripe-category gray-background-4 reverse font-size-2 fullw">
	<div class="text-outer minimal-padding">
		<p class="one-two">Iskanje: <?php echo get_search_query(); ?></p>
	</div>
</div>
<?php endif; ?>
<?php require('loop-articles.php'); ?>

<?php get_footer(); ?>
<?php exit; ?>

<?php get_header('home'); ?>

<!-- LOOP -->
<?php
//global $post, $wpdb, $my_query, $paged, $wp_query; // brez tega ne dela get_post_meta
global $my_query, $wp_query;
$my_loop_args = array(
	'posts_per_page' => 9,
	'posts_per_archive_page' => 9,
	'paged' => get_query_var('paged')
);


/*
add_filter('posts_join', 'myJoint');
add_filter('posts_where', 'myWhere');
add_filter('posts_orderby', 'myNewOrder');
 */

/* preserve passed arguments, eg. the search string */
$my_query = new WP_Query(array_merge($wp_query->query, $my_loop_args));
?>
<!-- LOOP -->

<div id="main" class="clearfix">
<?php
	$myIterator = 0; 
	$margin = "";
?>
<div class="row clearfix">
<?php while ($my_query->have_posts()) : $my_query->the_post(); ?>
<?php

if (($myIterator % 3) > 0) {	// 2., 3.
	$margin = "hasLeftMargin";
} else {
	$margin = "";
	if ($myIterator == 0) {

	} else {
		echo "</div>";
		echo "<div class=\"row clearfix\">";
	}
}

$myIterator++;
?>
	<div class="clearfix hoverBox content fourCol float <?php echo $margin; ?>">
		<h4><a href="<?php the_permalink() ?>" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a>&nbsp;</h4>
		<h5><?php echo get_post_meta($post->ID, 'mysubtitle', true) ?></h5>
		<div class="postExcerpt">
			<?php the_excerpt(); ?>
		</div>
	</div>
<?php endwhile; ?>

</div> <!-- close last row clearfix -->

<?php
$args = wp_parse_args($args, $defaults );

// echo "<p><pre>"; print_r($args); echo "</pre></p>";

$max_num_pages = $my_query->max_num_pages;
$paged = get_query_var('paged');

?>

<?php //wp_pagenavi( array( 'type' => 'multipart' ) ); ?>
<?php
$big = 999999999; // need an unlikely integer
echo paginate_links( array(
	'prev_text' => '&laquo; Novejše',
	'next_text' => 'Starejše &raquo;',
	'base' => str_replace( $big, '%#%', get_pagenum_link( $big ) ),
	'format' => '?paged=%#%',
	'current' => max( 1, get_query_var('paged') ),
	'total' => $my_query->max_num_pages
) );
?>

<?php
	/*remove_filter('posts_join', 'myJoint');
	remove_filter('posts_where', 'myWhere');
	remove_filter('posts_orderby', 'myNewOrder');*/
?>
<?php get_footer(); ?>
