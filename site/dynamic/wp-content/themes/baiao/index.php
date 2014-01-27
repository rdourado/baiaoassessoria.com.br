<?php 
/*
Template name: Início
*/
?>
<?php get_header() ?>
	<div id="slides" class="slides">
		<a class="buttons prev aria-hide" href="#"></a>
		<div class="viewport">
			<ul class="overview">
<?php 			$total = 0;
				while( has_sub_field( 'slides' ) ) : ?>
				<li class="slides-item">
					<a href="<?php the_sub_field( 'slide_link' ); ?>">
						<?php slide_image() ?>
						<div class="slides-info">
							<h2 class="slides-title"><?php the_sub_field( 'slide_title' ); ?></h2>
							<p class="slides-excerpt"><?php the_sub_field( 'slide_excerpt' ); ?></p>
						</div>
					</a>
				</li>
<?php 			$total++;
				endwhile; ?>
			</ul>
		</div>
		<a class="buttons next aria-hide" href="#"></a>
		<ul class="pager aria-hide">
<?php 		for( $i = 0; $i < $total; $i++ ) : ?>
			<li><a rel="<?php echo $i; ?>" class="pagenum" href="#"><?php echo $i + 1; ?></a></li>
<?php 		endfor; ?>
		</ul>
	</div>
	<hr>
	<div class="body">
		<div class="content">
<?php 		while( has_sub_field( 'highlights' ) ) : ?>
			<section class="highlight">
				<h2 class="highlight-title"><?php the_sub_field( 'highlight_title' ); ?></h2>
				<span class="highlight-image border"><?php highlight_image() ?></span>
				<p class="highlight-excerpt"><?php the_sub_field( 'highlight_excerpt' ); ?></p>
				<ul class="highlight-actions">
<?php 				while( has_sub_field( 'highlight_actions' ) ) : ?>
					<li class="highlight-action"><a href="<?php the_sub_field( 'action_link' ); ?>" class="highlight-icon icon-<?php the_sub_field( 'action_icon' ); ?>"><?php the_sub_field( 'action_text' ); ?></a></li>
<?php 				endwhile; ?>
				</ul>
			</section>
<?php 		endwhile; ?>
		</div>
<?php 	get_sidebar( 'home' ) ?>
	</div>
<?php get_footer() ?>