		<hr>
		<div class="sidebar">
<?php 		$parent = $post->post_parent ? $post->post_parent : $post->ID;
			$images = get_field( 'gallery', $parent );
			if ( $images ) :
			$first = array_shift( $images ); ?>
			<aside class="widget widget-gallery">
				<h3 class="widget-title"><?php _e('Nossa estrutura', 'baiao'); ?></h3>
				<a href="<?php echo $first['url'] ?>" class="wgal-main border fancybox" rel="gallery1" title="<?php echo $first['caption']; ?>"><img src="<?php echo $first['sizes']['square_large'] ?>" alt=""></a>
				<div class="wgal-thumbs">
<?php 				foreach( $images as $image ) : ?>
					<a href="<?php echo $image['url']; ?>" class="wgal-thumb fancybox" rel="gallery1" title="<?php echo $image['caption']; ?>"><span class="border"><img src="<?php echo $image['sizes']['square_medium']; ?>" alt=""></span></a>
<?php 				endforeach; ?>
				</div>
			</aside>
<?php 		endif; ?>
		</div>
