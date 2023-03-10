<?php get_header('home'); ?>
<script>
/*
	OKEJ DELUJE :-)
 */
/*
if ($.cookie('newlitSubscribeCookie') == undefined) {
	var seconds = (1 / 24 / 60 / 60) * 20;
	$.cookie('newlitSubscribeCookie', 'test', { expires: seconds });
	alert('nov cookie');
} else {
	alert('cookie že obstaja: ' + $.cookie('newlitSubscribeCookie'));
}
 */
</script>
<!-- intervju PHP (po na prvo žogo) --!>
<?php 
global $post;
global $thisPostID;
$thisPostID = $post->ID;
global $newlitTempCustomLength;
global $excerpt_show_more;
$contributor = wp_get_post_terms($post->ID, "ime_avtorja");


$contributorName = implode(', ', array_map(create_function('$r', 'return $r->name;'), $contributor));
$contributorSlug = array_map(create_function('$r', 'return $r->slug;'), $contributor);

//$contributorName = $contributor[0]->name;
//$contributorSlug = $contributor[0]->slug;

$mySubtitle = get_post_meta($post->ID, 'mysubtitle', true);
$myBackgroundPosition = "center";
$myBackgroundPosition = get_post_meta($post->ID, 'background-position', true);
$paged = get_query_var('paged');
?>
<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
<?php
	$words = str_word_count(strip_tags(get_the_title($post->ID)));
	$titleSize = 'font-size-6';
	if ($words > 10) {
		$titleSize = 'font-size-5';
	} elseif ($words <= 20) {
	} elseif ($words <= 40) {
	} else {
	}
?>
<div class="oneArticle <?php echo implode(' ', get_post_class()); ?>">
	<div class="">
		<div class="articleText clearfix">
			<div class="top-padding someMeta clearfix font-size-1 bare-links gray">
				<div class="addthis_sharing_toolbox float"></div>
				<p class="no-indent post_date align-right"><?php echo the_time('j. F Y'); ?></p>
				<ul id="categoryList" class="clearfix align-right">
<?php $category = get_the_category(); ?>
<?php $myCategoryNames = array(); ?>
<?php foreach ($category as $ctg) : ?>
<?php 
		if (($ctg->name == "izpostavljeno") or
			($ctg->name == "novo")) {
				continue;
			}
			$myCategoryNames[] = $ctg->name;
			$myCategorySlugs[] = $ctg->slug;
?>
					<li>
						<span class="sans"><a href="<?php echo esc_url(get_category_link($ctg->cat_ID)); ?>"><?php echo $ctg->cat_name; ?></a></span>
					</li>
