<?php
/*
Template name: nov home page visual composer 
 */
?>
<?php get_header('home'); ?>

<div id="main" class="clearfix">
	<!--BANNER-->
	
	<!--PRIKAZ KNJIG-->
<?php
	$args = array(
			'post_type' => 'product',
			'post_status' => 'publish',
			'posts_per_page' => 5,
			'order' => 'DESC',
			'orderby' => 'date',
		);
?>
			<div class='ludlit_wc_custom_products'>
				<ul class='products ludlit_wc_custom_products'>
					<?php
						$loop = new WP_Query($args);
						if($loop -> have_posts()) {
						while ( $loop->have_posts() ) : $loop->the_post();
							wc_get_template_part( 'content', 'product' );
						endwhile;
					}
					?>
				</ul>
			</div>
</div>
<!--PRIKAZ POSTOV-->

<!--PRIKAZ REVIJ-->

<!--PRIKAZ INSTAGRAM-->



<?php get_footer(); ?>