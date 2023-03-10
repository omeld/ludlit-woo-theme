<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-type" content="text/html;charset=UTF-8">
		<title><?php wp_title('&laquo;', true, 'right'); ?><?php bloginfo('name'); ?></title>
		
		<link href='http://fonts.googleapis.com/css?family=Titillium+Web:200,400,400italic,700&subset=latin-ext' rel='stylesheet' type='text/css'>
		
		<!-- <link href='http://fonts.googleapis.com/css?family=Lato|Neuton:400,700,400italic|PT+Sans|Bitter|PT+Serif|Crimson+Text|Vollkorn|Noticia+Text|Titillium+Web:200,400,400italic,700&subset=latin-ext' rel='stylesheet' type='text/css'> -->
		<link rel="stylesheet" href="<?php bloginfo('stylesheet_directory'); ?>/css/mimoglasje2013.css" type="text/css" media="screen">
		<script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.0/jquery.min.js" type="text/javascript"></script>
		<script type="text/javascript">
			$(window).load(function() {
				$('.authorPic').hover(
					function() {
						$(this).children('.overlay').stop().fadeTo('slow', 1);
						$(this).children('.overlayDesc').stop().slideDown('fast');
					},
					function() {
						$(this).children('.overlay').stop().fadeTo('fast', 0);
						$(this).children('.overlayDesc').stop().hide();
					}
				);
				//var e = "#projectTeaser";
				//var e_top = $(e).offset().top; //če ne obstaja, javi napako in zaključi skripto ... FIXME
				/*
				$(window).scroll(function(event) {
					if ($(window).scrollTop() >= e_top) {
						$(e).addClass('whiteBackground');
					} else {
						$(e).removeClass('whiteBackground');
					}
				});
				 */
				$('.content a').has('img').addClass('imgLink');
			});
		</script>
		<meta property="og:image" content="http://www.ludliteratura.si/wp-content/uploads/2013/02/mimoglasje-2013-3.jpg" />
		<?php wp_head(); ?>
		<?php require "mySilktideCookieConsent.php"; ?>
	</head>
	<body>
		<div class="" id="headerContainer">
			<div class="section" id="header">
				<div class="sectionPadding clearfix">
					<p class="float threeCol hasRightMargin" id="tag">
						<a href="<?php echo get_bloginfo('url'); ?>/mimoglasje-2013" title="Mimoglasje 2013">
							<!-- <img src="<?php echo get_bloginfo('url'); ?>/wp-content/uploads/2013/02/mimoglasje-2013-3-siva-2.jpg"> -->
							<img width="200" style="width: 200px" src="<?php echo get_bloginfo('url'); ?>/wp-content/uploads/2013/02/mimoglasje-2013-4.gif">
							
						</a>
						<!-- Večeri, na katerih se glasovi srečajo s tem, da se zgrešijo -->
					</p>
					<div id="sharing" class="twoCol float">
						<div class="addthis_toolbox addthis_default_style">
							<a class="addthis_button_facebook"></a>
							<a class="addthis_button_twitter"></a>    
						</div>
					</div>
				</div>
			</div>
		</div>
