<?php
/*
Plugin Name: LOKALNI DODATKI
Description: razni lokalni dodatki za newlit
Version: 1.0
Author: pika vejica
Author URI: http://www.pikavejica.si
*/

//iz izvorne kode: dodal sem pa samo eno vrstico
if ( !function_exists('wp_new_user_notification') ) :
	function wp_new_user_notification($user_id, $plaintext_pass = '') {
	        $user = get_userdata( $user_id );

	        $blogname = wp_specialchars_decode(get_option('blogname'), ENT_QUOTES);
	
	        $message  = sprintf(__('New user registration on your site %s:'), $blogname) . "\r\n\r\n";
	        $message .= sprintf(__('Username: %s'), $user->user_login) . "\r\n\r\n";
	        $message .= sprintf(__('E-mail: %s'), $user->user_email) . "\r\n";
	
	        @wp_mail(get_option('admin_email'), sprintf(__('[%s] New User Registration'), $blogname), $message);
	
	        if ( empty($plaintext_pass) )
	                return;
	
	        $message  = sprintf(__('Username: %s'), $user->user_login) . "\r\n";
			$message .= sprintf(__('Password: %s'), $plaintext_pass) . "\r\n";
			$message .= "\r\n" . 'POZOR: potrditev registracije s prvo prijavo je mogoča samo v naslednjih 48 urah, nakar bo potrebna ponovna registracija' . "\r\n";
	        $message .= wp_login_url() . "\r\n";
	
	        wp_mail($user->user_email, sprintf(__('[%s] uporabniško ime in geslo za registracijo'), $blogname), $message);
	
	}
endif;
?>
