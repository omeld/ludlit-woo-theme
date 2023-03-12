<?php 
	$currenturl = $_SERVER['REQUEST_URI']; 
	//echo $currentpage; home_url('/imena-avtorjev/' . $authorSlug . '/');
	//echo $currenturl;
	$key = 'imena-avtorjev';
	$key2 = 'tag';
	$key3 = 'category';
	$key4 = 'prispevki';

if(empty($_GET) && (strpos($currenturl, $key) == false) && (strpos($currenturl, $key2) == false) 
   && (strpos($currenturl, $key3) == false) && (strpos($currenturl, $key4) == false) ) : ?>
	<div class="text-outer top-padding bottom-padding bottom-widgets gray-background">
		<ul class="bare-list true-liquid-block-outer my-widget center-margins two-three center">
			<?php dynamic_sidebar('newlit-social-widget'); ?>
		</ul>
		<!--<?php dynamic_sidebar('newlit-narocirevijo-widget'); ?>-->
	</div>
<?php endif; ?>