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


add_action('wp_head', 'newlitGoogleAnalytics');
function newlitGoogleAnalytics() {

	$localhost = array('127.0.0.1', '::1');

	if (in_array($_SERVER['REMOTE_ADDR'], $localhost)) {
		return;
	}
	
	if (is_user_logged_in()) {
		$userdata = get_userdata(get_current_user_id());
		if (in_array('administrator', $userdata->roles))  {
			return;
		}
	}
?>
<!--<script type="text/plain" class="cc-onconsent-analytics">-->
<script type="text/javascript" class="not-cc-onconsent-analytics">
	(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
		(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
		m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
	})(window,document,'script','//www.google-analytics.com/analytics.js','ga');

	ga('create', 'UA-22395392-2', 'auto');
	ga('send', 'pageview');

</script>
<?php
}


?>