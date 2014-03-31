<!DOCTYPE html>
<html lang='pt-br'>
<head>
	<meta charset='UTF-8'>
	<title><?php wp_title() ?></title>
	<link href='<?php t_url() ?>/css/screen.css' rel='stylesheet'>
	<?php wp_head() ?>
</head>
<body <?php body_class() ?>>
	<header class='head'>
		<h1 class='logo'><img alt='<?php name() ?>' class='logo-img' height='159' src='<?php t_url() ?>/img/logo.png' width='277'></h1>
		<section class='welcome'>
			<h2 class='welcome-title'>
				Olá <strong><?php user_name() ?></strong> 
				<a href="<?php echo wp_logout_url( home_url() ); ?>">sair</a>
			</h2>
			<?php user_avatar( 'welcome-avatar' ) ?>
			<dl class='welcome-data'>
				<dt class='welcome-term'>Setor:</dt>
				<dd class='welcome-value'><?php user_field( 'setor' ) ?></dd>
			</dl>
			<dl class='welcome-data'>
				<dt class='welcome-term'>Sede/Filial:</dt>
				<dd class='welcome-value'><?php user_field( 'sede' ) ?></dd>
			</dl>
			<dl class='welcome-data'>
				<dt class='welcome-term'>Cargo:</dt>
				<dd class='welcome-value'><?php user_field( 'cargo' ) ?></dd>
			</dl>
			<dl class='welcome-data'>
				<dt class='welcome-term'>Telefone:</dt>
				<dd class='welcome-value'><?php user_field( 'telefone' ) ?></dd>
			</dl>
		</section>
		<form action='<?php home() ?>' class='search-form' method='get'>
			<fieldset>
				<legend>Busca no site</legend>
				<input aria-label='Busque o conteúdo no site' aria-required='true' class='s-search' id='s' name='s' placeholder='Busque o conteúdo no site' required type='search'>
				<button class='s-submit' type='submit'><span>Ok</span></button>
			</fieldset>
		</form>
		<form action='https://www.google.com.br/search' class='google-form' method='get' target='_blank'>
			<fieldset>
				<legend>Busca no Google</legend>
				<input aria-label='Busque o conteúdo no site' aria-required='true' class='s-search' id='q' name='q' placeholder='Busque no Google' required type='search'>
				<button class='s-submit' type='submit'><span>Ok</span></button>
			</fieldset>
		</form>
		<nav class='nav'>
			<?php 
			wp_nav_menu( array(
				'theme_location' => 'primary',
				'container' => '',
				'menu_class' => 'menu',
			) );
			?>

			<?php 
			wp_nav_menu( array(
				'theme_location' => 'secondary',
				'container' => '',
				'menu_class' => 'shortcuts',
			) );
			?>

		</nav>
	</header>
	<hr>
