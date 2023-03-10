			<div id="sideBarDiv" class="clearfix">
				<div class="myMainPosts float clearfix nineCol">
					<?php global $thisPostID; newlit_related_posts($thisPostID); ?>
				</div>
				<ul id="mySidebar3" class="threeCol hasLeftMargin float sideBarLiContent">
					<?php //dynamic_sidebar(3); ?>
					<li id="theRandomQuote" class="widget" style="">
						<h2 class="widgettitle">Literaturin citat</h2>
						<?php $myQuote = myRandomQuote(); ?>
						<p class="myRandomQuoteQuote">“<?php echo $myQuote[0];?>”</p>
						<p>
							<span class="myRandomQuoteAuthor"><?php echo "$myQuote[1] $myQuote[2]";?></span>: 
							<span class="myRandomQuoteTitle"><?php echo $myQuote[3];?></span>
							<!-- <p><?php //next_posts_link(); ?></p> -->
						</p>
						<?php $myPage = ((get_query_var('paged') == 0)) ? 1 : get_query_var('paged'); $myPage++?>
						<p style="">
							<a class="next page-numbers" href="javascript:ajax_scroll('newer','<?php echo urlencode("http://www.ludliteratura.si/page/$myPage/");?>','theRandomQuote');">naslednji citat &rarr;</a>
						</p>
					</li>
				</ul>
			</div>
			<div id="kolofon">
				Literaturin obveščevalnik skoraj vsak ponedeljek piše in pošilja LUD(a) Literatura. <a href="http://www.ludliteratura.si" title="LUD Literatura">www.ludliteratura.si</a>
			</div>
		</div> <!-- container div -->
		<?php wp_footer(); ?>
	</body>
</html>
