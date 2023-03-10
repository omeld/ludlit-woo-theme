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
?>