<?php endforeach; ?>
				</ul>
			</div>

			<?php if (in_array('Izdano', $myCategoryNames)) :?>
			<?php /* 
					HAS THUMBNAIL 
				 */
			?>
			<?php if (has_post_thumbnail($post->ID)) : ?>
			<?php $thumbnailURL = wp_get_attachment_url(get_post_thumbnail_id($post->ID)); ?>
			<?php $thumbnailMeta =  wp_get_attachment_metadata(get_post_thumbnail_id($post->ID)); ?>
			<?php $thumbnailIsPortrait = ($thumbnailMeta['height'] > $thumbnailMeta['width'] ? 1 : 0); ?>
			<?php $featuredClasses = ($thumbnailIsPortrait ? 'featuredPortrait' : 'featuredLandscape'); ?>
			<?php if ($thumbnailIsPortrait) : ?>
			<div class="full-full-width-not large-top-padding-not flex" style="align-items: flex-end">
				<h1 class="<?php echo $titleSize; ?> border-box leading-tight bold display-font" style=""><?php the_title(); ?></h1>
				<div id="authorPhotoSidebar" class="center myFeaturedImage <?php echo /*($thumbnailIsPortrait ? 'portraitContainer full-vh' : 'landscapeContainer ')*/ 'portraitContainer full-vh-not three-four-vh'; //čačke rabijo v bistvu vedno zgolj višino ekrana, sicer so prevelike ?>"
					style="background-image: url(<?php echo $thumbnailURL; ?>); background-position: <?php echo $myBackgroundPosition; ?>; background-size: contain; background-position: right bottom">
					<!--<h1 class="<?php echo $titleSize; ?> leading-tight bold display-font" style=""><?php the_title(); ?></h1>-->
					<p class="no-indent sans font-size-0" id="authorPhotoDesc" style="text-align: right"><?php echo get_post_meta(get_post_thumbnail_id($post->ID), '_wp_attachment_image_alt', true);  ?></p>
				</div>
			</div>
			<?php else : ?>
			<div class="full-full-width-not large-top-padding-not">
				<h1 class="<?php echo $titleSize; ?> border-box leading-tight bold display-font" style=""><?php the_title(); ?></h1>
				<div id="authorPhotoSidebar" class="center myFeaturedImage <?php echo /*($thumbnailIsPortrait ? 'portraitContainer full-vh' : 'landscapeContainer ')*/ 'portraitContainer full-vh-not three-four-vh'; //čačke rabijo v bistvu vedno zgolj višino ekrana, sicer so prevelike ?>"
					style="background-image: url(<?php echo $thumbnailURL; ?>); background-position: <?php echo $myBackgroundPosition; ?>">
					<!--<h1 class="<?php echo $titleSize; ?> leading-tight bold display-font" style=""><?php the_title(); ?></h1>-->
					<p class="no-indent sans font-size-0" id="authorPhotoDesc" style="text-align: right"><?php echo get_post_meta(get_post_thumbnail_id($post->ID), '_wp_attachment_image_alt', true);  ?></p>
				</div>
			</div>
			<?php endif; ?>
			<div>
				<?php if (isset($mySubtitle)) : ?>
				<h2 class="sans font-size-2  center small-top-margin bold " style="border-top: 1px solid; padding-top: 0.5em"><?php echo get_post_meta($post->ID, 'mysubtitle', true) ?></h2>
				<?php endif; ?>
				<?php if (isset($contributorName) and !(empty($contributorName))) : ?>
				<?php //$authorPage = get_page_by_title($contributorName, OBJECT, 'Avtor'); ?>
				<h3 class="font-size-3 serif center" id="articleContributor"><?php echo $contributorName; ?></h3>
				<!--<div class="one-eight center circle center-margins" style="margin-bottom: 2em">
					<div class="cover ratio-1-1" style="background-image: url(<?php //$xthumb = wp_get_attachment_image_src(get_post_thumbnail_id($authorPage->ID), 'myAuthorThumbnail'); echo $xthumb[0] ?>)"></div>
				</div>-->
<?php 	endif; ?>
			<?php else : ?>
<?php
	$words = str_word_count(strip_tags(get_the_title($post->ID)));
	$titleSize = 'font-size-8';
	if ($words > 10) {
		$titleSize = 'font-size-7';
	} elseif ($words <= 20) {
	} elseif ($words <= 40) {
	} else {
	}
?>



			<div id="article-title">
				<h1 class="<?php echo $titleSize; ?> leading-tight bold display-font" style=""><?php the_title(); ?></h1>
				<?php if (isset($mySubtitle)) : ?>
				<h2 class="sans font-size-2 gray small-top-margin light inline-block two-three center-margins" style="border-top: 1px solid; padding-top: 0.5em"><?php echo get_post_meta($post->ID, 'mysubtitle', true) ?></h2>
				<?php endif; ?>
				<?php if (isset($contributorName) and !(empty($contributorName))) : ?>
				<h3 class="font-size-3 serif" id="articleContributor"><?php echo $contributorName; ?></h3>
				<?php 	endif; ?>
			</div>

			<?php endif;  //if thumbnail ?>
			</div>
			<?php endif; //if given category ?>


			<div id="articleTags" class="one-two center center-margins light sans bare-links font-size-1" style="">
<?php newlit_show_tags() ?>
			</div>
<?php 
			if (
				in_array('Kritika, komentar', $myCategoryNames) || in_array('Trampolin', $myCategoryNames) || in_array('Robni zapisi', $myCategoryNames) &&
				(0 == count(array_intersect(array('Na torišču', 'Odziv', 'Poročilo'), $myCategoryNames)))
			) :
