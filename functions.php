<?php

require_once('functions-meta.php');
include('functions-test.php');
include('functions-types.php');
require_once('functions-image-sizes.php');

// 2023 additions
require_once('ludlit_wc_new.php');

setlocale(LC_ALL, 'sl_SI');

remove_action('wp_head', 'print_emoji_detection_script', 7);
remove_action('wp_print_styles', 'print_emoji_styles');

add_action('after_setup_theme', 'newlit_remove_admin_bar');
//create_function is deprecated
//add_filter( 'wp_default_editor', create_function('', 'return "tinymce";') );
add_filter( 'wp_default_editor', function() {
	return 'tinymce';
});
  

//andrej2022
//general style
function mainStyleCss() {
	$myMainCssHandle = 'style.css';
	$myMainCssFilePath = __DIR__ . '/' . $myMainCssHandle;
	$myMainCssFile = get_template_directory_uri() . "/$myMainCssHandle";
	wp_enqueue_style(
		'newlit-style', 
		$myMainCssFile,
		array(), 
		filemtime($myMainCssFilePath), //so browsers update it automatically
		false
	);
}
add_action('wp_enqueue_scripts', 'mainStyleCss');


function newlit_remove_admin_bar() {
	if (!current_user_can('administrator') && !is_admin()) {
		show_admin_bar(false);
	}
}

add_action('init', 'newlit_add_excerpts_to_pages');
function newlit_add_excerpts_to_pages() {
	add_post_type_support('page', 'excerpt');
}


add_filter('registration_redirect', 'newlit_return_after_registration');
function newlit_return_after_registration($redirect) {
	if (isset($_SERVER['HTTP_REFERER']) && strlen($_SERVER['HTTP_REFERER']) != 0) {
		$redirect = esc_url($_SERVER['HTTP_REFERER']);
	}
	return $redirect;
}

/* single templates per category */
add_filter('single_template', 'singleCategoryTemplate');
function singleCategoryTemplate($template) {
	if (is_singular('post')) {
		foreach ((array)get_the_category() as $cat) {
			if (file_exists(TEMPLATEPATH . "/single-{$cat->slug}.php"))
				return TEMPLATEPATH . "/single-{$cat->slug}.php"; 
			
			if ($cat->parent) {
				$cat = get_the_category_by_ID($cat->parent);
				if (file_exists(TEMPLATEPATH . "/single-{$cat->slug}.php"))
					return TEMPLATEPATH . "/single-{$cat->slug}.php"; 
			}
		}
	}
	return $template;
}

/* begin custom taxonomy */
/*
function my_add_feature_tax() {
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
	register_taxonomy('tematike', array('post', 'newlit_svezenj'), $args);
}
add_action('init', 'my_add_feature_tax');
 */

/* end custom taxonomy */

/* Removing private prefix from post titles */ 
function spi_remove_private_protected_from_titles($format) {
	return '%s';
}
add_filter('private_title_format', 'spi_remove_private_protected_from_titles');

/* rss */

add_action('rss2_item', 'newlit_rss_item');
function newlit_rss_item() {
	global $post;
	$featuredImg = array();

	if (has_post_thumbnail($post->ID)) {
		$featuredImg['src'] = wp_get_attachment_url(get_post_thumbnail_id($post->ID));
		$featuredImg['file'] = get_attached_file(get_post_thumbnail_id($post->ID));
		$featuredImg['mime'] = get_post_mime_type(get_post_thumbnail_id($post->ID));
	} else {
		$featuredImg = newlit_get_author_photo();
	}
	
	if (!empty($featuredImg)) {
		echo "<enclosure url='$featuredImg[src]' length='" . filesize($featuredImg['file']) . "' type='$featuredImg[mime]' />";
	}
}

add_filter('pre_get_posts', 'newlit_rss_pre_get_posts');
function newlit_rss_pre_get_posts($query) {
	if ($query->is_feed) {
		$query->set('cat', '-3902'); //hlapljivo!
	}
	return $query;
}

add_action('rss2_ns', 'newlit_rss_ns');
function newlit_rss_ns() {
	echo 'xmlns:ical="http://www.w3.org/2002/12/cal/icaltzd#"' . "\n";
}

add_action('rss2_item', 'newlit_rss_item_events');
function newlit_rss_item_events() {
	if (! tribe_is_event()) return;
	$event_start = tribe_get_start_date(null, true, 'r');
	$event_end = tribe_get_end_date(null, true, 'r');
	$event_venue = tribe_get_venue();
	echo "<ical:dtstart>$event_start</ical:dtstart>";
	echo "<ical:dtend>$event_end</ical:dtend>";
	echo "<ical:location>" . html_entity_decode($event_venue, ENT_COMPAT, 'utf-8') . "</ical:location>";
}

/* *** /

/* registration form quiz! */

add_action('register_form', 'newlit_register_form_add_field');
function newlit_register_form_add_field() {
	$newlit_register_quiz = (! empty($_POST['newlit_register_quiz'])) ? trim($_POST['newlit_register_quiz']) : '';
	$newlit_register_quiz = '';
?>
<p>
	<label for="newlit_register_quiz">Preverjanje pristnosti: vpiši ime ene izmed Literaturinih knjižnih zbirk<br />
		<input type="text" name="newlit_register_quiz" id="newlit_register_quiz" class="input" value="<?php echo esc_attr(wp_unslash($newlit_register_quiz)); ?>" size="25" />
	</label>
</p>
<p><b>Z registracijo potrjujete, da se strinjate s <a href="http://www.ludliteratura.si/?p=52479">pogoji uporabe</a>.</b></p><br>
<?php
}

add_filter('registration_errors', 'newlit_registration_errors', 10, 3);
function newlit_registration_errors($errors, $sanitized_user_login, $user_email) {
	$user_input = trim($_POST['newlit_register_quiz']);
	if (! empty($user_input)) {
		$answers = array('Prišleki', 'Novi pristopi', 'Labirinti', 'Stopinje');
		//if (str_ireplace($answers, '', $user_input) == $user_input) {
		if (! preg_match('/(Prišleki)|(Novi pristopi)|(Labirinti)|(Stopinje)/i', $user_input)) {
			$errors->add('register_quiz_error', '<strong>NAPAKA</strong>: Vpiši veljavno ime zbirke<br>'. "$user_input");
		}
	} else {
		$errors->add('register_quiz_error', '<strong>NAPAKA</strong>: Vpiši veljavno ime zbirke');
	}
	return $errors;
}

add_action('user_register', 'newlit_user_register');
function newlit_user_register($user_id) {
	update_user_meta($user_id, 'newlit_registration_date', time());
	update_user_meta($user_id, 'newlit_registration_check', 0);
}


/* end registration form quiz! */

/* store last login date: used to automatically (cron?) delete fake users who haven't logged in in X days */

function newlit_user_last_login($user_login, $user) {
    update_user_meta($user->ID, 'newlit_last_login', time());
}
add_action('wp_login', 'newlit_user_last_login', 10, 2);

/*
add_filter('wp_mail_from', 'newlit_wp_mail_from');
function newlit_wp_mail_from($original_email_address) {
	return 'andrej.hocevar@ludliteratura.si';
}
 */


//add_action('user_register', 'newlit_new_user', 10, 1);
function newlit_new_user($user_id) {
	if (isset($_POST['user_email'])) {
		$to = 'omeldoid@gmail.com';
		$subject = 'testni podatki';
		$body = "Živjo, testiram\n\n" . var_export($_POST, true);
		//wp_mail($to, $subject, $body);
		//TODO: simpl. prijavi na listo!
	}
}

function newlit_replace_quotes($content) {
	$match = array(
		"/‘((?:[^‘]*’)*[^‘]*)’/", //fixed via stackoverflow :-)
		"/  +/", // ne dela, ker spodaj spremenimo v nbsp; eno ali drugo!!! :-((
		"/ ([–…])/"
	);
	$replace = array(
		"›$1‹",
		" ",
		'&nbsp;${1}'
	);
	$content = preg_replace($match, $replace, $content);
	$content = str_replace(array('“', '”', '...'), array('»', '«', '…'), $content);
	return $content;
}
add_filter('content_save_pre', 'newlit_replace_quotes', 10, 1 );


function newlit_nicer_title($title) {
	$match = array(
		"/\b(v|in|ter|po|nad|s|z|pri|ob|pod|pred|brez|iz|na|za|h|k|čez|skozi|pri|o) /",
		"/ ([–…])/"
	);
	$replace = array(
		'${1}&nbsp;',
		'&nbsp;${1}'
	);
	$title = preg_replace($match, $replace, $title);
	return $title;
}
add_filter('the_title', 'newlit_nicer_title', 10, 2);

function newlit_nbsp_in_tinymce($mceInit) {
	$mceInit['entities'] = $mceInit['entities'] .'160,nbsp';   
    $mceInit['entity_encoding'] = 'named';
    return $mceInit;
}
add_filter('tiny_mce_before_init', 'newlit_nbsp_in_tinymce', 20);



/*
	poskus, kako izločiti neko kategorijo POVSOD!
 */

function newlit_exclude_cat($query) {
	global $WP_Query;
	if (! is_admin()) {
		//odvisno od tega, kako dejansko pokličeš posamezno zahtevo :-(
		//set_query_var('cat', '3963');
		//set_query_var('posts_per_page', '1');
		/*
		$tax_query = array(
			array(
				'taxonomy' => 'category',
				'terms' => array(3963),
				'field' => 'id',
				'operator' => 'IN'
			)
		);
		$query->set('tax_query', $tax_query);
		 */
	}
}
add_action('pre_get_posts', 'newlit_exclude_cat');

/*
	tole je potrebno za paginacijo!!!
	sicer se posts_per_page ne nastavi pravilno
	preko vmesnika je nastavljeno na 10, kar je preveč in zato zmanjka pri zadnjem
	lahko bi spremenil tudi tam, recimo na 1 (važno, da je manj od želenega)
 */
add_action('pre_get_posts', 'newlit_set_custom_posts_per_page', 1);
function newlit_set_custom_posts_per_page($query) {
	if (isset($query->query_vars['my_dont_use_post_count_filter'])) {
		return;
	} elseif (is_tax('zbirka')) {
		$query->set('posts_per_page', 9);
		return;
	} elseif (is_category()) {
		$query->set('posts_per_page', 18);
		return;
	//} elseif (is_home() && $query->is_main_query()) {
	} elseif (is_home()) {
		$query->set('posts_per_page', 18);
		return;
	}
}

