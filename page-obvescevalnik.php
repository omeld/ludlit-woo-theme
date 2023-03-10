<?php
/*
Template Name: obveščevalnik
*/
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
<?php

function my_list_a($a) {
	return '<a title="' . $a['title'] . '" href="' . $a['url'] . '">' . $a['title'] . '</a>';
}

function my_list_b($a) {
	return $a['title'];
}

$args = array(
	'posts_per_page' => -1,
	'category_name' => 'novo',
	'orderby' => 'meta_value_num',
	'meta_key' => 'myorder',
	'order' => 'ASC'
);
$mynewposts = new WP_Query($args);

$og = array();

if ($mynewposts->have_posts()) :
	while ($mynewposts->have_posts()) : $mynewposts->the_post();
		if (in_category('hlapljivo') && in_category('novo') && in_category('strip')) {
			continue;
		}
		$combinedTitle = '';

		$contributor = wp_get_post_terms($post->ID, "ime_avtorja");
		$contributorName = implode(', ', array_map(create_function('$r', 'return $r->name;'), $contributor));

		//$otherContributor = wp_get_post_terms($post->ID, "drugo_ime", array("count" => 1));
		//$contributorName = (empty($otherContributor) ? $contributor[0]->name : $otherContributor[0]->name);
		
		if (isset($contributorName) and !(empty($contributorName))) :
			//$combinedTitle = "$contributorName: " . get_the_title();
			$combinedTitle = "$contributorName: " . the_title_attribute('echo=0');
		else:
			$combinedTitle = get_the_title();
		endif;

		$og[$post->ID]['url'] = newlit_utm_parameters();
		$og[$post->ID]['title'] .= $combinedTitle;
		if (has_post_thumbnail($post->ID)) {
			echo '<meta property="og:image" content="' . wp_get_attachment_url(get_post_thumbnail_id($post->ID)) . '" />' . "\n";
		}
	endwhile;
	$mynewposts->rewind_posts();
endif;

echo '<meta property="og:title" content="LUD Literatura. Obveščevalnik" />' . "\n";
echo '<meta property="og:type" content="article" />' . "\n";
echo '<meta property="og:url" content="http://www.ludliteratura.si/obvescevalnik/" />' . "\n";
//echo '<meta property="og:description" content="' . implode(' | ', array_map( function($a) { return $a['title']; }, $og)) . '" />' . "\n";
echo '<meta property="og:description" content="' . implode(' | ', array_map("my_list_b", $og)) . '" />' . "\n";
echo '<meta property="og:image" content="http://www.ludliteratura.si/wp-content/uploads/2012/12/lud-literatura-logo.jpg" />' . "\n";

//echo '<meta name="description" content="' . implode(' | ', array_map( function($a) { return $a['title']; }, $og)) . '" />' . "\n";
echo '<meta name="description" content="' . implode(' | ', array_map("my_list_b", $og)) . '" />' . "\n";


?>
		<script type="text/javascript" src="//use.typekit.net/rha7jnl.js"></script>
		<script type="text/javascript">try{Typekit.load();}catch(e){}</script>
<?php
if (have_posts()) : ?>
<?php while (have_posts()) : the_post(); ?>
<?php $main_post = $post; ?>
<?php $newsletter_url = newlit_utm_parameters(); ?>
		<meta http-equiv="Content-type" content="text/html;charset=UTF-8">
		<title><?php wp_title('&laquo;', true, 'right'); ?><?php bloginfo('name'); ?></title>
		<?php //wp_head(); ?>
	</head>
	<body style="padding: 0; margin: 0; background-color: #F0F1F4; font-family: 'ff-tisa-web-pro', serif">
		<table cellpadding="0" cellspacing="0" border="0" id="backgroundTable" width="100%" style="border-collapse: collapse; background-color: #F0F1F4; width: 100%; margin: 0; padding: 0; width: 100% !important; line-height: 100% !important">
		<tr>
			<td>
				<table cellpadding="20" cellspacing="0" border="0" align="center" style="background-color: white; border: 0px solid #D8DDE1">
					<tr>
						<td>
							<p style="font-family: proxima-nova, Helvetica, sans-serif; font-size: 10px; text-align: right">
							Ni videti, kot bi moralo biti? <a style="text-decoration: none; border: none;"  href="<?php echo $newsletter_url; ?>">Poglejte na spletu.</a>
							</p>
							<p style="border-top: 1px solid black; text-align: center;">
								<a style="outline: none; text-decoration: none; border: none" title="LUD Literatura" href="http://www.ludliteratura.si/?utm_source=newsletter&utm_medium=email&utm_campaign=obvescevalnik">
									<img height="20" style="height: 20px; border: none; outline: none; text-decoration: none" alt="LUD Literatura" src="http://www.ludliteratura.si/lud-literatura-logo.jpg">
								</a>
							</p>
						</td>
					</tr>
<?php
/*
remove_filter( 'excerpt_length', 'custom_excerpt_length');
$args = array(
	'posts_per_page' => -1,
	'category_name' => 'novo',
	'orderby' => 'meta_value_num',
	'meta_key' => 'myorder',
	'order' => 'ASC'
);
query_posts($args);
 */
