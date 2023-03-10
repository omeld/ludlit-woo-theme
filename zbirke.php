<?php
/*
Template Name: stran za ZBIRKE
 */
?>
<?php get_header('home'); ?>
<!-- stran za zbirke -->
<div id="main" class="clearfix">
<?php global $wp_rewrite; echo "<!-- REWRITE::: "; print_r($wp_rewrite->rules); echo " -->"; ?>
<?php get_template_part( 'loop', 'zbirke' ); ?>
</div>
<?php get_footer(); ?>