function newlit_get_author_photo($args = '') {
	global $post;
	
	$authorPhoto = array();

	$pid		= (isset($args['pid'])	? $args['pid']	: $post->ID);
	$size		= (isset($args['size'])	? $args['size']	: 'Medium');

	//use other name if present (mostly for interviews?
	//kratka verzija na ljudmili ne dela!!!
	/*
	$_slug = array_shift(wp_get_post_terms($pid, "drugo_ime", array('fields' => 'slugs')));
	$nameSlug = (isset($args['name']) ? $args['name'] :
		//(!empty($_slug = array_shift(wp_get_post_terms($pid, "drugo_ime", array('fields' => 'slugs')))) ? $_slug : array_shift(wp_get_post_terms($pid, "ime_avtorja", array('fields' => 'slugs')))));
		(!empty($_slug) ? $_slug : array_shift(wp_get_post_terms($pid, "ime_avtorja", array('fields' => 'slugs')))));
	*/

	//fix only variables should be passed by reference error
	$my_terms = wp_get_post_terms($pid, "ime_avtorja", array('fields' => 'slugs'));
	$nameSlug = isset($args['name']) 
		? $args['name'] 
		: (!empty($_slug) 
			? $_slug 
			: array_shift($my_terms)
		);
		

	$_args = array(
		'post_status' => 'publish',
		'post_type' => 'avtor',
		'posts_per_page' => 1,
		'tax_query' => array(
			array(
				'taxonomy' => 'ime_avtorja',
				'field' => 'slug',
				'terms' => $nameSlug
			)
		)
	);
	$thisAuthor = get_posts($_args);
	if ($thisAuthor) :
		foreach ($thisAuthor as $author_post) : setup_postdata($author_post);
			if (has_post_thumbnail($author_post->ID)) :
				//$authorPhoto['src'] = array_shift(wp_get_attachment_image_src(get_post_thumbnail_id($author_post->ID), $size));
				$attachment_image = wp_get_attachment_image_src(get_post_thumbnail_id($author_post->ID), $size);
				$authorPhoto['src'] = array_shift($attachment_image);
			else :
				return false;
			endif;
			$attachment_image = wp_get_post_terms($author_post->ID, 'ime_avtorja', array('fields' => 'names'));
			$authorPhoto['name'] = array_shift($attachment_image);
			//$authorPhoto['name'] = array_shift(wp_get_post_terms($author_post->ID, 'ime_avtorja', array('fields' => 'names')));
			$authorPhoto['file'] = get_attached_file(get_post_thumbnail_id($author_post->ID));
			$authorPhoto['mime'] = get_post_mime_type(get_post_thumbnail_id($author_post->ID));
		endforeach;
	endif;
	wp_reset_postdata();
	return $authorPhoto;
}

add_action('wp_head', 'newlitCustomOG');
function newlitCustomOG() {
	global $post;
	global $interviewee_photo;
	global $author_photo;
	setup_postdata($post); //brez tega ne dela excerpt!!!

	echo '<meta property="og:type" content="article" />' . "\n";

	if (is_home()) {
	} else if (is_category()) {

		$thisCat['id'] = get_query_var('cat');
		$thisCat['desc'] = category_description($thisCat['id']);
		$thisCat['name'] = get_cat_name($thisCat['id']);
		$thisCat['url'] = get_category_link($thisCat['id']);

		echo '<meta property="og:url" content="' . $thisCat['url'] . '" />' . "\n";
		
		if (empty($thisCat['desc'])) {
			echo '<meta property="og:description" content="' . strip_tags($thisCat['name']) . '" />' . "\n";
		} else {
			echo '<meta property="og:description" content="' . strip_tags($thisCat['desc']) . '" />' . "\n";
		}

		if (function_exists('wp_get_terms_meta')) { 
			$metaValue = wp_get_terms_meta($thisCat['id'], "categoryimage" ,true); 
			if (!empty($metaValue)) {
				echo '<meta property="og:image" content="' . $metaValue . '" />' . "\n";
			} else {
				echo '<meta property="og:image" content="http://www.ludliteratura.si/wp-content/uploads/2012/12/lud-literatura-logo.jpg" />' . "\n";
			}
		} else {
			echo '<meta property="og:image" content="http://www.ludliteratura.si/wp-content/uploads/2012/12/lud-literatura-logo.jpg" />' . "\n";
		}

		echo '<meta property="og:title" content="' . get_cat_name(get_query_var('cat')) . ' • www.ludliteratura.si' . '" />' . "\n";
	} else { //else if (is_single()) …
		echo '<meta property="og:url" content="' . get_permalink() . '" />' . "\n";
		echo '<meta property="og:title" content="' . the_title_attribute('echo=0') . ' • www.ludliteratura.si' . '" />' . "\n";
		remove_filter('excerpt_more', 'new_excerpt_more');
		echo '<meta property="og:description" content="' . strip_tags(get_the_excerpt()) . '" />' . "\n";
		add_filter('excerpt_more', 'new_excerpt_more');

		//$author_photo = newlit_get_author_photo();

		if (! has_post_thumbnail($post->ID)) {
			/*
			//fix only variables should be passed by reference error
			$intervieweeName = array_shift(wp_get_post_terms($post->ID, "drugo_ime", array('fields' => 'slugs')));
			*/
			$my_terms = wp_get_post_terms($post->ID, "drugo_ime", array('fields' => 'slugs'));
			$intervieweeName = !empty($my_terms)
  				? array_shift($my_terms)
  				: '';

			if (!empty($intervieweeName)) {
				if (($interviewee_photo = newlit_get_author_photo(array('name' => $intervieweeName))) !== false) {
					echo '<meta property="og:image" content="' . $interviewee_photo['src'] . '" />' . "\n";
					return;
				}
			} elseif (($meta_featured_image = get_post_meta($post->ID, 'my-custom-featured-image', true)) != false) {
				echo '<meta property="og:image" content="' . $meta_featured_image . '" />' . "\n";

			} elseif (($author_photo = newlit_get_author_photo()) !== false) {
				// fix src not set?
				//echo '<meta property="og:image" content="' . $author_photo['src'] . '" />' . "\n";
				if (isset($author_photo['src'])) {
					echo '<meta property="og:image" content="' . $author_photo['src'] . '" />' . "\n";
				}
				return;
			} else {
				//default
				echo '<meta property="og:image" content="http://www.ludliteratura.si/wp-content/uploads/2012/12/lud-literatura-logo.jpg" />' . "\n";
			}
		} else {
			echo '<meta property="og:image" content="' . wp_get_attachment_url(get_post_thumbnail_id($post->ID)) . '" />' . "\n";
			return;
		}
	}
}

add_action('wp_head', 'newlitAddMetaDesc');
function newlitAddMetaDesc() {
	if (is_single()) {
		global $post;
		setup_postdata($post); //brez tega ne dela excerpt!!!
		remove_filter('excerpt_more', 'new_excerpt_more');
		echo '<meta name="description" content="' . strip_tags(get_the_excerpt()) . '" />' . "\n";
		add_filter('excerpt_more', 'new_excerpt_more');
	} else {
		echo '<meta name="description" content="LUD Literatura je literarno-umetniško društvo, ki skrbi za literarno kulturo. Izdaja revijo Literatura in ima obsežen knjižni program.">';
	}
}

add_action('wp_head', 'newlitFacebookPixel');
function newlitFacebookPixel() {
	if (
		$_SERVER['SERVER_NAME'] != 'localhost'
		and $_SERVER['SERVER_NAME'] != 'sonet'
		and $_SERVER['SERVER_NAME'] != 'jezr'
	) {
?>
<!-- Facebook Pixel Code -->
<script>
  !function(f,b,e,v,n,t,s)
  {if(f.fbq)return;n=f.fbq=function(){n.callMethod?
  n.callMethod.apply(n,arguments):n.queue.push(arguments)};
  if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
  n.queue=[];t=b.createElement(e);t.async=!0;
  t.src=v;s=b.getElementsByTagName(e)[0];
  s.parentNode.insertBefore(t,s)}(window, document,'script',
  'https://connect.facebook.net/en_US/fbevents.js');
  fbq('init', '2401150009896139');
  fbq('track', 'PageView');
</script>
<noscript><img height="1" width="1" style="display:none"
  src="https://www.facebook.com/tr?id=2401150009896139&ev=PageView&noscript=1"
/></noscript>
<!-- End Facebook Pixel Code -->
<?php
	}
}
add_action('wp_head', 'newlitMailchimp');
function newlitMailchimp() {
	if (
		$_SERVER['SERVER_NAME'] != 'localhost'
		and $_SERVER['SERVER_NAME'] != 'sonet'
		and $_SERVER['SERVER_NAME'] != 'jezr'
	) {
		if (is_user_logged_in()) {
			$userdata = get_userdata(get_current_user_id());
			if (in_array('administrator', $userdata->roles))  {
				return;
			}
		}
?>
<script id="mcjs">!function(c,h,i,m,p){m=c.createElement(h),p=c.getElementsByTagName(h)[0],m.async=1,m.src=i,p.parentNode.insertBefore(m,p)}(document,"script","https://chimpstatic.com/mcjs-connected/js/users/372ad152b7eae215b71282dee/5b7878862050bf46395f324a5.js");</script>
<?php
	}
}

