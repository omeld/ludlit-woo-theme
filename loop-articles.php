<?php
/*
 * _____
 * POZOR
 * -----
 * to je aktivna verzija s serverja; 
 * lokalna verzija je že drugi branch, 
 * ki ima nezdružljive posodobitve :-(
 *
 */
/*
to je glavna zanka za mnoge prikaze seznamov prispevkov (domača stran, arhivi po datumih, po kategorijah …)
 */
?>
<?php

$paged = 1; // page/paged zmeda #fixed

if (get_query_var('paged')) { $paged = get_query_var('paged'); }
elseif (get_query_var('page')) { $paged = get_query_var('page'); }
else { $paged = 1; }


$myIterator = 0;
global $myNumberOfPosts;

$myNumberOfPosts = (!empty($overrideNumberOfPosts) ? $overrideNumberOfPosts : 10);

//$myNumberOfPosts = 20;

$args = array_merge(
	$wp_query->query,
	array(
		'posts_per_page' => $myNumberOfPosts,
		'posts_per_archive_page' => $myNumberOfPosts, //bistveno!
		//'paged' => get_query_var('paged'),
		'paged' => $paged,
		'category__not_in' => array(3902, 3846, 3848) //dodal izpostavljeno – ker je kao samo ena, in to na coverju
	)
);



$myCurrentLoop = new WP_Query($args);

//$temp_query = clone $wp_query;

$myCoverStoriesNum = 0;

?>
<?php if ($myCurrentLoop->have_posts()) : ?>
<?php 
	$myIterator = 0; 
	$myListSwitch = 0;
?>

<!-- LOOP INSTAGRAM
<?php 
$counterInstagram = 0;
if ($counterinstagram == 0):
	require('loop-instagram.php'); 
	$counterInstagram++;
endif 
?> -->
<!--TEGLE BI PRESTAVU NA KONC // NAJDU KJE PRIDE TALE ARHIV NA KONCU IN KJE GA UREJAM -->
<!--<div>
	<?php
	require('loop-instagram.php'); 
	?>
</div>-->


<div class="myMainPosts  clearfix levodesnopadding">
	<ul class="newlit-stories-outer-wrapper">
<?php if (($paged < 2)  && (0 < $myCoverStoriesNum)) : ?>
		<li>
			<ul class="newlit-stories-inner-wrapper true-liquid-block-outer newlit-newest-stories-wrapper"><!--
<?php else : ?>
		<li class="medium-top-padding stretch-full-width gray-background">
			<ul class="newlit-stories-inner-wrapper true-liquid-block-outer newlit-newer-stories-wrapper"><!--
<?php endif; ?>
<?php while ($myCurrentLoop->have_posts()) : $myCurrentLoop->the_post(); $myIterator++; ?>
<?php


$contributor = ""; $contributorName = ""; $relatedContributor = ""; $relatedContributorName = ""; $relatedAuthorThumbnailURL = ""; $thumbnailURL = ""; // reset before next iteration


$contributor = wp_get_post_terms($post->ID, "ime_avtorja", array("count" => 1));
$contributorName = $contributor[0]->name;
$contributorSlug = $contributor[0]->slug;

$relatedContributor = wp_get_post_terms($post->ID, "drugo_ime", array("count" => 1));
$relatedContributorName = $relatedContributor[0]->name;
$relatedContributorSlug = $relatedContributor[0]->slug;

$mySubtitle = get_post_meta($post->ID, 'mysubtitle', true);
//$paged = get_query_var('paged');

// ---------------
$category = get_the_category();
$myCategoryNames = array();
foreach ($category as $ctg) :
	if (($ctg->name == "izpostavljeno") or
			($ctg->name == "novo")) {
		continue;
	}
	$myCategoryNames[] = $ctg->name;
	$myCategorySlugs[] = $ctg->slug;
endforeach;


if (!empty($relatedContributorName)) {
	//$relatedAuthorPage = get_page_by_title($relatedContributorName, OBJECT, 'Avtor');

	//update deprecated
	$tmp_args = array('post_type' => 'avtor', 'post_status' => 'publish', 'name' => $relatedContributorSlug, 'posts_per_page' => 1);
	$tmp_query = new WP_Query($tmp_args);
	$relatedAuthorPage = null;
	if ($tmp_query->have_posts()) $relatedAuthorPage = $tmp_query->posts[0];

	

	if (!empty($relatedAuthorPage)) {
		if (has_post_thumbnail($relatedAuthorPage->ID)) {
			$relatedAuthorThumbnailURL = wp_get_attachment_image_src(get_post_thumbnail_id($relatedAuthorPage->ID), 'medium');
			$relatedAuthorThumbnailURL = $relatedAuthorThumbnailURL[0];
		}
	}
}

