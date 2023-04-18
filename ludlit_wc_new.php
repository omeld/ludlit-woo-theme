<?php
add_action('after_setup_theme', 'mytheme_add_woocommerce_support');
function mytheme_add_woocommerce_support() {
	add_theme_support('woocommerce');
}

/* testing block templates */
add_action('after_setup_theme', 'ludlit_wc_add_block_template_part_support');
function ludlit_wc_add_block_template_part_support() {
	add_theme_support('block-template-parts');
}

// additional style sheet
add_action('wp_enqueue_scripts', 'ludlit_woo_theme_enqueue_style');
function ludlit_woo_theme_enqueue_style() {
	wp_enqueue_style( 
		'ludlit_woo_theme_style', 
		get_template_directory_uri() . '/includes/ludlit_woo_theme_style.css', 
		false, 
		filemtime(get_template_directory() . '/includes/ludlit_woo_theme_style.css'),
		'all' 
	);
}

add_action('wp_enqueue_scripts', 'ludlit_wc_enqueue_gradient_scripts');
function ludlit_wc_enqueue_gradient_scripts() {
	if (basename(get_page_template()) == 'front-page-block-parts.php') {
		wp_enqueue_script('colorthief','//cdnjs.cloudflare.com/ajax/libs/color-thief/2.3.0/color-thief.umd.js');
		wp_enqueue_script('ludlit-wc-gradients', 
			get_template_directory_uri() . '/js/ludlit-wc-gradients.js',
			array('colorthief'),
			filemtime(get_template_directory() . '/js/ludlit-wc-gradients.js')
		);
	}
}

// register a custom menu to be replaced by custom search? TODO
add_action('init', 'ludlit_wc_register_search_menu_location');
function ludlit_wc_register_search_menu_location() {
	register_nav_menus(
		array(
			'ludlit_wc-search_menu-location' => 'Ludlit WC Search Menu Location'
		)
	);
}

function ludlit_wc_create_menus() {
	wp_create_nav_menu('LudLit WC Search Menu');
	wp_create_nav_menu('LudLit WC Icon Menu');
}
add_action('after_setup_theme', 'ludlit_wc_create_menus');


?>