function myAuthorsRecentPosts($off, $num, $nameSlug, $el="h4") {
	global $post;
	global $thisPostID;
	global $wp_query;

	$myPostCount = 0;

	//$excludeID = $post->ID;
	$excludeID = $thisPostID;

	$myAddClass = "verticalMiddle";

	$args = array(
		'offset' => $off,
		'posts_per_page' => $num,
		'post_status' => 'publish',
		'post_type' => 'post',
		'post__not_in' => array($excludeID),
		'category__not_in' => array(3902),	
		'tax_query' => array(
			array(
				'taxonomy' => 'ime_avtorja',
				'field' => 'slug',
				'terms' => $nameSlug
			)
		)
		
	);

	$myPosts = get_posts($args);
	if ($myPosts) :
		$myPostCount = count($myPosts);
?>
	<h6 class="widgettitle font-size-1">Avtorjevi <?php echo ($myPostCount >= $num ? "novejši" : ""); ?> prispevki</h6>
	<ul class="recentArticles clearfix true-liquid-block-outer">
<?php foreach($myPosts as $post) : setup_postdata($post);?>

<?php	$contributor = wp_get_post_terms($post->ID, "ime_avtorja", array("count" => 1)); ?>
<?php	$contributorName = $contributor[0]->name; ?>
<?php
	$myCatList = array();
	$category = get_the_category();
	foreach ($category as $ctg) :
		if (($ctg->name == "izpostavljeno") or
			($ctg->name == "novo")) {
				continue;
		}
		$myCatList[] = $ctg->name;
	endforeach;
?>

		<li class="one-three true-liquid-block-inner">
			<div class="myPostItem">
			<div class="relatedArticlesDesc">
				<<?php echo $el; ?> class="related-title no-indent">
					<a href="<?php the_permalink() ?>" title="<?php the_title_attribute(); ?>">
						<?php the_title(); ?>
					</a>
				</<?php echo $el; ?>>
<?php
	#echo '<br>' . implode(' | ', $myCatList);
	echo '<p class="recentCatList no-indent">(' . "$myCatList[0]" . ')</p>';
?>
			</div>
			</div>
		</li>
<?php endforeach; wp_reset_postdata();?>
	</ul>
<?php if ($myPostCount >= $num) : ?>
<?php $myLink = home_url("/imena-avtorjev/" . $nameSlug); ?>
	<p style="text-align: right"><a class="" href="<?php echo $myLink;?>" title="<?php echo $contributorName; ?> – vsi prispevki">vsi avtorjevi prispevki</a></p>
<?php endif; ?>
<?php
	endif;
	
}

