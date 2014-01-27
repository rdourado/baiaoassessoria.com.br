<?php get_header(); ?>
	<div class="header">
		<div class="header-wrap">
			<h1 class="header-title"><?php single_cat_title() ?></h1>
			<blockquote class="header-quote">
				<p>“<?php category_quote() ?>"</p>
				<footer class="header-source">(<?php category_source() ?>)</footer>
			</blockquote>
		</div>
	</div>
	<div class="body">
		<div class="content">
			<ol class="archive-list">
<?php 			get_template_part( 'loop', 'archive' ); ?>
			</ol>
			<?php if ( function_exists( 'wp_pagenavi' ) ) wp_pagenavi(); ?>
		</div>
<?php 	get_sidebar( 'category' ) ?>
	</div>
<?php get_footer() ?>