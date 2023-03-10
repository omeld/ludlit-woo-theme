<?php
/*
Template Name: Stran za kategorije
 */
?>

<?php get_header('home'); ?>
<style type="text/css">
.one-author {
	position: relative;
	flex-wrap: nowrap;
}
.one-author span {
	white-space: nowrap;
}

.authors {
	flex-wrap: wrap;
}

@media only screen and (max-width: 600px) {
	.authors.flex {
		display: flex;
	}
	li.gendered-item-block > div {
		flex-direction: column;
		flex-shrink: 0;
	}
	.gendered-item-block {
		width: 100% !important;
	}
	.gendered-item-block .author-block .this-author-photo {
		margin-left: auto; margin-right: auto;
		width: 25% !important;
	}
	.gendered-item-block .triangle-inner {
		width: 100% !important;
	}
	.myPostListItem:nth-of-type(even) .author-block {
		order: 0;
	}
	.description-block {
		width: 100% !important;
		box-sizing: border-box;
	}
	html body h1 {
		text-align: center;
		width: 100% !important;
	}
}

</style>

<!-- category.php -->
<!-- LOOP -->
<?php
global $post, $wpdb, $my_query, $paged, $wp_query, $request; // brez tega ne dela get_post_meta
global $myNumberOfPosts;
$myNumberOfPosts = 20;

/*
$args = array(
	'posts_per_page' => $myNumberOfPosts,
	'posts_per_archive_page' => $myNumberOfPosts,
	'paged' => get_query_var('paged'),
	'cat' => get_query_var('cat'),
	'post_type' => $wp_query->query_vars['post_type']
);
 */




$args = //array_merge(
	//$wp_query->query,
	array(
		'posts_per_page' => $myNumberOfPosts,
		'posts_per_archive_page' => $myNumberOfPosts, //bistveno!
		'paged' => get_query_var('paged'),
		//'category__not_in' => array(3902, 3846, 3848), //dodal izpostavljeno – ker je kao samo ena, in to na coverju
		'post_status' => array('publish', 'draft'),
		'meta_query' => array(
			'relation' => 'AND',
			'meta_title' => array(
				'key' => 'gendered-topic-name'
			),
			'meta_order' => array(
				'key' => 'gendered-topic-order'
			)
		),
		'tax_query' => array(
			'relation' => 'AND',
			array(
				'taxonomy' => 'ime_avtorja',
				'field' => 'slug',
				'operator' => 'EXISTS'
			),
			array(
				'taxonomy' => 'category',
				'field' => 'slug',
				'terms' => 'ospoljene-reci'
			),
			array(
				'taxonomy' => 'category',
				'field' => 'id',
				'terms' => array(3902, 3846, 3848),
				'operator' => 'NOT IN'
			)
		),
		'orderby' => array('meta_order' => 'ASC', 'date' => 'ASC')
	)
//)
;

$myCurrentLoop = new WP_Query($args);


$myCoverStoriesNum = 999; // to pomeni, da bdo praktično vsi prispevki, kadar jih prikazujemo na arhivski strani, eden pod drugim, tj. nikoli ne bodo po denimo štirje na vrstico (kot bi bili na prvi strani)
//$myCurrentLoop = new WP_Query($args);

require('local-array-column.php');
$authorThumbnailURL = array();
if ($myCurrentLoop->have_posts()) :
$i = 0;
	foreach($myCurrentLoop->posts as $myPost) :
		$names = get_the_terms($myPost, 'ime_avtorja');
		if (!in_array($names[0]->name, array_column($authorThumbnailURL, 'name'))) :
			$authorPage = get_page_by_title($names[0]->name, OBJECT, 'Avtor');
			if (!empty($authorPage)) {
				if (has_post_thumbnail($authorPage->ID)) {
					$url = wp_get_attachment_image_src(get_post_thumbnail_id($authorPage->ID), 'myAuthorThumbnail');
					$authorThumbnailURL[$i]['url'] = $url[0];
					$authorThumbnailURL[$i]['name'] = $names[0]->name;
				}
			}
		endif;
		$i++;
	endforeach;


	$catDesc = category_description(get_query_var('cat'));
?>
<!--
<div class="mobile-override top-stripe-category light-blue-background fullw">
	<div class="text-outer minimal-padding">
		<p class="one-two font-size-2 bold">Arhiv prispevkov v rubriki <?php echo get_cat_name(get_query_var('cat')); ?> (<?php echo $myCurrentLoop->found_posts; ?>)</p>
	</div>
</div>
-->
<h1 class=" small-top-padding stretch-full-width gray-background small-bottom-padding two-three leading-tight bold display-font font-size-7">Ospoljene reči</h1>
<?php if(!empty($catDesc)) { ?>
<div class='stretch-full-width gray-background-not gray-4-not no-indent-not large-top-padding large-bottom-padding' style="/*max-width: 33em; margin-left: auto; margin-right: auto;*/">
<div class="two-three-not  font-size-1 leading-loose medium-top-padding medium-bottom-padding medium-left-padding medium-right-padding white-background center-margins gray-5">
<div style="column-width: 25em;">
	<?php echo $catDesc; ?>
	<p class="align-right small-top-margin"><em>Renata Šribar</em></p>
</div>

<div class="authors large-top-margin flex" style="">
<?php foreach ($authorThumbnailURL as $thumb) : ?>
	<div class="one-author small-right-margin small-bottom-margin" style="border-radius: 25px 0 0 25px; background-color: #eee;">
		<div style="width: 50px; display: inline-block; vertical-align: middle">
			<div class="circle">
				<div class="cover ratio-1-1" style="background-image: url(<?php echo $thumb['url'];?>)">
				</div>
			</div>
		</div>
		<span style="padding: 0 1em;"><?php echo $thumb['name']; ?></span>
	</div>
<?php endforeach; ?>
</div>
<!--<div class="large-top-margin this-author-photo one-five center circle center-margins" style="margin-bottom: 2em">
	<div class="cover ratio-1-1" style="background-image: url(http://www.ludliteratura.si/wp-content/uploads/2014/08/Mojca-Pisek-140x140.jpg)"></div>
</div>-->
</div>
</div>





<?php } ?>
<?php endif; ?>
<?php require('loop-gendered.php'); ?>
<?php get_footer(); ?>
