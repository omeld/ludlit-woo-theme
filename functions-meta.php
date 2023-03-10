<?php

//wp_enqueue_script('add-meta-instance', get_template_directory_uri().'/js/add-meta-instance.js');

function newlitAdminThemeInit() {
    if (is_admin()) {
        wp_enqueue_style('newlitAdminStyle', get_template_directory_uri()."/newlitAdminTheme.css");
    }
}
add_action('admin_init', 'newlitAdminThemeInit');


add_action('add_meta_boxes', 'newlitAddMetaPress');

function newlitAddMetaPress() {
	$myPostTypes = array('knjiga', 'product'); // andrej2022
	add_meta_box('newlit-press-quote-meta', 'Citati iz kritik', 'newlitPressMetaFunction', $myPostTypes, 'normal', 'low'); // andrej2022
	add_meta_box('newlit-prize-meta', 'Nagrade', 'newlitPrizeMetaFunction', $myPostTypes, 'normal', 'low'); // andrej2022
}

add_action('save_post', 'newlitSaveMetaPress');
add_action('save_post', 'newlitSaveMetaPrize');

function newlitSaveMetaPrize($post_id) {
	if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;
	if (!isset($_POST['newlitPrizeMetaNonce']) || !wp_verify_nonce($_POST['newlitPrizeMetaNonce'], 'newlitPrizeMetaNonceFunction')) return;
	if (!current_user_can('edit_post')) return;

	$htmlAllow = array(
		'a' => array(
			'href' => array()
		)
	);

	if (isset($_POST['newlitPrize'])) {
		update_post_meta($post_id, 'newlitPrize', $_POST['newlitPrize']);
		//foreach ($_POST['newlitPrize'] as $prize) {
		//}
	}
}

function newlitSaveMetaPress($post_id) {
	if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;
	if (!isset($_POST['newlitPressMetaNonce']) || !wp_verify_nonce($_POST['newlitPressMetaNonce'], 'newlitPressMetaNonceFunction')) return;
	if (!current_user_can('edit_post')) return;

	$htmlAllow = array(
		'a' => array(
			'href' => array()
		)
	);

    //$songs = $_POST['songs'];
    //update_post_meta($post_id,'songs',$songs);

	if (isset($_POST['newlitPressQuote'])) {
		update_post_meta($post_id, 'newlitPressQuote', $_POST['newlitPressQuote']);
		foreach ($_POST['newlitPressQuote'] as $quote) {

			/*
			if (isset($quote['Text'])) {
				update_post_meta($post_id, 'newlitPressQuoteText', wp_kses($quote['Text'], $htmlAllow));
			}
			if (isset($quote['Source'])) {
				update_post_meta($post_id, 'newlitPressQuoteSource', wp_kses($quote['Source'], $htmlAllow));
			}
			 */
			//update_post_meta($post_id, 'newlitPressQuote', wp_kses($quote, $htmlAllow));
			//update_post_meta($post_id, 'newlitPressQuote', $quote);
		}
	}
}

