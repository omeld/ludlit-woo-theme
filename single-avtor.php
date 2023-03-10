<?php get_header('home'); ?>
<?php 
global $post; 
global $newlitTempCustomLength;
$newlitTempCustomLength = 0;
$category = get_the_category();
$useName = wp_get_post_terms($post->ID, "ime_avtorja", array('count' => 1));
$authorSlug = $useName[0]->slug;
$authorName = $useName[0]->name;
?>

<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

<?php
$thisAuthorsArticles = _thisAuthorsWorks('post', 5, $authorSlug);
$thisAuthorsBooks = _thisAuthorsWorks('knjiga', -1, $authorSlug);
$thisAuthorsInterviews = _thisAuthorsWorks('post', 1, $authorSlug, 'intervju');
?>

<div class="mobile-override fullw gray-background">
	<div class="" style="">
		<div class="articleText text-outer  top-padding bottom-padding">
			<div class="" style="">
<?php if (has_post_thumbnail($post->ID)) : ?>
				<div class="single-author-photo one-three center-margins center relative">
<?php $mythumb = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), 'medium'); ?>
				<!--<a class="bare-links blockLink center one-two center-margins" href="<?php echo wp_get_attachment_url(get_post_thumbnail_id($post->ID)); ?>" title="<?php the_title_attribute(); ?>" >
<?php		the_post_thumbnail('medium', array('class' => 'circle roundBorders', 'alt' => trim(strip_tags(get_post_meta(get_post_thumbnail_id($post->ID), '_wp_attachment_image_alt', true))))); ?>
				</a>-->
<!--
				<div class="one-five center-margins center">
					<a class=" blockLink circle ratio-1-1 cover" href="<?php echo wp_get_attachment_url(get_post_thumbnail_id($post->ID)); ?>" title="<?php the_title_attribute(); ?>" style="background-image: url(<?php echo $mythumb[0] ; ?>)">
					</a>
				</div>
-->
					<div class="roundBorders bare-links">
						<a class=" blockLink  cover" href="<?php echo wp_get_attachment_url(get_post_thumbnail_id($post->ID)); ?>" title="<?php the_title_attribute(); ?>" style="">
<?php the_post_thumbnail('medium', array('class' => '', 'alt' => trim(strip_tags(get_post_meta(get_post_thumbnail_id($post->ID), '_wp_attachment_image_alt', true))))); ?>
						</a>
					</div>
					<p class="sans font-size-0" id="authorPhotoDesc" style="text-align: right"><?php echo get_post_meta(get_post_thumbnail_id($post->ID), '_wp_attachment_image_alt', true);  ?></p>
				</div>
<?php endif; ?>
				<h1 class="center medium-top-margin small-bottom-margin font-size-5 sans thin"><?php the_title(); ?></h1>
				<div class=" serif columnar-text font-size-1 two-three center-margins">
<?php the_content(); ?>
				</div>
				<div class="center">
					<ul id="authorsWorksNavigation" class="theTags center bold" style="display: inline-block;">
<?php if (!empty($thisAuthorsArticles)) : ?>
						<li class="gray-background-3" ><a href="#authorsArticles">članki</a></li>
<?php endif; ?>
<?php if (!empty($thisAuthorsBooks)) : ?>
						<li class="gray-background-3" ><a href="#authorsBooks">knjige</a></li>
<?php endif; ?>
<?php if (!empty($thisAuthorsInterviews)) : ?>
						<li  class="gray-background-3"><a href="#authorsInterviews">intervju</a></li>
<?php endif; ?>
					</ul>
				</div>
			</div>
		</div>
	</div>
</div>

<?php
if (!empty($thisAuthorsInterviews)) :
	$post = $thisAuthorsInterviews[0];
	setup_postdata($post);

	$words = str_word_count(strip_tags(get_the_title($post->ID)));
	if ($words <= 10) {
		$myQuoteClass = 'font-size-8 italic thin leading-display center '; //red-background reverse
		$itemWidth = 'one-two center-margins';
		$bgColor = 'light-blue-background';
	} elseif ($words <= 20) {
		$myQuoteClass = 'font-size-7 thin leading-tight reverse center two-three center-margins'; //red-background reverse
		$itemWidth = 'two-three center-margins';
		$bgColor = 'gray-background-3';
	} elseif ($words <= 40) {
		$myQuoteClass = 'font-size-6 extra-bold italic  leading-display ';
		$itemWidth = 'text-inner';
		$bgColor = 'light-blue-background';
	} else {
		$myQuoteClass = 'font-size-5 italic  leading-display ';
		$itemWidth = 'text-inner';
		$bgColor = 'light-blue-background';
	}

