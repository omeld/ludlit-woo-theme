<?php
/*
Template Name: Projekti idr.
 */

get_header('home');
global $post;
global $wp_query;
global $wpdb;

$projectPages = $wpdb->get_col("SELECT ID FROM $wpdb->posts WHERE menu_order > 100 ORDER BY menu_order DESC");

?>
<div id="main" class="clearfix">
	<div class="mobile-override top-stripe-description fullw gray-background-1 top-padding bottom-padding" style="">
		<div class="articleText clearfix text-outer" style="">
			<p class="text-inner mobile-base-size font-size-3 serif">LUD Literatura svoje osnovne dejavnosti redno dopolnjuje še z dodatnimi projekti, ki raziskujejo nove možnosti literarnega ustvarjanja in specifične vidike literature kot sočasnega družbenega pojava.</p>
		</div>
	</div>
	<div class="oneArticle continuous section">
		<div class="articleText clearfix text-outer" style="">
			<div class="project-list-container two-three center-margins">
<?php
if (!empty($projectPages)) :
?>
				<ul id="newlit-projects" class="x-large-bottom-margin x-large-top-margin true-liquid-block-outer"><!--
<?php
	foreach ($projectPages as $projectID) :
		$post = get_post($projectID);
		setup_postdata($post);
?>
					--><li class="true-liquid-block-inner verticalMiddle one-one ">
						<div class="myPostItem large-top-padding large-bottom-padding clearfix">
<?php
$img_id = get_post_thumbnail_id($post->ID);
$alt_text = get_post_meta($img_id , '_wp_attachment_image_alt', true);
?>
<?php if (has_post_thumbnail()) : ?>
							<a class="bare float one-four blockLink" href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>" >
<?php //if (has_post_thumbnail()) : the_post_thumbnail('medium', array('class' => $myAddClass, 'alt' => $alt_text)); endif; ?>
								<div class="small-right-margin " style="">
									<div class="cover ratio-1-1" style="background-image: url(<?php $xthumb = wp_get_attachment_image_src(get_post_thumbnail_id(), 'myAuthorThumbnail'); echo $xthumb[0] ?>)"></div>
								</div>
							</a>
<?php endif; ?>
							<div class="bookInfo floatRight three-four">
								<a class="bare " href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>" ><h2 class="reset-vertical-space small-bototm-margin sans light font-size-4"><?php the_title(); ?></h2></a>
								<div class="medium-top-margin gray">
<?php the_excerpt(); ?>
								</div>
							</div>
						</div>
					</li><!--
<?php endforeach; wp_reset_postdata(); ?>
				--></ul>
<?php endif; ?>
			</div>
		</div>
	</div>
</div>
<?php get_footer(); ?>
