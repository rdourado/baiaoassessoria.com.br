			<aside class="widget widget-newsletter">
				<h3 class="widget-title"><?php _e('Assine a nossa Newsletter', 'baiao'); ?></h3>
				<form action="http://feedburner.google.com/fb/a/mailverify" method="post" target="popupwindow" onsubmit="window.open('http://feedburner.google.com/fb/a/mailverify?uri=BaiaoAssessoria', 'popupwindow', 'scrollbars=yes,width=550,height=520');return true" class="newsletter-form">
					<fieldset>
						<legend><?php _e('Newsletter', 'baiao'); ?></legend>
						<!-- <input type="text" name="" id="" class="text newsletter-name" placeholder="Nome completo:" aria-label="Nome completo"> -->
						<input type="email" name="email" class="text newsletter-email" required placeholder="<?php _e('E-mail', 'baiao'); ?>:" aria-label="<?php _e('E-mail', 'baiao'); ?>">
						<input type="hidden" name="uri" value="BaiaoAssessoria">
						<input type="hidden" name="loc" value="pt_BR">
						<button type="submit" class="button newsletter-submit"><?php _e('Desejo ser assinante', 'baiao'); ?></button>
					</fieldset>
				</form>
			</aside>
