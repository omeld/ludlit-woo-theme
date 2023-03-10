<?php get_header('mimoglasje-2013'); ?>
<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
		<div class="container hasEffect">
			<div class="section article content main-content" id="projectDescription">
				<div class="sectionPadding clearfix">
					<div class="threeCol float hasRightMargin">
<?php
if (has_post_thumbnail()) : 
   $large_image_url = wp_get_attachment_image_src( get_post_thumbnail_id(), 'large');
	
	//$image_attributes = wp_get_attachment_image_src($post->ID, 'newlitSpecial2');
	$alt_text = the_title_attribute(array('echo' => false));
?>
	<div id="myFeaturedImage">
	<a class="imgLink" href="<?php echo wp_get_attachment_url(get_post_thumbnail_id($post->ID)); ?>" title="<?php the_title_attribute(); ?>">
<?php the_post_thumbnail('newlitSpecial4', array('alt' => $alt_text)); ?>
	</a>
<p class="wp-caption-text"><?php echo get_post(get_post_thumbnail_id($post->ID))->post_content; ?></p>
	
	</div>
<? else : ?>
<?php 	endif; ?>
						<h1><?php the_title() ?></h1>
						<div class="postMeta clearfix" id="postMetaRow">
							<div id="postDate"><?php echo the_time('j. F Y');?></div>
							<div id="sharing">
								<div class="addthis_toolbox addthis_default_style">
									<a class="addthis_button_facebook"></a>
									<a class="addthis_button_twitter"></a>    
								</div>
							</div>
						</div>
						<div class="singleMainContent"><?php the_content() ?></div>
						<div id="postBrowser" class="sans postMeta clearfix">

<?php
	$prevID = newlit_custom_adjacent_posts('prev', $post->ID);
	$nextID = newlit_custom_adjacent_posts('next', $post->ID);

	if ($nextID) {
		echo '<div id="nextLink" class="oneCol float hasRightMargin"><p><a href="' . get_permalink($nextID) . '" title="' . get_the_title($nextID) . '"> &larr;' . get_the_title($nextID) . '</a></p></div>';
	} else {
?>
							<div id="nextLink" class="oneCol float hasRightMargin">&nbsp;</div>
<?php
	}
?>
							<div class="oneCol float hasRightMargin">&nbsp;</div>
<?php
	if ($prevID) {
		echo '<div id="prevLink" class="oneCol float"><p><a href="' . get_permalink($prevID) . '" title="' . get_the_title($prevID) . '">' . get_the_title($prevID) . ' &rarr;</a></p></div>';
	} else {
?>
							<div id="prevLink" class="oneCol float">&nbsp;</div>
<?php
	}


?>
						</div>
					</div>
					<div class="twocol float">
<?php
	/*
	$terms = get_the_terms($post->ID, 'special_tag');
	$termList = array();
	foreach ($terms as $term) {
		$termList[] = $term->name;
	}
	echo implode(", ", $termList);
	 */
?>
					</div>
				</div>
			</div>
		</div>
<?php endwhile; endif; ?>
<?php get_footer('mimoglasje-2013'); ?>
