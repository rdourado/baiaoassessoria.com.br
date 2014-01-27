		<hr>
		<div class="sidebar">
<?php 		if ( has_post_thumbnail( 10 ) ) : ?>
			<aside class="widget widget-text">
				<h3 class="widget-title"><?php _e('Trabalhe conosco', 'baiao'); ?></h3>
				<div class="textwidget">
					<a href="<?php echo get_permalink( 10 ); ?>" class="border"><?php the_post_thumbnail( 10 ); ?></a>
				</div>
			</aside>
<?php 		endif; ?>
<?php 		if ( get_field( 'addresses' ) ) : ?>
			<aside class="widget widget-addr">
				<h3 class="widget-title"><?php _e('Nossos endereços', 'baiao'); ?></h3>
				<div class="wgal-thumbs">
<?php 				$i = 0;
					while( has_sub_field( 'addresses' ) ) :
					$url = get_permalink();
					$url = add_query_arg( 'addr', $i, $url ); ?>
					<a href="<?php echo $url; ?>" class="wgal-thumb fancybox" title="<?php echo get_sub_field( 'addr_title' ) . ' — ' . get_sub_field( 'addr_addr' ); ?>" data-fancybox-type="ajax">
						<span class="border"><?php echo wp_get_attachment_image( get_sub_field( 'addr_image' ), 'square_medium' ); ?></span>
						<h4 class="addr-title"><?php the_sub_field( 'addr_title' ); ?></h4>
					</a>
<?php 				$i++;
					endwhile; ?>
				</div>
			</aside>
<?php 		endif; ?>
		</div>