?>
<div class="oneArticle fullw <?php echo $bgColor; ?>">
	<div class="">
		<div class="articleText clearfix text-outer" style="">
			<!--<h6 class="sans font-size-5 thin center"  id=""><span class="">Avtorjevi intervjuji</span></h6>-->
			<div id="authorsInterviews" class=" ___relatedArticlesList ">
<?php //foreach ($thisAuthorsInterviews as $post) : setup_postdata($post); ?>
<?php
?>
				<p class="article-data display-font article-data-author article-data-title block-para <?php echo "$myQuoteClass $itemWidth"; ?>">
					<span class=" article-data-item"><a class="bare-links" href="<?php the_permalink() ?>" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a></span>
				</p>
				<p class="article-data  article-data-item article-data-metadata sans no-indent <?php echo $itemWidth; ?>" style="border-top: 1px solid; padding-top: 1em;">
<?php $category = get_the_category(); ?>
					(<a class="" href="<?php the_permalink() ?>" title="<?php the_title_attribute(); ?>"><?php echo "$authorName, " . $category[0]->cat_name; ?>, <?php echo the_time('j. F Y'); ?></a>)
				</p>
<?php //endforeach; ?>
			</div>
		</div>
	</div>
</div>
<?php endif; ?>
<?php wp_reset_postdata(); ?>


<?php
if (false) : //(!empty($thisAuthorsArticles)) :
?>
<div class="oneArticle section">
	<div class="">
		<div class="articleText clearfix text-outer" style="padding-top: 0">
			<h6 class="sans font-size-5 thin center"  id="authorsArticles"><span class="">Avtorjevi novejši prispevki</span></h6>
			<ul class=" relatedArticlesList one-two center-margins">
<?php foreach ($thisAuthorsArticles as $post) : setup_postdata($post); ?>
				<li class="myPostItem myPostListItem" style="">
					<p class="article-data article-data-author article-data-title no-indent">
<?php
$contributor = wp_get_post_terms($post->ID, "ime_avtorja", array("count" => 1));
$contributorName = $contributor[0]->name;
if (isset($contributorName) and !(empty($contributorName))) :
?>
						<!--<span class="article-data-item contributorName"><?php echo $contributorName; ?>: </span>-->
<?php endif; ?>
						<span class="font-size-2 serif article-data-item"><a href="<?php the_permalink() ?>" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a></span>
					</p>
					<p class="article-data myPostMeta article-data-item article-data-metadata sans no-indent">
<?php $category = get_the_category(); ?>
						(<span class="article-data-item article-data-categories"><?php echo $category[0]->cat_name; ?></span>, 
						<span class="noun-project timer"><?php echo app_reading_time(); ?></span>)
					</p>
					<div class="theExcerpt gray serif"><?php $newlitTempCustomLength = 20; the_excerpt(); $newlitTempCustomLength = 0; ?></div>
				</li>
<?php endforeach; ?>
			</ul>
		</div>
	</div>
</div>
<?php endif; ?>



<?php
if (!empty($thisAuthorsArticles)) :
?>
<div class="oneArticle section">
	<div class="">
		<div class="articleText clearfix text-outer" style="padding-top: 0">
			<h6 class="sans font-size-5 thin center"  id="authorsArticles"><span class="">Avtorjevi novejši prispevki</span></h6>
			<ul class=" relatedArticlesList true-liquid-block-outer"><!--
<?php foreach ($thisAuthorsArticles as $post) : setup_postdata($post); ?>
				--><li class="myPostItem myPostListItem one-five true-liquid-block-inner" style="">
					<p class="article-data article-data-author article-data-title no-indent">
<?php
$contributor = wp_get_post_terms($post->ID, "ime_avtorja", array("count" => 1));
$contributorName = $contributor[0]->name;
if (isset($contributorName) and !(empty($contributorName))) :
?>
						<!--<span class="article-data-item contributorName"><?php echo $contributorName; ?>: </span>-->
<?php endif; ?>
						<span class="font-size-2 serif article-data-item"><a href="<?php the_permalink() ?>" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a></span>
					</p>
					<p class="article-data myPostMeta article-data-item article-data-metadata sans no-indent">
<?php $category = get_the_category(); ?>
						(<span class="article-data-item article-data-categories"><?php echo $category[0]->cat_name; ?></span>, 
						<span class="noun-project timer"><?php echo app_reading_time(); ?></span>)
					</p>
					<div class="theExcerpt serif gray"><?php $newlitTempCustomLength = 20; the_excerpt(); $newlitTempCustomLength = 0; ?></div>
				</li><!--
<?php endforeach; ?>
			--></ul>
			<p class="block-para center"><a href="<?php echo home_url('/imena-avtorjev/' . $authorSlug . '/'); ?>" title="Prispevki avtorja: <?php echo $authorName; ?>">Vsi avtorjevi prispevki</a></p>
		</div>
	</div>
