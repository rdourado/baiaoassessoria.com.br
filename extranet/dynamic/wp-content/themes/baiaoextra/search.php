<?php get_header() ?>
	<div class='body'>
		<div class='content'>
			<h1 class='page-title'>Busca por ‘<?php the_search_query() ?>’</h1>
			<ol class='post-archive'>
<?php 				
					while( have_posts() ) : 
						the_post();
						get_template_part( 'loop' );
					endwhile;
?>
			</ol>
			<?php if ( function_exists( 'wp_pagenavi' ) ) wp_pagenavi(); ?>
		</div>
<?php 	get_sidebar() ?>
	</div>
<?php get_footer(); ?>