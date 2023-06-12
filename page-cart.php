<?php
/*
Template Name: ludlit_wc cart
*/

?>


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
<div class="oneArticle-not <?php echo implode(' ', get_post_class()); ?>">
	<div class="">
		<div class="articleText clearfix">
			<div id="article-title">
				<h1 class="<?php echo $titleSize; ?> center small-top-padding tiny-bottom-padding leading-tight thin sans" style=""><?php the_title(); ?></h1>
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