function newlitPrizeMetaFunction($post) {

	$fieldCount2 = 0;

	$myPrizes = get_post_meta($post->ID, 'newlitPrize', true);
	//echo "<!-- bar\n", count($myPrizes), "\n"; print_r($myPrizes); echo "\n -->";

	wp_nonce_field('newlitPrizeMetaNonceFunction', 'newlitPrizeMetaNonce'); 

	//if (count($myPrizes) > 1) {
	if (is_array($myPrizes) and count($myPrizes) > 0) {
		foreach ($myPrizes as $prize) {

			$thePrizeName = isset($prize['Name']) 
				? esc_attr($prize['Name']) 
				: ''; 
			$thePrizeYear = isset($prize['Year']) 
				? esc_attr($prize['Year']) 
				: ''; 

?>
<div class="newlitOnePrize">
<span class="newlitLabel">Nagrada: </span>
<div class="newlitInputWrap">
<input class="newlitMetaInput" id="newlitPN-<?php echo $fieldCount2; ?>" name="newlitPrize[<?php echo $fieldCount2; ?>][Name]" value="<?php echo $thePrizeName; ?>">
</div>
<span class="newlitLabel">Leto: </span>
<div class="newlitInputWrap">
<input class="newlitMetaInput" id="newlitPY-<?php echo $fieldCount2; ?>" type="text" name="newlitPrize[<?php echo $fieldCount2; ?>][Year]" value="<?php echo $thePrizeYear; ?>">
</div>
<a class="newlitRemovePrize">odstrani</a>
</div>
<?php
			$fieldCount2++;
		}
	} else {
	}
?>
		<p><a id="newlitPrizeMetaAddField">Dodaj</a></p>
<?php
?>
<script>
    var $ =jQuery.noConflict();
	$(document).ready(function() {
		var count2 = <?php echo $fieldCount2; ?>;
		//$(".newlitRemovePrize").live('click', function() { 	//andrej2022 deprecated!
		$(document).on('click', '.newlitRemovePrize', function() {		//andrej2022 new version
			$(this).parent(".newlitOnePrize").remove();
		});

		$("#newlitPrizeMetaAddField").click(function() {
			var prizeMetaRow =
				"<div class=\"newlitOnePrize\">" +
				"<span class=\"newlitLabel\">Nagrada: </span>" + 
				"<div class=\"newlitInputWrap\">" +
				"<input class=\"newlitMetaInput\" id=\"newlitPN-" + count2 + "\" name=\"newlitPrize[" + count2 + "][Name]\">" + 
				"</div><span class=\"newlitLabel\">Leto: </span>" + 
				"<div class=\"newlitInputWrap\">" +
				"<input class=\"newlitMetaInput\" id=\"newlitPY-" + count2 + "\" type=\"text\" name=\"newlitPrize[" + count2 + "][Year]\" value=\"\">" + 
				"<a class=\"newlitRemovePrize\">izbriši</a>" +
				"</div>";
			$("#newlitPrizeMetaAddField").before(
				prizeMetaRow
			);
			count2++;
		});
	});
</script>

<?php
}

function newlitPressMetaFunction($post) {

	$fieldCount = 0;

	//$myCustomMeta = get_post_custom($post->ID);
	//$myPressQuotes = unserialize($myCustomMeta['newlitPressQuote'][0]);
	//echo "<!-- myPressQuotes \n"; print_r($myPressQuotes); echo "\n -->";
	/* ISTO */
	$myPressQuotes = get_post_meta($post->ID, 'newlitPressQuote', true);
	//echo "<!-- foo\n", count($myPressQuotes), "\n";  print_r($myPressQuotes); echo "\n -->";


	wp_nonce_field('newlitPressMetaNonceFunction', 'newlitPressMetaNonce'); 

	//if (count($myPressQuotes) > 0) { // 1 pomeni napako (ni array)!
	if (is_array($myPressQuotes) and count($myPressQuotes) > 0) {
		foreach ($myPressQuotes as $quote) {

			$thePressQuoteText = isset($quote['Text']) 
				? esc_attr($quote['Text']) 
				: ''; 
			$thePressQuoteSource = isset($quote['Source']) 
				? esc_attr($quote['Source']) 
				: ''; 

?>
<div class="newlitOnePressQuote">
<div>
<p class="newlitLabel">Citat: </p>
<textarea class="newlitMetaTextarea" id="newlitPQT-<?php echo $fieldCount; ?>" name="newlitPressQuote[<?php echo $fieldCount; ?>][Text]" ><?php echo $thePressQuoteText; ?></textarea>
</div>
<div>
<p class="newlitLabel">Vir: </p>
<input class="newlitMetaInput" id="newlitPQS-<?php echo $fieldCount; ?>" type="text" name="newlitPressQuote[<?php echo $fieldCount; ?>][Source]" value="<?php echo $thePressQuoteSource; ?>">
</div>
<a class="newlitRemoveQuote">izbriši</a>
</div>
<?php
			$fieldCount++;
		}
	} else {
	}
?>
		<p><a id="newlitQuoteMetaAddField">Dodaj</a></p>
<?php
?>
<script>
    var $ =jQuery.noConflict();
	$(document).ready(function() {
		var count = <?php echo $fieldCount; ?>;
		//$(".newlitRemoveQuote").live('click', function() {			//andrej2022 deprecated
		$(document).on('click', '.newlitRemoveQuote', function() {		//andrej2022 new version
			$(this).parent(".newlitOnePressQuote").remove();
		});

		$("#newlitQuoteMetaAddField").click(function() {
			var quoteMetaRow =
				"<div class=\"newlitOnePressQuote\">" +
				"<div>" + 
				"<p class=\"newlitLabel\">Citat: </p>" + 
				"<textarea class=\"newlitMetaTextarea\" id=\"newlitPQT-" + count + "\" name=\"newlitPressQuote[" + count + "][Text]\" ></textarea>" + 
				"</div>" + 
				"<div>" + 
				"<p class=\"newlitLabel\">Vir: </p>" + 
				"<input class=\"newlitMetaInput\" id=\"newlitPQS-" + count + "\" type=\"text\" name=\"newlitPressQuote[" + count + "][Source]\" value=\"\">" + 
				"</div>" + 
				"<a class=\"newlitRemoveQuote\">izbriši</a>" +
				"</div>";
			$("#newlitQuoteMetaAddField").before(
				quoteMetaRow
			);
			count++;
		});
	});
</script>

<?php
}

