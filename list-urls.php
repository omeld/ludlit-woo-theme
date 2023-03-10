<?php
/*
Template Name: seznam url-jev
*/

wp_head();

global $wp_query, $wpdb, $post;

date_default_timezone_set('Europe/Ljubljana');

$mydate['month'] = 
	((1 <= $_GET['mymonth'] && $_GET['mymonth'] <= 12) ? 
		$_GET['mymonth'] : (date('n') - 1));
$mydate['year'] = 
	((preg_match('/\d\d\d\d/', $_GET['myyear'])) ? 
		$_GET['myyear'] : (date('Y')));

echo "<i>usage: /?mymonth=x[&myyear=yyyy]<br>or leave empty for default (prev. month)</i><br><br>";
echo "<b>using: $mydate[month], $mydate[year]</b><br><br>";

$args = array(
	'year' => $mydate['year'],
	'monthnum' => $mydate['month'],
	'status' => 'publish',
	'posts_per_page' => -1,
	'post_type' => 'post'
);

$monthsPosts = new WP_Query($args);
$myurls = array();

if ($monthsPosts->have_posts()) :
	while ($monthsPosts->have_posts()) : $monthsPosts->the_post();
		$myurls['urls'][] = get_permalink();
		$myurls['titles'][] = get_the_title();
	endwhile;

	echo "<b>total: " . count($myurls['urls']) . "</b><br><br>";

	$myurls['urls'] = str_replace('http://www.ludliteratura.si', '', $myurls['urls']);

	echo "<b>urls:</b><br>";
	echo "<p>". join('|',$myurls['urls']), "<p><br><br>";
	echo "<b>titles:</b><br>";
	echo "<p>" . join('|',$myurls['titles']), "</p><br><br>";
else :
	echo "<p>No posts to show</p>";
endif;

?>
