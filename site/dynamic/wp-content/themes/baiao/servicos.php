<?php 
/*
Template name: Serviços
*/
?>
<?php get_header() ?>
	<div class="header">
<?php 	while( have_posts() ) : the_post(); ?>
		<h1 class="header-title">Serviços / <?php the_title() ?></h1>
	</div>
	<div class="body">
		<article class="content">
			<h2 class="entry-title hide"><?php the_title() ?></h2>
			<div class="post-content entry-content">
				<?php the_content() ?>
			</div>
		</article>
<?php 	endwhile; ?>
<?php 	get_sidebar( 'servicos' ) ?>
	</div>
<?php get_footer() ?>