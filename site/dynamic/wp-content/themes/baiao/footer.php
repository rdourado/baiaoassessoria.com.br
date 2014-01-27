	<hr>
	<footer class="foot">
<?php 	$ID = 91; ?>
		<div id="hcard-baiao" class="vcard">
			© 2009-<?php year() ?> <span class="fn org"><?php name() ?></span> - <?php _e('Todos os direitos reservados', 'baiao'); ?>

			<div class="adr">
				<span class="street-address"><?php the_field( 'street-address', $ID ); ?></span> - <span class="locality"><?php the_field( 'locality', $ID ); ?></span>/<span class="region"><?php the_field( 'region', $ID ); ?></span> - <?php _e('CEP:', 'baiao'); ?> <span class="postal-code"><?php the_field( 'postal-code', $ID ); ?></span>
			</div>
			<?php _e('Tele-fax:', 'baiao'); ?> <a href="+55<?php echo sanitize_number( get_field( 'tel', $ID ) ); ?>" class="tel"><?php the_field( 'tel', $ID ); ?></a> - <a class="email" href="mailto:<?php echo encode_email( get_field( 'email', $ID ) ); ?>"><?php echo encode_email( get_field( 'email', $ID ) ); ?></a>
		</div>
		<ul class="social-list">
			<li class="social-item"><a href="<?php rss() ?>" target="_blank"><img src="<?php url() ?>/img/icon-rss.png" alt="RSS" width="31" height="32"></a></li>
<?php 		if ( get_field( 'facebook', $ID ) ) : ?>
			<li class="social-item"><a href="<?php echo esc_url( get_field( 'facebook', $ID ) ); ?>" target="_blank"><img src="<?php url() ?>/img/icon-fb.png" alt="Facebook" width="31" height="32"></a></li>
<?php 		endif; ?>
<?php 		if ( get_field( 'twitter', $ID ) ) : ?>
			<li class="social-item"><a href="<?php echo esc_url( get_field( 'twitter', $ID ) ); ?>" target="_blank"><img src="<?php url() ?>/img/icon-tw.png" alt="Twitter" width="31" height="32"></a></li>
<?php 		endif; ?>
<?php 		if ( get_field( 'linkedin', $ID ) ) : ?>
			<li class="social-item"><a href="<?php echo esc_url( get_field( 'linkedin', $ID ) ); ?>" target="_blank"><img src="<?php url() ?>/img/icon-li.png" alt="LinkedIn" width="31" height="32"></a></li>
<?php 		endif; ?>
		</ul>
		<a href="http://cristianoweb.net/servicos/" class="by" target="_blank"><img src="<?php url() ?>/img/cristianoweb.png" alt="@cristianoweb" class="by-logo" width="122" height="17"></a>
	</footer>
	<!-- WP/ --><?php wp_footer() ?><!-- /WP -->
	<!--[if lte IE 9]>
	<script src="//cdnjs.cloudflare.com/ajax/libs/jquery-placeholder/2.0.7/jquery.placeholder.min.js"></script>
	<script>$('input[placeholder],textarea[placeholder]').placeholder();</script>
	<![endif]-->
	<script src="<?php bloginfo( 'template_url' ); ?>/js/interface.min.js"></script>
</body>
</html>