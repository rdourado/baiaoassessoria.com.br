<?php get_header() ?>
	<div class='body'>
		<div class='content'>
			<h1 class='page-title'>Comunicados internos</h1>
			<nav class='filters'>
				<strong class='filter-title'>Sede/filial:</strong>
				<ul class='filter-list'>
					<li class='cat-item<?php 
					if ( is_category( 5 ) ) echo ' current-cat'; 
					?>'><a href='<?php echo get_category_link( 5 ); ?>'>Todos</a></li>
<?php 				wp_list_categories( 'title_li=&taxonomy=sedes' ) ?>
				</ul>
				<strong class='filter-title'>Assunto:</strong>
				<ul class='filter-list'>
					<li class='cat-item<?php 
					if ( is_category( 5 ) ) echo ' current-cat'; 
					?>'><a href='<?php echo get_category_link( 5 ); ?>'>Todos</a></li>
<?php 				wp_list_categories( 'title_li=&taxonomy=post_tag' ) ?>
				</ul>
			</nav>
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