<!-- loop-revija.php -->
<?php

global $post;
global $wpdb;
global $wp_query;

$args = array(
	'post_status' => publish,
	'posts_per_page' => 1,
	'post_type' => 'revija',
	'meta_key' => 'newlit-revija-new-stevilka',
	'orderby' => 'meta_value_num',
	'order' => 'DESC',
);
$magazineArticles = get_posts($args);
?>
<?php if ($magazineArticles) : foreach ($magazineArticles as $post) : setup_postdata($post);
	the_content();
endforeach; endif; ?>
