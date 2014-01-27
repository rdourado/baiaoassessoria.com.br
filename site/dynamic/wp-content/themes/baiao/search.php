<?php get_header(); ?>
	<div class="header">
		<h1 class="header-title"><?php _e('Busca', 'baiao'); ?></h1>
	</div>
	<div class="body">
		<div class="content">
<?php 		if ( have_posts() ) : ?>
			<ol class="archive-list">
<?php 			get_template_part( 'loop', 'archive' ); ?>
			</ol>
			<?php if ( function_exists( 'wp_pagenavi' ) ) wp_pagenavi(); ?>
<?php 		else : ?>
			<div class="post-content">
				<p><strong>Não foi encontrada nenhuma página com esse conteúdo. Por favor, refaça a busca alterando as palavras digitadas, ou entre em <a href="<?php the_permalink( 91 ); ?>">contato conosco</a>.</strong></p>
			</div>
<?php 		endif; ?>
		</div>
<?php 	get_sidebar() ?>
	</div>
<?php get_footer() ?>