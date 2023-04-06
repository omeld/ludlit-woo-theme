<?php
/*
Template name: front page w/ block template parts
 */
?>

<?php get_header('home'); ?>
<div id="main" class="clearfix levodesnopadding">
<!-- ...................................................... -->


<?php block_template_part('front-page-banner-top'); ?>

<section>
<?php 
// latest books
$args = array(
    'post_type' => 'product',
    'post_status' => 'publish',
    'posts_per_page' => 4,
    'order' => 'DESC',
    'orderby' => 'date',
    'tax_query' => array(
        array(
            'taxonomy' => 'product_cat',
            'terms' => 'knjige',
            'field' => 'name',
        ),
    ),
);

$loop = new WP_Query($args);
if ($loop->have_posts()) {
?>
    <h2>Najnovejše knjige</h2>
<?php
?>
<div class='ludlit_wc woocommerce ludlit_wc_custom_products'>
<ul class='products ludlit_wc_custom_products'>
<?php
    while ( $loop->have_posts() ) : $loop->the_post();
        wc_get_template_part( 'content', 'product' );
    endwhile;
?>
</ul>
</div>
<?php
} 
wp_reset_postdata();

?>
</section>
<section>
<?php 
// latest magazines
$args = array(
    'post_type' => 'product',
    'post_status' => 'publish',
    'posts_per_page' => 4,
    'order' => 'DESC',
    'orderby' => 'date',
    'tax_query' => array(
        array(
            'taxonomy' => 'product_cat',
            'terms' => 'revije',
            'field' => 'name',
        ),
    ),
);

$loop = new WP_Query($args);
if ($loop->have_posts()) {
?>
    <h2>Najnovejše številke revije Literatura</h2>
<?php
?>
<div class='ludlit_wc woocommerce ludlit_wc_custom_products'>
<ul class='products ludlit_wc_custom_products'>
<?php
    while ( $loop->have_posts() ) : $loop->the_post();
        wc_get_template_part( 'content', 'product' );
    endwhile;
?>
</ul>
</div>
<?php
} 
wp_reset_postdata();

?>

<?php block_template_part('front-page-banner-magazines'); ?>

</section>
<section>
<?php

// latest posts
$args = array(
    'post_type' => 'post',
    'post_status' => 'publish',
    'posts_per_page' => 8,
    'order' => 'DESC',
    'orderby' => 'date',
);

$latest_posts = new WP_Query($args);
if ($latest_posts->have_posts()) {
?>
    <h2>Novejši prispevki</h2>
<?php

?>
<div class='ludlit_wc woocommerce ludlit_wc_custom_products'>
<ul class='products ludlit_wc_custom_products'>

<?php
    while ($latest_posts->have_posts()) : $latest_posts->the_post();
        $main_author_imgs = array();
        $other_author_imgs = array();

        if ($contributors = wp_get_post_terms($post->ID, 'ime_avtorja')) {
            foreach ($contributors as $contributor) {
                $contributorName = $contributor->name;
                $author_page = new WP_Query(array(
                    //'title' => $contributorName,
                    'post_type' => 'avtor',
                    'posts_per_page' => 1,
                    'tax_query' => array(
                        array(
                            'taxonomy' => 'ime_avtorja',
                            'terms' => $contributorName,
                            'field' => 'name',
                        ),
                    ),
                ));
                if ($author_page->have_posts()): while ($author_page->have_posts()): $author_page->the_post();
                    if (has_post_thumbnail($post->ID)) {
                        $main_author_imgs[] = get_the_post_thumbnail($post->ID, 'myAuthorThumbnail');
                        //$main_author_imgs[] = get_the_post_thumbnail($post->ID, 'medium');
                    }
                endwhile; endif;
                $latest_posts->reset_postdata();
            }
        }
        if ($relatedContributors = wp_get_post_terms($post->ID, 'drugo_ime')) {
            foreach ($contributors as $contributor) {
                $contributorName = $contributor->name;
                $author_page = new WP_Query(array(
                    //'title' => $contributorName,
                    'post_type' => 'avtor',
                    'posts_per_page' => 1,
                    'tax_query' => array(
                        array(
                            'taxonomy' => 'drugo_ime',
                            'terms' => $contributorName,
                            'field' => 'name',
                        ),
                    ),
                ));
                if ($author_page->have_posts()): while ($author_page->have_posts()): $author_page->the_post();
                    if (has_post_thumbnail($post->ID)) {
                        $other_author_imgs[] = get_the_post_thumbnail($post->ID, 'myAuthorThumbnail');
                        //$other_author_imgs[] = get_the_post_thumbnail($post->ID, 'medium');
                    }
                endwhile; endif;
                $latest_posts->reset_postdata();
            }
        }

        $mySubtitle = get_post_meta($post->ID, 'mysubtitle', true);
?>

<li class="product but-actually-post">
    <a href="<?php the_permalink();?>" class="bare">
<?php
if (has_post_thumbnail($post->ID)) {
?>
<div class="ludlit_wc ludlit_wc_product_image_wrapper has_featured_image"><?php echo get_the_post_thumbnail($post->ID, 'medium'); ?></div>
<?php
} elseif (!empty($relatedContributorName) && !empty($other_author_imgs)) { 
?>
<div class="ludlit_wc ludlit_wc_product_image_wrapper has_other_author_image"><?php echo join('', $other_author_imgs); ?></div>
<?php
} elseif (!empty($contributorName) && !empty($main_author_imgs)) {
?>
<div class="ludlit_wc ludlit_wc_product_image_wrapper has_main_author_image"><?php echo join('', $main_author_imgs);?></div>
<?php
}
?>
    </a>
    <div class="ludlit_wc ludlit_wc_product_description">
        <h3 class="ludlit_wc_book_info_author"><?php echo $contributorName; ?></h3>
        <h4 class="ludlit_wc_book_info_title font-size-3 serif"><?php the_title(); ?></h4>
        <p class="ludlit_wc_additional_book_info">
<?php myParagraphExcerpt($args = array('limitWords' => 75, 'add_utm' => false)); //$newlitTempCustomLength = 50; the_excerpt(); $newlitTempCustomLength = 20; ?>
        </p>
        <p><?php echo the_time('j. F Y');?></p>
        <p>
<?php $category = get_the_category(); foreach ($category as $ctg) : ?>
            <a href="<?php echo esc_url(get_category_link($ctg->cat_ID)); ?>"><?php echo $ctg->cat_name; ?></a>
<?php endforeach; ?>
        </p>    
    </div>
</li>

<?php

    endwhile;
?>
</ul>
</div>
<?php
} 
wp_reset_postdata();

?>
</section>

<!-- ...................................................... -->
</div>
<?php get_footer(); ?>
