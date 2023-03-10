<?php
if (is_single()) {
} else {
$args = array (
		'post_status' => 'publish',
		'posts_per_page' => 5,
		'orderby' => 'rand',
		'post_type' => 'knjiga',
		'meta_key' => '_thumbnail_id'
		
);

$utm_query_args = array(
	'utm_source' => 'homepage',
	'utm_medium' => 'banner',
	'utm_campaign' => 'slide'
);

$myposts = get_posts($args);

?>



<div id="myPostShowcase" class="">
<?php foreach($myposts as $post) : setup_postdata($post); ?>
<?php $myImageId = get_post_thumbnail_id(); ?>
<?php $myImageUrl = wp_get_attachment_image_src($myImageId,'myShowcaseImageSmall', true); ?>
	<div class="mySlide">
		<div class="mySlidePicture bwWrapper">
			<img src="<?php echo $myImageUrl[0]; ?>">
		</div>
		<div class="mySlideDescriptionContainer fourCol">
			<div class="hasPadding">
				<h4><a href="<?php echo add_query_arg($utm_query_args, get_permalink()); ?>" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a>&nbsp;</h4>
				<div class="mySlideDescription">
					<?php //the_excerpt(); ?>
					<?php echo get_post_meta($post->ID, 'Ime', true);?> <?php echo get_post_meta($post->ID, 'Priimek', true);?>
				</div>
			</div>
		</div>
		<div class="clear"></div>
	</div>
<?php endforeach; ?>
</div>
<?php } ?>
<!-- <div class="clear"></div> -->