function myMagazineNavigation($dir) {
	global $thisPostID;
	global $wpdb;

	$op = $dir == 'prev' ? '<' : '>';
    $order = $dir == 'prev' ? 'DESC' : 'ASC';

	$current = get_post_meta($thisPostID, 'newlit-revija-new-stevilka', true);

	$query = "
		SELECT * 
			FROM 
				$wpdb->posts as p
					INNER JOIN wp_2_postmeta AS m ON m.post_id = p.ID
			WHERE 1=1
				AND p.post_type = 'revija'
				AND p.post_status = 'publish'
				AND m.meta_key = 'newlit-revija-new-stevilka'
				AND m.meta_value + 0 $op '$current' + 0
			ORDER BY
				m.meta_value + 0 $order
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

function _myRecentMagazines($num = 10, $off = 0) {
	global $thisPostID;
	global $post;
	$i = 0;
	$recentMagazines = array();

	$args = array(
		'post_status' => 'publish',
		'post_type' => 'revija',
		'offset' => $off,
		'post__not_in' => array($thisPostID),
		'orderby' => 'meta_value_num',
		'posts_per_page' => $num,
		'meta_key' => 'newlit-revija-new-stevilka'
	);
	$magazines = new WP_Query($args);
	if ($magazines->have_posts()) {
		while ($magazines->have_posts()) : $magazines->the_post();
			$recentMagazines[] = $post;
		endwhile;
	}
	return $recentMagazines;
}
function myRecentMagazines($num = 10, $off = 0) {
	//global $post;
	//global $wp_query, $post;
	global $thisPostID;
	$i = 0;

	$args = array(
		'post_status' => 'publish',
		'post_type' => 'revija',
		'offset' => $off,
		'post__not_in' => array($thisPostID),
		'orderby' => 'meta_value_num',
		'posts_per_page' => $num,
		'meta_key' => 'newlit-revija-new-stevilka'
	);
	$magazines = new WP_Query($args);
?>
<div class="clearfix row">
	<ul id="recent-magazines">
<?php while ($magazines->have_posts()) : $magazines->the_post(); ++$i; ?>
<?php $link = get_permalink(); ?>
		<li class="oneCol float <? if (($i % 5) != 0) { echo "hasRightMargin"; } ?>">
			<p>
				<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>" ><?php the_title(); ?></a>
<?php if (has_post_thumbnail($post->ID)) : ?>
				<a class="" href="<?php echo the_permalink(); ?>" title="<?php the_title_attribute(); ?>" >
<?php the_post_thumbnail('myOneColThumb', array('class' => 'roundBorders', 'alt' => trim(strip_tags(get_post_meta(get_post_thumbnail_id($post->ID), '_wp_attachment_image_alt', true))))); ?>
				</a>
<?php	endif; ?>
			</p>
		</li>
<?php	if (($i % 5) == 0) { ?>
<li class="clearfix hasBottomMargin"></li>
<?php 	} ?>
<?php endwhile; ?>
	</ul>
</div>

<?php		

		
}
function myRecentPosts($off, $num, $el="h4", $slide=false) {
	global $post;
	global $thisPostID;
	global $wp_query;

	//$excludeID = $post->ID;
	$excludeID = $thisPostID;

	$myIterator = 0;

	$myAddClass = "verticalMiddle";

	$args = array(
		'offset' => $off,
		'posts_per_page' => $num,
		'post__not_in' => array($excludeID),
		'category__not_in' => array(3902, 3846)		
	);
	$myPosts = get_posts($args);

?>



	<div class="<?php echo ($slide ? 'flexslider' : ''); ?>">
<ul class="slides">
<?php foreach($myPosts as $post) : setup_postdata($post); ?>
<?php if (($myIterator % 5) == 0) { ?>
	<li>
	<ul class="recentArticles">
<?php } ?>
<?php	$contributor = wp_get_post_terms($post->ID, "ime_avtorja", array("count" => 1)); ?>
<?php	$contributorName = $contributor[0]->name; ?>
<?php	$nameSlug = $contributor[0]->slug; ?>

<?php
	$myCatList = array();
	$category = get_the_category();
	foreach ($category as $ctg) :
		if (($ctg->name == "izpostavljeno") or
			($ctg->name == "novo")) {
				continue;
		}
		$myCatList[] = $ctg->name;
	endforeach;
?>
		<li>
			<div class="relatedArticlesThumb">
			<?php if (has_post_thumbnail()) : ?>
			<?php
			$img_id = get_post_thumbnail_id($post->ID);
			$alt_text = get_post_meta($img_id , '_wp_attachment_image_alt', true);
			?>
				<a class="bare" href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>" >
	<?php		the_post_thumbnail('myOneColSquare',
					array(
						'class'	=> $myAddClass,
						'alt'	=> $alt_text
					)); ?>
				</a>
			<?php endif; ?>
			</div>
			<div class="relatedArticlesDesc">
				<<?php echo $el; ?>>
					<a href="<?php the_permalink() ?>" title="<?php the_title_attribute(); ?>">
						<?php the_title(); ?>
					</a>
<?php
	if (isset($contributorName) and !(empty($contributorName))) :
		$myLink = home_url("/imena-avtorjev/" . $nameSlug);
?>
			(<b><a href="<?php echo $myLink;?>" title="<?php echo $contributorName; ?> – vsi prispevki"><?php echo $contributorName;?></b></a>)
<?php
	endif; 
?>
				</<?php echo $el; ?>>
<?php
	#echo '<br>' . implode(' | ', $myCatList);
	echo '<br><span class="recentCatList">' . "$myCatList[0]" . '</span>';
?>
			</div>
		</li>
<?php if ((($myIterator % 5) == 4)) { ?>
</ul>
</li>
<?php } ?>
<?php $myIterator++; ?>
<?php endforeach; wp_reset_postdata();?>
</ul>
</div>
<?php
	
}

/* ------------------------- */

add_action( 'init', 'register_my_menus' );
function register_my_menus() {
	register_nav_menu('menu_one', 'osnovni meni');
	register_nav_menu('menu_social', 'menu za socialna omrezja');
	register_nav_menu('menu-footer', 'meni na dnu strani');
}

if ( function_exists('register_sidebars') )
    register_sidebars(10);

	/*function register_some_widget___narociVseRevije() {
		register_sidebar(array(
			'id' => 'newlit-narociVseRevije-widget',
			'name' => 'naroci vse revije',
			'before_title' => '<h5 class="font-size-1 align-right reset-vertical-space">',
			'after_title' => '</h5>',
			)
		);
	}
	add_action('widgets_init', 'register_some_widget___narociVseRevije');*/

	function register_some_widget___iskanjesitewide() {
		register_sidebar(array(
			'id' => 'newlit-iskanjesitewide-widget',
			'name' => 'sitewide iskanje',
			'before_title' => '<h5 class="font-size-1 align-left reset-vertical-space">',
			'after_title' => '</h5>'
			)
		);
	}
	add_action('widgets_init', 'register_some_widget___iskanjesitewide');


	function register_some_widget___narociRevijo() {
		register_sidebar(array(
			'id' => 'newlit-narociRevijo-widget',
			'name' => 'naroci revijo',
			'before_title' => '<h5 class="font-size-1 align-left reset-vertical-space">',
			'after_title' => '</h5>',
			'before_widget' => '--><li id="%1$s" class="widget %2$s font-size-1 one-two true-liquid-block-inner">',
			'after_widget'  => '</li><!--'
			)
		);
	}
	add_action('widgets_init', 'register_some_widget___narociRevijo');

	function register_some_widget___social() {
		register_sidebar(array(
			'id' => 'newlit-social-widget',
			'name' => 'Socialna omrezja',
			'before_title' => '<h5 class="font-size-1 align-right reset-vertical-space">',
			'after_title' => '</h5>',
			)
		);
	}
	add_action('widgets_init', 'register_some_widget___social');

function register_some_widget___search() {
	register_sidebar(array(
		'id' => 'newlit-search-widget',
		'name' => 'Iskanje',
		'before_title' => '<h5 class="font-size-1 align-left reset-vertical-space">',
		'after_title' => '</h5>',
		'before_widget' => '--><li id="%1$s" class="widget %2$s font-size-1 one-two true-liquid-block-inner">',
		'after_widget'  => '</li><!--'
		)
	);
}
add_action('widgets_init', 'register_some_widget___search');

function register_some_widget___about() {
	register_sidebar(array(
		'id' => 'newlit-about-widget',
		'name' => 'LUD Literatura',
		'before_title' => '<h5 class="font-size-1">',
		'after_title' => '</h5>',
		'before_widget' => '--><li id="%1$s" class="lud-lit-info widget %2$s four-five font-size-1 true-liquid-block-inner">',
		'after_widget'  => '</li><!--'
		)
	);
}
add_action('widgets_init', 'register_some_widget___about');

function register_some_widget___editors() {
	register_sidebar(array(
		'id' => 'newlit-editors-widget',
		'name' => 'Uredništvo',
		'before_title' => '<h5 class="font-size-1">',
		'after_title' => '</h5>',
		'before_widget' => '--><li id="%1$s" class="widget %2$s four-five font-size-1 true-liquid-block-inner">',
		'after_widget'  => '</li><!--'
		)
	);
}
add_action('widgets_init', 'register_some_widget___editors');

function register_some_widget___archives() {
	register_sidebar(array(
		'id' => 'newlit-monthly-archives-widget',
		'name' => 'Arhiv zadnjih 24 mesecev',
		'before_title' => '<h5 class="font-size-1">',
		'after_title' => '</h5>',
		'before_widget' => '--><li id="%1$s" class="widget %2$s one-two font-size-1 true-liquid-block-inner">',
		'after_widget'  => '</li><!--'
		)
	);
}
add_action('widgets_init', 'register_some_widget___archives');

function register_some_widget___categories() {
	register_sidebar(array(
		'id' => 'newlit-categories-widget',
		'name' => 'Rubrike',
		'before_title' => '<h5 class="font-size-1">',
		'after_title' => '</h5>',
		'before_widget' => '--><li id="%1$s" class="widget %2$s font-size-1 one-two true-liquid-block-inner">',
		'after_widget'  => '</li><!--'
		)
	);
}
add_action('widgets_init', 'register_some_widget___categories');

function register_some_widget___mailman() {
	register_sidebar(array(
		'id' => 'newlit-mailman-widget',
		'name' => 'Kdor bere, je zraven! Naroči novice in obvestila po e-pošti.',
		'before_title' => '<h5 class="font-size-1 align-left reset-vertical-space">',
		'after_title' => '</h5>',
		'before_widget' => '--><li id="%1$s" class="widget %2$s font-size-1 one-two true-liquid-block-inner">',
		'after_widget'  => '</li><!--'
		)
	);
}
add_action('widgets_init', 'register_some_widget___mailman');

function exclude_widget_categories($args){
	$args["exclude"] = array(3902, 3846, 3848, 9999);
	return $args;
}
add_filter("widget_categories_args", "exclude_widget_categories");


function newlit_widget_archives( $args ) {
    $args['limit'] = 24;
    return $args;
}
add_filter( 'widget_archives_args', 'newlit_widget_archives' );



function custom_excerpt_length($length) {

	global $newlitTempCustomLength;

	if (!empty($newlitTempCustomLength) && ($newlitTempCustomLength > 0)) {
		return $newlitTempCustomLength;
	} else if (is_category() || is_tag() || is_archive() || is_page('arhiv')) {
		return 100;
	} else if (is_home()) {
		return 25;
	} else if (is_singular('knjiga')) {
		return 25;
	} else if (is_single()) {
		return 100;
	} else {
		return 25;
	}
}
add_filter( 'excerpt_length', 'custom_excerpt_length');


/*
function custom_rewrite_basic() {
  add_rewrite_rule('^category/.*ospoljene-reci', 'ospoljene-reci', 'top');
}
add_action('init', 'custom_rewrite_basic');
 */



function new_excerpt_more($more) {
	global $post, $wpdb;
	global $excerpt_show_more;
	if ($excerpt_show_more == false) {
		//return '&nbsp;[…]';
		return '&nbsp;…&nbsp;&rarr;';
	} elseif ($excerpt_show_more == 'none') {
		return '';
	} elseif (($excerpt_show_more === true) || ($excerpt_show_more == 1) || (!isset($excerpt_show_more))) {
	/*} elseif ($excerpt_show_more === true) {
	echo "<h1 style='color: red; background-color: black'>foobar true</h1>";
	} elseif ($excerpt_show_more == 1) {
	echo "<h1 style='color: red; background-color: black'>foobar 1</h1>";
	} elseif (!isset($excerpt_show_more)) {
		echo "<h1 style='color: red; background-color: black'>foobar not set</h1>";*/
		if (is_page("newsletter")) {
		//	return ' ... <a style="color: #8C281F; text-decoration: none" href="'. get_permalink($post->ID) . '">Več</a>';
		} elseif (is_single()) {
			return '&nbsp;… <a class="readMoreLink sans" href="'. get_permalink($post->ID) . '">Preberi</a>';
		} elseif (is_tax('ime_avtorja')) {
			//return ' ... <a class="readMoreLink" href="'. get_permalink($post->ID) . '">Več</a>';
		} else {
			return '&nbsp;… <a class="readMoreLink sans" href="'. get_permalink($post->ID) . '">Preberi</a>';
		}
	} else {
		return $excerpt_show_more;
	}
}
add_filter('excerpt_more', 'new_excerpt_more');


if (function_exists('add_theme_support')) { 
	add_theme_support( 'post-thumbnails' );
	//add_theme_support('post-thumbnails', array('obvescevalnik', 'post'));
	add_theme_support('post-formats', array('status', 'aside', 'quote'));
}

if (function_exists('add_post_type_support')) {
	add_post_type_support('obvescevalnik', 'post-formats' );
	add_post_type_support('post', 'post-formats' );
}


add_filter('query_vars', 'my_queryvars' );
function my_queryvars($qvars) {
	$qvars[] = 'my_dont_use_post_count_filter';
	return $qvars;
}
add_filter('query_vars', 'myissue_queryvars' );
function myissue_queryvars($qvars) {
	$qvars[] = 'myissue';
	return $qvars;
}

function filter_ptags_on_images($content){
	if (is_page("newsletter")) {
		return preg_replace('/<p>\s*(<a .*>)?\s*(<img .* \/>)\s*(<\/a>)?\s*<\/p>/iU', '\1\2\3', $content);
	}
}

add_filter('the_post_thumbnail', 'filter_ptags_on_images');

function myTitlesList($z=0) {
	global $wp_query, $post;

	if (!$z) {
		$args = array_merge(
			//$wp_query->query,
			array(
				'post_status' => 'publish',
				'posts_per_page' => -1,
				'post_type' => 'knjiga',
				'orderby' => 'title',
				'order' => 'ASC'
			)
		);
	} else {
		$args = array_merge(
			//$wp_query->query,
			array(
				'post_status' => 'publish',
				'posts_per_page' => -1,
				'post_type' => 'knjiga',
				'orderby' => 'title',
				'order' => 'ASC',
				'tax_query' => array(
					array(
						'taxonomy' => 'zbirka',
						'field' => 'slug',
						'terms' => $z
					)
				)
			)
		);
	}

	$myBookTitles = get_posts($args);
?>
<select name="myTitleSelect" id="myTitleSelect">
	<option class="truncateThis" value="">Izberi naslov</option>
<?php foreach($myBookTitles as $post) : setup_postdata($post); ?>
	<option class="truncateThis" value="<?php the_permalink() ?>"><?php echo get_the_title(); ?></option>
<?php endforeach; ?>
</select>
<script type="text/javascript">
		var dropdown_title = document.getElementById("myTitleSelect");
		function onTitleChange() {
			if (dropdown_title.options[dropdown_title.selectedIndex].value != '') {
				location.href = dropdown_title.options[dropdown_title.selectedIndex].value;		
			}	
		}	
		dropdown_title.onchange = onTitleChange;
</script>
<?php
}	
function myAuthorsList($where) {
	global $wp_query, $post;

	$args = array_merge(
		//$wp_query->query,
		array(
			'post_status' => 'publish',
			'posts_per_page' => -1,
			'post_type' => 'Avtor',
			'meta_key' => 'Priimek',
			'orderby' => 'meta_value',
			'order' => 'ASC',
			'meta_query' => array(
				array(
					'key' => 'sodelovanje',
					'value' => $where
				)
			)

		)
	);

	$myAuthorNames = get_posts($args);
?>
<select name="myAuthorSelect" id="myAuthorSelect">
	<option class="truncateThis" value="">Izberi avtorja</option>
<?php foreach($myAuthorNames as $post) : setup_postdata($post); ?>
	<option class="truncateThis" value="<?php the_permalink() ?>"><?php echo get_post_meta($post->ID, 'Priimek', 'true'); ?>, <?php echo get_post_meta($post->ID, 'Ime', 'true'); ?></option>
<?php endforeach; ?>
</select>
<script type="text/javascript">
		var dropdown_author = document.getElementById("myAuthorSelect");
		function onAuthorChange() {
			if (dropdown_author.options[dropdown_author.selectedIndex].value != '') {
				location.href = dropdown_author.options[dropdown_author.selectedIndex].value;		
			}	
		}	
		dropdown_author.onchange = onAuthorChange;
</script>
<?php
}	
function myRandomQuote($limitToSeries=false) {
	global $wp_query, $post;
	global $myRandomQuote;

	if ($limitToSeries == false) {
		$limitToSeries = "";
	}
	$args = array(
		'post_status' => 'publish',
		'post_type' => 'knjiga',
		'posts_per_page' => 3,
		'posts_per_archive_page' => 3,
		'orderby' => 'rand',
		'paged' => get_query_var('paged'),
		'meta_query' => array(
			array(
				'key' => 'citat',
				'value' => '',
				'compare' => '!='
			),
			array(
				'key' => 'zbirka',
				'value' => $limitToSeries,
				'compare' => 'LIKE'
			)
		)
	);

	//$myRandomQuote = get_posts($args);
	$myRandomQuote = new WP_Query($args);

	if ($myRandomQuote) {
?>
<?php
		foreach ($myRandomQuote as $post) : setup_postdata($post);
		$myQ = array(get_post_meta($post->ID, 'citat', true), get_post_meta($post->ID, 'Ime', true), get_post_meta($post->ID, 'Priimek', true), get_the_title($post->ID));
		endforeach;
?>
<?php //wp_pagenavi( array( 'query' => $myRandomQuote ) ); ?>
<!-- paginate_links -->
<?php
/*$big = 999999999; // need an unlikely integer
echo paginate_links( array(
	'base' => str_replace( $big, '%#%', get_pagenum_link( $big ) ),
	'format' => '?paged=%#%',
	'current' => max( 1, get_query_var('paged') ),
	'total' => $myRandomQuote->max_num_pages
) );*/
?>

<?php
	}

	return $myQ;
	
}
function myRandomQuoteX($limitToSeries=false) {
	global $wp_query, $post;
	global $myRandomQuote;

	if ($limitToSeries == false) {
		$limitToSeries = "";
	}
	$args = array(
		'post_status' => 'publish',
		'post_type' => 'knjiga',
		'posts_per_page' => 1,
		'posts_per_archive_page' => 1,
		'orderby' => 'rand',
		'meta_query' => array(
			array(
				'key' => 'citat',
				'value' => '',
				'compare' => '!='
			),
			array(
				'key' => 'zbirka',
				'value' => $limitToSeries,
				'compare' => 'LIKE'
			)
		)
	);

	$myRandomQuote = new WP_Query($args);

	if ($myRandomQuote) {
		foreach ($myRandomQuote as $post) : setup_postdata($post);
		$myQ = array(get_post_meta($post->ID, 'citat', true), get_post_meta($post->ID, 'Ime', true), get_post_meta($post->ID, 'Priimek', true), get_the_title($post->ID));
		endforeach;
	}

	return $myQ;
	wp_reset_postdata();
}
	
function thisAuthorsInterview($nameSlug) {
	global $wp_query, $post;

	$args = array(
		'post_status' => 'publish',
		'post_type' => 'post', 
		'posts_per_page' => -1,
		'category_name' => 'intervju',
		'tax_query' => array(
			array(
				'taxonomy' => 'drugo_ime',
				'field' => 'slug',
				'terms' => $nameSlug
			)
		)
	);

	$thisAuthorsWorks = get_posts($args);
	if ($thisAuthorsWorks) :
?>
<h4>Intervju</h4>
<ul id="titlesByAuthor">
<?php foreach ($thisAuthorsWorks as $post) : setup_postdata($post); ?>
		<li class="">
			<h5><a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"><?php echo get_the_title(); ?></a> | <span><?php echo the_time('j. F Y');?></span></h5>
		</li>
<?php
	endforeach;
?>
</ul>
<?php
endif;
}

function _thisAuthorsWorks($type, $num, $nameSlug, $term = false, $tax = 'category') {
	global $thisPostID;
	global $post;

	$myAuthorsWorks = array();
	$tax_query = array();
	$tax_query[] = array(
		'taxonomy' => 'category',
		'field' => 'slug',
		'terms' => array('hlapljivo'),
		'operator' => 'NOT IN'
	);

	$args = array(
		'post_status' => 'publish',
		'post_type' => $type, 
		'posts_per_page' => $num,
		'post__not_in' => array($thisPostID)
	);

	if ($term !== false) {
		$tax_query[] = array(
			'taxonomy' => $tax,
			'field' => 'slug',
			'terms' => $term
		);
		if ($term == 'intervju') {
			$tax_query[] = array(
				'taxonomy' => 'drugo_ime',
				'field' => 'slug',
				'terms' => $nameSlug
			);
		}
	}
	if ($term != 'intervju') {
		$tax_query[] = array(
			'taxonomy' => 'ime_avtorja',
			'field' => 'slug',
			'terms' => $nameSlug
		);
	}
	$args['tax_query'] = $tax_query;
	//echo "<br><hr><pre class='red'>"; var_dump($args); echo "</pre>";


	$thisAuthorsWorks = new WP_Query($args);
	if ($thisAuthorsWorks->have_posts()) :
		$myAuthorsWorks = $thisAuthorsWorks->posts; // brez ->posts bi dobili object, ki bi ga uporabili za while->have_posts
		//echo "<pre>"; var_dump($thisAuthorsWorks->posts); echo "</pre>";
		/*while ($thisAuthorsWorks->have_posts()) : $thisAuthorsWorks->the_post();
			$myAuthorsWorks[] = $post;
	endwhile;*/
	endif;
	return($myAuthorsWorks);
	//wp_reset_postdata();
	
}
function thisAuthorsWorks($heading, $type, $num, $nameSlug, $showThumbnail, $columns = 5, $columnClass = 'one-five') {
	global $thisPostID;
	global $wp_query, $post;
	$myIterator = 0;

	$args = array(
		'post_status' => 'publish',
		'post_type' => $type, 
		'posts_per_page' => $num,
		'post__not_in' => array($thisPostID),
		'tax_query' => array(
			array(
				'taxonomy' => 'ime_avtorja',
				'field' => 'slug',
				'terms' => $nameSlug
			)
		)
	);

	$thisAuthorsWorks = get_posts($args);
	if ($thisAuthorsWorks) :
?>
<h4><?php echo $heading; ?></h4>
<ul id="titlesByAuthor" class="true-liquid-block-outer">
<!--
<?php foreach ($thisAuthorsWorks as $post) : setup_postdata($post); $myIterator++; ?>
	--><li class="true-liquid-block-inner <?php echo $columnClass; ?>">
		<div class="myPostItem">
<?php if ($showThumbnail) :
		$img_id = get_post_thumbnail_id($post->ID);
		$alt_text = get_post_meta($img_id , '_wp_attachment_image_alt', true);
		if (has_post_thumbnail()) : ?>
			<a class="bare" href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>" ><?php the_post_thumbnail('myTwoColImage', array('class' => $myAddClass, 'alt' => $alt_text)); ?></a>
<?php 	endif; ?>
<?php endif; ?>
			<h5><a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"><?php echo get_the_title(); ?></a></h5>
		</div>
	</li><!--
<?php endforeach; ?>
--></ul>
<?php
	endif;
}

function newlit_save_author($post_id) {
	$myCombinedName = false;
	if (!empty($_REQUEST['ime']) && !empty($_REQUEST['priimek'])) {
		$myCombinedName = "$_REQUEST[ime] $_REQUEST[priimek]";

	} elseif (!empty($_REQUEST['ime'])) {
		$myCombinedName = $_REQUEST['ime'];

	} elseif (!empty($_REQUEST['priimek'])) {
		$myCombinedName = $_REQUEST['priimek'];

	} elseif ((get_post_meta($post_id, 'ime', true) != "") and (get_post_meta($post_id, 'priimek', true) != "")) {
		$myCombinedName = get_post_meta($post_id, 'ime', true) . " " . get_post_meta($post_id, 'priimek', true);

	} elseif (($myName = get_post_meta($post_id, 'ime', true)) != "") {
		$myCombinedName = $myName;

	} elseif (($mySurname = get_post_meta($post_id, 'priimek', true) != "")) {
		$myCombinedName = $mySurname;

	}


	if (!empty($myCombinedName)) {
		wp_set_post_terms($post_id, $myCombinedName, 'ime_avtorja', false);
	}
}

function newlit_save_book($post_id) {
	if (isset($_REQUEST['zbirka'])) {
		wp_set_post_terms($post_id, $_REQUEST['zbirka'], 'zbirka', false);
	} 

	if (isset($_REQUEST['prevajalec'])) {
		wp_set_post_terms($post_id, $_REQUEST['prevajalec'], 'prevajalec', false);
	}
	if (isset($_REQUEST['avtorji'])) {
		//wp_set_post_terms($post_id, $_REQUEST['avtorji'], 'ime_avtorja', false);
	}
}

function newlit_save_feature($post_id) {
	//$meta = get_post_meta($post_id);
}

function my_save_hook($post_id) {
	/*
		TODO:
		upoštevaj razlike glede na vrsto prispevka!!!
	 */
	if ($_POST['post_type'] == "avtor") {
		newlit_save_author($post_id);
		
	} elseif ($_POST['post_type'] == "knjiga") {
		newlit_save_book($post_id);
		newlit_save_author($post_id);

	} elseif ($_POST['post_type'] == "revija") {
	} elseif ($_POST['post_type'] == "newlit_svezenj") {
		//newlit_save_feature($post_id); //dsiabled for testing
	} else {
		return;
	}

}

add_action('save_post', 'my_save_hook');

add_filter('query_vars', 'myBookSeriesVar' );

function myBookSeriesVar($qvars) {
	$qvars[] = 'series';
	return $qvars;
}

function newlit_tiny_mce_before_init($init_array) {
	$init_array['theme_advanced_styles'] = "UPPERCASE=uppercase; blockquote_inside=inside; Intervju vprašanje=interviewQuestion; Intervju odgovor=interviewAnswer; sans=sans; razmik nad odstavkom=spaceAbove; intro para=introduction";
	//$init_array['theme_advanced_blockformats'] = "p,h3,h4,h5,a,blockquote"; // filter formats
	return $init_array;
}
add_filter('tiny_mce_before_init', 'newlit_tiny_mce_before_init');

function newlit_add_editor_styles() {
	add_editor_style( 'newlit-editor-style.css' );
}
add_action( 'admin_init', 'newlit_add_editor_styles' );


function newlit_show_tags() {
	$posttags = get_the_tags();
	if ($posttags) {
?>
<p>Ključne besede:</p>
<ul class="theTags clearfix">
<?php
	foreach($posttags as $tag) {
?>
	<li class="gray-background-3"><a href="<?php echo get_tag_link($tag->term_id); ?>"><?php echo $tag->name; ?></a></li>
<?php
	}
?>
</ul>
<?php
	}
}

function app_reading_time() {
	global $post;
	$myContent = $post->post_content;
	$words = str_word_count(strip_tags($myContent));
	$min = floor($words / 200);
	$sec = floor($words % 200 / (200 / 60));
	$app_time = $min . ':' .  $sec;
	return(($min < 1 ? '&lt; 1' : $min) . ' min');
}

function _newlit_related_posts($num=3, $type='post', $id=false) {
	global $thisPostID;
	global $myNumberOfPosts;
	$myNumberOfPosts = $num;
	//$id = $thisPostID;
	if ($id === false)
		$id = $thisPostID;
	$origPost = $post;
	global $post;
	global $wpdb;
	$tags = wp_get_post_tags($id);
	$related_posts = new WP_Query();

	$noneToShow = 0;
	if ($tags) {
		$tag_ids = array();
		foreach ($tags as $oneTag) {
			$tag_ids[] = $oneTag->name;
		}

		$separated_tags = "'". implode("','", $tag_ids) . "'";

		$querystr = "
SELECT SQL_CALC_FOUND_ROWS  
	p.*
FROM
	wp_2_posts p
	INNER JOIN wp_2_term_relationships tr ON p.ID=tr.object_id
	INNER JOIN wp_2_term_taxonomy tt ON tr.term_taxonomy_id = tt.term_taxonomy_id
	INNER JOIN wp_2_terms t ON tt.term_id = t.term_id
WHERE 1=1
	AND p.ID NOT IN ($id)
	AND (t.name IN ($separated_tags))
	AND p.post_type = '$type'
	AND (p.post_status = 'publish')
GROUP BY
	p.ID
ORDER BY
	count(*) DESC,
	p.post_date DESC
LIMIT
	0, $num			
";			
		
		$relatedPosts = $wpdb->get_results($querystr, OBJECT);

		if ($wpdb->num_rows > 0) {

			/*
foreach ($relatedPosts as $i => $post) {
	$relatedPosts[$i] = sanitize_post($post, 'raw');
}
			 */
	
			$related_posts = new WP_Query();
			$related_posts->posts = $relatedPosts;
			$related_posts->post_count = count($relatedPosts);

			//$related_posts->post = $relatedPosts[0];

		} else {
			$noneToShow = 1;
		}
		$post = $origPost;
		wp_reset_query();
	} else {
		$noneToShow = 1;
	}

	if ($noneToShow) {
		$categories = get_the_category($id);
		if ($categories) {
			$categoryIds = array();
			foreach ($categories as $oneCategory) {
				$categoryIds[] = $oneCategory->term_id;
			}
			$args = array (
				'paged' => get_query_var('paged'),
				'post_status' => 'publish',
				'category__in' => $categoryIds,
				'category__not_in' => array(3848, 9999),
				'post__not_in' => array($id),
				'post_type' => $type,
				'posts_per_page'=> $num
			);

			$relatedPosts = new WP_Query($args);

			if ($relatedPosts->found_posts > 0) {
				//while ($relatedPosts->have_posts()) : $relatedPosts->the_post(); $myIterator++;
					//$related_posts[] = $post->ID;
					//$related_posts = $relatedPosts->posts;
					$related_posts = $relatedPosts;
				//endwhile;
				$post = $origPost;
				wp_reset_query();
			}
		}
	}
	return $related_posts;
}
function newlit_related_post_ids($id, $num=3, $type='post') {
	$origPost = $post;
	global $post;
	global $wpdb;
	$tags = wp_get_post_tags($id);
	$related_ids = array();

	$noneToShow = 0;
	if ($tags) {
		$tag_ids = array();
		foreach ($tags as $oneTag) {
			$tag_ids[] = $oneTag->name;
		}

		$separated_tags = "'". implode("','", $tag_ids) . "'";
		//$separated_tags = $wpdb->dbh->mysqli_real_escape_string($separated_tags); //FIXME

		$querystr = "
SELECT SQL_CALC_FOUND_ROWS  
	p.*
FROM
	wp_2_posts p
	INNER JOIN wp_2_term_relationships tr ON p.ID=tr.object_id
	INNER JOIN wp_2_term_taxonomy tt ON tr.term_taxonomy_id = tt.term_taxonomy_id
	INNER JOIN wp_2_terms t ON tt.term_id = t.term_id
WHERE 1=1
	AND p.ID NOT IN ($id)
	AND (t.name IN ($separated_tags))
	AND p.post_type = '$type'
	AND (p.post_status = 'publish')
GROUP BY
	p.ID
ORDER BY
	count(*) DESC,
	p.post_date DESC
LIMIT
	0, $num			
";			
		
		$relatedPosts = $wpdb->get_results($querystr, OBJECT);

/*
	TODO:
	TODO
	TODO
	TODO
	namesto id-jev naj funkcija vrne array kot authors recent works!!!
 */
		if ($wpdb->num_rows > 0) {
			foreach ($relatedPosts as $post): setup_postdata($post); $myIterator++;
				$related_ids[] = $post->ID;
			endforeach;
		} else {
			$noneToShow = 1;
		}
		$post = $origPost;
		wp_reset_query();
	} else {
		$noneToShow = 1;
	}

	if ($noneToShow) {
		$categories = get_the_category($id);
		if ($categories) {
			$categoryIds = array();
			foreach ($categories as $oneCategory) {
				$categoryIds[] = $oneCategory->term_id;
			}
			$args = array (
				'paged' => get_query_var('paged'),
				'post_status' => 'publish',
				'category__in' => $categoryIds,
				'category__not_in' => array(3848, 9999),
				'post__not_in' => array($id),
				'post_type' => $type,
				'posts_per_page'=> $num
			);

			$relatedPosts = new WP_Query($args);

			if ($relatedPosts->found_posts > 0) {
				while ($relatedPosts->have_posts()) : $relatedPosts->the_post(); $myIterator++;
					$related_ids[] = $post->ID;
				endwhile;
				$post = $origPost;
				wp_reset_query();
			}
		}
	}
	return $related_ids;
}


function newlit_related_posts($id) {
	$myIterator = 0;
	$origPost = $post;
	global $post;
	global $wpdb;
	global $excerpt_show_more;
	$excerpt_show_more = false;
	//global $relatedPosts;
	$tags = wp_get_post_tags($id);
	//echo "<!-- $id -->";
	global $newlitTempCustomLength;
	$newlitTempCustomLength = 20;

	$noneToShow = 0;
	if ($tags) {
		//echo "<!-- has tags -->";
		$tag_ids = array();
		
		foreach ($tags as $oneTag) {
			$tag_ids[] = $oneTag->name;
		}

		$separated_tags = "'". implode("','", $tag_ids) . "'";

		$querystr = "
SELECT SQL_CALC_FOUND_ROWS  
	p.*
FROM
	wp_2_posts p
	INNER JOIN wp_2_term_relationships tr ON p.ID=tr.object_id
	INNER JOIN wp_2_term_taxonomy tt ON tr.term_taxonomy_id = tt.term_taxonomy_id
	INNER JOIN wp_2_terms t ON tt.term_id = t.term_id
WHERE 1=1
	AND p.ID NOT IN ($id)
	AND (t.name IN ($separated_tags))
	AND p.post_type = 'post'
	AND (p.post_status = 'publish')
GROUP BY
	p.ID
ORDER BY
	count(*) DESC,
	p.post_date DESC
LIMIT
	0, 3			
";			
		
		$args = array(
			'paged' => get_query_var('paged'),
			'post_status' => 'publish',
			'tag__in' => $tag_ids,
			'post__not_in' => array($id),
			'posts_per_page' => 3,
		);

		//$relatedPosts = new WP_Query($args);
		$relatedPosts = $wpdb->get_results($querystr, OBJECT);

	
	////echo "<!-- "; print_r($relatedPosts); echo " -->";
	//echo "<!-- QUERYSTR ::: $querystr -->";
	//echo "<!-- RELATEDPOSTSQUERY :::\n"; print_r($relatedPosts->query); echo "\n-->";
	//echo "<!-- RELATEDPOSTSQUERY :::\n$relatedPosts->request \n-->";

		/*
	if ($relatedPosts) {
		echo "<!-- YES -->";
		echo "<!-- $relatedPosts->num_rows\n$wpdb->num_rows -->";
	}
		 */

		//if ($relatedPosts) {
		//if ($relatedPosts->found_posts > 0) {
		if ($wpdb->num_rows > 0) {
			echo "<!-- has related 1 [TAGS] -->";
?>
<h5 class="font-size-2 sans">Sorodni prispevki</h5>
<ul class=" relatedArticlesList">
<?php foreach ($relatedPosts as $post): setup_postdata($post); $myIterator++; ?>
	<li class="myPostItem myPostListItem" style="">
		<p class="no-indent article-data article-data-author article-data-title">
<?php
$contributor = wp_get_post_terms($post->ID, "ime_avtorja", array("count" => 1));
$contributorName = $contributor[0]->name;
if (isset($contributorName) and !(empty($contributorName))) :
?>
			<span class="article-data-item contributorName"><?php echo $contributorName; ?>: </span>
<?php endif; ?>
			<span class="article-data-item"><a href="<?php the_permalink() ?>" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a></span>
		</p>
		<p class="no-indent article-data myPostMeta article-data-item article-data-metadata sans">
<?php $category = get_the_category(); ?>
			(<span class="article-data-item article-data-categories"><?php echo $category[0]->cat_name; ?></span>, 
			<span class="noun-project timer"><?php echo app_reading_time(); ?></span>)
		</p>
		<div class="theExcerpt serif"><?php the_excerpt(); ?></div>
	</li>
<?php endforeach; ?>
</ul>
<?php
		} else {
			$noneToShow = 1;
		}
		$post = $origPost;
		wp_reset_query();
	} else {
		$noneToShow = 1;
	}

	if ($noneToShow) {
		$categories = get_the_category($id);
		if ($categories) {
			#echo "<!-- has categories -->";
			$categoryIds = array();
			foreach ($categories as $oneCategory) {
				$categoryIds[] = $oneCategory->term_id;
			}
			$args = array (
				'paged' => get_query_var('paged'),
				'post_status' => 'publish',
				'category__in' => $categoryIds,
				'category__not_in' => array(3848, 9999),
				'post__not_in' => array($id),
				'posts_per_page'=> 3
			);

			$relatedPosts = new WP_Query($args);

			//if ($relatedPosts) {
			if ($relatedPosts->found_posts > 0) {
				#echo "<!-- has related 2 -->";

?>
<h4>Sorodni prispevki</h4>
<ul class="clearfix relatedArticlesList font-size-0">
<?php while ($relatedPosts->have_posts()) : $relatedPosts->the_post(); $myIterator++; ?>
	<li class="myPostItem myPostListItem" style="">
		<div class="">
			<p class="contributor-data">
<?php
$contributor = wp_get_post_terms($post->ID, "ime_avtorja", array("count" => 1));
$contributorName = $contributor[0]->name;
if (isset($contributorName) and !(empty($contributorName))) :
?>
				<span class="contributorName"><?php echo $contributorName; ?>: </span>
<?php endif; ?>
				<a href="<?php the_permalink() ?>" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a>
				<span class="subtitle"><?php echo get_post_meta($post->ID, 'mysubtitle', true) ?></span>
				<span class="myPostMeta"> 
<?php $category = get_the_category(); ?>
					(<a href="<?php echo esc_url(get_category_link($category[0]->cat_ID)); ?>"><?php echo $category[0]->cat_name; ?></a>
					<span class="noun-project timer"><?php echo app_reading_time(); ?></span>)
				</span>
			</p>
			<div class="theExcerpt serif"><?php the_excerpt(); ?></div>
		</div>
	</li>

<?php endwhile; ?>
</ul>
<?php
				$post = $origPost;
				wp_reset_query();
			}
		}
	}
	$newlitTempCustomLength = 0;
	$excerpt_show_more = true;
}

function my_wp_antispambot_shortcode_function($atts) {
	return '<a href="'.antispambot("mailto:" . $atts['address']).'">' 
		. (isset($atts['name']) ? $atts['name'] : antispambot($atts['address']))
		. '</a>';
}
add_shortcode('sendemail', 'my_wp_antispambot_shortcode_function');

function my_wp_antispambot_2_shortcode_function($atts){
	return antispambot($atts['address']);
}
add_shortcode('printemail', 'my_wp_antispambot_2_shortcode_function');

function myMagazineList() {
	$args = array(
		'post_type' => 'revija',
		'post_status' => 'publish',
		'orderby' => 'meta_value_num',
		'meta_key' => 'newlit-revija-new-stevilka',
		'posts_per_page' => -1
	);

	$backIssues = new WP_Query($args);
	if ($backIssues->have_posts()) :
?>
<select name="myMagazineArchives" id="myMagazineArchives">
	<option class="truncateThis" value="">Izberi številko</option>
<?php while ($backIssues->have_posts()) : $backIssues->the_post(); ?>
	<option class="truncateThis" value="<?php the_permalink() ?>"><?php the_title(); echo ", " . get_post_meta($backIssues->post->ID, 'newlit-revija-new-issue', true);?></option>
<?php endwhile; endif; ?>
</select>
<script type="text/javascript">
		var dropdown_magazines = document.getElementById("myMagazineArchives");
		function magazineChoice() {
			if (dropdown_magazines.options[dropdown_magazines.selectedIndex].value != '') {
				location.href = dropdown_magazines.options[dropdown_magazines.selectedIndex].value;		
			}	
		}	
		dropdown_magazines.onchange = magazineChoice;
</script>
<?php
}
function myArticleAuthorsList() {
	global $wp_query, $post, $wpdb;

	$myQueryStr = "
		SELECT
			m3.meta_value as L, m2.meta_value as F, C, N, S
			FROM
				(SELECT
					t.slug AS S, t.name AS N, count(*) AS C
						FROM
							wp_2_posts p
							INNER JOIN wp_2_term_relationships AS tr ON p.ID=tr.object_id
							INNER JOIN wp_2_term_taxonomy AS tt ON tr.term_taxonomy_id = tt.term_taxonomy_id
							INNER JOIN wp_2_terms AS t ON tt.term_id = t.term_id
						WHERE 1=1
							AND tt.taxonomy = 'ime_avtorja'
							AND p.post_type = 'post'
							AND p.post_status = 'publish'
						GROUP BY
							N) AS x
				INNER JOIN wp_2_posts p2
				INNER JOIN wp_2_term_relationships AS tr2 ON p2.ID=tr2.object_id
				INNER JOIN wp_2_term_taxonomy AS tt2 ON tr2.term_taxonomy_id = tt2.term_taxonomy_id
				INNER JOIN wp_2_terms AS t2 ON tt2.term_id = t2.term_id
				INNER JOIN wp_2_postmeta AS m2 ON m2.post_id = p2.ID
				INNER JOIN wp_2_posts p3
				INNER JOIN wp_2_term_relationships AS tr3 ON p3.ID=tr3.object_id
				INNER JOIN wp_2_term_taxonomy AS tt3 ON tr3.term_taxonomy_id = tt3.term_taxonomy_id
				INNER JOIN wp_2_terms AS t3 ON tt3.term_id = t3.term_id
				INNER JOIN wp_2_postmeta AS m3 ON m3.post_id = p3.ID
					WHERE 1=1
						AND p3.post_type = 'avtor'
						AND t3.name = x.N
						AND m3.meta_key = 'priimek'
						AND p2.post_type = 'avtor'
						AND t2.name = x.N
						AND m2.meta_key = 'ime'
		ORDER BY
		L
	";

		$myArticleAuthors = $wpdb->get_results($myQueryStr);
	if ($wpdb->num_rows > 0) {
		//echo "<pre>"; var_dump($myArticleAuthors); die;
?>
<select name="myAuthorSelect2" id="myArticleAuthorSelect2">
	<option class="truncateThis" value="">Izberi avtorja prispevkov</option>
<?php
			foreach ($myArticleAuthors as $author):
				$myLink = home_url("/imena-avtorjev/" . $author->S);
?>
	<option class="truncateThis" value="<?php echo $myLink ?>"><?php echo "$author->L, $author->F ($author->C"?>)</option>
<?php endforeach; ?>
</select>
<script type="text/javascript">
		var dropdown_author2 = document.getElementById("myArticleAuthorSelect2");
		function onAuthorChange2() {
			if (dropdown_author2.options[dropdown_author2.selectedIndex].value != '') {
				location.href = dropdown_author2.options[dropdown_author2.selectedIndex].value;		
			}	
		}	
		dropdown_author2.onchange = onAuthorChange2;
</script>
<?php
}
}

