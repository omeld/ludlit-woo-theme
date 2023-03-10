<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-type" content="text/html;charset=UTF-8">
<?php

global $post;
setup_postdata($post);
remove_filter('excerpt_more', 'new_excerpt_more');

echo '<meta name="description" content="' . strip_tags(get_the_excerpt()) . '" />' . "\n";

echo '<meta property="og:title" content="' . get_the_title() . '" />' . "\n";
echo '<meta property="og:type" content="article" />' . "\n";
echo '<meta property="og:url" content="' . get_permalink() . '" />' . "\n";
remove_filter('excerpt_more', 'new_excerpt_more');
echo '<meta property="og:description" content="' . strip_tags(get_the_excerpt()) . '" />' . "\n";
add_filter('excerpt_more', 'new_excerpt_more');

if (! has_post_thumbnail($post->ID)) {
	echo '<meta property="og:image" content="http://www.ludliteratura.si/wp-content/uploads/2012/12/lud-literatura-logo.jpg" />' . "\n";
} else {
	echo '<meta property="og:image" content="' . wp_get_attachment_url(get_post_thumbnail_id($post->ID)) . '" />' . "\n";
}

?>


		<style type="text/css">
			body {
				background-color: #F0F1F4 !important;
			}
		</style>
		<title><?php wp_title('&laquo;', true, 'right'); ?><?php bloginfo('name'); ?></title>
		<?php //wp_head(); ?>
<?php
	if (
		$_SERVER['SERVER_NAME'] != 'localhost'
		and $_SERVER['SERVER_NAME'] != 'sonet'
		and $_SERVER['SERVER_NAME'] != 'jezr'
		and ! is_user_logged_in()
	) {
?>
		<script type="text/plain" class="cc-onconsent-analytics">

		  var _gaq = _gaq || [];
		  _gaq.push(['_setAccount', 'UA-22395392-2']);
		  _gaq.push(['_trackPageview']);

		  (function() {
			var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
			ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
			var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
		  })();

		</script>
<?php
	}
?>
		<?php require "mySilktideCookieConsent.php"; ?>
	</head>
	<body style="padding: 0; margin: 0">
		<table cellpadding="0" cellspacing="0" border="0" id="backgroundTable" width="100%" style="border-collapse: collapse; background-color: #F0F1F4; width: 100%; margin: 0; padding: 0; width: 100% !important; line-height: 100% !important">
			<tr>
				<td align="center">
					<table bgcolor="white" cellpadding="20" cellspacing="0" border="0" style="border-collapse: collapse; background-color: white; margin: auto;">
						<tr>
							<td width="" style="background-color: #F0F1F4">
								<p style="font-family: Helvetica, sans-serif; font-size: 10px; text-align: right; padding-top: 20px; padding-bottom: 20px">
								Ni videti, kot bi moralo biti? 
								<a style="color: #2578D8 !important; text-decoration: underline; border: none" href="<?php echo newlit_utm_parameters(); ?>" title="<?php the_title_attribute(); ?>">Poglejte na spletu.</a>
								</p>
							</td>
						</tr>
					</table>
					<table width="90%" bgcolor="white" cellpadding="0" cellspacing="0" border="0" style="border-collapse: collapse; background-color: white; margin: auto; max-width: 50em;">
						<tr>
							<td>
								<table cellpadding="20" width="" style="border-collapse: collapse; border: 0px solid #dedede; background-color: white" bgcolor="white">
									<tr>
										<td>
											<table width="" style="border-collapse: collapse; width: px; table-layout: fixed; " cellpadding="0" cellspacing="0" border="0">
												<tr>
													<td>
														<p style="border-top: 1px solid black; text-align: center; margin: 0 auto 0 auto">
														<a style="color: #2578D8 !important; text-decoration: underline" style="outline: none; text-decoration: none; border: none" title="LUD Literatura" href="http://www.ludliteratura.si/?utm_source=newsletter&utm_medium=email&utm_campaign=obvestilo">
																<img height="20" style="height: 20px; border: none; outline: none; text-decoration: none" alt="LUD Literatura" src="http://www.ludliteratura.si/lud-literatura-logo.jpg">
															</a>
														</p>
													</td>
												</tr>
												<tr>
													<td width="" valign="top" align="left" style="font-family: Helvetica, sans-serif; font-size: 18px; line-height: 1.6; color: black;">
