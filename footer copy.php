			<div class="text-outer">
				<!--<div id="footer-subscribe" class="inline-subscribe block-para reverse almost-black-background center stretch-full-width tiny-top-padding tiny-bottom-padding font-size-1 bold"><p>Bodite obveščeni. Bodite udeleženi. Literaturin obveščevalnik v vašem e-poštnem nabiralniku.</p><p><a class="plain-link" href="<?php echo site_url('/prijava-na-novice'); ?>"><span class="font-size-1 bold button blue-background reverse">Naročilo</span></a></p>
				</div>-->
				<div id="footer-archives" class="gray-background-1 stretch-full-width top-padding-not footer">
					<ul class="category-list-container true-liquid-block-outer bare-links bare-list bare-section-with-margins " style="margin-top: 0; margin-bottom: 0"><!--
						<?php dynamic_sidebar('newlit-social-widget'); ?>
						<?php dynamic_sidebar('newlit-categories-widget'); ?>
						<?php dynamic_sidebar('newlit-monthly-archives-widget'); ?>
					--></ul>
				</div>
				<div id="footer-about" class="almost-black-background gray-3 stretch-full-width top-padding footer">
					<ul class="category-list-container true-liquid-block-outer bare-list bare-section-with-margins "><!--
						<?php dynamic_sidebar('newlit-editors-widget'); ?>
						<?php dynamic_sidebar('newlit-about-widget'); ?>
					--></ul>
					<div id="addthis-social-networks-follow" class="small-top-margin medium-bottom-margin addthis_horizontal_follow_toolbox bare-links center center-margins"></div>
					<p class=" center"><b><a href="<?php echo site_url('/o-mediju-in-pogojih-sodelovanja/'); ?>">O mediju in pogojih sodelovanja</a></b></p>
					<p class=" center"><b><a href="<?php echo site_url('/navodila-za-posiljanje-prispevkov/'); ?>">Navodila za pošiljanje prispevkov</a></b></p>
					<p class=" center"><b><a href="<?php echo site_url('/splosna-pravila-in-pogoji-nagradnih-iger/'); ?>">Splošna pravila in pogoji nagradnih iger</a></b></p>
					<p class=" center"><b><a href="<?php echo site_url('/pogoji-poslovanja-trgovine/'); ?>">Pogoji poslovanja trgovine</a></b></p>

					<div class="text-outer">
						<p class="center block-para small-bottom-margin">© avtorji in LUD Literatura <a href="http://www.ludliteratura.si" title="LUD Literatura">www.ludliteratura.si</a></p>
					<p class="medium-top-margin center ">Elektronski medij www.ludliteratura.si podpirata Ministrstvo za kulturo RS in Javna agencija za knjigo RS.</p>
					</div>
				</div>
				<div class="white-background small-top-padding stretch-full-width">
					<p class="block-para text-outer center">
						Izdelava: Pika vejica
					</p>
				</div>
			</div>
		</div> <!-- container div --> <?php //FIXME TODO ????? ?>
		<!--<script  type="text/plain" class="cc-onconsent-social" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-4f4f196e17f638ee"></script>-->
		<script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-4f4f196e17f638ee" async></script>
		<script type="text/javascript">
			var addthis_config = {
				data_ga_property: 'UA-22395392-2',
				ui_cobrand: "LUD Literatura",
				ui_click: true
			}; 
		</script>
		<?php wp_footer(); ?>
	</body>
</html>
