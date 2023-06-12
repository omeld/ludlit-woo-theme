<?php get_header('home'); ?>
<!-- FOOBAR is page.php -->
<?php 
global $post;
global $thisPostID;
global $newlitTempCustomLength;
$paged = get_query_var('paged');
?>
<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
<?php
	$words = str_word_count(strip_tags(get_the_title($post->ID)));
	$titleSize = 'font-size-7';
	if ($words > 10) {
		$titleSize = 'font-size-7';
	} elseif ($words <= 20) {
	} elseif ($words <= 40) {
	} else {
	}
?>
<div class="oneArticle <?php echo implode(' ', get_post_class()); ?>">
	<div class="">
		<div class="articleText clearfix">
			<?php if (has_post_thumbnail($post->ID)) : ?>
			<?php $thumbnailURL = wp_get_attachment_url(get_post_thumbnail_id($post->ID)); ?>
			<?php $thumbnailMeta =  wp_get_attachment_metadata(get_post_thumbnail_id($post->ID)); ?>
			<?php $thumbnailIsPortrait = ($thumbnailMeta['height'] > $thumbnailMeta['width'] ? 1 : 0); ?>
			<?php $featuredClasses = ($thumbnailIsPortrait ? 'featuredPortrait' : 'featuredLandscape'); ?>
			<?php //list($width, $height) = getimagesize($thumbnailURL); ?>
			<div id="authorPhotoSidebar" class="small-top-padding center myFeaturedImage <?php echo ($thumbnailIsPortrait ? 'portraitContainer full-vh' : 'landscapeContainer '); ?>">
				<a class="bare inline-block relative" href="<?php echo $thumbnailURL; ?>" tit2le="<?php the_title_attribute(); ?>" >
					<?php the_post_thumbnail('large', array('class' => "featuredImg $featuredClasses", 'alt' => trim(strip_tags(get_post_meta(get_post_thumbnail_id($post->ID), '_wp_attachment_image_alt', true))))); ?>
					<p class="no-indent sans font-size-1" id="authorPhotoDesc" style="text-align: right"><?php echo get_post_meta(get_post_thumbnail_id($post->ID), '_wp_attachment_image_alt', true);  ?></p>
				</a>
			</div>
			<?php endif; ?>
			<div id="article-title">
				<h1 class="<?php echo $titleSize; ?> center small-top-padding tiny-bottom-padding leading-tight thin sans" style=""><?php the_title(); ?></h1>
			</div>
			<div id="articleTags" class="thin sans bare-links font-size-1" style="">
				<?php newlit_show_tags() ?>
			</div>
			<div class="content serif x-large-bottom-margin">
				<div id="main-article-text" class="font-size-2">
					<div class="main-article-text-body font-size-2">
						<?php the_content(); ?>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<?php endwhile; else: ?>
<?php endif; ?>
<?php get_footer(); ?>