<?php
/*
Template Name: stran za revije(ce zberes revijo iz arhiva)
 */
?>
<?php get_header('home'); ?>
<?php global $post; ?>
<?php global $thisPostID; ?>

<?php //if (have_posts()) : while (have_posts()) : the_post(); ?>
<?php 	//$thisPostID = $post->ID; ?>




<?php
$args = array(
	'post_status' => 'publish',
	'posts_per_page' => 1,
	'post_type' => 'revija',
	'meta_key' => 'newlit-revija-new-stevilka',
	'orderby' => 'meta_value_num',
	'order' => 'DESC'
);
$magazineArticles = get_posts($args);
?>
<?php if ($magazineArticles) : ?>
<?php	foreach ($magazineArticles as $post) : setup_postdata($post); ?>
<?php		$thisPostID = $post->ID; ?>

<?php
	require('naroci-revije.php'); 
?>

<div class="levodesnopadding gray-background">
	<div class="" style="overflow-x: hidden">
		<div class="articleText top-padding bottom-padding clearfix text-outer true-liquid-block-outer sans"><!--
<?php if (has_post_thumbnail($post->ID)) : ?>
			--><div class="true-liquid-block-inner one-three verticalMiddle" style="vertical-align: top">
				<div id="featured-image" class="">
					<a class="bare" href="<?php echo wp_get_attachment_url(get_post_thumbnail_id($post->ID)); ?>" title="<?php the_title_attribute(); ?>" ><?php the_post_thumbnail('large', array('class' => 'featuredImg fit', 'alt' => trim(strip_tags(get_post_meta(get_post_thumbnail_id($post->ID), '_wp_attachment_image_alt', true))))); ?></a>
				</div>
			</div><!--
<?php endif; ?>
			--><div class="true-liquid-block-inner two-three" style="vertical-align: top">
				<div class="" style="">
					<div id="article-title">
						<h1 class="font-size-5 thin leading-display">Literatura št. <?php the_title(); ?></h1>
						<h2 class="font-size-1 bold " id=""><?php echo get_post_meta($post->ID, 'newlit-revija-new-issue', true) ?></h2>

					</div>
					<div class="excerpt sans leading-medium clearfix font-size-1 block-para" style="padding-top: 3em;">
<?php the_content(); ?>
						<!--<div class="text-outer top-padding bottom-padding bottom-widgets">
							<?php dynamic_sidebar('newlit-narociRevijo-widget'); ?>
						</div>-->				
					</div>
					
					<div id="postBrowser" class="sans postMeta clearfix magazine-browser" style="display: flex; flex-direction: column; align-items: center;>
<?php
	$prevMag = myMagazineNavigation('prev');
	$nextMag = myMagazineNavigation('next');

	if ($nextMag) {
?>
						<a class="gray-background-3 readMoreLink page-numbers next"  href="<?php echo get_permalink($nextMag); ?>" title="<?php get_the_title($nextMag); ?>">&larr; Novejša številka (<?php echo get_the_title($nextMag); ?>)</a>
<?php
	} 
	if ($prevMag) {
?>
						<a class="readMoreLink gray-background-3 prev page-numbers" href="<?php echo get_permalink($prevMag);?>" title="<?php get_the_title($prevMag); ?>"> Starejša številka (<?php echo get_the_title($prevMag); ?>) &rarr;</a>
<?php
	}

?>
						<div style="vertical-align: center;">
							<button class="btn btn-primary" style="background-color: #648aaa; border: #648aaa;  display:block; margin-left: auto; margin-right:auto; margin: 1em; ">Naročite izdajo tu!</button>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<?php endforeach; else: ?>
<?php endif; ?>

<!--<div class="text-outer top-padding bottom-padding bottom-widgets">
	<?php dynamic_sidebar('newlit-narociVseRevije-widget'); ?>
</div>-->

<div class="newlit-review-description oneArticle continuous section levodesnopadding light-blue-background font-size-3 sans">
	<div class="articleText clearfix text-outer top-padding bottom-padding" style="">
		<div class="columnar-text" style="width: 100%;">
			<p>Revija Literatura je osrednji slovenski mesečnik za književnost, ki kot samostojna revija izhaja od leta 1989, ko se je odcepila od revije Problemi. V več kot 30 letnikih izhaja neprekinjeno; v zadnjih letih v devetih zvezkih, po šest enojnih in tri dvojne številke letno.</p>
			<p>Prinaša izvirno in prevedeno poezijo in prozo ter izvirne in prevedene eseje, izstopajo tematski bloki (npr. Slovenska literatura in film, Slavljenje hibridnosti – o postkolonializmu, Literarni mediji jutri, Wittgenstein – sto let Traktata, Kdo je lahko slovenski_a pisatelj_ica?). Posebna pozornost gre še intervjujem in knjižnim ocenam, številke pogosto zaključi strip.</p>
			<p>Vlogo glavnega oziroma odgovornega urednika so v minulih letih zasedali Jani Virk, Vid Snoj, Igor Zabel, Igor Bratož, Tomo Virk, Matevž Kos, Samo Kutoš, Andrej Blatnik, Urban Vovk, Primož Čučnik in Maja Šučur.</p>
		</div>
	</div>
</div>


<?php
$recentMagazines = _myRecentMagazines(16);
if (!empty($recentMagazines)) :
?>
<div class="oneArticle section">
	<div class="">
		<div class="articleText clearfix text-outer" style="padding-top: 0">
			<h6 class="font-size-3 thin leading-display gray"  id="">Novejše številke revije Literatura</h6>
			<ul id="titlesByAuthor" class="newlit-review-issues dynamicBookList true-liquid-block-outer"><!--
<?php foreach ($recentMagazines as $post) : ?>
<?php
$itemSize = 'one-eight';
$fontSize = 'font-size-1';
?>
				--><li class="true-liquid-block-inner <?php echo $itemSize ?>">
					<div class="myPostItem">
						<a class="bare blockLink" href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>" ><?php the_post_thumbnail('myTwoColImage', array('class' => $myAddClass, 'alt' => $alt_text)); ?></a>
<?php
$img_id = get_post_thumbnail_id($post->ID);
$alt_text = get_post_meta($img_id , '_wp_attachment_image_alt', true);
if (has_post_thumbnail()) : ?>
<?php 	endif; ?>
						<div class="bookInfo">
							<h3 class="sans bold <?php echo $fontSize; ?>"><a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"><?php echo get_the_title(); ?></a></h3>
						</div>
					</div>
				</li><!--
<?php endforeach; ?>
			--></ul>
		</div>
	</div>
</div>
<?php endif; ?>


<div class="section fullw gray-background top-padding bottom-padding">
	<div class="">
		<div class="articleText clearfix text-outer" style="padding-top: 0">
			<h4 class="widgettitle font-size-4 thin center leading-display" style="padding: 10px;">Vse številke revije Literatura</h4>
			<div class="center">
				<?php myMagazineList(); ?>
			</div>
			<!--<h4 class="widgettitle font-size-3 thin center leading-display" style="padding: 10px;">Naročilo</h4>
			<p class="center">Na revijo se lahko <a href="<?php echo antispambot("mailto:ludliteratura@yahoo.com"); ?>" style="text-decoration: underline;">naročite po elektronski pošti</a>. Ob naročnini prejmete tudi knjigo iz programa LUD Literatura po vaši izbiri.
			</div>-->
		</div>
	</div>
</div>
<?php get_footer(''); ?>
