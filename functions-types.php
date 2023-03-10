<?php
add_action('init', 'newlit_post_types' );
add_action('init', 'newlit_custom_type_tax');

function newlit_post_types() {



	register_post_type('avtor',
		array(
			'labels' => array(
				'name' => __('avtorji'),
				'singular_name' => __('avtor')
			),
		'public' => true,
		'has_archive' => 'avtorji',
	    'capability_type' => 'post',
		'rewrite' => array('slug' => 'avtor'),
	    'supports' => array(
			'title', 'editor', 'thumbnail', 'custom-fields', 'excerpt'
			)
		)
	);


	register_post_type( 'revija',
		array(
			'labels' => array(
				'name' => __('revije'),
				'singular_name' => __('revija'),
			),
		'taxonomies' => array('category', 'post_tag'),
		'public' => true,
		'has_archive' => 'revija',
	    'capability_type' => 'post',
		'rewrite' => array('slug' => 'revija'),
	    'supports' => array(
			'title', 'editor', 'thumbnail', 'custom-fields', 'excerpt'
			)
		)
	);
	register_post_type( 'obvestilo',
		array(
			'labels' => array(
				'name' => __('Obvestila'),
				'singular_name' => __('Obvestilo'),
				'taxonomies' => array('category', 'post_tag')
			),
		'public' => true,
		'has_archive' => 'obvestila',
	    'capability_type' => 'post',
		'rewrite' => array('slug' => 'obvestilo'),
	    'supports' => array(
			'title', 'editor', 'thumbnail', 'custom-fields', 'excerpt'
			)
		)
	);
	register_post_type( 'newlit_special',
		array(
			'labels' => array(
				'name' => __('Posebno'),
				'singular_name' => __('Posebno'),
				'taxonomies' => array('special_cat', 'special_tag')
			),
		'public' => true,
		//'has_archive' => 'obvestila',
	    'capability_type' => 'post',
		'rewrite' => array('slug' => 'drugo'),
	    'supports' => array(
			'title', 'editor', 'thumbnail', 'custom-fields', 'excerpt'
			)
		)
	);
	register_post_type( 'newlit_proceedings',
		array(
			'labels' => array(
				'name' => __('Zapisniki'),
				'singular_name' => __('Zapisnik'),
			),
		'public' => true,
		'exclude_from_search' => true,
		'has_archive' => 'zapisniki',
	    'capability_type' => 'post',
		'rewrite' => array('slug' => 'zapisnik'),
	    'supports' => array(
			'title', 'editor', 'excerpt', 'custom-fields'
			)
		)
	);
	register_post_type('newlit_svezenj',
		array(
			'labels' => array(
				'name' => 'svežnji',
				'singular_name' => 'sveženj',
				'taxonomies' => array('category', 'post_tag', 'tematike')
			),
		'public' => true,
		'has_archive' => 'sveznji',
		'capability_type' => 'post',
		'rewrite' => array('slug' => 'svezenj'),
	    'supports' => array(
			'title', 'editor', 'thumbnail', 'custom-fields', 'excerpt'
			)
		)
	);
}