</div>
<?php endif; ?>




<?php wp_reset_postdata(); ?>
<?php
if (false) : //(!empty($thisAuthorsArticles)) :
?>
<div class="oneArticle section">
	<div class="">
		<div class="articleText clearfix text-outer" style="padding-top: 0">
			<h6 id="authorsArticles" class="sans font-size-5 thin center"  id=""><span class="">Avtorjevi novejši prispevki</span></h6>
			<ul class=" relatedArticlesList two-three">
<?php foreach ($thisAuthorsArticles as $post) : setup_postdata($post); ?>
				<li class="myPostItem myPostListItem clearfix" style="">
					<div class="float one-three" style="text-align: right">
						<p class="article-data article-data-author article-data-title no-indent">
							<span class="font-size-2 serif article-data-item"><a href="<?php the_permalink() ?>" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a></span>
						</p>
						<p class="article-data myPostMeta article-data-item article-data-metadata sans no-indent">
<?php $category = get_the_category(); ?>
							(<span class="article-data-item article-data-categories"><?php echo $category[0]->cat_name; ?></span>, 
							<span class="noun-project timer"><?php echo app_reading_time(); ?></span>)
						</p>
					</div>
					<div class="theExcerpt gray serif float two-three">
						<div class="hasLeftMargin">
<?php $newlitTempCustomLength = 20; the_excerpt(); $newlitTempCustomLength = 0; ?>
						</div>
					</div>
				</li>
<?php endforeach; ?>
			</ul>
		</div>
	</div>
</div>
<?php endif; ?>
<?php wp_reset_postdata(); ?>








<?php
if (!empty($thisAuthorsBooks)) :
?>
<div class="oneArticle section">
	<div class="">
		<div class="articleText clearfix text-outer books" style="padding-top: 0">
			<h6 id="authorsBooks" class="sans font-size-5 thin center"  id=""><span class="">Avtorjeve knjige</span></h6>
			<ul id="titlesByAuthor" class="dynamicBookList true-liquid-block-outer"><!--
<?php foreach ($thisAuthorsBooks as $post) : setup_postdata($post); ?>
<?php
$author = wp_get_post_terms($post->ID, "ime_avtorja", array('count' => 1));
$translator = wp_get_post_terms($post->ID, "prevajalec", array('count' => 1));
$translatorName = $translator[0]->name;
$authorName = $author[0]->name;
$bookCategory = wp_get_post_terms($post->ID, 'book_cat', array('parent' => 0, 'fields' => 'names'));
$itemSize = 'one-five';
$fontSize = 'font-size-1';
?>
				--><li class="true-liquid-block-inner <?php echo $itemSize ?>">
					<div class="myPostItem">
<?php
$img_id = get_post_thumbnail_id($post->ID);
$alt_text = get_post_meta($img_id , '_wp_attachment_image_alt', true);
?>
						<a class="bare blockLink" href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>" >
<?php if (has_post_thumbnail()) : ?>
<?php the_post_thumbnail('myTwoColImage', array('class' => $myAddClass, 'alt' => $alt_text)); ?>
<?php 	endif; ?>
						</a>
						<div class="bookInfo">
							<h3 class="sans bold <?php echo $fontSize; ?>"><a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"><?php echo get_the_title(); ?></a></h3>
							<h4 class="sans normal <?php echo $fontSize; ?>"><a href="<?php echo home_url('/avtor/' . $author[0]->slug . '/'); ?>"><?php echo $author[0]->name; ?></a></h4>
							<h4 class=" normal sans gray <?php echo $fontSize; ?>"><?php echo get_post_meta($post->ID, 'Zbirka', true) ?> (<?php echo get_post_meta($post->ID, 'izid', true); ?>) &bull; <?php echo implode(', ', $bookCategory); ?></h4>
							<div class="font-size-0">
<?php newlitDisplayPrizeMeta($post->ID, 0); ?>
							</div>
						</div>
					</div>
				</li><!--
<?php endforeach; ?>
			--></ul>
		</div>
	</div>
</div>
<?php wp_reset_postdata(); ?>
<?php endif; ?>

<?php endwhile; else: ?>
<?php endif; ?>

<?php //$useName = get_query_var('name'); ?>
<?php //thisAuthorsInterview($useName); ?>
<?php //thisAuthorsWorks('Knjige','knjiga', -1, $useName, 1); ?>
<?php ////thisAuthorsWorks('Avtorjevi novejši prispevki', 'post', 6, $useName, 0); ?>
<?php //myAuthorsRecentPosts(0, 12, $useName, "h5"); ?>
</div>
<?php get_footer(); ?>

