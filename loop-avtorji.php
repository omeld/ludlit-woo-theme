<!-- loop-avtorji.php -->
<?php


global $post;
global $wp_query;
//global $wpdb;
//global $request;

$myIterator = 0;

$args = array_merge(
	//$wp_query->query,
	array(
		'post_status' => 'publish',
		'posts_per_page' => -1,
		'my_dont_use_post_count_filter' => true,
		'paged' => get_query_var('paged'),
		'post_type' => 'Avtor',
		'meta_key' => 'Priimek',
		'orderby' => 'meta_value',
		'order' => 'ASC',
		'meta_query' => array(
			array(
				/*'key' => 'sodelovanje',
				'value' => 'avtor knjig'*/
			)
		)
	)
);

$literaturaAuthors = new WP_Query($args);

if ($literaturaAuthors->have_posts()) : 
?>

<div class="mobile-override fullw light-red-background top-padding bottom-padding" style="">
	<div class="articleText clearfix text-outer" style="">
	<p class="text-inner font-size-3 serif">Z LUD Literatura so sodelovali že mnogi avtorji vseh generacij iz različnih držav, vključno s prejemniki najpomembnejših literarnih nagrad. A med njimi so tudi tisti najmlajši in najbolj sveži, bodoči nagrajenci, ki že suvereno sooblikujejo slovensko literarno pokrajino, bodisi s knjigami bodisi s posameznimi prispevki na spletu.</p>
	</div>
</div>
<div class="oneArticle continuous section">
	<div class="">
		<div class="articleText clearfix text-outer books" style="padding-top: 0;">
			<h6 id="authorsBooks" class="sans font-size-5 thin center"  id=""><span class="">Vsi Literaturini avtorji</span></h6>
			<p class="block-paragraph">&nbsp;</p>
			<ul id="titlesByAuthor" class=" true-liquid-block-outer"><!--
<?php while ($literaturaAuthors->have_posts()) : $literaturaAuthors->the_post();
//$bookCategory = wp_get_post_terms($post->ID, 'book_cat', array('parent' => 0, 'fields' => 'names'));
$itemSize = 'one-six';
$fontSize = 'font-size-1';
?>
				--><li class="true-liquid-block-inner <?php echo $itemSize ?>">
					<div class="myPostItem">
<?php
$img_id = get_post_thumbnail_id($post->ID);
$alt_text = get_post_meta($img_id , '_wp_attachment_image_alt', true);
$contribution = get_post_meta($post->ID, 'sodelovanje');
?>
						<a class="bare blockLink three-four center center-margins" href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>" >
<?php if (has_post_thumbnail()) : ?>
<?php the_post_thumbnail('myAuthorThumbnail', array('class' => 'circle roundBorders', 'alt' => $alt_text)); ?>
<?php 	endif; ?>
						</a>
						<div class="bookInfo center">
							<h3 class="sans bold <?php echo $fontSize; ?>"><a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"><?php echo get_the_title(); ?></a></h3>
							<!--<p class=" normal sans gray <?php echo $fontSize; ?>"><?php echo get_post_meta($post->ID, 'Zbirka', true) ?> (<?php echo get_post_meta($post->ID, 'sodelovanje', true); ?>) </p>-->
						</div>
					</div>
				</li><!--
<?php endwhile; ?>
			--></ul>
		</div>
	</div>
</div>




<?php else: ?>
<p>ništa</p>
<?php endif; ?>
