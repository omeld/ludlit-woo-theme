<?php get_header('home'); ?>
<?php 
global $post; 
global $newlitTempCustomLength;
global $excerpt_show_more;
$newlitTempCustomLength = 0;


?>

<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
<?php
global $wp_query;
global $thisPostID;
$thisPostID = $post->ID;
$this_post_master_id = $post->ID;
//$useName = get_query_var('name');

$useName = wp_get_post_terms($post->ID, "ime_avtorja");
$authorName = implode(', ', array_map(create_function('$r', 'return $r->name;'), $useName));
$authorSlug = array_map(create_function('$r', 'return $r->slug;'), $useName);

$translator = "";
$translator = wp_get_post_terms($post->ID, "prevajalec");
//$translatorName = $translator[0]->name;
$translatorName = implode(', ', array_map(create_function('$r', 'return $r->name;'), $translator));

//$authorSlug = $useName[0]->slug;
//$authorName = $useName[0]->name;

$bookCategory = wp_get_post_terms($post->ID, 'book_cat', array("fields" => "names"));

$fullBookDescription = apply_filters('the_content',get_the_content());

$ebookAvailable = false;
$ebook = array(
	array(
		'meta' => 'biblos',
		'name' => 'Biblos'
	),
	array(
		'meta' => 'emka',
		'name' => 'e-Emka'
	),
	array(
		'meta' => 'ibooks',
		'name' => 'iTunes'
	),
	array(
		'meta' => 'kobo',
		'name' => 'Kobo'
	)
);

foreach ($ebook as $k => $v) {
	if (($url = get_post_meta($post->ID, 'ebook_' . $v['meta'], true)) != false) {
		$ebook[$k]['url'] = $url;
		$ebookAvailable = true;
	}
}

$buyBook = false;
if (($url = get_post_meta($post->ID, 'my-buy-book-url', true)) != false) {
	$buyBook = $url;
}

$bookPreview = false;
if (($str = get_post_meta($post->ID, 'my-book-preview', true)) != false) {
	$bookPreview = $str;
}



?>
<div class="mobile-override fullw gray-background" id="basicBookDesc">
	<div class="" style="overflow-x: hidden">
		<div class="articleText clearfix text-outer top-padding bottom-padding true-liquid-block-outer sans"><!--
<?php if (has_post_thumbnail($post->ID)) : ?>
			--><div class="true-liquid-block-inner one-two verticalMiddle" style="vertical-align: middle">


			<?php if ($bookPreview != false) : ?>
				<div class="book-preview-badge"><div><?php echo $bookPreview; ?></div></div>
			<?php endif; ?>


				<div id="featured-image" class="">
					<a class="bare" href="<?php echo wp_get_attachment_url(get_post_thumbnail_id($post->ID)); ?>" title="<?php the_title_attribute(); ?>" ><?php the_post_thumbnail('large', array('class' => 'featuredImg fit', 'alt' => trim(strip_tags(get_post_meta(get_post_thumbnail_id($post->ID), '_wp_attachment_image_alt', true))))); ?></a>
				</div>
			</div><!--
<?php endif; ?>
			--><div class="true-liquid-block-inner one-two" style="vertical-align: middle">
				<div class="two-three" style="margin: auto">
					<div id="article-title">
						<h1 class="font-size-5 thin leading-display"><?php the_title(); ?></h1>
						<h2 class="font-size-2 bold red" id=""><?php echo $authorName; ?></h2>
<?php if (!empty($translator)) { echo "<h3 class=\"translator\" >(prevod: $translatorName)</h3>"; }?>
						<h3 class="font-size-1 normal italic"><?php echo get_post_meta($post->ID, 'Zbirka', true) ?> (<?php echo get_post_meta($post->ID, 'izid', true); ?>) &bull; <?php echo implode(', ', $bookCategory); ?></h3>
					</div>


<?php if ($buyBook) : ?>
					<a class="buy-book" href="<?php echo $buyBook ?>">Kupi</a>
<?php endif; ?>


<?php if ($ebookAvailable) : ?>
					<div class="ebook-link medium-top-margin medium-bottom-margin">
						<span class="pill soft-borders show-hide font-size-1 sans" style="color: #EEE">kupi e-knjigo</span>
						<div class="ebook-list hide show-on-request" style="/*display: none; opacity: 0*/">
							<ul class="bare-list inline-list small-top-padding small-bottom-padding">
