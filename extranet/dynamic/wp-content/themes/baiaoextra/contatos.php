<?php 
/*
Template name: Contatos da empresa
*/
?>
<?php get_header() ?>
	<div class='body'>
<?php 	while( have_posts() ) : the_post(); ?>
		<h1 id="matriz" class='page-title'><?php the_title() ?></h1>
		<?php the_content() ?>
<?php 	endwhile; ?>
<?php 	$loop = new WP_Query( 'post_type=empresa&posts_per_page=-1&meta_key=tipo&meta_value=Matriz' );
		while ( $loop->have_posts() ) :
			$loop->the_post();
			get_template_part( 'loop', 'empresa' );
		endwhile;
		wp_reset_postdata();
?>
		<hr>
<?php 	$loop = new WP_Query( 'post_type=empresa&posts_per_page=-1&meta_key=tipo&meta_value=Filial' );
		if ( $loop->have_posts() ) : ?>
		<h3 id="filiais">Filiais</h3>
		<ul class='cols-4'>
<?php 		
			while ( $loop->have_posts() ) : 
				$loop->the_post();
				$tag = 'li';
				get_template_part( 'loop', 'empresa' );
			endwhile;
?>
		</ul>
<?php 	endif;
		wp_reset_postdata(); ?>
	</div>
<?php get_footer() ?>