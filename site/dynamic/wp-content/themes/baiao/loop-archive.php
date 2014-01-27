<?php 			while( have_posts() ) : the_post(); ?>
				<li class="archive-item">
					<a href="<?php the_permalink() ?>">
						<?php the_post_thumbnail( 'square_thumb', array( 'class' => 'archive-image' ) ); ?>

						<h2 class="archive-title"><?php the_title() ?></h2>
						<p class="archive-excerpt"><?php the_excerpt() ?></p>
						<p class="archive-more"><?php _e('Leia essa notícia completa', 'baiao'); ?></p>
					</a>
				</li>
<?php 			endwhile; ?>
