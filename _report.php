<?php
$db = "jaka";
$pw = "ludliterjav";

mysql_connect("www.ljudmila.org", "jaka", "ludliterjav");
@mysql_select_db("jaka");


$query = <<END
SELECT

concat(m3.meta_value, ', ', m4.meta_value) as "ime", 
date_format(p.post_date, '%e. %c. %Y') as "datum", 
concat(p.post_title, ' (', t1.name, ')') as "naslov", 
char_length(p.post_content) as "obseg",
'' as "opombe",
p.post_content as "content"

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
AND p.post_status IN ('publish')

AND year(p.post_date) = 2014
AND month(p.post_date) = 10

AND tt1.taxonomy = 'category'
AND tt2.taxonomy = 'ime_avtorja'

AND p2.post_type = 'avtor'
AND m3.meta_key = 'priimek'
AND m4.meta_key = 'ime'

group by p.ID
END;
$result = mysql_query($query);

mb_internal_encoding("UTF-8");

while($row = mysql_fetch_array($retval, MYSQL_ASSOC)) {
	$charCount = mb_strlen(strip_tags($row['content']));
	echo <<<END
"$row['ime']","$row['datum']","$row['naslov']","$row['obseg']","$charCount"
END;
}
	


?>
