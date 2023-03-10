<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-type" content="text/html;charset=UTF-8">
		<title><?php wp_title('&laquo;', true, 'right'); ?><?php bloginfo('name'); ?>, št. <?php echo my_LatestIssueNumber(); ?></title>
		<?php wp_head(); ?>
		<?php require "mySilktideCookieConsent.php"; ?>
	</head>
	<body style='font-family: "Hoefler Text", "Adobe Garamond", Garamond, "Adobe Garamond Pro", Baskerville, "Baskerville Old Face", Georgia, serif; font-size: 14px; line-height: 1.5; padding: 30px 60px; background-color: white; color: black'>
		<table style="width: 100%">
			<tbody>
				<tr>
					<td style="width: 50%; vertical-align: top">
						<h1 style="display: inline; font-size: 1em; line-height: 1; color: #8C281F; font-weight: normal; text-transform: uppercase; letter-spacing: 0.2em;">
							<a style="text-decoration: none; border: none; color: #8C281F" href="<?php bloginfo('url'); ?>" title="<?php bloginfo('name'); ?>"><?php echo get_bloginfo('name'); ?></a>
						</h1> (št. <?php echo my_LatestIssueNumber() ?>)
					</td>
					<td style="width: 50%; vertical-align: top; text-align: right">
						Ni videti, kot bi moralo biti? <a style="text-decoration: underline; border: none; color: #666" href="<?php bloginfo('url'); ?>" title="<?php bloginfo('name'); ?>">Poglejte na spletu.</a>
					</td>
				</tr>
			</tbody>
		</table>
		<p style="margin: 0 auto; border-top: 1px solid black; text-align: center;">
			<a style="text-decoration: none; border: none" title="LUD Literatura" href="http://www.ludliteratura.si">
				<img style="height: 20px; border: none; text-decoration: none" alt="LUD Literatura" src="<?php bloginfo('template_url'); ?>/img/lud-literatura-logo.jpg">
			</a>
		</p>
		<p style="font-size: 2em; line-height: 1.2">
			<?php myTagline(); ?>
		</p>