<?php foreach ($ebook as $_ebook) : if (!(empty($_ebook['url']))) : ?>
								<li><a class="one-ebook-link" href="<?php echo $_ebook['url']; ?>"><?php echo $_ebook['name']; ?></a></li>
<?php endif; endforeach; ?>
							</ul>
						</div>
					</div>
<?php endif; ?>
					<div class="someMeta">
<?php newlitDisplayPrizeMeta($this_post_master_id, 0); ?>
					</div>
					<div class="excerpt gray sans leading-medium clearfix font-size-2">
						<p>
<?php 
$newlitTempCustomLength = 50; 
$excerpt_show_more = ' <a class="readMoreLink sans" href="#o-knjigi">več o knjigi</a>'; 
echo get_the_excerpt(); 
$newlitTempCustomLength = 0; 
$excerpt_show_more = true; ?>
						</p>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<?php
$myQuoteClass = '';
$myQutoeStyle = '';
$extraMargins = '';

$myQuote = get_post_meta($post->ID, 'citat', true);

if (!empty($myQuote)) {
	$words = str_word_count(strip_tags($myQuote));
	if ($words <= 10) {
		$myQuoteClass = 'font-size-8 extra-bold leading-display center reverse'; //red-background reverse
	} elseif ($words <= 20) {
		$myQuoteClass = 'font-size-7 thin leading-tight reverse center'; //red-background reverse
	} elseif ($words <= 40) {
		$myQuoteClass = 'font-size-6 extra-bold italic transparent-background leading-display reverse';
		$extraMargins = 'text-inner';
	} else {
		$myQuoteClass = 'font-size-5 italic transparent-background leading-display reverse';
		$extraMargins = 'text-inner';
	}
?>

<div class="fullw <?php echo $myQuoteClass; ?>" style="margin-bottom: 24px;"
<?php
/*
if (has_post_thumbnail($post->ID)) {
	$mythumb = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), 'large');
	echo " style='background-image: url(" . $mythumb['0'] . "); background-size: cover; background-position: center center'";
}
 */
?>
>
	<div class="some-container">
		<div class="articleText clearfix text-outer">
			<div class="display-font citat <?php echo $extraMargins; ?>">
<?php echo apply_filters('the_content', $myQuote) ?>
			</div>
		</div>
	</div>
</div>
<?php } ?>
<?php 
	$myQuotes = newlitDisplayPressQuoteMeta($this_post_master_id); 
	if (!empty($myQuotes)) :
?>
<div class="oneArticle section">
	<div class="">
		<div class="articleText clearfix text-outer" style="padding-top: 0">
			<div id="press-quotes">
				<h6 class="medium-top-margin sans font-size-2 bold gray"  id="pressQuotes">Iz kritike</h6>
				<ul class="newlitPressQuotesList serif true-liquid-block-outer clearfix font-size-2">
					<!--
<?php foreach ($myQuotes as $myQuote) : ?>
					--><li class="newlitPressQuoteItem true-liquid-block-inner one-three ">
						<p class="newlitPressQuoteItemText "><?php echo $myQuote['text']; ?> 
							<span class="newlitPressQuoteItemSource"><?php echo $myQuote['source']; ?></span>
						</p>
					</li><!--
<?php endforeach; ?>
		-->
				</ul>
			</div>
		</div>
	</div>
</div>
<?php endif; ?>
<?php
$bookDescClass = '';
$bookDescWords = str_word_count(strip_tags($fullBookDescription));
if ($bookDescWords <= 100) {
	$bookDescClass = 'text-inner font-size-2';
} elseif ($bookDescWords <= 350) {
	$bookDescClass = 'text-inner columnar-text font-size-1';
} elseif ($bookDescWords < 500) {
	$bookDescClass = 'columnar-text font-size-1';
} else {
	$bookDescClass = 'text-inner font-size-1';
}
?>

<div class="oneArticle section this-book-description-container" id="o-knjigi">
	<div class="">
		<div class="articleText clearfix text-outer top-padding bottom-padding" style="padding-top: 0">
			<h6 class="medium-top-margin gray sans bold font-size-2">Predstavitev knjige</h6>
			<div class="this-book-description-text clearfix serif  <?php echo $bookDescClass ?>">
<?php echo $fullBookDescription; ?>
			</div>
		</div>
	</div>
</div>

