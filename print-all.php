<?php
/*
Template Name: Članki za sprintat
*/
?>
<!doctype html>
<html lang="sl">
	<head>
		<meta http-equiv="Content-type" content="text/html;charset=UTF-8" />
		<style type="text/css">
			@media all {
				.page-break	{ display: none; }
			}

			@media print {
				.page-break	{ display: block; page-break-before: always; }
			}
			img, iframe {
				display: none;
			}
			* {
				padding: 0;
				margin: 0;
				line-height: 1.3 !important;
				font-family: serif;
			}
			html {
				font-size: 18px;
			}
			body {
				margin: 2em;
			}
			h1, h2, h3 {
				font-family: sans-serif;
			}
			h1 {
				font-size: 1em;
				font-weight: bold;
				margin-bottom: 0.5em;
			}
			h2 {
				font-size: 1.5em;
				font-weight: bold;
				margin-bottom: 0.25em;
				border-bottom: 1px solid black;
				padding-bottom: 0em;
			}
			h3 {
				font-size: 1em;
				font-weight: normal;
			}
			h3 {
				margin-bottom: 1em;
			}
			p { text-indent: 1em; }
			h4, h5, h6 {
				font-size: 1em;
				font-weight: normal
			}
			/*
			@page {
				@top-center { content: element(header); }
			}
			#header {
				position: running(pageHeader);
			}
			#header::after {
				content: ' / ' counter(page);
			}
			*/
		</style>
		<?php wp_head(); ?>
	</head>
	<body>
	<!--<div id="header">www.ludliteratura.si</div>-->
	<?php
global $wp_query, $wpdb, $post;
$mysqlQuery = "
SELECT

concat(m3.meta_value, ', ', m4.meta_value) as ime, date_format(p.post_date, '%e. %c. %Y') as datum, p.post_title as naslov, t1.name as rubrika, concat(p.post_title, ' (', t1.name, ')') as 'naslov/rubrika', char_length(p.post_content) as 'obseg (št. znakov s presledki)', '' as opombe, p.post_content as content

FROM

wp_2_posts p

INNER JOIN wp_2_term_relationships AS tr1 ON p.ID=tr1.object_id
INNER JOIN wp_2_term_taxonomy AS tt1 ON tr1.term_taxonomy_id = tt1.term_taxonomy_id
INNER JOIN wp_2_terms AS t1 ON tt1.term_id = t1.term_id

INNER JOIN wp_2_term_relationships AS tr2 ON p.ID=tr2.object_id
INNER JOIN wp_2_term_taxonomy AS tt2 ON tr2.term_taxonomy_id = tt2.term_taxonomy_id
INNER JOIN wp_2_terms AS t2 ON tt2.term_id = t2.term_id

INNER JOIN wp_2_posts AS p2 ON p2.post_title = t2.name

INNER JOIN wp_2_term_relationships AS tr3 ON p2.ID=tr3.object_id
INNER JOIN wp_2_term_taxonomy AS tt3 ON tr3.term_taxonomy_id = tt3.term_taxonomy_id
INNER JOIN wp_2_terms AS t3 ON tt3.term_id = t3.term_id
INNER JOIN wp_2_postmeta AS m3 ON m3.post_id = p2.ID

INNER JOIN wp_2_term_relationships AS tr4 ON p.ID=tr4.object_id
INNER JOIN wp_2_term_taxonomy AS tt4 ON tr4.term_taxonomy_id = tt4.term_taxonomy_id
INNER JOIN wp_2_terms AS t4 ON tt4.term_id = t4.term_id
INNER JOIN wp_2_postmeta AS m4 ON m4.post_id = p2.ID

WHERE 1=1

AND p.post_type = 'post'
AND p.post_status IN ('publish', 'private', 'future')

AND year(p.post_date) = 2020
AND month(p.post_date) IN (1,2,3,4,5,6,7,8,9,10,11,12)

AND tt1.taxonomy = 'category'
AND tt2.taxonomy = 'ime_avtorja'

AND p2.post_type = 'avtor'
AND m3.meta_key = 'priimek'
AND m4.meta_key = 'ime'

group by p.ID

order by p.post_date asc
";

$printPosts = $wpdb->get_results($mysqlQuery, OBJECT);

if ($wpdb->num_rows > 0) :

	foreach ($printPosts as $postItem) :
?>
		<h1><?php echo $postItem->ime; ?></h1>
		<h2><?php echo $postItem->naslov; ?></h2>
		<h3><?php echo $postItem->datum; ?></h3>
		<div class="content"><?php echo apply_filters('the_content', $postItem->content); ?></div>
		<div class="page-break"></div>
	<?php endforeach; ?>
<?php endif; ?>
		<?php wp_footer(); ?>
	</body>
</html>
