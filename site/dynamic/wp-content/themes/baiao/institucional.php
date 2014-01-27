<?php 
/*
Template name: Institucional
*/
?>
<?php get_header() ?>
	<div class="header">
		<h1 class="header-title aria-hide"><?php institucional_title() ?></h1>
	</div>
	<div class="body">
<?php 	while( have_posts() ) : the_post(); ?>
		<article class="content hentry">
			<h1 class="entry-title hide"><?php institucional_title() ?></h1>
			<div class="post-content entry-content">
				<?php the_content(); ?>
<?php 			$team = new WP_Query( "post_type=page&orderby=menu_order&order=ASC&post_parent=" . parent() );
				if ( $team->have_posts() ) : ?>
				<h3><?php _e('Conheça a equipe Baião Assessoria', 'baiao'); ?></h3>
				<div class="gallery">
<?php 				while( $team->have_posts() ) : $team->the_post(); ?>
					<a href="<?php the_permalink() ?>" class="gallery-item border"><?php equipe_image() ?></a>
<?php 				endwhile; ?>
				</div>
<?php 			endif;
				wp_reset_postdata(); ?>
			</div>
		</article>
<?php 	endwhile; ?>
<?php 	get_sidebar( 'institucional' ); ?>
	</div>
<?php get_footer() ?>