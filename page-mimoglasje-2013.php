<?php get_header('mimoglasje-2013'); ?>
<?php date_default_timezone_set('Europe/Ljubljana'); ?>
		<div class="container hasEffect">
			<div class="section article content main-content" id="projectDescription">
				<div class="sectionPadding clearfix">
					<div class="threeCol float hasRightMargin">
						<h1>Mimoglasje so glasovi, ki se srečajo s tem, da se zgrešijo</h1>
						<p>Ne naveličamo se poskusov. Nikoli se ne moremo dovolj dobro zgrešiti. Medtem ko se poezija in glasba vedno znova poskušata zlititi v eno, slavi Mimoglasje njuno nezdružljivost in ohranja toliko večje zanimanje za vsako izmed njiju.</p>
						<p>Seveda pa so mogoča tudi presenečenja. Zgodijo se obrati. Poezija lahko zvoči in glasba uhaja v besede. Glasovi se hočejo zgrešiti, a se pomotoma srečajo. Mimoglasje je priložnost za drzne premierne nastope, v katerih predani mlajši improvizatorji raziskujejo meje lastnega izraza, ali efemerna združenja pesnikov s potrebo po šumu in eksperimentu. </p>
						<p>Poezija za napačno osnovo, zvočna improvizacija za napačno začimbo in pijača za pravo izbiro. Dogodki, ki jih že drugič zapored organizirata LUD Literatura in LUD Šerpa, se bodo začeli vsakič ob 18.30 v Klubu Daktari in bodo prosti vstopnine. Namesto tega bo mogoče kupiti knjige po znižanih cenah. Mimoglasje pravi: popust namesto vstopnine.</p>
					</div>
				</div>
			</div>
		</div>
		<div class="container hasEffect" id="projectTeaserContainer">
			<div class="section" id="projectTeaser">
				<div class="sectionPadding ">
					<ul id="teasers" class="clearfix sans">
						<li class="oneCol hasRightMargin <?php $t = ((mktime(18, 30, 0, 2, 5) - time()) / 60 / 60 / 24); if (0 < $t && $t < 7) { echo " current "; } ?>">
							<a class="bare" href="<?php echo home_url('/drugo/mimoglasje-2013-02-05-skrjanec-torkar-balzalorsky/'); ?>">
								<span class="hasPadding">
									<span class="mimoglasjeDate">5. 2. 2013 ob 18.30</span>
									<span><b>poezija:</b> Tone Škrjanec, Gašper Torkar</span>
									<span><b>zvok:</b> Vitja Balžalorsky</span>
								</span>
							</a>
						</li>
						<li class="oneCol hasRightMargin <?php $t = ((mktime(18, 30, 0, 2, 12) - time()) / 60 / 60 / 24); if (0 < $t && $t < 7) { echo " current "; } ?>">
							<a class="bare" href="<?php echo home_url('/drugo/mimoglasje-2013-02-12-novak-drab-jez/'); ?>">
								<span class="hasPadding">
									<span class="mimoglasjeDate">12. 2. 2013 ob 18.30</span>
									<span><b>poezija:</b> Franci Novak, Mitja Drab</span>
									<span><b>zvok:</b> Andraž Jež</span>
								</span>
							</a>
						</li>
						<li class="oneCol hasRightMargin <?php $t = ((mktime(18, 30, 0, 2, 19) - time()) / 60 / 60 / 24); if (0 < $t && $t < 7) { echo " current "; } ?>">
							<a class="bare" href="<?php echo home_url('/drugo/mimoglasje-2013-02-19-dintinjana-hmeljak-pepelnik-torkar-hocevar/'); ?>">
								<span class="hasPadding overlay">
									text or test
								</span>
								<span class="hasPadding baseDesc">
									<span class="mimoglasjeDate">19. 2. 2013 ob 18.30</span>
									<span><b>poezija:</b> Veronika Dintinjana, Karlo Hmeljak</span>
									<span><b>zvok:</b> Pepelnik / Torkar / Hočevar</span>
								</span>
							</a>
						</li>
						<li class="oneCol hasRightMargin <?php $t = ((mktime(18, 30, 0, 2, 26) - time()) / 60 / 60 / 24); if (0 < $t && $t < 7) { echo " current "; } ?>">
							<a class="bare" href="<?php echo home_url('/drugo/mimoglasje-2013-02-26-perat-plut-kravanja-kutin/'); ?>">
								<span class="hasPadding">
									<span class="mimoglasjeDate">26. 2. 2013 ob 18.30</span>
									<span><b>poezija:</b> Katja Perat, Katja Plut</span>
									<span><b>zvok:</b> Ana Kravanja in Samo Kutin</span>
								</span>
							</a>
						</li>
						<li class="oneCol <?php $t = ((mktime(18, 30, 0, 3, 5) - time()) / 60 / 60 / 24); if (0 < $t && $t < 7) { echo " current "; } ?>">
							<a class="bare" href="<?php echo home_url('/drugo/mimoglasje-2013-03-05-pepelnik-hocevar-idej/'); ?>">
								<span class="hasPadding">
									<span class="mimoglasjeDate">5. 3. 2013 ob 18.30</span>
									<span><b>poezija:</b> Ana Pepelnik, Andrej Hočevar</span>
									<span><b>zvok:</b> Idej</span>
								</span>
							</a>
						</li>
					</ul>
				</div>
			</div>
		</div>
		<div class="container hasEffect">
			<div class="section article content" id="projectDescription2">
				<div class="sectionPadding clearfix">
					<div class="float threeCol hasRightMargin">
						<h1>Novice</h1>
