<?php
/*
	počasi dodajmo vse taksonomije in mete ročno
	--------------------------------------------
 */

add_action('init', 'newlit_basic_custom_taxonomies');
function newlit_basic_custom_taxonomies() {
	register_taxonomy(
		'ime_avtorja',
		array('post', 'avtor'),
		array(
			'label' => 'imena avtorjev',
			'labels' => array(
				'singular_name' => 'ime avtorja',
				'add_new_item' => 'dodaj novega avtorja'
			),
			'show_admin_column' => true,
			'show_tagcloud' => false,
			'hierarchical' => false,
			'rewrite' => array(
				'slug' => 'imena-avtorjev'
			)
		)
	);
}

?>
