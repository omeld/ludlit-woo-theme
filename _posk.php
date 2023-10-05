<?php
/*
Template Name: stran za poskus
*/
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.3/jquery.min.js"></script>
		<link rel="stylesheet" href="<?php bloginfo('stylesheet_url'); ?>" type="text/css" media="screen" />
		<link rel="stylesheet" href="<?php bloginfo('stylesheet_directory'); ?>/home.css" type="text/css" media="screen">
		<?php wp_head(); ?>
	</head>
	<body <?php body_class(); ?>>
<?php $as_elem_id = 'theRandomQuote';  ?>
		<div id="container" class="clearfix">
				<ul id="mySidebar3" class="fourCol hasLeftMargin float sideBarLiContent">
					<li id="theRandomQuote" class="widget">
						<h2 class="widgettitle">Literaturin citat</h2>
						<?php $myQuote = myRandomQuote(); ?>
						<p class="myRandomQuoteQuote">“<?php echo $myQuote[0];?>”</p>
						<p><span class="myRandomQuoteAuthor"><?php echo "$myQuote[1] $myQuote[2]";?></span>: <span class="myRandomQuoteTitle"><?php echo $myQuote[3];?></span></p>
<p><!-- next post 5--><?php //next_posts_link(); ?></p>
<p><!-- next post 6 --><?php //posts_nav_link(); ?></p>
<p><!-- next post 7 --><?php //wp_pagenavi( array( 'query' => $myRandomQuote ) ); ?></p>
<p><!-- next post 8 --><?php //wp_pagenavi(); ?></p>
<div><!-- paginate_links -->
<?php
$big = 999999999; // need an unlikely integer
/*
echo paginate_links( array(
	'base' => str_replace( $big, '%#%', get_pagenum_link( $big ) ),
	'format' => '?paged=%#%',
	'current' => max( 1, get_query_var('paged') ),
	'total' => $myRandomQuote->post_count,
	'end_size' => 0,
	'mid_size' => 0
) );
 */
?>
<?php //echo "<p>max_num_pages: " . $myRandomQuote->max_num_pages . "</p>"; ?>
<?php //echo "<p>post_count: " . $myRandomQuote->post_count . "</p>"; ?>
<?php //echo get_next_posts_link(); ?>
</div>
<div>
<?php
$myPage = ((get_query_var('paged') == 0)) ? 1 : get_query_var('paged');
$myPage++;
?>
	<!--<p>My links: <?php echo get_query_var('paged') ?></p><p><a class="next page-numbers" href="javascript:ajax_scroll('newer','<?php echo urlencode("http://jezr.local/~andrej/posk/newlit/stran-za-testiranje/page/" . $myPage + 1 . "/");?>','theRandomQuote');">naprej</a></p>-->
	<p>My links: <?php echo get_query_var('paged') ?></p>
	<?php echo "<p>" . urlencode('http://jezr.local/~andrej/posk/newlit/stran-za-testiranje/page/' . $myPage . "/") . "</p>"; ?>
<p><a class="next page-numbers" href="javascript:ajax_scroll('newer','<?php echo urlencode("http://jezr.local/~andrej/posk/newlit/stran-za-testiranje/page/$myPage/"); ?>','theRandomQuote');">naprej</a></p>
</div>
					</li>
				</ul>
		</div> <!-- container div -->
		<?php wp_footer(); ?>
	</body>
</html>
