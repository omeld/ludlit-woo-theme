<?php
/*
Template Name: Stran za posamezno številko
 */
?>

<?php get_header('home'); ?>
<?php
//global $wp_query;
?>
<div id="main">
<?php get_template_part( 'loop', 'index' ); ?>
	<div id="myRecentPosts">	
		<h3>Starejše objave</h3>
		<?php myNewList(15); ?>
	</div>
</div>
<?php get_footer(); ?>
