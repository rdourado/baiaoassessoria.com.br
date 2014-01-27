		<hr>
		<div class="sidebar">
<?php 		$loop = new WP_Query( 'posts_per_page=6' );
			if ( $loop->have_posts() ) : ?>
			<aside class="widget widget-news">
				<h3 class="widget-title"><?php _e('Notícias e jurisprudências', 'baiao'); ?></h3>
				<ul class="news-list">
<?php 				while( $loop->have_posts() ) : $loop->the_post(); ?>
					<li <?php post_class( 'news-item' ); ?>>
						<a href="<?php the_permalink() ?>">
							<time class="news-date" datetime="<?php the_time( 'Y-m-d' ); ?>"><?php the_time( 'd/m/Y' ); ?></time>
							<h4 class="news-title"><?php the_title() ?></h4>
						</a>
					</li>
<?php 				endwhile; ?>
				</ul>
			</aside>
<?php 		endif;
			wp_reset_postdata(); ?>
<?php 		get_template_part( 'widget', 'newsletter' ); ?>
		</div>
