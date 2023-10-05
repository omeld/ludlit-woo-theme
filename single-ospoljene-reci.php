<?php get_header('home'); ?>
<script type="text/javascript">
$(document).ready(function() {
	//only once, on load
	var hash = window.location.hash;
	switch(hash){
    	case '#dialog':
			$(".one-tab").toggleClass("selected");
			changeTabs();
	        break;
	}
	/* TODO */
	
	function changeTabs() {
		$(".tab-entry").each(function(i) {
			if ($(this).is('.show')) {
				$(this).animate({opacity: 0}, 500, function() {
					$(this).css({display: 'none'}).toggleClass("hide show");
				});
			} else {
				$(this).css({display: 'block'}).animate({opacity: 1}, 500, function() {
					$(this).toggleClass("hide show");
				});
			}
		});
	}
	$(".one-tab").click(function(event) {
		//event.stopPropagation();
		//event.stopImmediatePropagation();
		
		if ($(this).is(".selected")) {
			return 0;
		}

		$(".one-tab").toggleClass("selected");
		changeTabs();

	})
});

</script>

<style type="text/css">

.one-tab {
	bottom: -1px;
	padding: 0.5em;
	position: relative;
	border-radius: 3px 3px 0 0;
	margin: 0 1em;
	border: 1px solid;
	border-bottom: none;
	cursor: pointer;
}

.one-tab.selected {
	border-bottom: 1px solid white;
	background-color: white;
}

.one-author {
	position: relative;
	flex-wrap: nowrap;
}
.one-author span {
	white-space: nowrap;
}
.one-author.other-author:before {
	content: '';
	position: absolute;
	width: 100%;
	height: 100%;
	border-radius: 999em 0 0 999em;
	background-color: rgba(255,255,255,0.67);
	transition: background-color 0.5s;
}
.one-author.other-author {
	filter: grayscale();
	transition: filter 0.5s;
}
.other-author.publish:hover:before, .other-author.publish:hover {
	background-color: initial;
	filter: none;
}

.authors a {
	display: inline-flex;
	align-items: center;
}

.authors {
	flex-wrap: wrap;
}

@media only screen and (max-width: 600px) {
	.authors.flex {
		display: flex;
	}
	.category-description {
		width: 100% !important;
	}
	h1 {
		width: 100% !important;
	}
	.gendered .flex > .one-two {
		width: 100% !important;
		margin-bottom: 1em;
	}
	.gendered .this-author-photo-not {
		width: 25% !important;
	}
}



</style>
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
<!-- ospoljene reči --!>
<?php 
global	$post,
   		$wp_query,	
		$thisPostID,
		$newlitTempCustomLength,
		$excerpt_show_more;

$thisPostID = $post->ID;
$contributor = wp_get_post_terms($post->ID, "ime_avtorja");

//$contributorName = implode(', ', array_map(create_function('$r', 'return $r->name;'), $contributor));
//$contributorSlug = array_map(create_function('$r', 'return $r->slug;'), $contributor);
$contributorName = implode(', ', array_map(fn($r) => $r->name, $contributor));
$contributorSlug = array_map(fn($r) => $r->slug, $contributor);

//$contributorName = $contributor[0]->name;
//$contributorSlug = $contributor[0]->slug;

$mySubtitle = get_post_meta($post->ID, 'mysubtitle', true);
//$myBackgroundPosition = "center";
//$myBackgroundPosition = get_post_meta($post->ID, 'background-position', true);

$myGenderedAuthor['quote'] = get_post_meta($post->ID, 'gendered-author-quote', true);
$myGenderedCounterpart['name'] = get_post_meta($post->ID, 'gendered-counterpart-name', true);
$myGenderedCounterpart['quote'] = get_post_meta($post->ID, 'gendered-counterpart-quote', true);

$paged = get_query_var('paged');


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
$thisAuthor = new WP_Query($args);

$xthumb = wp_get_attachment_image_src(
	get_post_thumbnail_id($thisAuthor->posts[0]->ID),
	'myAuthorThumbnail'
);

$thisCounterpart = new WP_Query(array(
	//'title' => $myGenderedCounterpart['name'], // novejša verzija
	'tax_query' => array(
		array(
			'taxonomy' => 'ime_avtorja',
			'field' => 'name',
			'terms' => $myGenderedCounterpart['name']
		)
	),
	'status' => 'publish',
	'post_type' => 'avtor',
	'posts_per_page' => 1
));

if (!empty($thisCounterpart)) {
	$counterpartThumb = wp_get_attachment_image_src(
		get_post_thumbnail_id($thisCounterpart->posts[0]->ID),
		'myAuthorThumbnail'
	);
}