/*
	
	DISPLAYING THE DATA

 */


function newlitDisplayPrizeMeta($pid, $display = 1) {
	//global $wp_query;
	//$myPrizes = get_post_meta($wp_query->post->ID, 'newlitPrize', true);
	// zgornje sicer deluje!

	$myPrizes = get_post_meta($pid, 'newlitPrize', true);

	if (is_array($myPrizes) and count($myPrizes) > 0) {
		if ($display) { echo "<h4>Nagrade in nominacije</h4>"; }
		echo "<ul class=\"newlitPrizeList clearfix\">";
		foreach ($myPrizes as $prize) {
			$thePrizeName = isset($prize['Name']) 
				? esc_attr($prize['Name']) 
				: ''; 
			$thePrizeYear = isset($prize['Year']) 
				? esc_attr($prize['Year']) 
				: '';
?>
			<li class="newlitPrizeItem">
				<span class="newlitPrizeItemName"><?php echo $thePrizeName; ?></span> 
				<?php if ($display) : ?>
				<span class="newlitPrizeItemYear">(<?php echo $thePrizeYear; ?>)</span>
				<?php endif; ?>
			</li>
<?php
		}
		echo "</ul>";
	}
}

function newlitDisplayPressQuoteMeta($pid) {

	$myResult = array();

	$myPressQuotes = get_post_meta($pid, 'newlitPressQuote', true);

	if (is_array($myPressQuotes) and count($myPressQuotes) > 0) {
		foreach ($myPressQuotes as $quote) {
			$thePressQuoteText = isset($quote['Text']) 
				? esc_attr($quote['Text']) 
				: ''; 
			$thePressQuoteSource = isset($quote['Source']) 
				? esc_attr($quote['Source']) 
				: ''; 
			$myResult[] = array(
				'text' => $thePressQuoteText, 
				'source' => $thePressQuoteSource);
		}
	}
	return($myResult);
}
/*
function newlitDisplayPressQuoteMeta($pid) {

	$myPressQuotes = get_post_meta($pid, 'newlitPressQuote', true);

	if (is_array($myPressQuotes) and count($myPressQuotes) > 0) {
?>
<div class="oneArticle section">
	<div class="">
		<div class="articleText clearfix text-outer">
			<div id="press-quotes">
				<h6 id="pressQuotes">Iz kritike</h6>
				<ul class="newlitPressQuotesList serif true-liquid-block-outer clearfix font-size-2">
					<!--
<?php
foreach ($myPressQuotes as $quote) {
	$thePressQuoteText = isset($quote['Text']) 
		? esc_attr($quote['Text']) 
		: ''; 
	$thePressQuoteSource = isset($quote['Source']) 
		? esc_attr($quote['Source']) 
		: ''; 

?>
					--><li class="newlitPressQuoteItem true-liquid-block-inner one-three ">
						<p class="newlitPressQuoteItemText "><?php echo $thePressQuoteText; ?> 
							<span class="newlitPressQuoteItemSource"><?php echo $thePressQuoteSource; ?></span>
						</p>
					</li><!--
<?php
		}
?>
		-->
				</ul>
			</div>
		</div>
	</div>
</div>
<?php
	}
	

}
*/