?>
			<?php if (has_post_thumbnail($post->ID)) : ?>
			<?php $thumbnailURL = wp_get_attachment_url(get_post_thumbnail_id($post->ID)); ?>
			<?php $thumbnailMeta =  wp_get_attachment_metadata(get_post_thumbnail_id($post->ID)); ?>
			<?php $thumbnailIsPortrait = ($thumbnailMeta['height'] > $thumbnailMeta['width'] ? 1 : 0); ?>
			<div id="myFeaturedImage" class="one-five float">
				<div class="hasMargins relative">
					<a class="bare blockLink" href="<?php echo $thumbnailURL; ?>" title="<?php the_title_attribute(); ?>" >
						<?php the_post_thumbnail('medium', array('class' => 'featuredImg fit', 'alt' => trim(strip_tags(get_post_meta(get_post_thumbnail_id($post->ID), '_wp_attachment_image_alt', true))))); ?>
					</a>
					<!--<p class="no-indent sans font-size-1" id="authorPhotoDesc" style="text-align: right"><?php echo get_post_meta(get_post_thumbnail_id($post->ID), '_wp_attachment_image_alt', true);  ?></p>-->
				</div>
			</div>
			<?php endif; ?>
			<?php endif; ?>
			<div class="content serif">
				<div id="main-article-text" class="font-size-2 sans light">
					<div class="main-article-text-body">
					<?php
						if (in_array('Poezija', $myCategoryNames)) :
							$myContent = get_the_content();
							$myContent = apply_filters('the_content', $myContent);

							if (strpos($myContent, 'class="prose-poem"') === false) {
								$search = array("/<p>/", "/<br[ \/]*>/", "/<\/p>/");
								$replace = array("<p><span class='verse'>", "</span>$0<span class='verse'>", "</span></p>");
								$myContent = preg_replace($search, $replace, $myContent);
							}
							echo $myContent;
						else :		
							the_content();
						endif;
					?>
					</div>
				</div>
				<div id="bottom-addthis-toolbox" class="medium-top-margin x-large-bottom-margin bare-links addthis_sharing_toolbox center"></div>
<?php
global $wp_query;

$args = array(
	'post_status' => 'publish',
	'post_type' => 'avtor',
	//'posts_per_page' => 1,
	'tax_query' => array(
		array(
			'taxonomy' => 'ime_avtorja',
			'field' => 'slug',
			'terms' => $contributorSlug
		)
	)
);
$thisAuthor = get_posts($args);
if ($thisAuthor) :
	global $newlitTempCustomLength;
	$newlitTempCustomLength = 50;;
	foreach ($thisAuthor as $post) : setup_postdata($post); $term = wp_get_post_terms($post->ID, "ime_avtorja"); 
?>
					<div class="authorDetailsArticle two-three center-margins clearfix sans font-size-1" style="">
						<!--<h5 class="font-size-2">Avtor</h5>-->
						<?php if (has_post_thumbnail($post->ID)) : ?>
						<div class="this-author-photo one-four center circle center-margins" style="margin-bottom: 2em">
							<div class="cover ratio-1-1" style="background-image: url(<?php $xthumb = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), 'myAuthorThumbnail'); echo $xthumb[0] ?>)"></div>
						</div>
						<?php endif; ?>
						<div class="">
							<p class="no-indent block-para"><b><a title="<?php the_title(); ?>" href="<?php the_permalink(); ?>">O avtorju.</a></b> <?php echo get_the_excerpt(); ?></p>
						</div>
						<?php $authorsArticles = _thisAuthorsWorks('post', 3, $term[0]->slug); ?>
						<?php if (!empty($authorsArticles)) : ?>
						<?php $myPostCount = count($authorsArticles); ?>
						<div>
							<h6 class="widgettitle font-size-1 center">Avtorjevi <?php echo ($myPostCount >= $num ? "novejši" : ""); ?> prispevki</h6>
							<ul class="center-margins bare-list two-three margin-after-item">
							<?php foreach ($authorsArticles as $post) : setup_postdata($post) ?>
	<?php
	$myCatList = array();
	$category = get_the_category();
	foreach ($category as $ctg) :
		if (($ctg->name == "izpostavljeno") or
			($ctg->name == "novo")) {
				continue;
		}
		$myCatList[] = $ctg->name;
	endforeach;
	?>
								<li class="">
									<div class="myPostItem center">
										<p class="related-title no-indent font-size-1 bold serif">
											<a href="<?php the_permalink() ?>" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a>
										</p>
										<p class="tiny-top-margin recentCatList gray no-indent"><?php echo $myCatList[0]; ?></p>
									</div>
								</li>
							<?php endforeach; ?>
							</ul>
						</div>
						<?php endif; ?>
						<?php wp_reset_postdata(); ?>
					</div>