?>
<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
<?php
	$words = str_word_count(strip_tags(get_the_title($post->ID)));
	$titleSize = 'font-size-5';
	if ($words > 10) {
		$titleSize = 'font-size-4';
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

			<?php if (in_array('Ospoljene reči', $myCategoryNames)) :?>
			<div class="stretch-full-width gray-background x-large-top-padding x-large-bottom-padding">
				<h1 class="<?php echo $titleSize; ?> two-three leading-tight bold display-font" style=""><?php the_title(); ?></h1>
				<?php if (!empty($mySubtitle)) : ?>
				<h2 class="sans font-size-2  center-not small-top-margin bold " style="border-top: 1px solid; padding-top: 0.5em"><?php echo get_post_meta($post->ID, 'mysubtitle', true) ?></h2>
				<?php endif; ?>
				<?php if (isset($contributorName) and !(empty($contributorName))) : ?>
				<?php //$authorPage = get_page_by_title($contributorName, OBJECT, 'Avtor'); ?>
				<h3 class="font-size-2 serif " id="articleContributor"><?php echo $contributorName; ?></h3>


				<div class="category-description sans center-margins-not x-large-top-margin light-not font-size-1 one-two gray-4">
					<p class="bold-not">Dialoški eseji, ki se šele&nbsp;sproti&nbsp;porajajo, so priložnostni odgovor na&nbsp;aktualna prepletanja ospoljenih življenjskih praks, njihovih izzivajočih spontanih tematizacij in&nbsp;teoretskih nadgrajevanj. Sogovorniki_ce: Alja Adam, Martin Gramc, Jedrt Lapuh Maležič, Carlos Pascual, Barbara Korun.</p>
					<div class="show-on-request hide">
						<p>Živeto in&nbsp;mišljeno&nbsp;bo na&nbsp;spodbudne načine združeno. Poleg esejističnih zapisov v&nbsp;dopisovanju bomo na&nbsp;nekaterih platformah za&nbsp;informacijsko-komunikacijsko tehnologijo (spletne klepetalnice in&nbsp;sporočila, esemesi, elektronska pošta) od neformalne<span class="Apple-converted-space">&nbsp;</span>komunikacije prešle_i na&nbsp;raven blago formalizirane diskusije. Esejistični izmenjavi videnj, mnenj, znanja in&nbsp;izkušenj bo tako sledilo demokratično usklajevanje, pomiritev ali, nasprotno, eskalacija nasprotij. Delujemo, tj. dopisujemo si v&nbsp;petih sogovorništvih, v&nbsp;zaključku udeležene_i načrtujemo skupno virtualno okroglo mizo.</p>
						<p>Odprimo karte s&nbsp;posameznimi temami: z&nbsp;<strong>Aljo Adam</strong> o&nbsp;feminističnih, intelektualnih pogojno t.i. <em>fatalkah</em>, kar se bo zgodilo ob&nbsp;vpadu ruralne, ironično zamišljene miniature <i>femme fatal</i> v&nbsp;izhodiščni tekst. V navezi z&nbsp;<strong>Martinom Gramcem</strong>, politično lezbijko, se bo nadaljevalo neko sprva zasebno soočanje različnih teoretskih perspektiv, ki so jih odprle ali spodbudile politike transspolnosti; pri&nbsp;analizi in&nbsp;razgradnji materinskega mita skozi&nbsp;topiko materinjenja v&nbsp;hetero- in<span class="Apple-converted-space">&nbsp; </span>istospolnem partnerstvu bova sodelovali z&nbsp;<strong>Jedrt Lapuh Maležič</strong>. Naslednji dialog bo potekal s&nbsp;<strong>Carlosom Pascualom</strong>, pri&nbsp;komer&nbsp;bom poizvedovala o&nbsp;oblikah patriarhata in&nbsp;njegovih odklonih od pričakovanih rigidnosti. Z Barbaro Korun si bova izmenjali vpoglede v preplet delovnih sfer, pri njej zlasti pesništva in angažmaja v begunskih skupnostih; za povrh bova izmenjali problematične izkušnje o ospoljenih razmerjih moči na skupnem polju aktivizma oziroma aktivnega državljanstva. – Renata Šribar</p>
					</div>
					<a href="#" class="small-top-margin center-margins show-hide readMoreLink gray-background-3 block one-one center">Daljši opis</a>
				</div>
				<!--<div class="one-eight center circle center-margins" style="margin-bottom: 2em">
					<div class="cover ratio-1-1" style="background-image: url(<?php //$xthumb = wp_get_attachment_image_src(get_post_thumbnail_id($authorPage->ID), 'myAuthorThumbnail'); echo $xthumb[0] ?>)"></div>
				</div>-->
<?php 	endif; ?>
			</div>




<div class="gray-4 gendered x-large-top-margin clearfix x-large-bottom-margin x-large-bottom-padding stretch-full-width " style="border-bottom: 1px solid #eee;">
<div class="flex">
	<div class=" one-two" style="align-self: flex-end;">
		<div class="inline-block this-author-photo-not one-ten center circle center-margins vertical-bottom">
			<div class="cover ratio-1-1" style="background-image: url(<?php echo $xthumb[0]; ?>)"></div>
		</div>
		<div class="gendered-author bubble two-three inline-block gray-background padded medium-left-margin">
			<p><?php echo $myGenderedAuthor['quote'];?><span class="sc"> — <?php echo $contributorName; ?></span></p>
		</div>
	</div>
	<div class=" one-two" style="align-self: flex-end;">
		<div class="gendered-counterpart bubble two-three inline-block gray-background padded medium-right-margin" <?php if (empty($myGenderedCounterpart['quote'])) { echo ' style="color: #eee"'; } ?>>
			<p><?php echo $myGenderedCounterpart['quote'];?><span class="sc"> — <?php echo "$myGenderedCounterpart[name]"; ?></span></p>
		</div>
		<div class="inline-block vertical-bottom this-author-photo-not one-ten center circle center-margins">
			<div class="cover ratio-1-1" style="background-image: url(<?php echo $counterpartThumb[0]; ?>)"></div>
		</div>
	</div>

<?php



			//////////////////////////////



$_args = array(
	'posts_per_page' => -1,
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
);

require('local-array-column.php');
$_myCurrentLoop = new WP_Query($_args);
$authorThumbnailURL = array();
if ($_myCurrentLoop->have_posts()) :
$i = 0;
	foreach($_myCurrentLoop->posts as $myPost) :
		$names = get_the_terms($myPost, 'ime_avtorja');
		if (!in_array($names[0]->name, array_column($authorThumbnailURL, 'name'))) :
			$authorPage = get_page_by_title($names[0]->name, OBJECT, 'Avtor');
			if (!empty($authorPage)) {
				if (has_post_thumbnail($authorPage->ID)) {
					$url = wp_get_attachment_image_src(get_post_thumbnail_id($authorPage->ID), 'myAuthorThumbnail');
					$authorThumbnailURL[$i]['url'] = $url[0];
					$authorThumbnailURL[$i]['name'] = $names[0]->name;
					$authorThumbnailURL[$i]['status'] = $myPost->post_status;
					$authorThumbnailURL[$i]['post_url'] = get_permalink($myPost->ID);
				}
			}
		endif;
		$i++;
	endforeach;
endif;

//echo "<pre style='color:green'>";var_dump($authorThumbnailURL); echo "</pre>";



////////////////////////////////

?>

</div>
	<div class="authors large-top-margin flex" style="">
	<?php foreach ($authorThumbnailURL as $thumb) : ?>
		<?php $whichAuthor = ($thumb['name'] == $contributor[0]->name ? 'current-author' : 'other-author'); ?>
			<?php if (($thumb['status'] == 'publish') && ($whichAuthor != 'current-author')) { 
				echo "<a href='$thumb[pust_url]' class='block-link bare "; 
			} else {
				echo "<div class='";
			}
			echo "one-author small-right-margin small-bottom-margin $whichAuthor $thumb[status] '";
			?>
			style="border-radius: 25px 0 0 25px; background-color: #eee;">
			<div style="width: 50px; display: inline-block; vertical-align: middle">
				<div class="circle">
					<div class="cover ratio-1-1" style="background-image: url(<?php echo $thumb['url'];?>)">
					</div>
				</div>
			</div>
			<span style="padding: 0 1em;"><?php echo $thumb['name']; ?></span>
			<?php if (($thumb['status'] == 'publish') && ($whichAuthor != 'current-author')) { echo "</a>"; } else { echo "</div>"; } ?>
	<?php endforeach; ?>
	</div>
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
				<div id="main-article-text" class="font-size-2 serif">
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
						if (($translator = get_post_meta($post->ID, 'my-translator', true)) != false) {
							echo "<p class='large-top-margin translator align-right bold sans'>Prevod: $translator</p>";
						}
							
					?>
					</div>
				</div>
				<div id="bottom-addthis-toolbox" class="medium-top-margin x-large-bottom-margin bare-links addthis_sharing_toolbox center"></div>
<?php
if ($thisAuthor->have_posts()) :
	$newlitTempCustomLength = 50;;
							//foreach ($thisAuthor as $post) : setup_postdata($post); $term = wp_get_post_terms($post->ID, "ime_avtorja"); 
	while ($thisAuthor->have_posts()) : $thisAuthor->the_post();
?>
					<div class="authorDetailsArticle two-three center-margins clearfix sans font-size-1" style="">
						<!--<h5 class="font-size-2">Avtor</h5>-->
						<?php if (has_post_thumbnail($post->ID)) : ?>
						<div class="this-author-photo one-four center circle center-margins" style="margin-bottom: 2em">
							<div class="cover ratio-1-1" style="background-image: url(<?php echo $xthumb[0] ?>)"></div>
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
<?php endwhile; ?>
<?php endif; ?>
				</div>
<?php include('mailchimp-subscribe.php');?>
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
