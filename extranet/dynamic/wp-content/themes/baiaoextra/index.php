<?php get_header() ?>
	<div class='body'>
		<div class='content'>
<?php 		if ( get_field( 'destaques', 'options' ) ) : ?>
			<section class='hero'>
				<h3 class='hero-title'>Eventos recentes e galerias de fotos</h3>
				<div id='slider'>
					<a class='buttons prev' href='#'>«</a>
					<div class='viewport'>
						<ul class='overview'>
<?php 						$total = 0;
							while( has_sub_field( 'destaques', 'options' ) ) :
							$total++; ?>
							<li><a href="<?php the_sub_field( 'link' ) ?>" class="no"><?php 
							echo wp_get_attachment_image( get_sub_field( 'imagem' ), 'highlight' ); ?></a></li>
<?php 						endwhile; ?>
						</ul>
					</div>
					<a class='buttons next' href='#'>»</a>
					<ul class='pager'>
<?php 					for ( $i = 0; $i < $total; $i++ ) : ?>
						<li><a class='pagenum' href='#' rel='<?php echo $i; ?>'><?php echo $i + 1; ?></a></li>
<?php 					endfor; ?>
					</ul>
				</div>
			</section>
<?php 		endif; ?>
			<section class='recent'>
				<h3 class='recent-title'>Últimas notícias, informações e comunicados</h3>
<?php 			if ( have_posts() ) : ?>
				<ol class='post-archive'>
<?php 				
					while( have_posts() ) : 
						the_post();
						get_template_part( 'loop' );
					endwhile;
?>
				</ol>
<?php 			endif; ?>
				<?php if ( function_exists( 'wp_pagenavi' ) ) wp_pagenavi(); ?>
			</section>
		</div>
<?php 	get_sidebar() ?>
	</div>
<?php get_footer() ?>