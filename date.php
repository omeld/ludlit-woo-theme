<?php
/*
Template Name: Stran za arhive po datumu
 */
?>

<?php get_header('home'); ?>

<!-- date.php -->
<!-- LOOP -->
<?php
global $post, $wpdb, $my_query, $paged; // brez tega ne dela get_post_meta
global $myNumberOfPosts;
$myNumberOfPosts = 24;

if (is_day()) {
	$my_loop_args = array(
		'posts_per_page' => 24,
		'posts_per_archive_page' => 24,
		'paged' => get_query_var('paged'),
		'year' => get_query_var('year'),
		'monthnum' => get_query_var('monthnum'),
		'day' => get_query_var('day'),
		'category_not_in' => array(3902), 
		'cat' => '-3902'

	);
	$dateString = strtotime(sprintf('%s-%s-%s', 
			get_query_var('year'),
			get_query_var('monthnum'),
			get_query_var('day')
		)
		
	);
	$archiveDate = strftime('%A, %j. %B %Y', $dateString);
} else if (is_month()) {
	$my_loop_args = array(
		'posts_per_page' => 24,
		'posts_per_archive_page' => 24,
		'paged' => get_query_var('paged'),
		'year' => get_query_var('year'),
		'monthnum' => get_query_var('monthnum'),
		'category_not_in' => array(3902), 
		'cat' => '-3902'
	);
	$dateString = strtotime(sprintf('%s-%s', 
			get_query_var('year'),
			get_query_var('monthnum')
		)
	);
	$archiveDate = strftime('%B %Y', $dateString);
} else if (is_year()) {
	$my_loop_args = array(
		'posts_per_page' => 24,
		'posts_per_archive_page' => 24,
		'paged' => get_query_var('paged'),
		'year' => get_query_var('year'),
		'category_not_in' => array(3902), 
		'cat' => '-3902'
	);
	$archiveDate = get_query_var('year');
}

$myCurrentLoop = new WP_Query($my_loop_args);
$myCoverStoriesNum = 999;
?>
<!-- LOOP -->

<?php if ($myCurrentLoop->have_posts()) : ?>
<div class="mobile-override top-stripe-category gray-background-4 reverse font-size-2 fullw">
	<div class="text-outer minimal-padding">
		<p class="one-two">Arhiv prispevkov za <?php echo $archiveDate; ?></p>
	</div>
</div>
<?php endif; ?>
<?php require('loop-articles.php'); ?>
<?php get_footer(); ?>