/* main query: contents of the PAGE (custom intro etc, folowed by automated content */
?>
<tr>
<td width="560" style="padding-top: 28px; padding-bottom: 56px; border-bottom: 14px solid #F0F1F4">
<?php if (has_post_thumbnail()) : ?>
<a style="outline: none; text-decoration: none; border: none" href="<?php echo newlit_utm_parameters(); ?>" title="<?php the_title_attribute(); ?>" >
<?php		the_post_thumbnail('medium', array('style' => 'outline: none; text-decoration: none; border: none; align: midle; max-width: 100%; height: auto')); ?>
</a>
<?php endif; ?>
<!-- <h2 style="font-family: proxima-nova, Helvetica, sans-serif; font-size: 49px; letter-spacing: -1px; line-height: 1.1; font-weight: bold; color: black; margin: 14px 0 14px 0"><?php the_title(); ?></h2> -->
<div style="font-size: 14px; font-family: proxima-nova, Helvetica, sans-serif; line-height: 1.6; margin-top: 47px">
<?php
	$my_content = get_the_content();
	$my_content = apply_filters('the_content', $my_content);
	$pattern = '/<img ([^>]+)>/';
	$replacement = '<div style="text-align: center !important; display: block; width: 100%"><img style="max-width: 100%; width: 100%; height: auto" ${1}></div>';
	$my_content = preg_replace($pattern, $replacement, $my_content);
?>




<?php	echo $my_content; //the_content(); ?>

<pre>
</pre>
<p><b>Vsebina:</b><br> 
<?php 
echo implode('<br>', array_map("my_list_a", $og)); //old version of php (without annon functions)
?>
<?php //echo implode(' <br> ', array_map( function($a) { return '<a title="' . $a['title'] . '" href="' . $a['url'] . '">' . $a['title'] . '</a>'; }, $og)); ?>
</p>
</div>
</td>
</tr>
<?php endwhile; ?>
<?php 	endif; ?>

<?php
if ($mynewposts->have_posts()) : ?>
<?php while ($mynewposts->have_posts()) : $mynewposts->the_post(); ?>

<?php if (in_category('hlapljivo') && in_category('novo') && in_category('strip')) : ?>
<tr>
<td width="560" style="padding-top: 28px; padding-bottom: 56px; border-bottom: 14px solid #F0F1F4">
<div style="font-size: 14px; font-family: proxima-nova, Helvetica, sans-serif; line-height: 1.6; margin-top: 0px">
<?php	the_content(); //the_excerpt(); ?>
</div>
<?php if (has_post_thumbnail()) : ?>
<p style="width: 100%; text-align: center">
<?php		the_post_thumbnail('medium', array('style' => 'outline: none; text-decoration: none; border: none; align: middle; max-width: 100%; height: auto')); ?>
</p>
<?php endif; ?>
</td>
</tr>
<?php else: ?>

<tr>
<td width="560" style="padding-top: 28px; padding-bottom: 56px; border-bottom: 14px solid #F0F1F4">
<?php if (has_post_thumbnail()) : ?>
<p style="width: 100%; text-align: center">
<a style="outline: none; text-decoration: none; border: none" href="<?php echo newlit_utm_parameters(); ?>" title="<?php the_title_attribute(); ?>" >
<?php		the_post_thumbnail('medium', array('style' => 'outline: none; text-decoration: none; border: none; align: middle; max-width: 100%; height: auto')); ?>
</a>
</p>
<?php endif; ?>
<h2 style="font-family: proxima-nova, Helvetica, sans-serif; font-size: 49px; letter-spacing: -1px; line-height: 1.1; font-weight: bold; color: black; margin: 14px 0 14px 0"><a style="text-decoration: none; border: none; color: black;" href="<?php echo newlit_utm_parameters() ?>" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a></h2>
<?php
		$contributor = wp_get_post_terms($post->ID, "ime_avtorja");
		$contributorName = implode(', ', array_map(create_function('$r', 'return $r->name;'), $contributor));
?>
<?php	if (isset($contributorName) and !(empty($contributorName))) : ?>
<p style="text-align: left; font-family: proxima-nova, Helvetica, sans-serif; font-size: 22px; font-weight: bold; text-transform: none; letter-spacing: 0px; margin: 0 0 28px 0"><?php echo $contributorName; ?></p>
<?php 	endif; ?>
<h3 style="font-size: 14px; color: #666; font-family: proxima-nova, Helvetica, sans-serif;"><?php echo get_post_meta($post->ID, 'mysubtitle', true) ?></h3>
<?php $category = get_the_category(); ?>
<?php foreach ($category as $ctg) : ?>
<?php
	if (($ctg->name == "izpostavljeno") or
		($ctg->name == "hlapljivo") or
		($ctg->name == "novo")) {
			continue;
	}
?>

