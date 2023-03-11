<?php
/*
Template Name: stran za avtorje prispevkov (taxonomy: ime_avtorja)
 */
?>

<?php get_header('home'); ?>

<?php

?>
<?php
global $post, $wpdb, $my_query, $paged; // brez tega ne dela get_post_meta
global $myNumberOfPosts;
$myNumberOfPosts = 20;

$queryTax = get_query_var('taxonomy'); // ime_avtorja
$queryTerm = get_query_var('term'); // slug!

$myTerm = get_term_by('slug', $queryTerm, $queryTax);

$args = array(
	'posts_per_page' => 20,
	'posts_per_archive_page' => 20,
	'post_status' => 'publish',		
	'post_type' => 'post',
	'paged' => get_query_var('paged'),
	'tax_query' => array(
		array(
			'taxonomy' => 'ime_avtorja',
			'field' => 'slug',
			'terms' => $queryTerm
		)
	)
	
);

$myCoverStoriesNum = 999;
$myCurrentLoop = new WP_Query($args);

if ($myCurrentLoop->have_posts()) :
?>
<div class="mobile-override light-blue-background levodesnopadding">
	<div class="text-outer minimal-padding">
		<div class="one-two font-size-2 serif tiny-bottom-padding"><p><?php echo "Arhiv prispevkov avtorja <i><b>$myTerm->name</b></i> ($myCurrentLoop->found_posts)"; ?></p></div>
		<ul id="mySidebar4" class="bare-list sideBarLiContent">
<?php //dynamic_sidebar(4); ?>
			<li class="widget" id="recentIssuesContainer">
				<?php myArticleAuthorsList(); ?>
			</li>
		</ul>
	</div>
</div>
<?php endif; ?>
<?php require('loop-articles.php'); ?>
<?php get_footer(); ?>