//if (in_array('Na prvo žogo', $myCategoryNames)) :
	if (has_post_thumbnail($post->ID)) :
		$thumbnailURL = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), 'medium');
		$thumbnailURL = $thumbnailURL[0];
		$thumbnailMeta =  wp_get_attachment_metadata(get_post_thumbnail_id($post->ID));
		$thumbnailIsPortrait = ($thumbnailMeta['height'] > $thumbnailMeta['width'] ? 1 : 0);
		$featuredClasses = ($thumbnailIsPortrait ? 'featuredPortrait' : 'featuredLandscape');
		$myBackgroundPosition = get_post_meta($post->ID, 'background-position', true);
	endif;
//endif;
// ------------------

		if (!empty($relatedAuthorThumbnailURL) && empty($thumbnailURL)) {
			$thumbnailURL = $relatedAuthorThumbnailURL;
		}


?>
<?php 
	if ($paged < 2) :
		$articleWidth = ($myIterator <= $myCoverStoriesNum ? 'one-one' : 'one-four'); // v arhivu bo to vedno res!
		$fontSize = ($myIterator <= $myCoverStoriesNum ? 'two-three center-margins font-size-5 serif center normal leading-tight' : 'font-size-2 bold serif center leading-tight');
	else :
		$articleWidth = 'one-four';
		$fontSize = 'font-size-2 bold serif center leading-tight';
	endif;
?>
<?php if (($paged < 2)  && ($myIterator <= $myCoverStoriesNum)) : ?>
		--><li class="myPostListItem true-liquid-block-inner newest-items <?php echo $articleWidth; ?> myPostItem">
			<div class="text-outer medium-top-padding x-large-bottom-padding">
				<div class="paddedText sans-dagny thin">
<?php if (!empty($thumbnailURL)) : ?>
					<div class="fluid-height-wrapper small-top-margin-not small-bottom-margin">
					<a class="bare" style="display: block" href="<?php the_permalink() ?>"><div class="fluid-height-ratio-2-3 cover" style="background-image: url(<?php echo $thumbnailURL; ?>); <?php if (isset($myBackgroundPosition)) { echo "background-position: $myBackgroundPosition"; }  ?>">
						</div></a>
					</div>
<?php endif; ?>
					<h4 class="article-title <?php echo $fontSize; ?>"><a href="<?php the_permalink() ?>" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a></h4>
<?php if (!empty($mySubtitle)) : ?><h5 class="article-subtitle one-two center-margins gray normal center font-size-1"><?php echo $mySubtitle ?></h5><?php endif; ?>
<?php if (!is_tax('ime_avtorja')) : ?>
<?php if (isset($contributorName) and !(empty($contributorName)) and ($showAuthorThumb !== false)) : ?>
<?php 
	//$authorPage = get_page_by_title($contributorName, OBJECT, 'Avtor'); 

	//update deprecated
	$tmp_args = array('post_type' => 'avtor', 'post_status' => 'publish', 'name' => $contributorSlug, 'posts_per_page' => 1);
	$tmp_query = new WP_Query($tmp_args);
	$authorPage = null;
	if ($tmp_query->have_posts()) $authorPage = $tmp_query->posts[0];
?>
					<p class="bottom-margin no-indent contributorName serif italic center font-size-2 normal"><?php echo $contributorName; ?></p>
<?php if (empty($thumbnailURL)) : ?>
					<div class="this-author-photo one-eight center small-top-margin circle center-margins" style="margin-bottom: 2em">
						<div class="cover ratio-1-1" style="background-image: url(<?php $xthumb = wp_get_attachment_image_src(get_post_thumbnail_id($authorPage->ID), 'myAuthorThumbnail'); echo $xthumb[0] ?>)"></div>
					</div>
<?php endif; ?>
<?php endif; ?>
<?php endif; ?>
				</div>
				<div class="mobile-full-width one-two center-margins ">
					<div class="theExcerpt serif font-size-1"><?php myParagraphExcerpt($args = array('limitWords' => 75, 'add_utm' => false)); //$newlitTempCustomLength = 50; the_excerpt(); $newlitTempCustomLength = 20; ?></div>
					<div class="myPostMeta gray sans  center top-margin">
						<p class="no-indent"><?php echo the_time('j. F Y');?> | 
<?php //$category = get_the_category(); ?>
<?php foreach ($category as $ctg) : ?>
<?php 
		//if (($ctg->name == "izpostavljeno") or
		//	($ctg->name == "novo")) {
		//		continue;
		//	}
?>
							<a href="<?php echo esc_url(get_category_link($ctg->cat_ID)); ?>"><?php echo $ctg->cat_name; ?></a>
<?php endforeach; ?>
							<!-- | <a href="<?php comments_link(); ?>">Komentarji (<?php echo get_comments_number(); ?>)</a> -->
						</p>
					</div>
				</div>
			</div>
		</li><!--
