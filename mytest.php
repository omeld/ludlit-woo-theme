<?php
/*
Template Name: myTest
 */
?>
<?php get_header('home'); ?>
<?php
global $post, $wpdb, $wp_query, $paged; // brez tega ne dela get_post_meta
$args = array('posts_per_page' => 15, 'posts_per_archive_page' => 15, 'paged' => get_query_var('paged'));
add_filter('posts_join', 'myJoint');
add_filter('posts_where', 'myWhere');
add_filter('posts_orderby', 'myNewOrder');
$myquery = new WP_Query($args);
?>
<div id="main">
<p>wp_query->request: <?php echo $wp_query->request; ?></p>
<p>found_posts: <b><?php echo $wp_query->found_posts; ?></b></p>
<p>max_num_pages: <b><?php echo $wp_query->max_num_pages; ?></b></p>
<p>query_vars['posts_per_page']: <b><?php echo $wp_query->query_vars['posts_per_page']; ?></b></p>
<p>paged: <b><?php echo get_query_var('paged'); ?></p></p>
<?php if ($myquery->have_posts()) : while ($myquery->have_posts()) : $myquery->the_post(); ?>
		<p><?php the_title(); ?></p>
<?php endwhile; ?>

<?php
$args = wp_parse_args( $args, $defaults );
$max_num_pages = $wp_query->max_num_pages;
$paged = get_query_var('paged');
print_r($args);
echo "<br>";
echo "$max_num_pages ::::::: $paged";
?>
<p>******************************</p>
<p>wp_query->request: <?php echo $wp_query->request; ?></p>
<p>found_posts: <b><?php echo $wp_query->found_posts; ?></b></p>
<p>max_num_pages: <b><?php echo $wp_query->max_num_pages; ?></b></p>
<p>query_vars['posts_per_page']: <b><?php echo $wp_query->query_vars['posts_per_page']; ?></b></p>
<p>paged: <b><?php echo get_query_var('paged'); ?></p></p>
<div>
<?php posts_nav_link(); ?>
</div>
<?php wp_pagenavi( array( 'type' => 'multipart' ) ); ?>
<?php
$big = 999999999; // need an unlikely integer
echo paginate_links( array(
	'base' => str_replace( $big, '%#%', get_pagenum_link( $big ) ),
	'format' => '?paged=%#%',
	'current' => max( 1, get_query_var('paged') ),
	'total' => $wp_query->max_num_pages
) );
?>
<?php endif; ?>
</div>

<?php
remove_filter('posts_join', 'myJoint');
remove_filter('posts_where', 'myWhere');
remove_filter('posts_orderby', 'myNewOrder');
?>
<?php get_footer(); ?>
