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
			<div class="newlit-featured-article mobile-override fullw white-background hide-overflow">
				<div class="text-outer">
					<h4 class="center normal center-margins three-four serif leading-tight font-size-6 "><a href="<?php the_permalink() ?>" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a>&nbsp;</h4>


					<?php
						$contributor = wp_get_post_terms($post->ID, "ime_avtorja", array("count" => 1));
						$contributorName = $contributor[0]->name;
						if (isset($contributorName) and !(empty($contributorName))) :
							$authorPage = get_page_by_title($contributorName, OBJECT, 'Avtor');
					?>

							<p class="this-author one-two center center-margins serif italic font-size-2" ><?php echo $contributorName; ?></p>
							<div class="this-author-photo center center-margins one-ten small-top-margin circle ">
								<div class="cover ratio-1-1" style="background-image: url(<?php $xthumb = wp_get_attachment_image_src(get_post_thumbnail_id($authorPage->ID), 'myAuthorThumbnail'); echo $xthumb[0] ?>)">
								</div>
							</div>
					<?php endif; ?>

					<div class="this-excerpt top-margin large-bottom-padding center-margins sans font-size-3 one-two gray leading-medium"><?php the_excerpt(); ?>
					</div>
				</div>
			</div>
		<?php endwhile; ?>
	<?php endif; ?>
