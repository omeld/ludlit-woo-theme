<?php



function myRecentPosts($off, $num, $el="h4") {
	global $post;
	
	$args = array(
		'offset' => $off,
		'posts_per_page' => $num
	);

	$myPosts = get_posts($args);
?>
	<ul class="recentArticles">
<?php foreach($myPosts as $post) : setup_postdata($post);?>
		<li>
			<<?php echo $el; ?>>
				<a href="<?php the_permalink() ?>" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a>
			</<?php echo $el; ?>>
		</li>
<?php endforeach;?>
	</ul>
<?php
	
}

/* ------------------------- */

add_action( 'init', 'register_my_menus' );
function register_my_menus() {
	register_nav_menu('menu_one', 'osnovni meni');
}

if ( function_exists('register_sidebars') )
    register_sidebars(5);

function custom_excerpt_length($length) {
	if (is_category() || is_archive() || is_page('arhiv')) {
		return 55;
	} else {
		return 25;
	}
}
add_filter( 'excerpt_length', 'custom_excerpt_length');


function new_excerpt_more($more) {
	global $post, $wpdb;
	if (is_page("newsletter")) {
		return ' ... <a style="color: #8C281F; text-decoration: none" href="'. get_permalink($post->ID) . '">Več&nbsp;&rarr;</a>';
	} else {
		return ' ... <a class="readMoreLink" href="'. get_permalink($post->ID) . '">Več&nbsp;&rarr;</a>';
	}
}
//add_filter('excerpt_more', 'new_excerpt_more');


if (function_exists('add_theme_support')) { 
	add_theme_support( 'post-thumbnails' );
	//add_theme_support('post-thumbnails', array('obvescevalnik', 'post'));
	add_theme_support('post-formats', array('status', 'aside', 'quote'));
}

if (function_exists('add_image_size')) {
	//add_image_size('myIssueThumbnail', 340, 140, true);
	//add_image_size('myIssueThumbnail', 200, 140, true);
	//add_image_size('myIssueThumbnail', 140, 140, true);
	//add_image_size('myEmailThumbnail', 340, 140, true);
}

