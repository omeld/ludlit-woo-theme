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


?>