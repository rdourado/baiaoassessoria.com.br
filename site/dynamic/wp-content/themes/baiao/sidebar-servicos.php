		<hr>
		<div class="sidebar">
<?php 		$pages = new WP_Query( array(
				'post_type' 	=> 'page',
				'orderby' 		=> 'menu_order',
				'order' 		=> 'DESC',
				'post_parent' 	=> parent(),
				'post__not_in' 	=> array( $post->ID )
			) );
			if ( $pages->have_posts() ) : ?>
			<aside class="widget widget-more">
				<h3 class="widget-title"><?php _e('Outros Serviços', 'baiao'); ?></h3>
				<div class="textwidget">
					<p><?php the_field( 'sidebar_text', 6 ); ?></p>
				</div>
				<div class="wgal-thumbs">
<?php 				while( $pages->have_posts() ) : $pages->the_post();
					if ( has_post_thumbnail() ) : ?>
					<a href="<?php the_permalink(); ?>" class="wgal-thumb">
						<span class="border"><?php the_post_thumbnail( 'square_medium' ); ?></span>
						<h4 class="addr-title"><?php the_title(); ?></h4>
					</a>
<?php 				endif;
					endwhile; ?>
				</div>
			</aside>
<?php 		endif;
			wp_reset_postdata(); ?>
		</div>