function newlit_custom_type_tax() {

	register_taxonomy('book_cat', 
	array('knjiga', 'product'), // dodal za woocommerce povsod, kjer je post_type vseboval knjiga andrej2022
		array(
			'show_in_rest' => true, // za wordpress 5 (gutenberg)!
			'label' => 'book category',
			'hierarchical' => true,
			'rewrite' => array(
				'slug' => 'zvrst'
			)
		)
	);
	register_taxonomy('special_cat', 'newlit_special', 
		array(
			'show_in_rest' => true, // za wordpress 5 (gutenberg)!
			'label' => 'special cat',
			'hierarchical' => true
		)
	);
	register_taxonomy('special_tag', 'newlit_special',
		array(
			'show_in_rest' => true, // za wordpress 5 (gutenberg)!
			'label' => 'special tag',
			'hierarchical' => false,
			'update_count_callback' => '_update_post_term_count'
		)
	);

	/*
	$labels = array(
		'name' => 'tematike',
		'singular_name' => 'tematika',
		'all_items' => 'vse tematike',
		'parent_item' => 'nadrejena tematika',
		'add_new_item' => 'dodaj tematika',
		'menu_name' => 'tematike'
	);
	$args = array(
		'hierarchical' => true,
		'labels' => $labels,
		'show_ui' => true,
		'show_admin_column' => false,
		'query_var' => true,
		'rewrite' => array('slug' => 'svezenj'),
		'show_in_rest' => true // za wordpress 5 (gutenberg)!
	);
	 */
	register_taxonomy(
		'tematike', 
		array(
			'post', 'newlit_svezenj'
		), 
		array(
			'hierarchical' => true,
			'labels' => array(
				'name' => 'tematike',
				'singular_name' => 'tematika',
				'all_items' => 'vse tematike',
				'parent_item' => 'nadrejena tematika',
				'add_new_item' => 'dodaj tematika',
				'menu_name' => 'tematike'
			),
			'show_ui' => true,
			'show_admin_column' => false,
			'query_var' => true,
			'rewrite' => array('slug' => 'svezenj'),
			'show_in_rest' => true // za wordpress 5 (gutenberg)!
		)
	);
	/*register_taxonomy(
		'foobar', 
		array(
			'post'
		), 
		array(
			'hierarchical' => false,
			'labels' => array(
				'name' => 'foobar',
				'singular_name' => 'foobar',
				'all_items' => 'all',
				'add_new_item' => 'dodaj foobar',
				'menu_name' => 'foobar'
			),
			'show_ui' => true,
			'show_admin_column' => false,
			'query_var' => true,
			'rewrite' => array('slug' => 'foobar'),
			'show_in_rest' => true // za wordpress 5 (gutenberg)!
		)
	);*/
	register_taxonomy(
		'drugo_ime', 
		array(
			'knjiga', 'post', 'product'
		), 
		array(
			'hierarchical' => false,
			'labels' => array(
				'name' => 'drugo ime',
				'singular_name' => 'drugo ime',
				'all_items' => 'vsa druga imena',
				'add_new_item' => 'dodaj drugo ime',
				'menu_name' => 'druga imena'
			),
			'show_ui' => true,
			'show_admin_column' => false,
			'query_var' => true,
			'rewrite' => array('slug' => 'druga-imena'),
			'show_in_rest' => true // za wordpress 5 (gutenberg)!
		)
	);
	register_taxonomy(
		'ime_avtorja', 
		array(
			'knjiga', 'avtor', 'post', 'page', 'product'
		), 
		array(
			'hierarchical' => false,
			'labels' => array(
				'name' => 'ime avtorja',
				'singular_name' => 'ime avtorja',
				'all_items' => 'vsa imena avtorjev',
				'add_new_item' => 'dodaj ime avtorja',
				'menu_name' => 'imena avtorjev'
			),
			'show_ui' => true,
			'show_admin_column' => false,
			'query_var' => true,
			'rewrite' => array('slug' => 'imena-avtorjev'),
			'show_in_rest' => true // za wordpress 5 (gutenberg)!
		)
	);
	register_taxonomy(
		'prevajalec', 
		array(
			'knjiga', 'avtor', 'product'
		), 
		array(
			'hierarchical' => false,
			'labels' => array(
				'name' => 'prevajalec',
				'singular_name' => 'prevajalec',
				'all_items' => 'vsi prevajalci',
				'add_new_item' => 'dodaj prevajalca',
				'menu_name' => 'prevajalci'
			),
			'show_ui' => true,
			'show_admin_column' => false,
			'query_var' => true,
			'rewrite' => array('slug' => 'prevajalec'),
			'show_in_rest' => true // za wordpress 5 (gutenberg)!
		)
	);
	register_taxonomy(
		'zbirka', 
		array(
			'knjiga', 'product'
		), 
		array(
			'hierarchical' => false,
			'labels' => array(
				'name' => 'zbirka',
				'singular_name' => 'zbirka',
				'all_items' => 'vse zbirke',
				'add_new_item' => 'dodaj zbirko',
				'menu_name' => 'zbirke'
			),
			'show_ui' => true,
			'show_admin_column' => false,
			'query_var' => true,
			'rewrite' => array('slug' => 'zbirka'),
			'show_in_rest' => true // za wordpress 5 (gutenberg)!
		)
	);

	register_taxonomy_for_object_type('category', 'obvestilo');
	register_taxonomy_for_object_type('post_tag', 'obvestilo');
}










/*
	rewrite rules
 */

add_filter('rewrite_rules_array','my_insert_rewrite_rules_2');
add_action('wp_loaded','my_flush_rules_2');
 
// flush_rules() if our rules are not yet included
function my_flush_rules_2() {
	$rules = get_option('rewrite_rules');
	if ( 
		! isset($rules['obvestilo/(.+)/?$'])
		//or ! isset($rules['zbirke/([^/]+)/page/?([0-9]{1,})/?$'])
		//or ! isset($rules['zbirke/([^/]+)/?$'])
	) {
		global $wp_rewrite;
		$wp_rewrite->flush_rules();
	}
}
 
// Adding a new rule
function my_insert_rewrite_rules_2($rules) {
	$newrules = array();
	$newrules['obvestilo/(.+)/?$'] = 'obvestilo=$matches[1]';

	//$newrules['zbirke/([^/]+)/page/?([0-9]{1,})/?$'] = 'index.php?post_type=knjige&taxonomy=zbirka&term=$matches[1]&paged=$matches[2]';
	//$newrules['zbirke/([^/]+)/?$'] = 'index.php?post_type=knjiga&taxonomy=zbirka&term=$matches[1]';
	
	return $newrules + $rules;
}
 

/*
add_filter('query_vars', 'my_parent_cat_function' );
function my_parent_cat_function($qvars) {
	$qvars[] = 'my_parent_cat';
	return $qvars;
}
 */

function newlit_custom_adjacent_posts($dir, $id) {
	global $wpdb;

	$op = $dir == 'prev' ? '<' : '>';
    $order = $dir == 'prev' ? 'DESC' : 'ASC';

	//$current_post_date = $post->post_date;
	$current_post_date = get_post_time('U', true, $id);

	$category = get_the_terms($post->ID, 'special_cat');
	$child = 0;
	foreach ($category as $c) {
		if ($c->parent == 0) {
		} else {
			$child = $c;
		}
	}

	$terms = get_term($child, 'special_cat');
	$child_cat = $terms->name;
	
	
	$query = "
		SELECT * 
			FROM 
				$wpdb->posts as p
					INNER JOIN wp_2_term_relationships AS tr ON p.ID=tr.object_id
					INNER JOIN wp_2_term_taxonomy AS tt ON tr.term_taxonomy_id = tt.term_taxonomy_id
					INNER JOIN wp_2_terms AS t ON tt.term_id = t.term_id
			WHERE 1=1
				AND tt.taxonomy = 'special_cat'
				AND p.post_type = 'newlit_special'
				AND p.post_status = 'publish'
				AND t.name = '" . $child_cat . "'
				AND unix_timestamp(p.post_date) $op " . $current_post_date . "
			ORDER BY
				p.post_date $order
			LIMIT
				1
		";

	$myAdjacentPost = $wpdb->get_results($query);
	if ($wpdb->num_rows > 0) {
		foreach ($myAdjacentPost as $post): setup_postdata($post);
			return $post->ID;
		endforeach;
	} else {
		return false;
	}
		
}

?>
