<?php get_header('home'); ?>
<!-- stran za knjige -->
<div id="main" class="clearfix">
<?php get_template_part( 'loop', 'knjige' ); ?>
	<!--<div id="sideBarDivRight" class="clearfix floatRight threeCol">
		<ul id="mySidebar4" class="sideBarLiContent">
			<li class="widget" id="recentIssuesContainer">
				<h2 class="widgettitle">Vsi naslovi</h2>
<?php //myBooksList() ?>
			</li>
		</ul>
	</div>-->
</div>
<?php get_footer(); ?>

