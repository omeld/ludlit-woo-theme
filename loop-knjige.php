<!-- loop-knjige.php -->
<?php

/*
use for: 
	taxonomy archive (zbirka, book_cat)
	post_type archive (FIXME: don't use page, use archive-template
 */

global $post;
//global $newlitTempCustomLength;
global $myNumberOfPosts;
//global $excerpt_show_more;
$myNumberOfPosts = 30;

$paged = get_query_var('paged');

?>

<?php 	if (is_page('knjige')) : /* TODO FIXME to bi moralo biti cpt archive */ ?>
<?php 		if ($paged > 1) : ?>
<?php 		else : ?>

<?php


// 2 featured titles

$args = array(
	'post_status' => 'publish',
	'posts_per_page' => 2,
	'post_type' => 'knjiga',
	'tag' => 'izpostavljeno',
	'meta_key' => 'izid',
	'orderby' => array('meta_value_num' => 'DESC', 'date' => 'DESC'),
	'order' => 'DESC'
);

$featuredBooks = new WP_Query($args);

if ($featuredBooks->have_posts()) :
?>
<div id="featuredBooksContainer" class="oneArticle stretch-full-width gray-background clearfix top-padding bottom-padding">
	<div class="">
		<div class="articleText clearfix text-outer" style="">
			<ul id="featuredBooks" class="true-liquid-block-outer leading-medium"><!--
<?php while ($featuredBooks->have_posts()) : $featuredBooks->the_post(); ?>
<?php
$author = wp_get_post_terms($post->ID, "ime_avtorja", array('count' => 1));
$translator = wp_get_post_terms($post->ID, "prevajalec");
$translatorName = $translator[0]->name;
$translatorName = implode(', ', array_map(create_function('$r', 'return $r->name;'), $translator));
$authorName = $author[0]->name;
$bookCategory = wp_get_post_terms($post->ID, 'book_cat', array('parent' => 0, 'fields' => 'names'));
$itemSize = 'one-two';
$fontSize = 'font-size-2';
?>
				--><li class="true-liquid-block-inner verticalMiddle <?php echo $itemSize ?>">
					<div class="true-liquid-block-outer">
						<div class="true-liquid-block-inner one-two verticalMiddle">
<?php
$img_id = get_post_thumbnail_id($post->ID);
$alt_text = get_post_meta($img_id , '_wp_attachment_image_alt', true);
if (has_post_thumbnail()) : ?>
							<a class="bare" href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>" ><?php the_post_thumbnail('medium', array('class' => $myAddClass, 'alt' => $alt_text)); ?></a>
<?php 	endif; ?>
						</div><!--
						--><div class="true-liquid-block-inner one-two verticalMiddle">
							<div id="article-title">
								<h1 class="font-size-3 thin leading-display"><?php the_title(); ?></h1>
								<h2 class="font-size-1 bold red" id=""><?php echo $authorName; ?></h2>
<?php if (!empty($translator)) { echo "<h3 class=\"font-size-1 translator\" >(prevod: $translatorName)</h3>"; }?>
								<h3 class="font-size-1 normal italic"><?php echo get_post_meta($post->ID, 'Zbirka', true) ?> (<?php echo get_post_meta($post->ID, 'izid', true); ?>) &bull; <?php echo implode(', ', $bookCategory); ?></h3>
							</div>
							<div class="someMeta">
<?php newlitDisplayPrizeMeta($this_post_master_id, 0); ?>
							</div>
							<div class="hasTopMargin excerpt sans leading-medium clearfix font-size-1">
<?php $newlitTempCustomLength = 25; the_excerpt(); $newlitTempCustomLength = 0;?>
							</div>
						</div>
					</div>
<?php

$args = array(
	'post_status' => 'publish',
	'post_type' => 'avtor',
	'posts_per_page' => 1,
	'tax_query' => array(
		array(
			'taxonomy' => 'ime_avtorja',
			'field' => 'slug',
			'terms' => $author[0]->slug
		)
	)
);
//$thisAuthor = new WP_Query($args);
//if ($thisAuthor->have_posts()) :
if (false) :
	$newlitTempCustomLength = 25;;
	while ($thisAuthor->have_posts()) : $thisAuthor->the_post();
