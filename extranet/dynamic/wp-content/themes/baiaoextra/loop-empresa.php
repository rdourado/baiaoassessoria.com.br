<?php 
global $tag;
$tag = empty($tag) ? 'div' : $tag;
?>
			<<?php echo $tag; ?> class='firm-data'>
<?php 			if ( has_post_thumbnail() ) : ?>
				<a href='<?php the_permalink() ?>'><?php the_post_thumbnail( 'medium' ) ?></a>
<?php 			endif; ?>
				<h2 class='firm-title'><a href="<?php the_permalink() ?>"><?php the_title() ?></a></h2>
				<p class='firm-address'><?php the_field( 'endereco' ) ?></p>
				<p class='firm-contact'>
<?php 				if ( get_field( 'telefone' ) ) : ?>
					<em><?php the_field( 'telefone' ) ?></em>
					<br>
<?php 				endif;
					if ( get_field( 'email' ) ) : ?>
					<a class='u' href='mailto:<?php the_field( 'email' ) ?>'><?php the_field( 'email' ) ?></a>
<?php 				endif; ?>
				</p>
			</<?php echo $tag; ?>>