if (function_exists('add_post_type_support')) {
	add_post_type_support('obvescevalnik', 'post-formats' );
	add_post_type_support('post', 'post-formats' );
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
function myAuthorsList() {
	global $wp_query, $post;

	$args = array_merge(
		//$wp_query->query,
		array(
			'post_status' => 'publish',
			'posts_per_page' => -1,
			'post_type' => 'Avtor',
			'meta_key' => 'Priimek',
			'orderby' => 'meta_value',
			'order' => 'ASC'
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
			<h5><a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"><?php echo get_the_title(); ?></a></h5>
		</li>
<?php
	endforeach;
?>
</ul>
<?php
endif;
}

function thisAuthorsWorks($heading, $type, $num, $nameSlug, $showThumbnail) {
	global $wp_query, $post;
	$myIterator = 0;

	$args = array(
		'post_status' => 'publish',
		'post_type' => $type, 
		'posts_per_page' => $num,
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
<ul id="titlesByAuthor">
<?php
	foreach ($thisAuthorsWorks as $post) : setup_postdata($post); $myIterator++; 
?>
	<?php if (($myIterator != 0) and !($myIterator % 2)) { ?>
	<?php $myPostMargin = ""; ?>
	<?php } else { ?>
	<?php $myPostMargin = " hasRightMargin"; ?>
	<?php } ?>
		<li class="twoCol float <?php echo $myPostMargin; ?>">
<?php if ($showThumbnail) : ?>
<?php	 if (has_post_thumbnail()) : ?>
			<a class="bare" href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>" >
<?php			the_post_thumbnail('myTwoColImage', array('class' => $myAddClass)); ?>
			</a>
<?php 	endif; ?>
<?php endif; ?>

			<h5><a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"><?php echo get_the_title(); ?></a></h5>
</li>
<?php if (($myIterator != 0) and !($myIterator % 2)) : ?>
<div style="clear: both; height: 0px"></div>
<?php endif; ?>
<?php
	endforeach;
?>
<div style="clear: both; height: 0px"></div>
</ul>
<?php
	endif;
}

function myUpdateMeta($pid) {
	//preveri, da ne gre za revizijo
	//določi vrsto
	//dodaj po potrebi
}
//add_action('save_post', 'myUpdateMeta');

/*add_role('pomocnik', 'Pomočnik', array(
	'read' => true,
	'edit_posts' => true,
	'delete_posts' => true,
	'edit_dashboard' => true
));

$role =& get_role('pomocnik'); 
$role->add_cap('read');*/

/* update hook */

function my_save_hook($post_id) {
	if (($_POST['post_type'] != "avtor") or
		($_POST['post_type'] != "knjiga") or
		($_POST['post_type'] != "revija"))
	{
		return;
	}

	if (isset($_REQUEST['ime'], $_REQUEST['priimek'])) {
		$myCombinedName = "$_REQUEST[ime] $_REQUEST[priimek]";

	} elseif (isset($_REQUEST['ime'])) {
		$myCombinedName = $_REQUEST['ime'];

	} elseif (isset($_REQUEST['priimek'])) {
		$myCombinedName = $_REQUEST['priimek'];

	} elseif ((get_post_meta($post_id, 'ime', true) != "") and (get_post_meta($post_id, 'priimek', true) != "")) {
		$myCombinedName = get_post_meta($post_id, 'ime', true) . " " . get_post_meta($post_id, 'priimek', true);

	} elseif (($myName = get_post_meta($post_id, 'ime', true)) != "") {
		$myCombinedName = $myName;

	} elseif (($mySurname = get_post_meta($post_id, 'priimek', true) != "")) {
		$myCombinedName = $mySurname;

	}
	wp_set_post_terms($post_id, $myCombinedName, 'ime_avtorja', false);
}

add_action('save_post', 'my_save_hook');

add_filter('query_vars', 'myBookSeriesVar' );

function myBookSeriesVar($qvars) {
	$qvars[] = 'series';
	return $qvars;
}

function newlit_tiny_mce_before_init($init_array) {
	$init_array['theme_advanced_styles'] = "UPPERCASE=uppercase; blockquote_inside=inside; Intervju vprašanje=interviewQuestion; Intervju odgovor=interviewAnswer; sans=sans";
	//$init_array['theme_advanced_blockformats'] = "p,h3,h4,h5,a,blockquote"; // filter formats
	return $init_array;
}
add_filter('tiny_mce_before_init', 'newlit_tiny_mce_before_init');


function newlit_show_tags() {
	$posttags = get_the_tags();
	if ($posttags) {
?>
<p><b>Ključne besede:</b></p>
<ul class="theTags clearfix">
<?php
	foreach($posttags as $tag) {
?>
	<li><a href="<?php echo get_tag_link($tag->term_id); ?>"><?php echo $tag->name; ?></li></a>
<?php
	}
?>
</ul>
<?php
	}
}

function newlit_related_posts($id) {
	$myIterator = 0;
	$origPost = $post;
	global $post;
	$tags = wp_get_post_tags($id);
	echo "<!-- $id -->";

	$noneToShow = 0;
	if ($tags) {
		echo "<!-- has tags -->";
		$tag_ids = array();
		
		foreach ($tags as $oneTag) {
			$tag_ids[] = $oneTag->term_id;
		}
		
		$args = array(
			'paged' => get_query_var('paged'),
			'post_status' => 'publish',
			'tag__in' => $tag_ids,
			'post__not_in' => array($id),
			'posts_per_page' => 6,
		);

		$relatedPosts = new WP_Query($args);

		if ($relatedPosts) {
			echo "<!-- has related -->";
?>
<ul class="clearfix relatedArticlesList">
<?php while ($relatedPosts->have_posts()) : $relatedPosts->the_post(); $myIterator++; ?>
<?php if (($myIterator != 0) and !($myIterator % 3)) { ?>
<?php $myPostMargin = ""; ?>
<?php } else { ?>
<?php $myPostMargin = " hasRightMargin"; ?>
<?php } ?>
<li class="myPostItem threeCol float <?php echo $myPostMargin; ?>">
<div class="paddedText">
	<h4><a href="<?php the_permalink() ?>" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a>&nbsp;</h4>
</div>
	<div class="postExcerpt">
<?php if (has_post_thumbnail()) : ?>
			<a class="bare" href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>" >
<?php		the_post_thumbnail('myThumbnail', array('class' => $myAddClass)); ?>
			</a>
<?php endif; ?>
</div>
<div class="paddedText">
	<h5><?php echo get_post_meta($post->ID, 'mysubtitle', true) ?></h5>
<?php	the_excerpt(); ?>
<?php	$contributor = wp_get_post_terms($post->ID, "ime_avtorja", array("count" => 1));
$contributorName = $contributor[0]->name;
if (isset($contributorName) and !(empty($contributorName))) :
?>
		<p class="contributorName"><?php echo $contributorName; ?></p>
<?php
endif;
?>

	<div class="myPostMeta">
	<p><?php echo the_time('j. F Y');?> | <a href="<?php comments_link(); ?>">Komentarji (<?php echo get_comments_number(); ?>)</a>
<br>
<?php $category = get_the_category(); ?>
<?php foreach ($category as $ctg) : ?>
<a href="<?php echo esc_url(get_category_link($ctg->cat_ID)); ?>">&darr;&nbsp;<?php echo $ctg->cat_name; ?>&nbsp;</a>
<?php endforeach; ?>
</p>
	</div>
	</div>
</li>
<?php if (($myIterator != 0) and !($myIterator % 3)) { ?>
<div style="clear: both; height: 0px"></div>
<?php } ?>

<?php endwhile; ?>
</ul>
<?php
		} else {
			$noneToShow = 1;
		}
		$post = $origPost;
		wp_reset_query();
	}

	if ($noneToShow) {
		$categories = get_the_category($id);
		if ($categories) {
			echo "<!-- has categories -->";
			$categoryIds = array();
			foreach ($categories as $oneCategory) {
				$categoryIds[] = $oneCategory->term_id;
			}
			$args = array (
				'paged' => get_query_var('paged'),
				'post_status' => 'publish',
				'category__in' => $categoryIds,
				'post__not_in' => array($id),
				'posts_per_page'=> 6
			);

			$relatedPosts = new WP_Query($args);

			if ($relatedPosts) {
				echo "<!-- has related 2 -->";

?>
<!-- 
<ul class="clearfix">
<?php while ($relatedPosts->have_posts()) : $relatedPosts->the_post(); $myIterator++; ?>
<li class="fourCol float">
<?php if (has_post_thumbnail()) : ?>
	<div class="postExcerpt float">
			<a class="bare" href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>" >
<?php		the_post_thumbnail('myOneColThumb', array('class' => $myAddClass)); ?>
			</a>
	</div>
<?php endif; ?>
<div class="paddedText float">
	<h4><a href="<?php the_permalink() ?>" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a>&nbsp;</h4>
	<h5><?php echo get_post_meta($post->ID, 'mysubtitle', true) ?></h5>
<?php	the_excerpt(); ?>
<?php	$contributor = wp_get_post_terms($post->ID, "ime_avtorja", array("count" => 1));
$contributorName = $contributor[0]->name;
if (isset($contributorName) and !(empty($contributorName))) :
?>
		<p class="contributorName"><?php echo $contributorName; ?></p>
<?php
endif;
?>
</li>
<?php
				endwhile;
?>
</ul>
-->
<?php
				$post = $origPost;
				wp_reset_query();
			}
		}
	}
}

?>