<?php

global $post;
$args = array(
	'posts_per_page' => -1,
	'post_type' => 'newlit_special',
	'post_status' => 'publish',	
	'tax_query' => array(
		'relation' => 'AND',
		array(
			'taxonomy' => 'special_cat',
			'field' => 'slug',
			'terms' => 'blog',
		),
		array(
			'taxonomy' => 'special_cat',
			'field' => 'slug',
			'terms' => 'mimoglasje2013'
			//'include_children' => false // ???
		)
	)
);

$myPosts = get_posts($args);

$myIterator = 0;

if ($myPosts) : foreach($myPosts as $post) : setup_postdata($post); $myIterator++;
?>
						<div class="oneCol float <?php echo (($myIterator % 3 == 0) ? '' : ' hasRightMargin'); ?>">
<?php
if (has_post_thumbnail()) : 
	//$image_attributes = wp_get_attachment_image_src($post->ID, 'newlitSpecial2');
?>
<a class="imgLink" href="<?php the_permalink(); ?>" title="" >
<?php
	the_post_thumbnail('newlitSpecial1', array('alt' => $alt_text));
?>
	</a>
<? else : ?>
<?php 	endif; ?>
						<h2><a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a></h2>
						<div class="excerpt">
							<?php the_excerpt(); ?>
							<p><?php echo the_time('j. F Y');?></p>
						</div>
						</div>
<?php
if ($myIterator % 3 == 0) {
?>
						<div class="clear"></div>
<?php
}
endforeach; endif;
?>
					</div>
					<!-- <div class="oneCol float sans"> -->
					<div class="twoCol float">
					<h1>&nbsp;</h1>
						<img src="http://www.ludliteratura.si/wp-content/uploads/2013/02/mimoglasje-II-daktari-500x712.jpg" style="width: 100%">
						<p style="text-align: right; font-size: 0.75em">Avtor plakata: Matej Stupica</p>
					</div>

<?php
/*
global $post;
$args = array(
	'posts_per_page' => 999,
	'offset' => 9,
	'post_type' => 'newlit_special',
	'post_status' => 'publish',	
	'tax_query' => array(
		'relation' => 'AND',
		array(
			'taxonomy' => 'special_cat',
			'field' => 'slug',
			'terms' => 'blog',
		),
		array(
			'taxonomy' => 'special_cat',
			'field' => 'slug',
			'terms' => 'mimoglasje2013'
		)
	)
);

$myPosts = get_posts($args);

$myIterator = 0;
 */

//if ($myPosts) :
if (false) :
?>
						<h3>Starejše objave</h3>
<?php foreach($myPosts as $post) : setup_postdata($post); $myIterator++; ?>
	<h4><a href="<?php the_permalink();?>" title="<?php the_title_attribute();?>"><?php the_title(); ?></a></h4>
<?php
endforeach; endif;
?>
					</div>	
				</div>
			</div>
		</div>
		<div class="container hasEffect">
			<div class="section article content" id="projectDetails">
				<div class="sectionPadding clearfix">
					<h1>Nastopajo</h1>
<?php
global $post;
$args = array(
	'posts_per_page' => -1,
	'orderby' => 'title',
	'order' => 'ASC',
	'post_type' => 'newlit_special',
	'post_status' => 'publish',	
	'tax_query' => array(
		'relation' => 'AND',
		array(
			'taxonomy' => 'special_cat',
			'field' => 'slug',
			'terms' => 'avtor'
		),
		array(
			'taxonomy' => 'special_cat',
			'field' => 'slug',
			'terms' => 'mimoglasje2013'
		)
	)
);

$myPosts = get_posts($args);

$myIterator = 0;

if ($myPosts) : foreach($myPosts as $post) : setup_postdata($post); $myIterator++;
?>
<!-- <a href="<?php the_permalink();?>"> -->
	<div class="oneCol authorPic relative hasBottomMargin float <?php echo (($myIterator % 5 == 0) ? '' : 'hasRightMargin'); ?>">
		<a href="<?php the_permalink();?>" class="overlay"></a>
		<div class="sans overlayDesc">
			<a href="<?php the_permalink();?>" title="<?php the_title_attribute();?>"><?php the_title();?></a>
		</div>
<?php if (has_post_thumbnail()) : ?>
		<a class="imgLink" href="<?php the_permalink();?>" title="<?php the_title_attribute();?>" >
<?php 		the_post_thumbnail('newlitSpecial1', array('alt' => $alt_text)); ?>
		</a>
<? 
else : 
the_title();
endif; 
?>
	</div>
<?php endforeach; endif; ?>
				</div>
			</div>
		</div>
<?php get_footer('mimoglasje-2013'); ?>
