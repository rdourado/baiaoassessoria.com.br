		<hr>
		<div class="sidebar">
			<aside class="widget widget-categories">
				<h3 class="widget-title">Busque por categorias</h3>
				<ul>
					<?php wp_list_categories( array(
						'title_li' => '',
						'child_of' => category_id(),
						'depth' => 2,
					) ); ?>
				</ul>
			</aside>
			<aside class="widget widget-text">
<?php 			$cat_id = category_id() == 3 ? 1 : 3; ?>
				<h3 class="widget-title"><?php the_field( 'description', "category_{$cat_id}" ); ?></h3>
				<div class="textwidget">
<?php 				if ( $img = get_field( 'image', "category_{$cat_id}" ) ) : ?>
					<a href="<?php echo get_category_link( $cat_id ); ?>" class="border"><?php 
					echo wp_get_attachment_image( $img, 'rect_thumb_2' ); ?></a>
<?php 				endif; ?>
				</div>
			</aside>
<?php 		get_template_part( 'widget', 'newsletter' ); ?>
		</div>
