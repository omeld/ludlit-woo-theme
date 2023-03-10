<?php
/*
trakova z info za knjige
 */
?>
<div class="fullw gray-background-1" style="">
	<div class="articleText clearfix text-outer sans   center" style="padding-top: 0; padding-bottom: 0; margin-bottom: 0">
		<span>Vse knjige po zbirkah: </span>
		<ul id="bookSeries" class="theTags">
<?php 
$args = array(
	'taxonomy' => 'zbirka',
	'hierarchical' => false,
	'title_li' => '',
	'show_count' => true
);
wp_list_categories($args); 
?> 
		</ul>
	</div>
</div>
<div class="fullw gray-background-2">
	<div class="articleText clearfix text-outer sans  center" style="padding-top: 0; padding-bottom: 0; margin-bottom: 1em">
		<span>Vse knjige po zvrsteh: </span>
		<ul id="bookCategories" class="theTags">
<?php 
$args = array(
	'taxonomy' => 'book_cat',
	'hierarchical' => false,
	'title_li' => '',
	'show_count' => true
);
wp_list_categories($args); 
?> 
		</ul>
	</div>
</div>
