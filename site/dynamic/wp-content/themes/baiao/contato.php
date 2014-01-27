<?php 
/*
Template name: Contato
*/
if ( function_exists( 'wpcf7_enqueue_scripts' ) ) wpcf7_enqueue_scripts();

if ( isset( $_GET['addr'] ) ) {
	$meta = get_field( 'addresses' );
	echo $meta[$_GET['addr']]['addr_map'];
	exit;
}
?>
<?php get_header() ?>
	<div class="header">
<?php 	while( have_posts() ) : the_post(); ?>
		<h1 class="header-title"><?php the_title() ?></h1>
	</div>
	<div class="body">
		<article class="content">
			<h2 class="entry-title hide"><?php the_title() ?></h2>
			<div class="post-content entry-content">
				<?php the_content() ?>
			</div>
		</article>
<?php 	endwhile; ?>
<?php 	get_sidebar( 'contato' ); ?>
	</div>
<?php get_footer() ?>