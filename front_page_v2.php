<?php
/*
Template name: nov home page visual composer 
 */
?>
<?php get_header('home'); ?>

<div id="main" class="clearfix">

	<?php
	if ( have_posts() ) {
		while ( have_posts() ) {
			the_post();
			the_content();
		}
	}
	?>	
</div>



<?php get_footer(); ?>