<p style="display: inline; font-family: proxima-nova, Helvetica, sans-serif; font-size: 14px; line-height: 1.6; font-weight: bold; padding-right: 6px"><a style="text-decoration: none; border: none; color: #666" href="<?php echo add_query_arg(array('utm_source' => 'newsletter', 'utm_medium' => 'email', 'utm_campaign' => 'obvescevalnik'), esc_url(get_category_link($ctg->cat_ID)));?>">•&nbsp;<?php echo $ctg->cat_name; ?></a></p></li>
<?php endforeach; ?>
</ul>
<div style="font-size: 14px; font-family: proxima-nova, Helvetica, sans-serif; line-height: 1.6; margin-top: 0px">
<?php	myParagraphExcerpt(); //the_excerpt(); ?>
</div>
</td>
</tr>
<?php endif; ?>
<?php endwhile; ?>
<?php 	endif; ?>
<?php wp_reset_postdata(); ?>
						<tr>
							<td width="560" style="border-bottom: 0px solid #F0F1F4; ">
<?php $myQuote = myRandomQuoteX(); ?>
								<p style="padding: 0 42px; line-height: 1.6; font-size: 21px; font-family: 'ff-tisa-web-pro', georgia, serif; font-style: italic; ">“<?php echo $myQuote[0];?>”</p>
								<p style="text-align: right">
									<span style="font-size: 12px; font-family: proxima-nova, Helvetica, sans-serif; font-weight: bold"><?php echo "$myQuote[1] $myQuote[2]";?></span>: 
									<span style="font-size: 12px; font-family: proxima-nova, Helvetica, sans-serif; font-style: italic; font-weight: bold;"><?php echo $myQuote[3];?></span>
								</p>
							</td>
						</tr>
						<tr>
							<td width="560" style="border-bottom: 0px solid #F0F1F4; text-align: center">
<?php $post = $main_post; ?>
<?php //if (is_user_logged_in()) : ?>
<div style="margin: auto; text-align: center; display: inline-block">
<!-- AddThis Button BEGIN -->
<a href="http://api.addthis.com/oexchange/0.8/forward/facebook/offer?pco=tbx32nj-1.0&amp;url=<?php echo rawurlencode(get_permalink()); ?>&amp;pubid=ra-4f4f196e17f638ee" target="_blank" ><img src="http://cache.addthiscdn.com/icons/v1/thumbs/32x32/facebook.png" border="0" alt="Facebook" /></a>
<a href="http://api.addthis.com/oexchange/0.8/forward/twitter/offer?pco=tbx32nj-1.0&amp;url=<?php echo rawurlencode(get_permalink()); ?>&amp;pubid=ra-4f4f196e17f638ee" target="_blank" ><img src="http://cache.addthiscdn.com/icons/v1/thumbs/32x32/twitter.png" border="0" alt="Twitter" /></a>
<a href="http://www.addthis.com/bookmark.php?source=tbx32nj-1.0&amp;=300&amp;pubid=ra-4f4f196e17f638ee&amp;url=<?php echo rawurlencode(get_permalink()); ?>" target="_blank"  ><img src="http://cache.addthiscdn.com/icons/v1/thumbs/32x32/more.png" border="0" alt="More..." /></a>
<!-- AddThis Button END -->
</div>
<?php //else : ?>
<!-- tole ni nujno prav: naj bo vedno osnovna verzija za pošiljanje po mejlu -->
<!--
<div class="addthis_toolbox addthis_32x32_style addthis_default_style" style="text-align: center; margin: auto; display: inline-block">
    <a class="addthis_button_facebook"></a>
    <a class="addthis_button_twitter"></a>
    <a class="addthis_button_email"></a>
    <a class="addthis_button_google"></a>
</div>
-->
<?php //endif; ?>

							</td>
						</tr>
						<tr>
							<td width="560">
								<p style="padding: 5px; background-color: #F0F1F4; color: black; font-family: proxima-nova, Helvetica, sans-serif; line-height: 1.6; font-size: 12px; text-align: center">
								Literaturin obveščevalnik skoraj vsak ponedeljek piše in pošilja LUD Literatura.<br>LUD Literatura<br>Erjavčeva 4<br>1000 Ljubljana<br>tel.: 01 251 43 69 ali 01 426 97 60<br><a href="http://www.ludliteratura.si/?utm_source=newsletter&utm_medium=email&utm_campaign=obvescevalnik">www.ludliteratura.si</a>
								<br>
								Obveščevalnik vam pošiljamo v prepričanju, da vas zanima. Lahko se odjavite.
								</p>
							</td>
						</tr>
					</table>
				</td>
			</tr>
		</table>
		<?php //wp_footer(); ?>
<?php //if (! is_user_logged_in()) : ?>
<?php if (false) : ?>
		<script type="text/javascript" src="http://s7.addthis.com/js/250/addthis_widget.js#pubid=ra-4f4f196e17f638ee"></script>
		<script type="text/javascript">
			var addthis_config = {
				data_ga_property: 'UA-22395392-2',
				ui_cobrand: "LUD Literatura"
			}; 
		</script>
<?php endif; ?>
	</body>
</html>
