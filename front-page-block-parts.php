<?php
/*
Template name: front page w/ block template parts
 */
?>

<?php get_header('home'); ?>
<div id="main" class="clearfix levodesnopadding_not">
<!-- ...................................................... -->


<?php block_template_part('front-page-banner-top'); ?>

<section>
<?php 
// latest books
$args = array(
    'post_type' => 'product',
    'post_status' => 'publish',
    'posts_per_page' => 8,
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

function ludlit_wc_get_term_link($tax, $term) {
    $my_url = get_term_link(get_term_by('name', $term, $tax));
    return $my_url ?: '';
}

$loop = new WP_Query($args);
if ($loop->have_posts()) {
?>
    <div class="ludlit_wc_is_flex">
        <h2>Najnovejše knjige</h2>
        <p><a href="<?php echo ludlit_wc_get_term_link('product_cat', 'knjige'); ?>">&rarr; vse knjige</a></p>
    </div>
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
    <div class="ludlit_wc_is_flex">
        <h2>Najnovejše številke revije Literatura</h2>
        <p><a href="<?php echo ludlit_wc_get_term_link('product_cat', 'revije') ?>">&rarr; vse revije</a></p>
    </div>
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
/**
 * *******************************************************************
 * novejši prispevki
 * *******************************************************************
 */
// latest posts
$args = array(
    'post_type' => 'post',
    'post_status' => 'publish',
    'posts_per_page' => 12,
    'order' => 'DESC',
    'orderby' => 'date',
);

$latest_posts = new WP_Query($args);
if ($latest_posts->have_posts()) {
?>
    <div class="ludlit_wc_is_flex">
        <h2>Novejši prispevki</h2>
        <p><a href="<?php echo get_post_type_archive_link('post'); ?>">&rarr; vsi prispevki</a></p>
    </div>

<?php block_template_part('front-page-banner-quote'); ?>

<div class='ludlit_wc woocommerce ludlit_wc_custom_products'>
<ul class='products ludlit_wc_custom_products ludlit_wc_recent_posts'>

<?php
    while ($latest_posts->have_posts()) : $latest_posts->the_post();
    
        // categories
        $category = get_the_category(); 
        $list_categories = array(); 
        $category_slugs = array();
        foreach ($category as $ctg) {
            $list_categories[] = "<a href='" . esc_url(get_category_link($ctg->cat_ID)) . "'>$ctg->cat_name</a>";
            $category_slugs[] = $ctg->slug;
        }
        $mySubtitle = get_post_meta($post->ID, 'mysubtitle', true);

        $show_contributor_names = wp_get_post_terms($post->ID, 'ime_avtorja');

        $show_contributor_name = join(', ', array_map(function($object) {
            return $object->name;
        }, $show_contributor_names));
        

        $main_author_imgs = array();
        $other_author_imgs = array();
        $my_post_thumbnail = array();
        $my_show_imgs = array();
        $my_post_id = '';

        $my_featured_image_options = array('featured image', 'other contributor', 'contributor');

        // prepare all different options for cover img
        foreach ($my_featured_image_options as $option) {
            $my_taxonomy = '';
            $my_classes = array();
            if ($option == 'contributor') {
                $my_taxonomy = 'ime_avtorja';
                $my_classes[] = 'ludlit_wc_has_main_author_img';
                $my_classes[] = 'has_main_author_image';
            } elseif ($option == 'other contributor') {
                $my_taxonomy = 'drugo_ime';
                $my_classes[] = 'ludlit_wc_has_other_author_img';
                $my_classes[] = 'has_other_author_image';
            } else {
                $my_classes[] = 'ludlit_wc_has_featured_img';
                $my_classes[] = 'has_featured_image';
            }
            if (!empty($my_taxonomy)) {
                if ($contributors = wp_get_post_terms($post->ID, $my_taxonomy)) {
                    foreach ($contributors as $contributor) {
                        $contributorName = $contributor->name;
                        $author_page = new WP_Query(array(
                            'post_type' => 'avtor',
                            'posts_per_page' => 1,
                            'tax_query' => array(
                                array(
                                    'taxonomy' => $my_taxonomy,
                                    'terms' => $contributorName,
                                    'field' => 'name',
                                ),
                            ),
                        ));
                        if ($author_page->have_posts()): while ($author_page->have_posts()): $author_page->the_post();
                            if (has_post_thumbnail($post->ID)) {
                                //$main_author_imgs[] = get_the_post_thumbnail($post->ID, 'myAuthorThumbnail');
                                $my_show_imgs[] = get_the_post_thumbnail($post->ID, 'medium');
                                $my_post_id = $post->ID;
                            }
                        endwhile; endif;
                        $latest_posts->reset_postdata();
                    }
                }
            } else {
                if (has_post_thumbnail($post->ID)) {
                    $my_show_imgs[] = get_the_post_thumbnail($post->ID, 'medium');
                    $my_post_id = $post->ID;
                }
            }
            if (!empty($my_show_imgs)) {
                if ($my_attachment_image_src = wp_get_attachment_image_src(get_post_thumbnail_id($my_post_id), 'medium')) {
                    $my_img_width = $my_attachment_image_src[1];
                    $my_img_height = $my_attachment_image_src[2];

                    if ($my_img_width > $my_img_height) {
                        $my_classes[] = "ludlit_wc_is_landscape_image";
                    } elseif ($my_img_width < $my_img_height) {
                        $my_classes[] ="ludlit_wc_is_portrait_image";
                    } else {
                        $my_classes[] = "ludlit_wc_is_square_image";
                    }
                }
                break;
            }
        }
?>

<li class="product but-actually-post <?php echo join(' ', array_map(function($r) { return 'ludlit_wc_post_is_cat_' . $r; }, $category_slugs));?>">
    <a href="<?php the_permalink();?>" class="bare">
        <div class="ludlit_wc ludlit_wc_product_image_wrapper <?php echo join(' ', $my_classes); ?>">
            <?php echo join('', $my_show_imgs); ?>
        </div>
    </a>
    <div class="ludlit_wc ludlit_wc_product_description">
        <div class="ludlit_wc_post_meta">
            <p class="ludlit_wc_post_date"><?php echo the_time('j. F Y');?></p>
            <p class="ludlit_wc_post_categories">
<?php echo join(' / ', $list_categories); ?>
            </p>    
        </div>
        <h3 class="ludlit_wc_book_info_author"><?php echo $show_contributor_name; ?></h3>
        <h4 class="ludlit_wc_book_info_title"><?php the_title(); ?></h4>
        <?php if (!empty($mySubtitle)) { echo "<p class='ludlit_wc_subtitle'>$mySubtitle</p>"; } ?>
        <div class="ludlit_wc_post_excerpt">
<?php //myParagraphExcerpt($args = array('limitWords' => 75, 'add_utm' => false));  ?>
<?php //$newlitTempCustomLength = 50; the_excerpt(); $newlitTempCustomLength = 20; ?>
<?php //the_excerpt(); //too long! ?>
<?php
//$my_excerpt = get_the_excerpt();
$my_excerpt_length = apply_filters('excerpt_length', 50);
$my_excerpt_more   = apply_filters('excerpt_more', '&nbsp; &hellip;');
$my_excerpt        = wp_trim_words(get_the_excerpt(), $my_excerpt_length, '&nbsp;&hellip;');
?>
            <p><?php echo $my_excerpt; ?></p>
        </div>
        <p class="ludlit_wc_read_more"><a href="<?php the_permalink(); ?>">&rarr; preberi</a></p>
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
<section>
    <h2>
        Socialna omrežja
    </h2>
    
    <ul style="list-style: none;">
		<?php dynamic_sidebar('newlit-social-widget')?>  
	</ul>
    
</section>
<!-- ...................................................... -->
</div>
<?php get_footer(); ?>