?>
					<div class="authorDetailsArticle clearfix serif italic gray font-size-1" style="border-top: 1px solid #808079; padding-top: 1em">
<?php if (has_post_thumbnail($post->ID)) : ?>
<!--
						<div class="float hasRightMargin one-four">
							<a class="bare-links" title="<?php echo $author[0]->name;?>" href="<?php echo get_bloginfo('url'); ?>/avtor/<?php echo $author[0]->slug;?>/">
<?php			the_post_thumbnail('myAuthorThumbnail', array('class' => "attachment-myAuthorThumbnail roundBorders", 'alt' => trim(strip_tags(get_post_meta(get_post_thumbnail_id($post->ID), '_wp_attachment_image_alt', true))))); ?>
							</a>
						</div>
<?php endif; ?>
-->
						<div class="">
						<p><b><a title="<?php echo $author[0]->name;?>" href="<?php echo get_bloginfo('url'); ?>/avtor/<?php echo $author[0]->slug;?>/">O avtorju.</a></b> <?php echo get_the_excerpt(); ?></p>
						</div>
					</div>
<?php
		//thisAuthorsWorks('Knjige','knjiga', -1, $authorSlug);
		//thisAuthorsWorks('Avtorjevi novejši prispevki', 'post', 6, $authorSlug, 0);
	endwhile;
	wp_reset_postdata();
endif;
?>
				</li><!--
<?php endwhile; ?>
			--></ul>
		</div>
	</div>
</div>
<?php endif; ?>
<?php require('book-tax-ribbons.php'); ?>
<div class="oneArticle section " id="seriesDescriptionParagraph">
	<div class="articleText clearfix text-outer " style="">
		<div class="  text-inner font-size-2 serif " style="margin-left: 0">
			<span>LUD Literatura izdaja štiri knjižne zbirke. </span>
<ul id="bookSeriesShortDesc" style="display: inline">
<li><strong>Prišleki</strong> prinašajo najnovejše v izvirni slovenski prozi in 
poeziji. Izdaje sledijo živemu toku slovenske ustvarjalnosti in ji določajo nove smernice, med drugim s knjižnimi 
prvenci. </li>
<li><strong>Stopinje</strong> so namenjene izdajanju prevodnih  
knjig kratke proze. V zbirki izhajajo dela tistih svetovnih 
avtorjev, ki so temeljno pripomogli k razvoju te literarne vrste. </li>
<li><strong>Novi pristopi</strong> so namenjeni izvirni slovenski esejistiki, literarni kritiki 
in teoriji ter filozofiji umetnosti, </li>
<li><strong>Labirinti</strong> pa so namenjeni 
prevodni esejistiki, literarni teoriji, estetiki in filozofiji umetnosti.</li>
</ul>
		</div>
	</div>
</div>
<?php endif; /* paged < 2 */ ?>
<?php

// other recent titles

$myIterator = 0;
$args = array(
	'post_status' => 'publish',
	'posts_per_page' => $myNumberOfPosts,
	'paged' => get_query_var('paged'),
	'post_type' => 'knjiga',
	'meta_key' => 'izid',
	//'orderby' => 'meta_value_num',
	'orderby' => array('meta_value_num' => 'DESC', 'date' => 'DESC'),
	'order' => 'DESC'
);
?>

<?php 
	/* endif is_page('knjige') */ 
	elseif (is_tax(array('zbirka', 'book_cat'))) :
?>
<?php 
		
/*

taxonomy zbirka/book_cat
========================

*/
//$series = 'prisleki';

$queryTax =  $wp_query->query_vars['taxonomy'];
$queryTerm = get_term_by('slug', $wp_query->query_vars['term'], $wp_query->query_vars['taxonomy']);

?>
<?php if (is_tax('zbirka') && ($paged < 2)) : ?>

<div class="mobile-override oneArticle section fullw light-blue-background gray-5 ">
	<div class="articleText clearfix text-outer " style="">
		<div class="series-description  text-inner font-size-2 serif " style="margin-left: 0">
