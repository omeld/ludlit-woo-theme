<?php
/*
Template Name: Stran za svežnje
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
	'cat' => 'FOOVAR',
	'post_type' => $wp_query->query_vars['post_type']
);

$mySubtitle = get_post_meta($post->ID, 'mysubtitle', true);

//$myMeta = get_post_meta($post->ID);
//echo "<pre style='color:green;font-size: 1em;'>";var_dump($myMeta);echo "</pre>";


$myCurrentLoop = new WP_Query($args);

if ($myCurrentLoop->have_posts()) :
	$catDesc = category_description(get_query_var('cat'));
?>
<!--
<div class="mobile-override top-stripe-category light-blue-background fullw">
	<div class="text-outer minimal-padding">
		<p class="one-two font-size-2 bold">Arhiv prispevkov v rubriki <?php echo get_cat_name(get_query_var('cat')); ?> (<?php echo $myCurrentLoop->found_posts; ?>)</p>
	</div>
</div>-->



<div class="large-top-padding stretch-full-width-not gray-background-not large-bottom-padding two-three center center-margins leading-tight bold display-font font-size-5">
<h1 class="bold"><?php the_title()?></h1>
				<?php if (isset($mySubtitle)) : ?>
				<h2 class="sans font-size-2 gray-not bold small-top-margin inline-block two-three center-margins" style="border-top: 1px solid; padding-top: 0.5em"><?php echo get_post_meta($post->ID, 'mysubtitle', true) ?></h2>
				<?php endif; ?>
</div>


			<?php if (has_post_thumbnail($post->ID)) : ?>
			<?php $thumbnailURL = wp_get_attachment_url(get_post_thumbnail_id($post->ID)); ?>
			<?php $thumbnailMeta =  wp_get_attachment_metadata(get_post_thumbnail_id($post->ID)); ?>
			<?php $thumbnailIsPortrait = ($thumbnailMeta['height'] > $thumbnailMeta['width'] ? 1 : 0); ?>
			<?php $featuredClasses = ($thumbnailIsPortrait ? 'featuredPortrait' : 'featuredLandscape'); ?>

			<div id="authorPhotoSidebar" class="center myFeaturedImage <?php echo ($thumbnailIsPortrait ? 'portraitContainer full-vh' : 'landscapeContainer '); ?>">
				<a class="bare inline-block relative " href="<?php echo $thumbnailURL; ?>" title="<?php the_title_attribute(); ?>" >
					<?php the_post_thumbnail('large', array('class' => "featuredImg $featuredClasses", 'alt' => trim(strip_tags(get_post_meta(get_post_thumbnail_id($post->ID), '_wp_attachment_image_alt', true))))); ?>
					<p class="no-indent sans font-size-1" id="authorPhotoDesc" style="text-align: right"><?php echo get_post_meta(get_post_thumbnail_id($post->ID), '_wp_attachment_image_alt', true);  ?></p>
				</a>
			</div>
			<?php endif; ?>



<div class='stretch-full-width-not gray-background-not gray-4-not no-indent-not large-top-padding large-bottom-padding' style="/*max-width: 33em; margin-left: auto; margin-right: auto;*/">
	<div class="two-three light font-size-2 leading-loose medium-top-padding medium-bottom-padding medium-left-padding medium-right-padding white-background center-margins">
		<div style="margin: auto">
			<div ><?php the_content(); ?></div>
		</div>
	</div>
</div>

<?php
global $overrideNumberOfPosts;
$overrideNumberOfPosts = -1;
/* loop-articles naredi nov loop, ki ga zgradi iz default queryja loopa, zato mu že tukaj dodamo informacijo o tematiki */
$currentTopic = get_the_terms($post->ID, 'tematike');
$currentTopic = $currentTopic[0]->slug;
//$Xargs = array_merge(
//	$wp_query->query,
$Xargs = 
	array(
		'post_status' => 'publish',
		'post_type' => 'post',
		'orderby' => 'date',
		'order' => 'ASC',
		'tax_query' => array(
			array(
				'taxonomy'	=> 'tematike',
				'field'		=> 'slug',
				'terms'		=> $currentTopic,
	        )
	    ),
	//)
);

query_posts($Xargs); // ouch ;-(
?>

<?php endif; ?>
<?php require('loop-articles.php'); ?>
<?php include('mailchimp-subscribe.php');?>
<?php get_footer(); ?>

