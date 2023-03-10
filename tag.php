<?php
/*
Template Name: Stran za tage
 */
?>

<?php get_header('home'); ?>

<!-- tag.php -->
<!-- LOOP -->
<?php
global $post, $wpdb, $my_query, $paged; // brez tega ne dela get_post_meta
global $myNumberOfPosts;
$myNumberOfPosts = 20;
$myTermSlug = get_query_var('tag');
$myTerm = get_term_by('slug', $myTermSlug, 'post_tag');
//$myTaxonomy = get_query_var('taxonomy');


//echo "<pre class='red'>"; var_dump($wp_query->query, $wp_query->query_vars); echo "</pre>";

$args = array(
	'posts_per_page' => 20,
	'posts_per_archive_page' => 20,
	'paged' => get_query_var('paged'),
	'tag' => $myTermSlug,
	'post_type' => $wp_query->query_vars['post_type']
);


$myCoverStoriesNum = 999;
$myCurrentLoop = new WP_Query($args);

if ($myCurrentLoop->have_posts()) :
?>
<div class="light-blue-background fullw">
	<div class="text-outer">
		<div class="one-two font-size-2 serif"><p><?php echo "Arhiv prispevkov z oznako <i><b>$myTerm->name</b></i> ($myTerm->count)"; ?></p></div>
	</div>
</div>
<?php endif; ?>
<?php require('loop-articles.php'); ?>
<?php get_footer(); ?>