<?php
if ($wp_query->query_vars['term'] == "prisleki") {
?>
<p>Prve knjižne izdaje v zbirki Prišleki so na police prišle leta 1996, od leta 2002 (od takrat do leta 2007 jo je urejal Urban Vovk) pa zbirka deluje s polno paro. Med letoma 2008 in 2012 so zbirko sourejali Goran Dekleva, Andrej Hočevar in Petra Koršič. V njej je doslej izšlo že čez 50 naslovov, prinaša pa najnovejše v izvirni slovenski prozi in poeziji. Njene izdaje sledijo živemu toku slovenske ustvarjalnosti, vendar so pogosto prav one tiste, ki ji določajo nove smernice. Poleg tega, da zbirka Prišleki išče nova imena in objavlja knjižne prvence, je med njenimi avtorji tudi veliko priznanih in nagrajevanih imen.<br>Ureja: <a href="<?php echo antispambot("mailto:andrej.hocevar@ludliteratura.si"); ?>"><b>Andrej Hočevar</b></a></p>
<?php
} else if ($wp_query->query_vars['term'] == "stopinje") {
?>
<p>Knjižna zbirka Stopinje izhaja od leta 2007 in je namenjena izdajanju
prevodnih avtorskih knjig kratke proze, bodisi prevajanju zaključenih
zbirk bodisi izboru kratkoproznih besedil nekega avtorja. V zbirki
izhajajo dela tistih svetovnih avtorjev, ki so temeljno pripomogli
k razvoju te literarne vrste oziroma jo zaznamovali tako na nacionalni
kot na mednarodni ravni. Gre torej za »klasike« kratke proze, pri čemer
se njihov izbor ne osredotoča le na sodobno produkcijo, temveč skuša
pokriti tudi morebitne prevodne vrzeli v preteklosti.<br>Urejata: <a href="<?php echo antispambot("mailto:gaja.kos@ludliteratura.si"); ?>"><b>Gaja Kos</b></a><br><a href="<?php echo antispambot("mailto:tina.kozin@ludliteratura.si"); ?>"><b>Tina Kozin</b></a></p>
<?php
} else if ($wp_query->query_vars['term'] == "novi-pristopi") {
?>
<p>Knjižna zbirka Novi pristopi izhaja od leta 1990. Namenjena je izvirni slovenski esejistiki, literarni kritiki in teoriji ter filozofiji umetnosti. Doslej je v zbirki izšlo več knjig, ki so jih napisali avtorji različnih generacij, literarnoteoretskih smeri, predmetnih področij in interesnih usmeritev: od strogih znanstvenih monografij, polemičnih razprav in literarnokritiških izborov pa do literarnih esejev v pravem pomenu besede. Nekatere izmed knjig, ki so izšle v Novih pristopih, so dobile najvišje nacionalne nagrade ali pa so bile zanje nominirane (bodisi za področje esejistike bodisi za področje znanosti oziroma humanistike).<br>Ureja: <a href="<?php echo antispambot("mailto:matevz.kos@ludliteratura.si"); ?>"><b>Matevž Kos</b></a></p>
<?php
} else if ($wp_query->query_vars['term'] == "labirinti") {
?>
<p>Knjižna zbirka Labirinti izhaja od leta 1995. Namenjena je prevodni esejistiki, literarni teoriji, estetiki in filozofiji umetnosti. Doslej je v zbirki izšlo več knjig najrazličnejših avtorjev iz različnih jezikovnih okolij, po večini gre za »moderne klasike« humanistične misli 20. stoletja. Dela, ki izhajajo v zbirki, so praviloma prevajalsko in strokovna zahtevna: prevajajo jih najvidnejši slovenski prevajalci, večina del je opremljena z znanstvenim aparatom in s spremnimi besedami slovenskih poznavalcev.<br>Ureja: <a href="<?php echo antispambot("mailto:matevz.kos@ludliteratura.si"); ?>"><b>Matevž Kos</b></a></p>
<?php
}
?>
		</div>
	</div>
