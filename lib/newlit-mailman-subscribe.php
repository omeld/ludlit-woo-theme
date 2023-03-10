<?php
//require('/Users/andrej/banja/lib/FirePHPCore-0.3.2/lib/FirePHPCore/fb.php');
$return = '';
$result = array(
	'status' => false,
	'error' => 'Nekaj ni v redu',
	'address' => $_POST['newlit-subscribe-address']
);

if (!filter_var($result['address'], FILTER_VALIDATE_EMAIL)) {
	$result['error'] = 'Neveljaven naslov';
} else {
	$result['error'] = false;
	
	$mailmanOptions = array(
		'adminpw' => 'ludliterjav',
		'listname' => 'ludlit-info'
	);

	$mailmanOptions['url'] = 'https://mail.ljudmila.org/cgi-bin/mailman/admin/' 
		. $mailmanOptions['listname'] 
		. '/members/add?'
		. 'subscribe_or_invite=1'
		. '&send_welcome_msg_to_this_batch=0'
		. '&notification_to_list_owner=0'
		. '&subscribees_upload=' . $result['address']
		. '&adminpw=' . $mailmanOptions['adminpw'];


	$result['content'] = file_get_contents($mailmanOptions['url']);

	if (preg_match('#<h5>([^<]+)</h5>.+?(<ul>.+?</ul>)#is', $result['content'], $matches)) {
		if (($matches[1] == 'Uspešno prijavljeni:')
			|| ($matches[1] == 'Povabilo sprejeli:')
		) {
			$result['status'] = true;
		} else {
			$result['error'] = trim(strip_tags($matches[1]), ':') . '<br>' . trim(strip_tags($matches[2]));
		}
	} else {
	}

	unset($result['content']);

	//$return = json_encode($mailmanOptions);
}
//echo json_encode($mailmanOptions);
//header('Content-Type: application/json');
exit(json_encode($result));
?>
