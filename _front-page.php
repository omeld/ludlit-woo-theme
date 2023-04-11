<?php
/*
Template name: kao front page – isto kot index!
 */
?>
<?php get_header('home'); ?>
<div id="main" class="clearfix">
  <main id="main" class="site-main" role="main">

    <?php while ( have_posts() ) : the_post(); ?>

      <?php the_content(); ?>

    <?php endwhile; // end of the loop. ?>

  </main><!-- #main -->



</div>
<?php get_footer(); ?>