<?php
$args = array(
	'post_status' => 'publish',
	'post_type' => 'avtor',
	'posts_per_page' => -1,
	'tax_query' => array(
		array(
			'taxonomy' => 'ime_avtorja',
			'field' => 'slug',
			'terms' => $authorSlug
		)
	)
);


$thisAuthor = get_posts($args);
//echo "<pre>"; var_dump($args); echo "\n"; var_dump($thisAuthor); echo "</pre>";
if ($thisAuthor) :
	foreach ($thisAuthor as $post) : setup_postdata($post);
	$nameTerm = wp_get_post_terms($post->ID, "ime_avtorja");

?>
<div class="oneArticle section">
	<div class="">
		<div class="articleText clearfix text-outer top-padding bottom-padding">
			<div class="clearfix authorDetailsArticle sans text-inner font-size-1">
				<div class="">
					<h5><a title="<?php echo $nameTerm[0]->name;?>" href="<?php echo get_bloginfo('url'); ?>/avtor/<?php echo $nameTerm[0]->slug;?>/"><?php echo $nameTerm[0]->name; ?></a></h5>
					<div class="float one-four ">
<?php if (has_post_thumbnail($post->ID)) :?>
						<a class="hasRightMargin blockLink bare" title="<?php echo $nameTerm[0]->name;?>" href="<?php echo get_bloginfo('url'); ?>/avtor/<?php echo $nameTerm[0]->slug;?>/">
<?php			the_post_thumbnail('myAuthorThumbnail', array('class' => "attachment-myAuthorThumbnail roundBorders", 'alt' => trim(strip_tags(get_post_meta(get_post_thumbnail_id($post->ID), '_wp_attachment_image_alt', true))))); ?>
						</a>
<?php endif; ?>
					</div>
					<div class="" style="overflow: hidden">
						<div class="hasLeftMargin">
<?php the_content(); ?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<?php endforeach; ?>
<!--
				<div class="one-four float">
<?php //thisAuthorsWorks('Knjige','knjiga', -1, $authorSlug, 1, 1, ''); ?>
				</div>
-->
<?php endif;?>



<?php
$thisAuthorsBooks = _thisAuthorsWorks('knjiga', -1, $authorSlug);
if (!empty($thisAuthorsBooks)) :
?>
<div class="oneArticle section">
	<div class="">
		<div class="articleText clearfix text-outer" style="padding-top: 0">
			<h6 class="medium-top-margin sans font-size-2 bold gray"  id="">Druge avtorjeve knjige</h6>
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
				--><li class="clearfix true-liquid-block-inner <?php echo $itemSize ?>">
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
<?php wp_reset_postdata(); ?>
			--></ul>
		</div>
	</div>
</div>
<?php endif; ?>
<?php
$related_books = newlit_related_post_ids($thisPostID, 5, 'knjiga');
if (!empty($related_books)) :
	$args = array(
		'post__in' => $related_books,
		'post_type' => 'knjiga'
	);
	$related_books_query = new WP_Query($args);
	if ($related_books_query->have_posts()) :
?>
<div class="oneArticle section">
	<div class="">
		<div class="articleText clearfix text-outer" style="padding-top: 0">
			<div id="related_books">
				<h6 class="medium-top-margin sans font-size-2 bold gray"  id="">Sorodne knjige</h6>
				<ul id="titlesByAuthor" class="dynamicBookList true-liquid-block-outer"><!--
<?php while ($related_books_query->have_posts()) : $related_books_query->the_post(); ?>
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
if (has_post_thumbnail()) : ?>
						<a class="bare blockLink" href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>" ><?php the_post_thumbnail('myTwoColImage', array('class' => $myAddClass, 'alt' => $alt_text)); ?></a>
<?php 	endif; ?>
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
<?php endwhile; ?>
				--></ul>
			</div>
		</div>
	</div>
</div>
<?php endif; ?>
<?php endif; ?>
<?php endwhile; ?>
<?php else : ?>
<?php endif; ?>

<!--
<div id="articleSideBar" class="fiveCol float hasLeftMargin">
<div style="margin-top: 12px">
	<?php do_action( 'addthis_widget', get_permalink(), get_the_title(), "fb_tw_p1_sc"); ?>
</div>
-->
<div>
	<?php //myAuthorsRecentPosts(0, 5, $authorSlug, "h5"); ?>
</div>

<?php get_footer(); ?>
