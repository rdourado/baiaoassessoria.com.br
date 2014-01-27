<?php get_header() ?>
	<div class="header">
<?php 	while( have_posts() ) : the_post(); ?>
		<h1 class="header-title"><?php the_title() ?></h1>
	</div>
	<div class="body">
		<article class="content hentry">
			<h1 class="entry-title hide"><?php the_title() ?></h1>
			<div class="post-content entry-content">
				<?php the_content(); ?>
			</div>
		</article>
<?php 	endwhile; ?>
<?php 	get_sidebar(); ?>
	</div>
<?php get_footer() ?>