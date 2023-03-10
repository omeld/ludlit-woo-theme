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
				<?php if (is_page('ubezne-misli')) : ?>
				<div class="x-large-top-margin x-large-bottom-margin x-large-top-padding x-large-bottom-padding myComments section font-size-1" style="">
					<div class="text-inner">
		<div id="disqus_thread"></div>
<script type="text/javascript">
    /* * * CONFIGURATION VARIABLES * * */
    var disqus_shortname = 'ludliteratura';
    /* * * DON'T EDIT BELOW THIS LINE * * */
    (function() {
        var dsq = document.createElement('script'); dsq.type = 'text/javascript'; dsq.async = true;
        dsq.src = '//' + disqus_shortname + '.disqus.com/embed.js';
        (document.getElementsByTagName('head')[0] || document.getElementsByTagName('body')[0]).appendChild(dsq);
    })();
</script>
<noscript>Please enable JavaScript to view the <a href="https://disqus.com/?ref_noscript" rel="nofollow">comments powered by Disqus.</a></noscript>
					</div>
				</div>
				<?php endif; ?>
			</div>
		</div>
	</div>
<?php endwhile; else: ?>
<?php endif; ?>
<?php get_footer(); ?>
