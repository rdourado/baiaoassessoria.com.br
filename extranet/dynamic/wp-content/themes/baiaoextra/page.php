<?php get_header() ?>
	<div class='body'>
<?php 	while( have_posts() ) : the_post(); ?>
		<div class='content'>
			<article class="h-entry">
				<h1 class="page-title p-name"><?php the_title() ?></h1>
				<div class="e-content">
					<?php the_content() ?>
				</div>
			</article>
		</div>
<?php 	endwhile; ?>
<?php 	get_sidebar() ?>
	</div>
<?php get_footer(); ?>