<?php endforeach; ?>
<?php endif; ?>
				</div>
				<div class="large-bottom-margin myComments section font-size-1" style="">
					<div class="text-inner">
						<h5 class="commentsTitle font-size-2">Pogovor o tekstu</h5>
		


				<?php comments_template(); ?> 



<!--
		<div id="disqus_thread"></div>
<script type="text/javascript">
    /* * * CONFIGURATION VARIABLES * * */
    var disqus_shortname = 'ludliteratura';
    
    /* * * DON'T EDIT BELOW THIS LINE * * */
    (function() {
        var dsq = document.createElement('script'); dsq.type = 'text/javascript'; dsq.async = true;
        dsq.src = '//' + disqus_shortname + '.disqus.com/embed.js';
        (document.getElementsByTagName('head')[0] || document.getElementsByTagName('body')[0]).appendChild(dsq);
    })();
</script>
<noscript>Please enable JavaScript to view the <a href="https://disqus.com/?ref_noscript" rel="nofollow">comments powered by Disqus.</a></noscript>

-->


					</div>
				</div>
				<?php $myRelatedPosts = _newlit_related_posts(3, 'post', $thisPostID);  ?>
				<?php if ($myRelatedPosts->have_posts()) : ?>
				<div class="light-blue-background stretch-full-width large-top-padding large-bottom-padding myMainPosts section font-size-1">
					<h5 class="font-size-2 sans">Sorodni prispevki</h5>
					<ul class=" relatedArticlesList true-liquid-block-outer"><!--
					<?php while ($myRelatedPosts->have_posts()) : $myRelatedPosts->the_post(); ?>
						--><li class=" myPostItem myPostListItem true-liquid-block-inner one-three" style="">
							<div class="paddedText ">
								<div class="center bare-links font-size-1 no-indent article-data article-data-author article-data-title">
									<p class="light leading-tight article-data-item sans font-size-3"><a href="<?php the_permalink() ?>" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a></p>
	<?php
	$contributor = wp_get_post_terms($post->ID, "ime_avtorja", array("count" => 1));
	$contributorName = $contributor[0]->name;
	if (isset($contributorName) and !(empty($contributorName))) :
	?>
									<p class="tiny-top-margin center article-data-item contributorName uppercase font-size-1"><?php echo $contributorName; ?></p>
	<?php endif; ?>
								</div>
								<p class="center no-indent gray-3 article-data myPostMeta article-data-item article-data-metadata sans">
	<?php $category = get_the_category(); ?>
									(<span class="article-data-item article-data-categories"><?php echo $category[0]->cat_name; ?></span>, 
									<span class="xxxnoun-project xxxtimer fa fa-clock-o">&nbsp;<?php echo app_reading_time(); ?></span>)
								</p>
								<div class="theExcerpt large-top-margin "><?php $newlitTempCustomLength = 25; $excerpt_show_more = false; the_excerpt(); $newlitTempCustomLength = 0; $excerpt_show_more = true; ?></div>
							</div>
						</li><!--
					<?php endwhile; ?>
					--></ul>
				</div>
				<?php endif; ?>
<?php endwhile; else: ?>
<?php endif; ?>
			</div>
		</div>
	</div>
<?php get_footer(); ?>