/*
	tinymce inline styles - for newsletters
 */

add_filter('mce_buttons_2', 'newlit_mce_buttons_2');

function newlit_mce_buttons_2($buttons) {
    array_unshift($buttons, 'styleselect');
    return $buttons;
}


add_filter('tiny_mce_before_init', 'newlit_mce_before_init');
function newlit_mce_before_init($settings) {
	$style_formats = array(
		array(
			'title' => 'h2 za newsletter',
			'selector' => 'h2',
			'styles' => array(
				'margin' => '42px 0 0 0',
				'color' => '#333',
				'fontFamily' => 'Helvetica, sans-serif',
				'fontSize' => '26px',
				'lineHeight' => '30px',
				'fontWeight' => 'bold'
			)
		), 
		array(
			'title' => 'interviewQuestion',
			'block' => 'p',
			'classes' => 'interviewQuestion sans bold'
		),
		array(
			'title' => 'sans',
			'block' => 'p',
			'classes' => 'sans'
		),
		array(
			'title' => 'span/quote',
			'inline' => 'span',
			'classes' => 'span-make-blockquote'
		),
		array(
			'title' => 'book-indent paragraph',
			'block' => 'p',
			'classes' => 'book-para'
		),
		array(
			'title' => 'hanging paragraph',
			'block' => 'p',
			'classes' => 'hanging'
		),
		array(
			'title' => 'intro para',
			'block' => 'p',
			'classes' => 'introduction'
		),
		array(
			'title' => 'no-indent paragraph',
			'block' => 'p',
			'classes' => 'no-indent'
		),
		array(
			'title' => 'h3 za newsletter',
			'selector' => 'h3',
			'styles' => array(
				'margin' => '14px 0 14px 0',
				'color' => '#333',
				'fontFamily' => 'Helvetica, sans-serif',
				'fontSize' => '18px',
				'lineHeight' => '23px',
				'fontWeight' => 'bold'
			)
		), 
        array(
			'title' => 'p za newsletter',
			'selector' => 'p',
			'styles' => array(
				'fontFamily' => 'Georgia, Times, serif',
				'fontSize' => '14px',
				'lineHeight' => '21px'
			)
        ),
        array(
			'title' => 'a za newsletter',
			'selector' => 'a',
			'styles' => array(
				'color' => '#2578D8',
				'textDecoration' => 'underline'
			)
        )
		
	);

	$settings['style_formats'] = json_encode($style_formats);
	return $settings;
}


