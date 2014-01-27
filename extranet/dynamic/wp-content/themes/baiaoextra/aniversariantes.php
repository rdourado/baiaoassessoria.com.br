<?php 
/*
Template name: Aniversariantes do mês
*/
?>
<?php get_header() ?>
	<div class='body'>
<?php 	while( have_posts() ) : the_post(); ?>
		<h1 class='page-title'><?php the_title(); ?></h1>
<?php 	endwhile; ?>

<?php 
		$user_query = new WP_User_Query(array(
			'number' => 99,
			'meta_query' => array(
				'key' 		=> 'nascimento',
				'value' 	=> date( 'Ym' ) . '%',
				'compare' 	=> 'LIKE',
				'type' 		=> 'CHAR'
			),
		));
		foreach ( $user_query->results as $user_obj ) : 
			$user = $user_obj->data;
			$uID = $user->ID;
?>
		<article class="box">
			<?php 
			$attr = array( 'class' => 'alignleft b' );
			$avatar_id = get_field( 'avatar', "user_{$uID}" );
			if ( $avatar_id )
				echo wp_get_attachment_image( $avatar_id, 'thumbnail', false, $attr );
			?>
			<h2 class='user-name'><?php echo $user->display_name; ?></h2>
			<dl class='user-data'>
				<dt class='user-term'>Setor:</dt>
				<dd class='user-value'><?php the_field( 'setor', "user_{$uID}" ) ?></dd>
			</dl>
			<dl class='user-data'>
				<dt class='user-term'>Sede/Filial:</dt>
				<dd class='user-value'><?php the_field( 'sede', "user_{$uID}" ) ?></dd>
			</dl>
			<dl class='user-data'>
				<dt class='user-term'>Cargo:</dt>
				<dd class='user-value'><?php the_field( 'cargo', "user_{$uID}" ) ?></dd>
			</dl>
			<dl class='user-data'>
				<dt class='user-term'>Telefone:</dt>
				<dd class='user-value'><?php the_field( 'telefone', "user_{$uID}" ) ?></dd>
			</dl>
		</article>
		<section class="box">
			<h3 class="box-title">Outras informações</h3>
<?php 		if ( $value = get_field( 'nascimento', "user_{$uID}" ) ) : ?>
			<dl class='user-data'>
				<dt class='user-term'>Aniversário:</dt>
				<dd class='user-value'><?php 
				$date = DateTime::createFromFormat( 'Ymd', $value );
				echo date_i18n( get_option( 'date_format' ), $date->getTimestamp() );
				?></dd>
			</dl>
<?php 		endif; ?>
<?php 		if ( $value = get_field( 'ferias', "user_{$uID}" ) ) : ?>
			<dl class='user-data'>
				<dt class='user-term'>Período de férias:</dt>
				<dd class='user-value'><?php echo $value; ?></dd>
			</dl>
<?php 		endif; ?>
<?php 		if ( $value = get_field( 'mudancas', "user_{$uID}" ) ) : ?>
			<dl class='user-data'>
				<dt class='user-term'>Mudanças:</dt>
				<dd class='user-value'>
					<ul>
<?php 					while( has_sub_field( 'mudancas', "user_{$uID}" ) ) : ?>
						<li><?php the_sub_field( 'mudanca' ) ?> (<?php 
						$date = DateTime::createFromFormat( 'Ymd', get_sub_field( 'data' ) );
						echo date_i18n( get_option( 'date_format' ), $date->getTimestamp() );
						?>)</li>
<?php 					endwhile; ?>
					</ul>
				</dd>
			</dl>
<?php 		endif; ?>
		</section>
<?php 	endforeach; ?>
	</div>
<?php get_footer(); ?>