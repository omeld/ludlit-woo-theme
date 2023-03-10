<pre class="font-size-2 red">
<?php
echo "post_type_archive " . is_post_type_archive() . "\n";
echo "page " . is_page('knjige') . "\n";
echo "category " . is_category() . "\n";
echo "tax " . is_tax('zbirka') . "\n";
echo "archive " . is_archive() . "\n";
?>
</pre>
<?php

global $post;
global $wp_query;
//global $wpdb;
global $request;

$myIterator = 0;
global $myNumberOfPosts;
$myNumberOfPosts = 9;

$series = 'prisleki';

$queryTax =  $wp_query->query_vars['taxonomy'];
$queryTerm = $wp_query->query_vars['term'];

if ($queryTax == "zbirka" and isset($queryTerm)) {
	$series = $queryTerm;
}

$args = array_merge(
	//$wp_query->query,
	array(
		'posts_per_page' => $myNumberOfPosts,
		'posts_per_archive_page' => $myNumberOfPosts,
		'paged' => get_query_var('paged'),
		'post_status' => 'publish',
		'post_type' => 'knjiga',
		'meta_key' => 'izid',
		'orderby' => 'meta_value_num',
		'order' => 'DESC',
		'tax_query' => array(
			array(
				'taxonomy' => 'zbirka',
				'field' => 'slug',
				'terms' => $series
			)
		)
	)
);


//$myBookTitles = get_posts($args);
//echo "<!-- WP_QUERY1:::"; print_r($wp_query); echo " -->";

$myBookTitles = new WP_Query($args);
//echo "<!-- WP_QUERY2:::"; print_r($myBookTitles); echo " -->";



//echo "
/*
//	<!-- WP_QUERY ::: " . $wp_query->request . " -->";
echo "
	<!-- WP_QUERY2 ::: " . $myBookTitles->request . " -->";
//echo "
//	<!-- WP_QUERY3 :::"; print_r($wp_query->query); echo " -->";
echo "
	<!-- WP_QUERY4 :::"; print_r($myBookTitles->query); echo " -->";
 */

//if (have_posts()) : 
?>
<div class="myMainPosts float clearfix nineCol">
<ul class="clearfix">
<?php //foreach($myBookTitles as $post) : setup_postdata($post); $myIterator++ ?>
<?php while ($myBookTitles->have_posts()) : $myBookTitles->the_post(); $myIterator++; ?>
<?php
	$this_post_master_id = $post->ID;
	$term_list = wp_get_post_terms($post->ID, 'ime_avtorja', array("fields" => "names"));
	$useName = implode(", ", $term_list);
?>
<?php if (($myIterator != 0) and !($myIterator % 3)) { ?>
<?php $myPostMargin = ""; ?>
<?php } else { ?>
<?php $myPostMargin = " hasRightMargin"; ?>
<?php } ?>
<li class="myPostItem threeCol float <?php echo $myPostMargin; ?>">
	<div class="postExcerpt">
<?php if (has_post_thumbnail()) : ?>
			<a class="bare" href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>" >
<?php		the_post_thumbnail('myBookThumbnail', array('class' => $myAddClass, 'alt' => trim(strip_tags(get_post_meta(get_post_thumbnail_id($post->ID), '_wp_attachment_image_alt', true))))); ?>
			</a>
<?php endif; ?>
	</div>
	<div class="paddedText">
		<h5 class="uppercase"><?php echo $useName; ?></h5>
		<h4><a href="<?php the_permalink() ?>" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a></h4>
		<p class="myBookQuote"><?php echo get_post_meta($post->ID, 'citat', true);?></p>
		<p class="zbirka"><?php echo get_post_meta($post->ID, 'zbirka', true); ?></p>
		<p class="izid">(leto izida: <?php echo get_post_meta($post->ID, 'izid', true); ?>)</p>
			<?php newlitDisplayPrizeMeta($this_post_master_id, 0); ?>

	</div>
</li>
<?php if (($myIterator != 0) and !($myIterator % 3)) { ?>
<li style="clear: both; height: 0px"></li>
<?php } ?>
<?php 
endwhile; 
//endforeach;
?>
</ul>
<?php

//$max_num_pages = $myBookTitles->max_num_pages;
//$paged = get_query_var('paged');
//$my_max_num_pages = ceil($wp_query->found_posts / $myNumberOfPosts);
//echo "<!-- my max num pages: $my_max_num_pages ::: $wp_query->found_posts -->";

?>
<div class="clearfix floatRight" id="myPagination">
<?php
//$big = 999999999; // need an unlikely integer
echo paginate_links(
	array(
		'prev_text' => '&laquo; Novejše',
		'next_text' => 'Starejše &raquo;',
		//'base' => str_replace($big, '%#%', get_pagenum_link($big)),
		'base' => get_pagenum_link() . '%_%',
		'format' => '?paged=%#%',
		'current' => max(1, get_query_var('paged')),
		'total' => $myBookTitles->max_num_pages
	)
);
?>
</div>
</div>
