<?php
	get_header('obvestilo');
	global $post;
	if (have_posts()) : while (have_posts()) : the_post();

?>

<h2 style="font-family: Helvetica, sans-serif; font-size: 49px; letter-spacing: -1px; line-height: 1.1; font-weight: bold; color: black; margin: 70px 0 18px 0"><?php the_title(); ?></h2>
<?php
		//the_content();
		$content = get_the_content();
		$content = apply_filters('the_content', $content);
		
		$find = array(
			'<p>',
			//'<p ',
			'<a ',
			//'<img '
		);
		$replace = array(
			'<p style="max-width: 50em; margin: auto; font-family: Helvetica, sans-serif; font-size: 18px; line-height: 1.6; color: black; margin-top: 1em;">',
			//'<p style="font-family: Georgia, Times, serif; font-size: 18px; color: #222; line-height: 21px; margin-top: 1em;" ',
			'<a style="color: #2578D8 !important; text-decoration: underline" ',
			//'<span style="text-align: center !important"><img style="max-width: 100%; height: auto" '
		);
		//echo str_replace($find, $replace, $content);
		$content = str_replace($find, $replace, $content);


		$patterns = array('/<img (((?!noresize)[^>])*)>/', '/<img ([^>]*noresize[^>]*)>/');
		$replacements = array(
			'<div style="text-align: center !important; display: block; width: 100%"><img style="max-width: 100%; width: 100%; height: auto" ${1}></div>',
			'<div style="text-align: center !important; display: block; width: 100%"><img style="max-width: 100%; height: auto" ${1}></div>'
		);



		//$pattern = '/<img ([^>]+)>/';
		//$replacement = '<div style="text-align: center !important; display: block; width: 100%"><img style="max-width: 100%; width: 100%; height: auto" ${1}></div>';
		$content = preg_replace($patterns, $replacements, $content);


		$slug = basename(get_permalink());

		$urlPattern = array();
		$urlReplace = array();

		//if paragraph already has its own style, include it!
		$urlPattern[2] = <<<PAT
		/<p style=(["'])([^"']+)(["'])/
PAT;
		$urlReplace[2] = 
			'<p style="font-family: Helvetica, sans-serif; font-size: 18px; color: black; line-height: 1.6; margin-top: 1em; '
			. '${2}'
			.'"';

		//with some variables already included
		$urlPattern[0] = <<<PAT
		/href=(["'])([^"']+)\?([^"']+)(["'])/
PAT;
		$urlReplace[0] = 'href=${1}${2}?${3}'
			. '&'
			. "utm_source=newsletter&utm_medium=email&utm_campaign=obvestilo-$slug"
			. '${4}';
		//without any variables included
		$urlPattern[1] = <<<PAT
		/href=(["'])([^"'\?]+)(["'])/
PAT;
		$urlReplace[1] = 'href=${1}${2}'
			. '?'
			. "utm_source=newsletter&utm_medium=email&utm_campaign=obvestilo-$slug"
			. '${3}';
		
		$content = preg_replace($urlPattern, $urlReplace, $content);
 
#		//without any variables included and is not a directory! (no trailing slash, eg. index.php or www.bar.fu!!!)
#		$find = '#href=([\"\'])([^\"\'\?])+([^/])([\"\'])#';
#		$replace = 'href=${1}${2}${3}'
#			. '/?'
#			. "utm_source=newsletter&utm_medium=email&utm_campaign=obvestilo-$slug"
#			. '${4}';
#
#		$content = preg_replace($find, $replace, $content);

		echo $content;

	endwhile; endif;
	get_footer('obvestilo');
?>