/* preusmeritev */
/*
	!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
	the_permalink: when we call the_permalink()
	post_link, post_type_link: when we call get_permalink()
	!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
 */
add_filter('the_permalink', 'newlitOtherLink');
add_filter('post_link', 'newlitOtherLink');
add_filter('post_type_link', 'newlitOtherLink');
function newlitOtherLink($permalink) {
	global $post;
	$myLink = get_post_meta($post->ID, 'newlitLink', true);
	if (!empty($myLink)) {
		return $myLink;
	} else {
		return $permalink;
	}
}
	
set_user_setting('dfw_width', 600);
set_user_setting('dfw', true);

function newlit_utm_parameters(
	$source = 'newsletter',
	$medium = 'email',
	$campaign = 'obvescevalnik',
	$custom = ''
) {
	global $my_date_parameter;
	$my_date_parameter = date('Ymd');
	return add_query_arg(array('utm_source' => $source, 'utm_medium' => $medium, 'utm_campaign' => $campaign . (empty($custom) ? '' : "-$custom")), get_permalink());

}

//title attribute missing in wp 3.5! :-(
//deluje samo za get image ali post thumbnail!
add_filter('wp_get_attachment_image_attributes','newlit_image_title_attribute',10,2);
function newlit_image_title_attribute($atts,$img) {
	if (!isset($attr['title']) && isset($img->post_title) && $img->post_title !='') {
		$atts['title'] = trim(strip_tags($img->post_title));
	}
	return $atts;
}


