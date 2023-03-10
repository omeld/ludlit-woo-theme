<?php if ( have_comments() ) : ?>
<?php $numberOfComments = get_comments_number(); ?>
<!--
<p class="commentsNum serif">
	Število komentarjev: <?php echo $numberOfComments; ?>
</p>
-->
<ul class="commentlist margin-after-item">
<?php
	$args = array(
		'reply_text' => 'Odgovori na ta komentar',
		'avatar_size' => 60
	);	
	wp_list_comments($args);
?>
</ul>
<?php endif; ?>

<?php
$myArgs = array(
	"title_reply" => "Pripiši svoje mnenje",
	"comment_field" => '<p class="comment-form-comment"><label for="comment">Komentar</label><textarea id="comment" name="comment" cols="45" rows="8" aria-required="true"></textarea></p>',
	'comment_notes_before' => '<p>Vaš naslov je potreben zaradi varnosti in ne bo objavljen.</p>',
	'comment_notes_after' => '',
	'label_submit' => 'Oddaj',
	'logged_in_as' => '<p class="logged-in-as">' . sprintf('Prijavljeni ste kot <a href="%1$s">%2$s</a>. <a href="%3$s" title="Log out of this account">Se želite odjaviti?</a>', admin_url( 'profile.php' ), $user_identity, wp_logout_url( apply_filters( 'the_permalink', get_permalink( ) ) ) ) . '</p>',
	'must_log_in' => '<p class="must-log-in">' . 
		sprintf('Za objavo komentarja se morate <a href="%s">prijaviti</a> oz. najprej <a href="%s">registrirati</a>.', 
		wp_login_url(apply_filters('the_permalink', get_permalink())),
		wp_registration_url()
	)
);

	comment_form($myArgs);
?>
