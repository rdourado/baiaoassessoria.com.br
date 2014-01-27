		<hr>
		<div class="sidebar">
<?php 		if ( has_post_thumbnail( 91 ) ) : ?>
			<aside class="widget widget-text">
				<h3 class="widget-title"><?php _e('Fale conosco', 'baiao'); ?></h3>
				<div class="textwidget">
					<a href="<?php echo get_permalink( 91 ); ?>" class="border"><?php the_post_thumbnail( 91 ); ?></a>
				</div>
			</aside>
<?php 		endif; ?>
<?php 		if ( get_field( 'jobs' ) ) : ?>
			<aside class="widget widget-text">
				<h3 class="widget-title"><?php _e('Vagas atuais', 'baiao'); ?></h3>
				<div class="textwidget">
<?php 				while( has_sub_field( 'jobs' ) ) : ?>
					<p>
						<strong><?php the_sub_field( 'job_title' ); ?></strong><br>
						<?php _e('Atividades:', 'baiao'); ?> <?php the_sub_field( 'job_excerpt' ); ?>
					</p>
					<p><?php _e('Requisitos mínimos:', 'baiao'); ?></p>
					<ul>
<?php 					while( has_sub_field( 'job_requirements' ) ) : ?>
						<li><?php the_sub_field( 'job_item' ); ?></li>
<?php 					endwhile; ?>
					</ul>
<?php 				endwhile; ?>
				</div>
			</aside>
<?php 		endif; ?>
		</div>