<?php $myListSwitch = ($myIterator == $myCoverStoriesNum ? 1 : 0); ?>
<?php else : /* not cover stories anymore */ ?>
<?php if ($myListSwitch) : $myListSwitch = 0; ?>
--></ul></li><li class="medium-top-padding stretch-full-width gray-background"><ul class="newlit-stories-inner-wrapper true-liquid-block-outer newlit-newer-stories-wrapper"><!--
<?php endif; ?>
		--><li class="myPostListItem other-story center one-three newer-items myPostItem true-liquid-block-inner">
			<div class="text-outer minimal-padding white-background"><!--
				--><div class="sans-dagny thin">
<?php if (!empty($thumbnailURL)) : ?>
					<div class="fluid-height-wrapper small-top-margin-not small-bottom-margin">
					<a class="bare" style="display: block" href="<?php the_permalink() ?>"><div class="fluid-height-ratio-2-3 cover" style="background-image: url(<?php echo $thumbnailURL; ?>); <?php if (isset($myBackgroundPosition)) { echo "background-position: $myBackgroundPosition"; }  ?>">
						</div></a>
					</div>
<?php endif; ?>
					<h4 class="article-title serif font-size-2 bold"><a href="<?php the_permalink() ?>" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a></h4>
					<?php if (!empty($mySubtitle)) : ?><h5 class="article-subtitle normal three-four center-margins gray center font-size-1"><?php echo $mySubtitle ?></h5><?php endif; ?>
<?php if (!is_tax('ime_avtorja')) : ?>
	<?php if (isset($contributorName) and !(empty($contributorName)) and ($showAuthorThumb !== false)) : ?>
<?php 
	//$authorPage = get_page_by_title($contributorName, OBJECT, 'Avtor'); 
	
	//update deprecated
	$tmp_args = array('post_type' => 'avtor', 'post_status' => 'publish', 'name' => $contributorSlug, 'posts_per_page' => 1);
	$tmp_query = new WP_Query($tmp_args);
	$authorPage = null;
	if ($tmp_query->have_posts()) $authorPage = $tmp_query->posts[0];
	
	
?>
					<p class="contributorName serif italic small-bottom-margin font-size-1 normal"><?php echo $contributorName; ?></p>
<?php if (empty($thumbnailURL)) : ?>
					<div class="this-author-photo one-four center circle center-margins" style="margin-bottom: 2em">
						<div class="cover ratio-1-1" style="background-image: url(<?php $xthumb = wp_get_attachment_image_src(get_post_thumbnail_id($authorPage->ID), 'myAuthorThumbnail'); echo $xthumb[0] ?>)"></div>
					</div>

<?php endif; ?>
	<?php endif; ?>
<?php endif; ?>
				
					<div class="theExcerpt normal align-left small-bottom-margin font-size-1" style="display: flex; align-items: center; flex-direction: column; margin: 1em;"><?php myParagraphExcerpt($args = array('limitWords' => 75, 'add_utm' => false)); //$newlitTempCustomLength = 50; the_excerpt(); $newlitTempCustomLength = 20; ?></div>
					<div class="myPostMeta  sans normal ">
						<p class="gray no-margin no-indent"><?php echo the_time('j. F Y');?> | 
<?php $category = get_the_category(); ?>
<?php foreach ($category as $ctg) : ?>
<?php 
		//if (($ctg->name == "izpostavljeno") or
		//	($ctg->name == "novo")) {
		//		continue;
		//	}
?>
							<a href="<?php echo esc_url(get_category_link($ctg->cat_ID)); ?>"><?php echo $ctg->cat_name; ?></a>
<?php endforeach; ?>
							<!-- | <a href="<?php comments_link(); ?>">Komentarji (<?php echo get_comments_number(); ?>)</a> -->
						</p>
					</div>
				</div>
			</div>
		</li><!--
<?php endif; ?>
<?php endwhile; ?>
--></ul></li></ul>
<?php

//$wp_query = $temp_query;
//$max_num_pages = $wp_query->max_num_pages;
//echo "<!-- max_num_pages ::: $wp_query->max_num_pages ||| posts_per_page ::: $wp_query->posts_per_page ||| found_posts ::: $wp_query->found_posts -->";
$my_max_num_pages = ceil($myCurrentLoop->found_posts / $myNumberOfPosts);

//echo "<!-- <pre> $my_max_num_pages — "; var_dump($wp_query); echo "</pre> -->"; 

?>
<?php
$big = 999999999; // need an unlikely integer
$paginateLinks = paginate_links( array(
	'prev_text' => '&laquo; Novejše',
	'next_text' => 'Starejše &raquo;',
	'base' => str_replace( $big, '%#%', get_pagenum_link( $big ) ),
	'format' => '?paged=%#%',
	'current' => max(1, $paged),
	'total' => $my_max_num_pages
) );
if ($my_max_num_pages > 1)
	echo "<div class='clearfix floatRight small-top-padding small-bottom-padding' id='myPagination'>$paginateLinks</div>";
?>
</div>
<div>
	<?php
require('loop-instagram.php'); 
?>
</div>
<?php else: ?>
<p>ništa</p>
<?php endif; ?>
