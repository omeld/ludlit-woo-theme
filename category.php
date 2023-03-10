<?php
/*
Template Name: Stran za kategorije
 */
?>

<?php get_header('home'); ?>

<!-- category.php -->
<!-- LOOP -->
<?php
global $post, $wpdb, $my_query, $paged, $wp_query, $request; // brez tega ne dela get_post_meta
global $myNumberOfPosts;
$myNumberOfPosts = 20;

$args = array(
	'posts_per_page' => $myNumberOfPosts,
	'posts_per_archive_page' => $myNumberOfPosts,
	'paged' => get_query_var('paged'),
	'cat' => get_query_var('cat'),
	'post_type' => $wp_query->query_vars['post_type']
);


$myCoverStoriesNum = 999; // to pomeni, da bdo praktično vsi prispevki, kadar jih prikazujemo na arhivski strani, eden pod drugim, tj. nikoli ne bodo po denimo štirje na vrstico (kot bi bili na prvi strani)
$myCurrentLoop = new WP_Query($args);

if ($myCurrentLoop->have_posts()) :
	$catDesc = category_description(get_query_var('cat'));
?>
<div class="mobile-override top-stripe-category light-blue-background fullw">
	<div class="text-outer minimal-padding">
		<p class="one-two font-size-2 bold">Arhiv prispevkov v rubriki <?php echo get_cat_name(get_query_var('cat')); ?> (<?php echo $myCurrentLoop->found_posts; ?>)</p>
	</div>
</div>
<?php if(!empty($catDesc)) { ?>
<div class='stretch-full-width gray-background gray-4-not no-indent-not large-top-padding large-bottom-padding' style="/*max-width: 33em; margin-left: auto; margin-right: auto;*/">
<div class="two-three-not light font-size-2 leading-loose padded white-background center-margins">
<?php echo $catDesc; ?>
</div>
</div>
<?php } ?>
<?php endif; ?>
<?php require('loop-articles.php'); ?>
<?php get_footer(); ?>
