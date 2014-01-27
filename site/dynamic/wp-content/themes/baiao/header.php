<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title><?php wp_title() ?></title>
	<link rel="stylesheet" href="<?php url(); ?>/css/screen.css" media="all">
	<!--[if lt IE 9]><script src="//cdnjs.cloudflare.com/ajax/libs/html5shiv/3.6.2/html5shiv.js"></script><![endif]-->
	<!-- WP/ --><?php wp_head() ?><!-- /WP -->
</head>
<body <?php body_class() ?>>
	<header class="head">
		<?php logo() ?>
		<form action="<?php echo home_url( '/' ); ?>" method="get" class="search-form">
			<fieldset>
				<legend><?php _e('Busca', 'baiao'); ?></legend>
				<input type="text" name="s" id="s" class="search-input" required placeholder="<?php _e('Faça uma busca', 'baiao'); ?>:" aria-label="<?php _e('Faça uma busca', 'baiao'); ?>">
				<button type="submit" class="search-submit"><img src="<?php url() ?>/img/magnifier.png" alt="<?php _e('OK', 'baiao'); ?>" class="search-icon" width="12" height="13"></button>
			</fieldset>
		</form>
		<?php 
		wp_nav_menu( array(
			'container' 		=> 'nav',
			'container_class' 	=> 'nav',
			'menu_class' 		=> 'menu',
			'fallback_cb' 		=> false,
			'depth' 			=> 1,
		) );
		?>

	</header>
	<hr>