add_action('add_meta_boxes', 'newlitAddLinkMeta');

function newlitAddLinkMeta() {
	add_meta_box('newlit-link-meta', 'Posebna preusmeritev', 'newlitLinkMetaFunction', 'post', 'normal', 'low');
	add_meta_box('newlit-link-meta', 'Posebna preusmeritev', 'newlitLinkMetaFunction', 'obvestilo', 'normal', 'low');
	add_meta_box('newlit-link-meta', 'Posebna preusmeritev', 'newlitLinkMetaFunction', 'page', 'normal', 'low');
}

add_action('save_post', 'newlitSaveLinkMeta');

function newlitSaveLinkMeta($post_id) {
	if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;
	if (!isset($_POST['newlitLinkMetaNonce']) || !wp_verify_nonce($_POST['newlitLinkMetaNonce'], 'newlitLinkMetaNonceFunction')) return;
	if (!current_user_can('edit_post')) return;

	if (isset($_POST['newlitLink'])) {
		update_post_meta($post_id, 'newlitLink', $_POST['newlitLink']);
	}
}


function newlitLinkMetaFunction($post) {
	$myLink = get_post_meta($post->ID, 'newlitLink', true);

	wp_nonce_field('newlitLinkMetaNonceFunction', 'newlitLinkMetaNonce'); 


?>
<div class="newlitOneLink">
	<span class="newlitLabel">Preusmeritev: </span>
	<div class="newlitInputWrap">
		<input class="newlitMetaInput" id="newlit-Link" name="newlitLink" value="<?php echo "$myLink"; ?>">
	</div>
</div>
<?php
}

/*
	newlit_revija_new - meta
 */

add_action('add_meta_boxes', 'newlit_revija_new_meta', 10, 2);
function newlit_revija_new_meta($post_type, $post) {
	add_meta_box(
		'newlit-revija-new-stevilka',
		'Številka revije',
		'newlit_revija_new_meta_function',
		'revija',
		'normal',
		'high'
	);
}

function newlit_revija_new_meta_function($post, $args) {
	wp_nonce_field(plugins_url(__FILE__), 'newlit_revija_noncename');
?>
	<label for="newlit-revija-new-stevilka">Številka revije</label>
	<input type="text" name="newlit-revija-new-stevilka" value="<?php echo get_post_meta($post->ID, 'newlit-revija-new-stevilka', true); ?>">
	<label for="newlit-revija-new-issue">Letnik revije (mesec, leto, letnik)</label>
	<input type="text" name="newlit-revija-new-issue" value="<?php echo get_post_meta($post->ID, 'newlit-revija-new-issue', true); ?>">
<?php
}

add_action('save_post', 'newlit_revija_new_issue_save', 10, 2);
function newlit_revija_new_issue_save($post_id, $post) {
	if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE)
		return;

	if ('newlit_revija_new' == $_POST['post_type']) {
		if (!current_user_can('edit_page', $post_id))
			return $post_id;
		} elseif (!current_user_can('edit_post', $post_id)) {
			return $post_id;
	}
	

	if (isset($_POST['newlit_revija_noncename']) 
	&& wp_verify_nonce($_POST['newlit_revija_noncename'], plugins_url(__FILE__)) 
	&& check_admin_referer(plugins_url(__FILE__), 'newlit_revija_noncename')) {
		update_post_meta($post_id, 'newlit-revija-new-stevilka', $_POST['newlit-revija-new-stevilka']);
		update_post_meta($post_id, 'newlit-revija-new-issue', $_POST['newlit-revija-new-issue']);
	}
	return;
}


?>
