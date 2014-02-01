<?php get_header() ?>
	<div class='body'>
<?php 	while( have_posts() ) : the_post(); ?>
		<div class='content'>
			<h1 class='page-title'><?php 
			$category = get_the_category();
			echo $category[0]->cat_name;
			?></h1>
			<article class="h-entry">
				<h2 class="p-name"><?php the_title() ?></h2>
				<div class="e-content">
					<?php the_content() ?>

<?php 				$images = get_field( 'galeria' );
					if ( $images ) : ?>
					<div class="gallery">
						<?php 					
						foreach( $images as $img ) :
							$meta = wp_get_attachment_image_src( $img['id'], 'full' );
							$src = reset( $meta );
							$img = wp_get_attachment_image( $img['id'], 'thumbnail' );
							echo "<a href='{$src}' rel='fancybox' class='fancybox'>{$img}</a>";
						endforeach;
						?>
					</div>
<?php 				endif; ?>
				</div>
				<div class="post-meta">
					<dl class="post-date">
						<dt class="post-date-term">Data:</dt>
						<dd class="post-date-desc"><time class="dt-published" datetime="<?php the_time( 'c' ) ?>"><?php the_time( get_option( 'date_format' ) ) ?></time></dd>
					</dl>
					<dl class="post-cat">
						<dt class="post-cat-term">Categoria:</dt>
						<dd class="post-cat-desc"><?php the_category( ', ' ) ?></dd>
					</dl>
					<dl class="post-author">
						<dt class="post-author-term">Autor:</dt>
						<dd class="post-author-desc"><?php the_author() ?></dd>
					</dl>
					<?php the_tags( '<dl class="post-tag"><dt class="post-tag-term">Tags:</dt><dd class="post-tag-desc">', ', ', '</dd></dl>' ) ?>

				</div>
			</article>
<?php 		comments_template() ?>
		</div>
<?php 	endwhile; ?>
<?php 	get_sidebar() ?>
	</div>
<?php get_footer(); ?>