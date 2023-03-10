<?php
/*
Template Name: subscription page
 */
?>
<?php get_header('home'); ?>
</div>
<div id="newlit-ajax-overlay" class="full-stretch center" style="background-color: rgba(0,0,0,0.25); z-index: 999; position: fixed; display: none">
	<div class="force-vertical-middle font-size-8" style="height: 100%">
		<div class="fa fa-circle-o-notch fa-spin reverse">
		</div>
	</div>
</div>
<div class="center force-vertical-middle dont-use-full-page mobile-override stretch-full-width gray-background <?php echo implode(' ', get_post_class()); ?>">
<div class="text-outer"><!--
	--><div class="newlit-subscribe-block inline-block center one-two vertical-middle large-top-padding large-bottom-padding font-size-5">
		<div id="newlit-subscribe-invitation" class="fade-in light display-font font-size-8 leading-display">Kdor bere,<br/>je udeležen.</div>
		<form class="small-top-margin center-margins" id="newlit-mailman-subscribe" action="<?php echo $_SERVER['REQUEST_URI']; ?>" method="post">
			<label id="newlit-subscribe-label" for="newlit-subscribe-address" class="font-size-1">Vpiši svoj e-naslov:</label>
			<input class="center font-size-3 serif bold" id="newlit-input-email" value="" type="text" name="newlit-subscribe-address" style="border: none; border-bottom: 1px dotted; background-color: transparent" />
			<div id="newlit-form-errors" class="sans bold font-size-1 errors"></div>
			<input class="small-top-margin button font-size-2 sans bold red-background" type="submit" name="prijava" value="Hočem se pridružiti!" style="padding: 0.5em 1em; border: 1px double; cursor: pointer; border-radius: 0.5em" />
		</form>
		<div class="sans bold font-size-0" id="newlit-subscribe-responses">
		</div>
	</div>
</div>
</div>
<div id="container" class="clearfix">
<script type="text/javascript"> 
$('#newlit-mailman-subscribe').submit(function(e){
	e.preventDefault();
	$('#newlit-ajax-overlay').fadeToggle('fast');
	$.ajax({
		url: '<?php echo bloginfo('template_url'); ?>/lib/newlit-mailman-subscribe.php',
		data: $('#newlit-mailman-subscribe').serialize(),
		dataType: 'json',
		type: 'POST',
		//fail: function() {
		error: function() {
			alert('Hm. Ne deluje.');
		},
		//done: function(data) {
		success: function(data) {
			$('#newlit-ajax-overlay').fadeOut('fast');
			if (data.error !== false) {
				$('#newlit-subscribe-invitation').fadeOut('fast', function() {
					$(this).html('Poskusi še enkrat!');
					$(this).fadeIn('slow');
				});
				$('#newlit-subscribe-label').html('Vpiši svoj <b>veljavni</b> e-naslov:');
				$('#newlit-form-errors').html('<p>' + data.error + '</p>');
			} else {
				$('#newlit-subscribe-invitation').fadeOut('fast', function() {
					$(this).html('<p class="font-size-8">Hvala!</p><p class="small-top-margin leading-normal sans font-size-2 bold">Odpri potrditveni e-mail in klikni link.<br>Označi kot zaželeno pošto in dodaj naš naslov v svoj imenik –<br>s tem si boš zagotovil redno dostavo.</p>');
					$(this).fadeIn('slow');
				});
				$('#newlit-form-errors').html('');
				$('#newlit-subscribe-label').html('Naslov ' + data.address + ' vpisan.');
			}
			//$('#newlit-subscribe-responses').html('<p>OK<br/><pre>' + JSON.stringify(data) + '</pre></p>')
		},
		//always: function() {
		complete: function() {
			$('#newlit-ajax-overlay').fadeOut('fast');
		}
	});
});
</script>

<?php get_footer(); ?>
