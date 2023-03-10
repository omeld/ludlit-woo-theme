<?php get_header('home'); ?>
<?php 
global $post;
global $wp_query;
global $thisPostID; 
$issueExists = 0;
$magazine = false;
?>

<?php 
if (have_posts()) : 
	$issueExists = 1;
	$magazine = $wp_query;
else :
	$args = array(
		'post_status' => publish,
		'posts_per_page' => 1,
		'post_type' => 'revija',
		'meta_key' => 'newlit-revija-new-stevilka',
		'orderby' => 'meta_value_num',
		'order' => 'DESC'
	);
	$magazine = new WP_Query($args);
endif;

if ($magazine->have_posts()) :
	while ($magazine->have_posts()) : $magazine->the_post();
		$thisPostID = $post->ID; 
?>
<div class="fullw gray-background">
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
					</div>
					<div id="postBrowser" class="sans postMeta clearfix magazine-browser">
<?php
	$prevMag = myMagazineNavigation('prev');
	$nextMag = myMagazineNavigation('next');

	if ($nextMag) {
?>
						<a class="gray-background-3 readMoreLink page-numbers next" href="<?php echo get_permalink($nextMag); ?>" title="<?php get_the_title($nextMag); ?>">&larr; Novejša številka (<?php echo get_the_title($nextMag); ?>)</a>
<?php
	} 
	if ($prevMag) {
?>
						<a class="readMoreLink gray-background-3 prev page-numbers" href="<?php echo get_permalink($prevMag);?>" title="<?php get_the_title($prevMag); ?>"> Starejša številka (<?php echo get_the_title($prevMag); ?>) &rarr;</a>
<?php
	}

?>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<?php 
	endwhile;	//loop
	else: 		//no posts
	endif;
?>

<?php if (! $issueExists) : ?>

<div class="newlit-review-description oneArticle continuous section fullw light-blue-background font-size-2 sans">
	<div class="articleText clearfix text-outer" style="">
		<div class="columnar-text" style="">
			<p>Revija Literatura je osrednji slovenski mesečnik za književnost, ki kot samostojna revija izhaja od leta 1989, ko se je odcepila od revije Problemi. V skoraj 25 letnikih je doslej izšlo že skoraj tristo številk v skoraj dvesto zvezkih revije. V zadnjih letih izhaja v osmih zvezkih, po štiri enojne in dvojne številke letno.</p>
			<p>Mesto v reviji najdejo izvirna in prevedena poezija in proza, izvirni in prevedeni eseji, tematski bloki (v zadnjem času so bili med najodmevnejšimi Slovenska literatura in film, Slavljenje hibridnosti – o postkolonializmu, Ut »musica viva« poesis – o literaturi in glasbi, Literatura in strip), intervjuji ter daljše in krajše knjižne ocene, v zadnjem času tudi strip.</p>
			<p>Vlogo glavnega oziroma odgovornega urednika so v minulih dvajsetih letih zasedali Jani Virk, Vid Snoj, Igor Zabel, Igor Bratož, Tomo Virk, Matevž Kos, Samo Kutoš, Andrej Blatnik, Urban Vovk in Primož Čučnik.</p>
		</div>
	</div>
</div>
<?php endif; ?>

<?php
$recentMagazines = _myRecentMagazines(16);
if (!empty($recentMagazines)) :
?>
<div class="oneArticle section">
	<div class="">
		<div class="articleText clearfix text-outer" style="padding-top: 0">
			<h6 class="sans font-size-2 bold gray"  id="">Novejše številke revije Literatura</h6>
			<ul id="titlesByAuthor" class="dynamicBookList true-liquid-block-outer"><!--
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
			<h4 class="widgettitle">Vse številke revije Literatura</h4>
			<?php myMagazineList(); ?>
			<h4 class="widgettitle">Naročilo</h4>
			<p>Na revijo se lahko <a href="<?php echo antispambot("mailto:ludliteratura@yahoo.com"); ?>">naročite po elektronski pošti</a>. Ob naročnini prejmete tudi knjigo iz programa LUD Literatura po vaši izbiri.
			</div>
		</div>
	</div>
</div>
<?php get_footer(''); ?>