//deluje za vse, kar izbereš z insert media
//še vedno pa NE deluje za tiste, ki so že notri, za to bi bil potreben filter v the_content in preg_replace :-(
function newlit_restore_image_title($html, $id) {
	$attachment = get_post($id);
	if (strpos($html, "title=")) {
		return $html;
	} else {
		$mytitle = esc_attr($attachment->post_title);
		return str_replace('<img', '<img title="' . $mytitle . '" '  , $html);
	}
}
add_filter('media_send_to_editor', 'newlit_restore_image_title', 15, 2);

/*
add_filter('tiny_mce_before_init', 'newlitMCEconfig');
function newlitMCEconfig($conf) {
	$conf['paste_remove_spans'] = true;
	$conf['paste_remove_styles'] = true;
}
 */

/* obvescevalnik */

/*
function myParagraphExcerpt(
	$numParagraphs = 1,
	$limitWords = 150,
	$allowedTags = '<i><em><b><p><br><a><strong>',
	$allowedTags_kses = array(
		'a' => array(
			'href' => array(),
			'title' => array()
		),
		'em' => array(),
		'b' => array(),
		'p' => array(), //FIXME
		'br' => array(),
		'i' => array(),
		'strong' => array()
	)
) {
 */
function myParagraphExcerpt(array $args = array()) {

	$args = array_merge(array(
		'numParagraphs' => 1,
		'limitWords' => 150,
		'allowedTags' => '<i><em><b><p><br><a><strong>',
		'add_utm' => true,
		'allowedTags_kses' => array(
			'a' => array(
				'href' => array(),
				'title' => array()
			),
			'em' => array(),
			'b' => array(),
			'p' => array(), //FIXME
			'br' => array(),
			'i' => array(),
			'strong' => array()
		)
	), $args);

	extract($args); // v glavnem zato, da mi ni treba vsega spodajspreminjat

	global $post;
	global $my_date_parameter;
	$myContent = trim(get_the_content());
	$myLink = get_post_meta($post->ID, 'newlitLink', true);

	if (empty($myLink)) {
		//$myLink = get_permalink($post->ID);
		//FIXME TODO?
		$myLink = add_query_arg(array('utm_source' => 'newsletter', 'utm_medium' => 'email', 'utm_campaign' => "obvescevalnik", 'utm_content' => 'moreLink'), get_permalink($post->ID));
	} else {
		$myLink = add_query_arg(array('utm_source' => 'newsletter', 'utm_medium' => 'email', 'utm_campaign' => "obvescevalnik", 'utm_content' => 'moreLink'), get_permalink($post->ID));
	}
	//undo everything ;-)
	$myLink = get_permalink($post->ID);
	// odstrani vse shortcodes
	//$content = preg_replace('#\[.*\]#is', '', $content);


	if (!empty($post->post_excerpt)) {
		$myExcerptText = "<p>" . $post->post_excerpt . "</p>";
	} else {

		$myContent = apply_filters('the_content', $myContent);
		$myContent = str_replace(']]>', ']]&gt;', $myContent);
		//$myContent = strip_tags($myContent, $allowedTags);
		$myContent = wp_kses($myContent, $allowedTags_kses);

		/*
			// po odstavkih
		$myContent = explode('</p>', $myContent);
		$myExcerptText = '';
		for ($i = 0; $i <= count($myContent); $i++) {
			$myExcerptText .= $myContent[$i];

			$myWords = explode(' ', $myExcerptText);

			if (count($myWords) > $limitWords) {
				break;
			}
		}
		 */

		$satisfied = false;
		for ($j = 0; $satisfied == false; $j++) {
			$myParagraphs = explode('</p>', $myContent);
			$myWords = explode(' ',	implode(' ', 
									array_slice($myParagraphs, 0, ($numParagraphs + $j))
								)
							);

			if (count($myWords) > ($limitWords / 3 * 4)) {
				//že en odstavek je mnogo predolg, odrežemo po točno določenem številu besed
				$myContent = explode(' ', $myContent);
				$myExcerptText = '';
				for ($i = 0; $i < $limitWords; $i++) {
					$myExcerptText .= ' ' . $myContent[$i];
				}
				$satisfied = true;
			} else if (count($myWords) < ($limitWords / 2)) {
				//en odstavek je ful prekratek: nova iteracija (dodajaj odstavke, enega po enega, dokler ne bo dovolj)
				if (count($myParagraphs) == $j + 1) {
					$myExcerptText = implode(' ', array_slice($myParagraphs, 0, ($numParagraphs + $j)));
					$satisfied = true;
				}

			} else {
				//dolžina je sprejemljiva. uporabi toliko odstavkov, kot je bilo potrebnih, da smo prišli do sem
				$myExcerptText = implode(' ', array_slice($myParagraphs, 0, ($numParagraphs + $j)));
				$satisfied = true;
			}
		}
	}


	$myExcerptText .= '<a class="more" style="font-weight: normal; font-size: 12px; padding: 1px; color: white; text-decoration: none; background-color: #666" href="'. $myLink . '">Preberi</a>';
	$myExcerptText = balanceTags($myExcerptText, true);



	$urlPattern = array();
	$urlReplace = array();

	//with some variables already included
	$urlPattern[0] = <<<PAT
	/href=(["'])([^"']+)\?([^"']+)(["'])/
PAT;
	$urlReplace[0] = 'href=${1}${2}?${3}'
		. '&'
		. "utm_source=newsletter&utm_medium=email&utm_campaign=obvescevalnik"
		. '${4}';
	//without any variables included
	$urlPattern[1] = <<<PAT
	/href=(["'])([^"'\?]+)(["'])/
PAT;
	$urlReplace[1] = 'href=${1}${2}'
		. '?'
		. "utm_source=newsletter&utm_medium=email&utm_campaign=obvescevalnik"
		. '${3}';
	
	if ($add_utm === true) {
		$myExcerptText = preg_replace($urlPattern, $urlReplace, $myExcerptText);
	}
	
	echo $myExcerptText;
}

function artDirection() {
	global $post;
	if (is_single()) {
		$currentID = $post->ID;
		$serverfilepath = TEMPLATEPATH . '/css/art-direction/style-' . $currentID . '.css';
		$publicfilepath = get_bloginfo('template_url');
		$publicfilepath .= '/css/art-direction/style-' . $currentID . '.css';
		if (file_exists($serverfilepath)) {
			echo "<link rel='stylesheet' type='text/css' href='$publicfilepath' media='screen' />"."\n";
		}
	}
}
add_action('wp_head', 'artDirection');

function remove_image_size_attributes( $html ) {
	return preg_replace('/(width|height)="\d*"/', '', $html);
}
// Remove image size attributes from post thumbnails
add_filter('post_thumbnail_html', 'remove_image_size_attributes');
// Remove image size attributes from images added to a WordPress post
add_filter('image_send_to_editor', 'remove_image_size_attributes');

// --------------------------------------- 
add_filter( 'mfrh_new_filename', 'my_filter_filename', 10, 3 ); 
function my_filter_filename( $new, $old, $post ) { 


	/*
	setlocale(LC_ALL, 'en_US.UTF-8');
	$mynewname = iconv('UTF-8', 'ASCII//TRANSLIT//IGNORE', $old); 
	return $mynewname; 
	setlocale(LC_ALL, 'sl_SI');
 */
	$sanitized_filename = remove_accents($old); // Convert to ASCII
$sanitized_filename = strtolower($sanitized_filename); // Lowercase
//echo "<h1>$sanitized_filename</h1>";
	return $sanitized_filename;
} 

//add_filter( 'rest_post_collection_params', 'newlit_add_rest_orderby_params', 10, 1 );
//was for testing media renamer; the problem was encoding (ftp)

function newlit_add_rest_orderby_params( $params ) {
    $params['orderby']['enum'][] = 'rand';

    return $params;
}

/*
setlocale(LC_ALL, 'en_US.UTF-8');
$mstr = "ÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏ00D0ÐÑÒÓÔÕÖ×ØÙÚÛÜÝÞß00E0àáâãäåæçèéêëìíîï00F0ðñòóôõö÷øùúûüýþÿ0100ĀāĂăĄąĆćĈĉĊċČčĎď0110ĐđĒēĔĕĖėĘęĚěĜĝĞğ0120ĠġĢģĤĥĦħĨĩĪīĬĭĮį0130İıĲĳĴĵĶķĸĹĺĻļĽľĿ0140ŀŁłŃńŅņŇňŉŊŋŌōŎŏ0150ŐőŒœŔŕŖŗŘřŚśŜŝŞş0160ŠšŢţŤťŦŧŨũŪūŬŭŮů0170ŰűŲųŴŵŶŷŸŹźŻżŽžſ0180ƀƁƂƃƄƅƆƇƈƉƊƋƌƍƎƏ0190ƐƑƒƓƔƕƖƗƘƙƚƛƜƝƞƟ01A0ƠơƢƣƤƥƦƧƨƩƪƫƬƭƮƯ01B0ưƱƲƳƴƵƶƷƸƹƺƻƼƽƾƿ01C0ǀǁǂǃǄǅǆǇǈǉǊǋǌǍǎǏ01D0ǐǑǒǓǔǕǖǗǘǙǚǛǜǝǞǟ01E0ǠǡǢǣǤǥǦǧǨǩǪǫǬǭǮǯ01F0ǰǱǲǳǴǵǶǷǸǹǺǻǼǽǾǿ0200ȀȁȂȃȄȅȆȇȈȉȊȋȌȍȎȏ0210ȐȑȒȓȔȕȖȗȘșȚțȜȝȞȟ0220ȠȡȢȣȤȥȦȧȨȩȪȫȬȭȮȯ0230ȰȱȲȳȴȵȶȷȸȹȺȻȼȽȾȿ0240ɀɁɂɃɄɅɆɇɈɉɊɋɌɍɎɏ0250ɐɑɒɓɔɕɖɗɘəɚɛɜɝɞɟ0260ɠɡɢɣɤɥɦɧɨɩɪɫɬɭɮɯ0270ɰɱɲɳɴɵɶɷɸɹɺɻɼɽɾɿ0280ʀʁʂʃʄʅʆʇʈʉʊʋʌʍʎʏ0290ʐʑʒʓʔʕʖʗʘʙʚʛʜʝʞʟ02A0ʠʡʢʣʤʥʦʧʨʩʪʫʬʭʮʯ";
echo "<h1>" . iconv('UTF-8', 'ASCII//TRANSLIT//IGNORE', $mstr); echo "</h1>";
echo "<h1>" . normalizer_normalize('UTF-8', 'ASCII//TRANSLIT//IGNORE', $mstr); echo "</h1>";
setlocale(LC_ALL, 'sl_SI');
 */


/*
add_filter( 'mfrh_replace_rules', 'replace_s_by_z', 10, 1 ); 
function replace_s_by_z( $rules ) { 
	$rules = array(
        'Š'=>'S', 'š'=>'s', 'Đ'=>'D', 'đ'=>'d', 'Ž'=>'Z', 'ž'=>'z', 'Č'=>'C', 'č'=>'c', 'Ć'=>'C', 'ć'=>'c',
        'À'=>'A', 'Á'=>'A', 'Â'=>'A', 'Ã'=>'A', 'Ä'=>'A', 'Å'=>'A', 'Æ'=>'A', 'Ç'=>'C', 'È'=>'E', 'É'=>'E',
        'Ê'=>'E', 'Ë'=>'E', 'Ì'=>'I', 'Í'=>'I', 'Î'=>'I', 'Ï'=>'I', 'Ñ'=>'N', 'Ò'=>'O', 'Ó'=>'O', 'Ô'=>'O',
        'Õ'=>'O', 'Ö'=>'O', 'Ø'=>'O', 'Ù'=>'U', 'Ú'=>'U', 'Û'=>'U', 'Ü'=>'U', 'Ý'=>'Y', 'Þ'=>'B', 'ß'=>'ss',
        'à'=>'a', 'á'=>'a', 'â'=>'a', 'ã'=>'a', 'ä'=>'a', 'å'=>'a', 'æ'=>'ae', 'ç'=>'c', 'è'=>'e', 'é'=>'e',
        'ê'=>'e', 'ë'=>'e', 'ì'=>'i', 'í'=>'i', 'î'=>'i', 'ï'=>'i', 'ð'=>'o', 'ñ'=>'n', 'ò'=>'o', 'ó'=>'o',
        'ô'=>'o', 'õ'=>'o', 'ö'=>'o', 'ø'=>'o', 'ù'=>'u', 'ú'=>'u', 'û'=>'u', 'ý'=>'y', 'ý'=>'y', 'þ'=>'b',
        'ÿ'=>'y', 'Ŕ'=>'R', 'ŕ'=>'r',
    );


	return $rules; 
} */
// --------------------------------------- 

// Shortcode to output custom PHP in Elementor
function elementor_php_objava ($atts){
     ob_start();
    get_template_part('objava_prva_stran');
    $output = ob_get_clean();
    return $output;
}
add_shortcode('elementor_objava', 'elementor_php_objava')

?>
