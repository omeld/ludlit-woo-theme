<?php
/*
Template Name: stran za revije
 */
?>
<?php get_header('home'); ?>
<?php global $post; ?>
<?php global $thisPostID; ?>

<?php //if (have_posts()) : while (have_posts()) : the_post(); ?>
<?php 	//$thisPostID = $post->ID; ?>



<?php
$args = array(
	'post_status' => publish,
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
			--><div class="true-liquid-block-inner one-two verticalMiddle" style="vertical-align: middle">
				<div id="featured-image" class="">
					<a class="bare" href="<?php echo wp_get_attachment_url(get_post_thumbnail_id($post->ID)); ?>" title="<?php the_title_attribute(); ?>" ><?php the_post_thumbnail('large', array('class' => 'featuredImg fit', 'alt' => trim(strip_tags(get_post_meta(get_post_thumbnail_id($post->ID), '_wp_attachment_image_alt', true))))); ?></a>
				</div>
			</div><!--
<?php endif; ?>
			--><div class="true-liquid-block-inner two-three" style="vertical-align: top">
				<div class="" style="">
					<div id="article-title">
						<h1 class="font-size-5 thin leading-display">Literatura št. <?php the_title(); ?></h1>
						<h2 class="font-size-2 bold red" id=""><?php echo get_post_meta($post->ID, 'newlit-revija-new-issue', true) ?></h2>
					</div>
					<div class="excerpt sans leading-medium clearfix font-size-1 block-para" style="padding-top: 3em;">
<?php the_content(); ?>
						<!--<div class="text-outer top-padding bottom-padding bottom-widgets">
							<?php dynamic_sidebar('newlit-narociRevijo-widget'); ?>
						</div>-->	
					</div>
					
					
					<div id="postBrowser" class="sans postMeta clearfix magazine-browser" style="display: flex; flex-direction: column; align-items: center; margin-right: 30em; margin: -20em; ">
<?php
	$prevMag = myMagazineNavigation('prev');
	$nextMag = myMagazineNavigation('next');

	if ($nextMag) {
?>
						<div id="nextLink" class="twoCol float oneColMargin hasRightMargin ">
							<p><a class="page-numbers next" href="<?php echo get_permalink($nextMag); ?>" title="<?php get_the_title($nextMag); ?>">&larr; Novejša številka (<?php echo get_the_title($nextMag); ?>)</a></p>
						</div>
<?php
	} 
	if ($prevMag) {
?>
						<div id="prevLink" class="twoCol float oneColMargin" style="text-align: right">
							<p><a class="prev page-numbers" href="<?php echo get_permalink($prevMag);?>" title="<?php get_the_title($prevMag); ?>"> Starejša številka (<?php echo get_the_title($prevMag); ?>) &rarr;</a></p>
						</div>
<?php
	}

?>
						<div style="vertical-align: center;">
							<button class="btn btn-primary" style="background-color: #648aaa; border: #648aaa;  display:block; ">Naročite izdajo tu!</button>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>









<?php endforeach; else: ?>
<?php endif; ?>
<div id="articleSideBar" class="fiveCol float hasLeftMargin">
<?php if (has_post_thumbnail($post->ID)) : ?>
<div id="authorPhotoSidebar">
			<a class="bare" href="<?php echo wp_get_attachment_url(get_post_thumbnail_id($post->ID)); ?>" title="<?php the_title_attribute(); ?>" >
<?php		the_post_thumbnail('myArticleThumbnail', array('class' => $myAddClass, 'alt' => trim(strip_tags(get_post_meta(get_post_thumbnail_id($post->ID), '_wp_attachment_image_alt', true))))); ?>
			</a>
			<p class="sans" id="authorPhotoDesc" style="text-align: right"><?php echo get_post_meta(get_post_thumbnail_id($post->ID), '_wp_attachment_image_alt', true);  ?></p>
</div>
<?php endif; ?>

<div id="fixedFloaterContainer">
	<div id="floaterWrap">
		<div style="" class="">
			<div class="addthis_toolbox addthis_pill_combo">
				<!-- <a class="addthis_button_facebook_like" fb:like:layout="button_count"></a> -->
				<a class="addthis_button_facebook_like"></a>
				<a class="addthis_button_tweet" tw:count="horizontal"></a>
				<!-- <a class="addthis_counter addthis_pill_style"></a> -->
				<a class="addthis_counter addthis_button_expanded"></a>
			</div>
		</div>
		<div id="sideBarDivRight">
			<ul id="mySidebar3" class="sideBarLiContent">
				<?php dynamic_sidebar(3); ?>
			</ul>
		</div>
	</div>
</div>

<?php //newlit_show_tags() ?>

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
</div>
<?php get_footer(''); ?>
