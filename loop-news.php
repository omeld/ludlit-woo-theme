<?php

if (get_query_var('paged') < 2): 

global $post;
$myIterator = 0;
global $newlitTempCustomLength;
$newlitTempCustomLength = 20;

$args = array(
	'my_dont_use_post_count_filter' => true,
	'posts_per_page' => 5,
	'category_name' => 'novice-in-obvestila',
	'category__not_in' => array(3902),
	'post_type' => array('post', 'obvestilo')
);

$myNews = new WP_Query($args);

$args = array(
	'my_dont_use_post_count_filter' => true,
	'posts_per_page' => 5,
	'post_type' => 'knjiga'
);
$myBooks = new WP_Query($args);


?>
<?php
if ($myNews->have_posts()) :
	$utm_query_args = array(
		'utm_source' => 'homepage',
		'utm_medium' => 'banner',
		'utm_campaign' => 'bulletin'
	);
?>



<div id="" class="fullw light-blue-background leading-tight">
	<div class="text-outer minimal-padding">
		<ul class="mobile-touch-scroll-horizontal true-liquid-block-outer"><!--
<?php while ($myNews->have_posts()) : $myNews->the_post(); ?>
<?php //foreach ($myNews as $post) : setup_postdata($post); ?>
			--><li class=" true-liquid-block-inner one-five <?php echo "item-$myIterator"; ?>">
<?php if (has_post_thumbnail()) : ?>
				<!--<div class="float" style="margin: 0 5px 5px 0">
					<a class="" href="<?php echo add_query_arg($utm_query_args, get_permalink()); ?>" title="<?php the_title_attribute(); ?>" >
<?php				the_post_thumbnail('myOneColSquare', array('class' => '', 'alt' => trim(strip_tags(get_post_meta(get_post_thumbnail_id($post->ID), '_wp_attachment_image_alt', true))))); ?>
					</a>
				</div>-->
<?php endif; ?>
				<div class="paddedText">
					<h4><a href="<?php echo add_query_arg($utm_query_args, get_permalink()); ?>" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a>&nbsp;</h4>
					<p class="serif italic"><?php echo get_the_excerpt(); ?> <!--<span style="color: #666"> (<?php echo implode('&nbsp;', explode(' ', get_the_time('j. F Y'))); ?>)</span>--></p>
				</div>
			</li><!--
<?php $myIterator++; ?>
<?php //endforeach; ?>
<?php endwhile; ?>
		--></ul>
	</div>
</div>
<?php endif; ?>
<?php
if (false) :
//if ($myBooks->have_posts()) :
	$utm_query_args = array(
		'utm_source' => 'homepage',
		'utm_medium' => 'banner',
		'utm_campaign' => 'bulletin'
	);
?>
<div id="" class="fullw light-blue-background leading-tight">
	<div class="text-outer minimal-padding">
		<ul class="true-liquid-block-outer"><!--
<?php while ($myBooks->have_posts()) : $myBooks->the_post(); ?>
<?php //foreach ($myBooks as $post) : setup_postdata($post); ?>
			--><li class="verticalBottom true-liquid-block-inner one-five <?php echo "item-$myIterator"; ?>">
				<div class="paddedText">
<?php if (has_post_thumbnail()) : ?>
					<div class="float" style="margin: 0 5px 5px 0">
						<a class="block-link" href="<?php echo add_query_arg($utm_query_args, get_permalink()); ?>" title="<?php the_title_attribute(); ?>" >
<?php				the_post_thumbnail('myOneColSquare', array('class' => '', 'alt' => trim(strip_tags(get_post_meta(get_post_thumbnail_id($post->ID), '_wp_attachment_image_alt', true))))); ?>
						</a>
					</div>
<?php endif; ?>
					<h4><a href="<?php echo add_query_arg($utm_query_args, get_permalink()); ?>" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a>&nbsp;</h4>
				</div>
			</li><!--
<?php $myIterator++; ?>
<?php //endforeach; ?>
<?php endwhile; ?>
		--></ul>
	</div>
</div>
<?php endif; ?>
<?php $newlitTempCustomLength = 0; ?>
<?php endif; ?>
