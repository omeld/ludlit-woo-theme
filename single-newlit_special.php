<?
global $post;

$category = get_the_terms($post->ID, 'special_cat');
$parent = 0;

foreach ($category as $c) {
	if ($c->parent != 0) {
		$parent = $c->parent;
	} else {
		$parent = $c->term_id;
	}
}

$terms = get_term($parent, 'special_cat');
$parent = $terms->name;

if (file_exists(TEMPLATEPATH . "/single-newlit_special-${parent}.php")) {
	include(TEMPLATEPATH . "/single-newlit_special-${parent}.php");
	return;
} else {
}

?>
