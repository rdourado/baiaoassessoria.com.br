<?php get_header() ?>
	<div class='body'>
<?php 	while( have_posts() ) : the_post(); ?>
		<h1 class='page-title'>Contatos da empresa</h1>
		<article class="h-entry">
<?php 		if ( has_post_thumbnail() ) : ?>
			<a class="fancybox" href="<?php 
			echo reset( wp_get_attachment_image_src( get_post_thumbnail_id(), 'full' ) ); ?>"><?php 
			the_post_thumbnail( 'post-thumbnail', array( 'class' => 'alignleft' ) ) 
			?></a>
<?php 		endif; ?>
			<h2 class="p-name"><?php the_title() ?></h2>
			<div class="e-content">
				<?php the_field( 'endereco' ) ?>
				<br>
				<em><?php the_field( 'telefone' ) ?></em> 
				<a href="mailto:<?php the_field( 'email' ) ?>" class="u"><?php the_field( 'email' ) ?></a>
			</div>
		</article>

<?php 	while( has_sub_field( 'departamentos' ) ) : ?>
		<section class="sector">
			<h3 class="sector-title"><?php the_sub_field( 'nome' ) ?></h3>
			<ul class="team-list">
<?php 			while( has_sub_field( 'funcionarios' ) ) :
				$u = (object) get_sub_field( 'usuario' );
				$u_link = get_author_posts_url( $u->ID ); ?>
				<li class="team-item">
					<?php 
					$avatar_id = get_field( 'avatar', "user_{$u->ID}" );
					$attr = array( 'class' => 'team-avatar alignleft' );
					if ( $avatar_id )
						echo '<a href="' . $u_link . '" class="team-avatar-link">' . wp_get_attachment_image( $avatar_id, 'user-avatar', false, $attr ) . '</a>';
					?>
			
					<h4 class="team-name"><a href="<?php echo $u_link; ?>"><?php echo $u->display_name; ?></a></h4>
					<p class="team-info"><?php the_field( 'telefone', "user_{$u->ID}" ) ?><br>
					<a href="mailto:<?php echo $u->user_email; ?>" class="u"><?php echo $u->user_email; ?></a></p>
				</li>
<?php 			endwhile; ?>
			</ul>
		</section>
<?php 	endwhile; ?>

<?php 	endwhile; ?>
	</div>
<?php get_footer(); ?>