</div>
<?php elseif (is_tax('book_cat') && ($paged < 2)) : ?>
<div class="mobile-override book-genre gray-background-4 reverse font-size-2 fullw">
	<div class="text-outer minimal-padding">
		<p class="one-two">Knjige po zvrsti: <?php echo $queryTerm->name; ?></p>
	</div>
</div>
<?php endif; ?>

<?php




/*
if ($queryTax == "zbirka" and isset($queryTerm)) {
	$series = $queryTerm;
}
 */

$args = array_merge(
	//$wp_query->query,
	array(
		'posts_per_page' => $myNumberOfPosts,
		'posts_per_archive_page' => $myNumberOfPosts,
		'paged' => get_query_var('paged'),
		'post_status' => 'publish',
		'post_type' => 'knjiga',
		'meta_key' => 'izid',
		//'orderby' => 'meta_value_num',
		'orderby' => array('meta_value_num' => 'DESC', 'date' => 'DESC'),
		'order' => 'DESC',
		'tax_query' => array(
			array(
				'taxonomy' => $queryTax,
				'field' => 'slug',
				'terms' => $queryTerm->slug
			)
		)
	)
);

?>
<?php endif; /* is_tax() */ ?>

<?php
$books = new WP_Query($args);

if ($books->have_posts()) :
?>
<div class="oneArticle section">
	<div class="">
		<div class=" clearfix " style="padding-top: 0">
			<ul id="recentBooks" class="true-liquid-block-outer leading-medium"><!--
<?php while ($books->have_posts()) : $books->the_post(); $myIterator++; ?>
<?php
$author = wp_get_post_terms($post->ID, "ime_avtorja", array('count' => 1));
$translator = wp_get_post_terms($post->ID, "prevajalec", array('count' => 1));
$translatorName = $translator[0]->name;
$authorName = $author[0]->name;
$bookCategory = wp_get_post_terms($post->ID, 'book_cat', array('parent' => 0, 'fields' => 'names'));
if ($myIterator <= 6) {
	$itemSize = 'one-six';
	$fontSize = 'font-size-1';
} else {
	$itemSize = 'one-six';
	$fontSize = 'font-size-1';
} 
?>
				--><li class="clearfix true-liquid-block-inner <?php echo $itemSize ?>">
					<div class="myPostItem">
<?php
$img_id = get_post_thumbnail_id($post->ID);
$alt_text = get_post_meta($img_id , '_wp_attachment_image_alt', true);
?>
						<a class="bare blockLink tiny-bottom-margin" href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
<?php 
// tudi če ni fotke, hočemo, da se polja poravnajo …
if (has_post_thumbnail()) :
	the_post_thumbnail('myTwoColImage', array('class' => $myAddClass, 'alt' => $alt_text));
endif; 
?>
						</a>
						<div class="bookInfo">
							<h3 class="sans bold <?php echo $fontSize; ?>"><a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"><?php echo get_the_title(); ?></a></h3>
							<h4 class="serif bold italic <?php echo $fontSize; ?>"><a href="<?php echo home_url('/avtor/' . $author[0]->slug . '/'); ?>"><?php echo $author[0]->name; ?></a></h4>
							<h4 class="tiny-bottom-margin normal sans gray <?php echo $fontSize; ?>"><?php echo get_post_meta($post->ID, 'Zbirka', true) ?> (<?php echo get_post_meta($post->ID, 'izid', true); ?>) &bull; <?php echo implode(', ', $bookCategory); ?></h4>
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

<div class="clearfix  small-top-padding small-bottom-padding" id="myPagination">
<?php
echo paginate_links(
	array(
		'prev_text' => '&larr; Novejše',
		'next_text' => 'Starejše &rarr;',
		'base' => get_pagenum_link() . '%_%',
		'format' => '?paged=%#%',
		//'current' => max(1, get_query_var('paged')), //$paged!?
		'current' => $paged,
		'show_all' => true,
		'total' => $books->max_num_pages
	)
);
#wp_reset_postdata();
?>
</div>


<?php endif; ?>
