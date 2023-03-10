<?php

function myRecentPostsX($off, $num, $el="h4") {
	global $post;
	global $thisPostID;
	global $wp_query;

	//$excludeID = $post->ID;
	$excludeID = $thisPostID;

	$myIterator = 0;

	$myAddClass = "verticalMiddle";

	$args = array(
		'offset' => $off,
		'posts_per_page' => $num,
		'post__not_in' => array($excludeID)
	);

	$myPosts = get_posts($args);
?>

<script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.0/jquery.min.js" type="text/javascript"></script>
<script src="<?php bloginfo('template_url'); ?>/js/flex/jquery.flexslider-min.js"></script>
<script>
$(window).load(function() {
	$('.flexslider').flexslider({
		animation: "slide"
	});
});
</script>


<div class="flexslider">
<ul class="slides">
<?php foreach($myPosts as $post) : setup_postdata($post); $myIterator++; ?>

<?php if (($myIterator % 5) == 0) { ?>
	<li>
	<ul class="recentArticles">
<?php } ?>
<?php	$contributor = wp_get_post_terms($post->ID, "ime_avtorja", array("count" => 1)); ?>
<?php	$contributorName = $contributor[0]->name; ?>
<?php	$nameSlug = $contributor[0]->slug; ?>
		<li>
			<div class="relatedArticlesThumb">
			<?php if (has_post_thumbnail()) : ?>
			<?php
			$img_id = get_post_thumbnail_id($post->ID);
			$alt_text = get_post_meta($img_id , '_wp_attachment_image_alt', true);
			?>
				<a class="bare" href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>" >
	<?php		the_post_thumbnail('myOneColSquare',
					array(
						'class'	=> $myAddClass,
						'alt'	=> $alt_text
					)); ?>
				</a>
			<?php endif; ?>
			</div>
			<div class="relatedArticlesDesc">
				<<?php echo $el; ?>>
					<a href="<?php the_permalink() ?>" title="<?php the_title_attribute(); ?>">
						<?php the_title(); ?>
					</a>
<?php
	if (isset($contributorName) and !(empty($contributorName))) :
		$myLink = home_url("/imena-avtorjev/" . $nameSlug);
?>
			(<a href="<?php echo $myLink;?>" title="<?php echo $contributorName; ?> – vsi prispevki"><?php echo $contributorName;?></a>)
<?php
	endif; 
?>
				</<?php echo $el; ?>>
			</div>
		</li>
<?php if (($myIterator % 5) == 0 and $myIterator > 0) { ?>
</ul>
</li>
<?php } ?>
<?php endforeach; wp_reset_postdata();?>
</ul>
</div>
<?php
	
}

?>
