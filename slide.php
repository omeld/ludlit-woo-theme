<?php if (get_query_var('paged') < 2) : ?>
<?php
global $wp_query;

$utm_query_args = array(
	'utm_source' => 'homepage',
	'utm_medium' => 'banner',
	'utm_campaign' => 'slide'
);




function ___custom_excerpt_length($length) {
	return 25;
}
remove_filter( 'excerpt_length', 'custom_excerpt_length');
add_filter( 'excerpt_length', '___custom_excerpt_length');




?>
<?php

$args = array(
	'post_type' => 'tribe_events',
	'eventDisplay' => 'upcoming',
	'posts_per_page' => 4,
	'posts_per_archive_page' => 4,
	'my_dont_use_post_count_filter' => true
);
$myEvents = new WP_Query($args);
?>

<?php if (is_front_page() && $myEvents->have_posts()) : ?>
<div class="mobile-override fullw white-background">
	<div class="text-outer minimal-padding clearfix">
		<ul class="bare-links home-event-list thick-bottom-border true-liquid-block-outer align-right"><!--
			--><!--<li class="verticalMiddle true-liquid-block-inner one-five">
				<h5 class="center bold sans font-size-1"><span class="">Literatura v živo:</span></h5>
			</li>--><!--
			<?php $i = 0; while ($myEvents->have_posts()) : $myEvents->the_post(); $i++; ?>
			--><li class="event-list-item item-<?php echo $i; ?> true-liquid-block-inner one-five verticalBottom reset-vertical-space">
				<a class="" href="<?php echo tribe_get_event_link(); ?>">
					<div class="soft-borders-top gray-background">
						<p class="serif bold italic"><?php the_title(); ?></p>
						<p class="gray sans light no-margin leading-tight"><?php echo tribe_get_start_date($post->ID, true, 'j. F Y \o\b G:i') . ' <br> ' . tribe_get_venue($post->ID); ?></p>
					</div>
				</a>
			</li><!--
			<?php endwhile; ?>
		--></ul>
	</div>
</div>
<?php endif; ?>

<?php
$args = array (
	'status' => 'publish',
	'post_type' => array('post', 'obvestilo'),
	'posts_per_page' => 1,
	'posts_per_archive_page' => 1,
	'category_name' => 'izpostavljeno'
);
$myShowcasePosts = new WP_Query($args);
?>

<?php if ($myShowcasePosts->have_posts()) : ?>
<?php while ($myShowcasePosts->have_posts()) : $myShowcasePosts->the_post(); ?>
<div class="newlit-featured-article mobile-override fullw white-background hide-overflow x-large-top-padding large-bottom-padding">
	<div class="text-outer">
		<h4 class="center normal center-margins three-four serif leading-tight font-size-6 "><a href="<?php the_permalink() ?>" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a>&nbsp;</h4>
<?php
$contributor = wp_get_post_terms($post->ID, "ime_avtorja", array("count" => 1));
$contributorName = $contributor[0]->name;
$contributorSlug = $contributor[0]->slug;
if (isset($contributorName) and !(empty($contributorName))) :
	//$authorPage = get_page_by_title($contributorName, OBJECT, 'Avtor');
	//update deprecated
	$tmp_args = array('post_type' => 'avtor', 'post_status' => 'publish', 'name' => $contributorSlug, 'posts_per_page' => 1);
	$tmp_query = new WP_Query($tmp_args);
	$authorPage = null;
	if ($tmp_query->have_posts()) $authorPage = $tmp_query->posts[0];
?>
		<p class="this-author one-two center center-margins serif italic font-size-2" ><?php echo $contributorName; ?></p>
		<div class="this-author-photo center center-margins one-ten small-top-margin circle ">
			<div class="cover ratio-1-1" style="background-image: url(<?php $xthumb = wp_get_attachment_image_src(get_post_thumbnail_id($authorPage->ID), 'myAuthorThumbnail'); echo $xthumb[0] ?>)"></div>
		</div>
<?php endif; ?>
		<div class="this-excerpt top-margin large-bottom-padding center-margins sans font-size-3 one-two gray leading-medium"><?php the_excerpt(); ?></div>
	</div>
</div>
<?php endwhile; ?>
<?php endif; ?>
<?php endif; ?>
<?php
remove_filter( 'excerpt_length', '___custom_excerpt_length');
add_filter( 'excerpt_length', 'custom_excerpt_length');
?>
