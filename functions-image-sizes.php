<?php
add_action('after_setup_theme', 'image_size_setup');
function image_size_setup() {
	add_image_size('myShowcaseImage', 940, 300, true);
	add_image_size('myThumbnail', 220, 80, true);
	add_image_size('myAuthorThumbnail', 140, 140, true);
	add_image_size('myShowcaseImageSmall', 700, 300, true);
	add_image_size('myArticleThumbnail', 380);
	add_image_size('myOneColThumb', 60);
	add_image_size('myArticleImage', 480);
	//add_image_size('myEmailThumbnail', 480, 160, true);
	//add_image_size('myEmailThumbnail', 600, 600, false); /* po novem je kar medium! 600x600 */
	//add_image_size('myArticleImageSmall', 220); //not used?
	add_image_size('myBookThumbnail', 220);
	add_image_size('myTwoColImage', 140);
	//add_image_size('myThreeColThumb', 300, 150, true); //not used?
	add_image_size('myOneColSquare', 60, 60, true);
	/* za nova obvestila po mejlu */
	/* ne rabimo več, po novem medium 600x600, kot newsletter */
	//add_image_size('myNewsletterFull', 530, 256, true);
	//add_image_size('myNewsletterFullHeight', 530);
	//add_image_size('myNewsletterFullBig', 530, 354, true);
	//add_image_size('myNewsletterHalf', 256, 256, true);
	/* začasno za mimoglasje 2013 */ //ne rabimo več novih
	//add_image_size('newlitSpecial1', 150, 150, true);
	//add_image_size('newlitSpecial2', 325, 150, true);
	/*add_image_size('newlitSpecial3', 325, 150, true);*/
	//add_image_size('newlitSpecial4', 500);
	

}

function my_insert_custom_image_sizes($sizes) {
  global $_wp_additional_image_sizes;
  if (empty($_wp_additional_image_sizes))
    return $sizes;

  foreach ($_wp_additional_image_sizes as $id => $data) {
    if (!isset($sizes[$id]))
      $sizes[$id] = ucfirst(str_replace('-', ' ', $id ));
  }

  return $sizes;
}
add_filter('image_size_names_choose', 'my_insert_custom_image_sizes');

?>
