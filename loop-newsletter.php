<?php

//global $wp_query;

$thisIssue = "";
$myIterator = 0;

$query = "
	select $wpdb->posts.*, meta_value
		from wp_posts, $wpdb->postmeta
			where ID in (
				select post_id
					from $wpdb->postmeta
						where meta_key = 'myissue'
						and meta_value = (
							select max(meta_value + 0)
								from $wpdb->postmeta
									where meta_key = 'myissue'
							)
				)
			and ID = post_id
			and meta_key = 'myorder'
			AND $wpdb->posts.post_status = 'publish'
			order by meta_value + 0
			";
?>
<?php $pageposts = $wpdb->get_results($query, OBJECT); ?>
<?php $previousCategory = ""; ?>
<?php if ($pageposts): ?>
<?php foreach ($pageposts as $post): ?>
<?php setup_postdata($post); ?>
<?php $categories = get_the_category(); ?>
<?php if ($categories[0]->cat_name != $previousCategory): ?>
<?php $previousCategory = $categories[0]->cat_name; ?>

	<h3 style=" font-size: 1em; margin-bottom: 0.5em; margin-top: 1em; font-weight: normal; color: #666; border-bottom: 1px solid #666; text-transform: uppercase; letter-spacing: 0.2em;" ><a style="text-decoration: none; border: none; color: #666" href="<?php echo esc_url(get_category_link($categories[0]->cat_ID)); ?>/"><?php echo $categories[0]->cat_name ?></a></h3>

<?php endif; ?>

		<h4 style=" font-size: 1.5em; font-weight: bold; color: black; line-height: 1; margin-bottom: 0.5em; margin-top: 1em; " ><a style="text-decoration: none; border: none; color: #8C281F" href="<?php the_permalink() ?>" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a>&nbsp;</h4>
		<h5 style=" font-style: italic; color: #666; font-weight: normal; margin-top: 0; margin-bottom: 0.5em; font-size: 1em; " ><?php echo get_post_meta($post->ID, 'mysubtitle', true) ?></h5>

<?php if (has_post_thumbnail()) : ?>

		<a style="text-decoration: none; border: none" href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>" >
			<?php the_post_thumbnail('myEmailThumbnail'); ?>
		</a>

<?php endif; ?>

		<?php the_excerpt(); ?>

<?php endforeach; ?>

<?php endif; ?>

<?php wp_reset_postdata(); ?>

