<?php

// 
// My Functions
// 

function t_url() { echo get_stylesheet_directory_uri(); }
function home() { echo home_url( '/' ); }
function name() { echo get_bloginfo( 'name' ); }

global $current_user;
get_currentuserinfo();

function user_name() {
	global $current_user;
	echo $current_user->display_name;
}

function user_field( $field ) {
	global $current_user;
	$uID = "user_{$current_user->ID}";
	switch ( $field ) {
		case 'sede' : the_sede( $uID ); break;
		case 'setor' : the_setor( $uID ); break;
		default : the_field( $field, $uID ); break;
	}
}

function user_avatar( $class = 'avatar' ) {
	global $current_user;
	$attr = array( 'class' => $class );
	$avatar_id = get_field( 'avatar', "user_{$current_user->ID}" );
	if ( $avatar_id )
		echo wp_get_attachment_image( $avatar_id, 'user-avatar', false, $attr );
}

function get_UF( $uID = 0 ) {
	if ( ! $uID ) $uID = get_current_user_id();
	$sede = get_sede( $uID );
	preg_match( '/\((.*?)\)/', $sede, $matches );
	return $matches[1];
}

function get_sede( $uID ) {
	global $wpdb;
	$uID = intval( end( explode( '_', $uID ) ) );
	$pID = $wpdb->get_var( $wpdb->prepare(
		"
		SELECT `post_id` 
		  FROM `{$wpdb->postmeta}` 
		 WHERE `meta_key` LIKE %s 
		   AND `meta_value` = %d 
		ORDER BY `meta_key` ASC 
		LIMIT 1
		",
		'departamentos_%_funcionarios_%_usuario',
		$uID
	) );
	if ( ! $pID ) return;
	return get_the_title( $pID );
	
}

function the_sede( $uID, $before = '' ) {
	$sede = get_sede( $uID );
	if ( ! $sede ) return;
	echo $before . $sede;
}

function the_setor( $uID, $before = '' ) {
	global $wpdb;
	$uID = intval( end( explode( '_', $uID ) ) );
	$row = $wpdb->get_row( $wpdb->prepare(
		"
		SELECT `post_id`, `meta_key` 
		  FROM `{$wpdb->postmeta}` 
		 WHERE `meta_key` LIKE %s 
		   AND `meta_value` = %d 
		ORDER BY `meta_key` ASC 
		LIMIT 1
		",
		'departamentos_%_funcionarios_%_usuario',
		$uID
	) );
	if ( ! $row ) return;
	preg_match( '/^departamentos_(.*?)_funcionarios/', $row->meta_key, $matches );
	echo $before . get_post_meta( $row->post_id, 'departamentos_' . $matches[1] . '_nome', true );
}

// 
// Filters
// 

remove_filter( 'the_excerpt', 'wpautop' );

if ( function_exists( 'acf_set_options_page_menu' ) ) {
	acf_set_options_page_menu( 'Destaques' );
	acf_set_options_page_title( 'Destaques' );
}

// 
// Shortcodes
// 

remove_shortcode( 'gallery' );
add_shortcode( 'gallery', 'my_gallery_shortcode' );

function my_gallery_shortcode( $atts ) {
	global $post;
 
	if ( ! empty( $atts['ids'] ) ) {
		// 'ids' is explicitly ordered, unless you specify otherwise.
		if ( empty( $atts['orderby'] ) )
			$atts['orderby'] = 'post__in';
		$atts['include'] = $atts['ids'];
	}
 
	extract( shortcode_atts( array(
		'orderby' 	 => 'menu_order ASC, ID ASC',
		'include' 	 => '',
		'id' 		 => $post->ID,
		'itemtag' 	 => 'dl',
		'icontag' 	 => 'dt',
		'captiontag' => 'dd',
		'columns' 	 => 3,
		'size' 		 => 'medium',
		'link' 		 => 'file'
	), $atts));

	$args = array(
		'post_type' 	 => 'attachment',
		'post_status' 	 => 'inherit',
		'post_mime_type' => 'image',
		'orderby' 		 => $orderby
	);
 
	if ( ! empty( $include ) ) {
		$args['include'] = $include;
	} else {
		$args['post_parent'] = $id;
		$args['numberposts'] = -1;
	}

	$images = get_posts( $args );
	if ( ! empty( $images ) ) echo '<div class="gallery">';

	foreach( $images as $img ) {
		$meta = wp_get_attachment_image_src( $img->ID, 'full' );
		$src = reset( $meta );
		$img = wp_get_attachment_image( $img->ID, 'thumbnail' );
		echo "<a href='{$src}' rel='gal{$post->ID}' class='fancybox'>{$img}</a>";
	}

	if ( ! empty( $images ) ) echo '</div>';
}

// 
// Actions
// 

add_action( 'after_setup_theme', 'my_setup' );
add_action( 'wp_enqueue_scripts', 'my_scripts' );
add_action( 'template_redirect', 'my_auth_redirect' );
add_action( 'pre_get_posts', 'my_pre_get_posts' );
// add_action( 'acf/save_post', 'my_acf_save_post', 20 );
add_action( 'widgets_init', 'my_widgets_init' );
add_action( 'widgets_init', 'unregister_default_widgets', 11 );

function my_setup() {
	// Menus
	register_nav_menus( array(
		'primary'   => 'Menu principal',
		'secondary' => 'Menu secundário',
	) );

	// Thumbnails
	add_theme_support( 'post-thumbnails' );
	set_post_thumbnail_size( 56, 56, true );
	add_image_size( 'user-avatar', 76, 76, true );
	add_image_size( 'highlight', 612, 392, true );

	// Roles
	add_role( 'rh', 'RH', array(
		'edit_users' => true,
		'read' => true
	) );
}

function my_scripts() {
	wp_deregister_script( 'jquery' );
	wp_register_script( 'jquery', 'http://code.jquery.com/jquery-1.10.1.min.js', false, null, true );
	wp_enqueue_script( 'jquery' );
	
	wp_enqueue_script( 'scripts', get_stylesheet_directory_uri() . '/js/interface.min.js', array( 'jquery' ), filemtime( TEMPLATEPATH . '/js/interface.min.js' ), true );
}

function my_auth_redirect() {
	if ( ! is_user_logged_in() ) {
		wp_redirect( wp_login_url( home_url( '/' ) ) );
		exit;
	}
}

function my_pre_get_posts( $query ) {
    if ( ! is_admin() && ( $query->is_search() || $query->is_category() || $query->is_tag() ) ) {
    	$uf = strtolower( get_UF( 2 ) );
    	// $term = get_term_by( 'slug', $uf, 'sedes' );
    	$query->set( 'sedes', $uf );
    }
}

function my_widgets_init() {
	register_sidebar( array(
		'name'          => 'Lateral',
		'id'            => 'sidebar',
		'description'   => '',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );
}

function unregister_default_widgets() {
	unregister_widget( 'WP_Widget_Pages' );
	unregister_widget( 'WP_Widget_Calendar' );
	unregister_widget( 'WP_Widget_Archives' );
	unregister_widget( 'WP_Widget_Links' );
	unregister_widget( 'WP_Widget_Meta' );
	unregister_widget( 'WP_Widget_Search' );
	// unregister_widget( 'WP_Widget_Text' );
	unregister_widget( 'WP_Widget_Categories' );
	unregister_widget( 'WP_Widget_Recent_Posts' );
	unregister_widget( 'WP_Widget_Recent_Comments' );
	unregister_widget( 'WP_Widget_RSS' );
	unregister_widget( 'WP_Widget_Tag_Cloud' );
	unregister_widget( 'WP_Nav_Menu_Widget' );
	unregister_widget( 'Twenty_Eleven_Ephemera_Widget' );
}

// 
// Login
// 

add_action( 'login_enqueue_scripts', 'my_login_logo' );
add_filter( 'login_headerurl', 'my_login_logo_url' );
add_filter( 'login_headertitle', 'my_login_logo_url_title' );

function my_login_logo() {
	?><style type="text/css">
	body.login div#login h1 {
		height: 70px;
	}
	body.login div#login h1 a {
		background: url(<?php echo get_stylesheet_directory_uri(); ?>/img/logo.png);
		display: block;
		height: 159px;
		left: 50%;
		margin-left: -139px;
		position: fixed;
		top: 0;
		width: 277px;
	}
	</style><?php
}

function my_login_logo_url() {
    return get_bloginfo( 'url' );
}

function my_login_logo_url_title() {
    return get_bloginfo( 'name' );
}

// 
// Comments
// 

function my_comment_form() {
	global $post, $commenter, $aria_req;
	
	$ph_author 	= 'Seu nome completo:';
	$ph_email 	= 'E-mail (não será divulgado):';
	$ph_url 	= 'Site:';
	$ph_comment = 'Seu comentário:';
	
	$fields = array(
		'author' => "<p class='field comment-form-author'><label for='author'>{$ph_author}</label><br>" . 
			"<input id='author' name='author' type='text' value='" . esc_attr( $commenter['comment_author'] ) .
			"' class='text' placeholder='{$ph_author}' required {$aria_req}></p>",
		'email' => "<p class='field comment-form-email'><label for='email'>{$ph_email}</label><br>" . 
			"<input id='email' name='email' type='email' value='" . esc_attr( $commenter['comment_author_email'] ) .
			"' class='text' placeholder='{$ph_email}' required {$aria_req}></p>",
		'url' => "<p class='field comment-form-url'><label for='url'>{$ph_url}</label><br>" . 
			"<input id='url' name='url' type='text' value='" . esc_attr( $commenter['comment_author_url'] ) .
			"' class='text' placeholder='{$ph_url}'></p>",
	);
	$comment_field = "<p class='field comment-form-comment'><label for='comment'>{$ph_comment}</label><br>" . 
		"<textarea id='comment' name='comment' cols='30' rows='10' class='area' placeholder='{$ph_comment}' required aria-required='true'></textarea></p>";

	comment_form( array(
		'fields' => $fields,
		'comment_field' => $comment_field,
		'comment_notes_before' => false,
		'comment_notes_after' => false,
	) );
}

function my_theme_comment( $comment, $args, $depth ) {
	$GLOBALS['comment'] = $comment;
	extract( $args, EXTR_SKIP );
	$comment_class = empty( $args['has_children'] ) ? '' : 'parent';
?>
	<li <?php comment_class( $comment_class ) ?> id="comment-<?php comment_ID() ?>">
		<div id="div-comment-<?php comment_ID() ?>" class="comment-body">
			<?php 
			$avatar_id = get_field( 'avatar', "user_{$comment->user_id}" );
			if ( $avatar_id )
				echo '<a href="' . get_author_posts_url( $comment->user_id ) . '" class="comment-avatar-link">' . wp_get_attachment_image( $avatar_id, 'user-avatar' ) . '</a>';
			?>
			<div class="comment-author vcard">
				<cite class="fn"><?php 
				if ( $comment->user_id ) {
					$author_url = get_author_posts_url( $comment->user_id );
					echo '<a href="' . $author_url . '">' . get_comment_author() . '</a>';
				} else {
					comment_author();
				}
				?></cite> 
				comentou em <a href="<?php echo htmlspecialchars( get_comment_link( $comment->comment_ID ) ) ?>"><?php comment_time( get_option( 'date_format' ) ) ?></a>.
			</div>
<?php 		if ($comment->comment_approved == '0') : ?>
			<em class="comment-awaiting-moderation"><?php _e('Your comment is awaiting moderation.') ?></em>
			<br />
<?php 		endif; ?>

			<?php comment_text() ?>

			<div class="reply"><?php 
			comment_reply_link( array_merge( $args, array(
				'add_below' => 'div-comment',
				'max_depth' => $args['max_depth'],
				'depth' 	=> $depth,
			) ) ); ?></div>
		</div>
<?php
}

// 
// Admin
// 

add_action( 'admin_enqueue_scripts', 'my_admin_scripts' );
add_action( 'wp_ajax_my-ajax-acf', 'my_ajax_acf' );

function my_admin_scripts() {
	wp_enqueue_script( 'my_admin', get_template_directory_uri() . '/js/admin.js', array( 'jquery', 'suggest' ) );
}

function my_ajax_acf() {
	global $wpdb;
	$value = $_GET['q'];

	// Cargos
	$sql = "SELECT DISTINCT `meta_value` FROM `$wpdb->usermeta` 
			WHERE `meta_key` LIKE %s 
			AND `meta_value` LIKE %s";
	$results = $wpdb->get_col( $wpdb->prepare( $sql, 'cargo', "%{$value}%" ) );
	foreach ( $results as $result ) 
		echo $result . "\n";

	// 
	die();
}

// 
// Custom Post Type
// 

add_action( 'init', 'register_cpt_empresa' );

function register_cpt_empresa() {

	$labels = array( 
		'name' => 'Empresas',
		'singular_name' => 'Empresa',
		'add_new' => 'Add New',
		'add_new_item' => 'Add New Empresa',
		'edit_item' => 'Edit Empresa',
		'new_item' => 'New Empresa',
		'view_item' => 'View Empresa',
		'search_items' => 'Search Empresas',
		'not_found' => 'No empresas found',
		'not_found_in_trash' => 'No empresas found in Trash',
		'parent_item_colon' => 'Parent Empresa:',
		'menu_name' => 'Empresas',
	);

	$args = array( 
		'labels' => $labels,
		'hierarchical' => false,
		
		'supports' => array( 'title', 'thumbnail', 'custom-fields' ),
		'taxonomies' => array(),
		'public' => true,
		'show_ui' => true,
		'show_in_menu' => true,
		'menu_position' => 5,
		
		'show_in_nav_menus' => false,
		'publicly_queryable' => true,
		'exclude_from_search' => false,
		'has_archive' => true,
		'query_var' => true,
		'can_export' => true,
		'rewrite' => true,
		'capability_type' => 'post'
	);

	register_post_type( 'empresa', $args );
}

// 
// Custom Taxonomy
// 

add_action( 'init', 'register_taxonomy_sedes' );

function register_taxonomy_sedes() {

	$labels = array( 
		'name' => 'Sedes/Filiais',
		'singular_name' => 'Sede/Filial',
		'search_items' => 'Search Sedes/Filiais',
		'popular_items' => 'Popular Sedes/Filiais',
		'all_items' => 'All Sedes/Filiais',
		'parent_item' => 'Parent Sede/Filial',
		'parent_item_colon' => 'Parent Sede/Filial:',
		'edit_item' => 'Edit Sede/Filial',
		'update_item' => 'Update Sede/Filial',
		'add_new_item' => 'Add New Sede/Filial',
		'new_item_name' => 'New Sede/Filial',
		'separate_items_with_commas' => 'Separate sedes/filiais with commas',
		'add_or_remove_items' => 'Add or remove sedes/filiais',
		'choose_from_most_used' => 'Choose from the most used sedes/filiais',
		'menu_name' => 'Sedes/Filiais',
	);

	$args = array( 
		'labels' => $labels,
		'public' => true,
		'show_in_nav_menus' => true,
		'show_ui' => true,
		'show_tagcloud' => false,
		'show_admin_column' => false,
		'hierarchical' => true,

		'rewrite' => true,
		'query_var' => true
	);

	register_taxonomy( 'sedes', array('post'), $args );
}

// 
// Widgets
// 

// Aniversariante do mês

class BirthdaysWidget extends WP_Widget {
	function BirthdaysWidget() {
		$widget_ops = array(
			'classname' => 'BirthdaysWidget',
			'description' => 'Lista de aniversariantes do mês'
		);
		$this->WP_Widget( 'BirthdaysWidget', 'Aniversariantes do mês', $widget_ops );
	}
 
	function form( $instance ) {
		$instance = wp_parse_args( (array) $instance, array( 'link_to' => '' ) );
		$link_to = $instance['link_to'];
		?><p>
			<label for="<?php echo $this->get_field_id('link_to'); ?>">
				Link para a lista completa: 
				<input class="widefat" id="<?php echo $this->get_field_id('link_to'); ?>" name="<?php echo $this->get_field_name('link_to'); ?>" type="url" value="<?php echo esc_attr($link_to); ?>" />
			</label>
		</p><?php
	}
 
	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['link_to'] = esc_url( $new_instance['link_to'] );
		return $instance;
	}
 
	function widget( $args, $instance ) {
		extract( $args, EXTR_SKIP );

		global $wpdb;
		$user_ids = $wpdb->get_col($wpdb->prepare( 
			"
			SELECT `user_id` 
			  FROM `{$wpdb->usermeta}` 
			 WHERE `meta_key` = %s 
			   AND SUBSTRING(`meta_value`,5,2) = %s 
			ORDER BY `meta_value` ASC 
			LIMIT 50 
			",
			'nascimento',
			date( 'm' )
		));
		if ( ! $user_ids )
			return '';

		/*$user_query = new WP_User_Query(array(
			'include' => $user_ids
		));
		if ( empty( $user_query->results ) )
			return '';*/

		echo $before_widget;
		$link_to = empty( $instance['link_to'] ) ? '' : esc_url( $instance['title'] );
 
		echo "{$before_title}Aniversariantes do mês{$after_title}";

?>
<ul class='widget-list'>
<?php 
	foreach ( $user_ids as $user_id ) : 
		$user = get_userdata( $user_id );
		$uID = "user_{$user->ID}";
?>
	<li>
		<a href='<?php echo get_author_posts_url( $user->ID ); ?>'>
			<?php 
			$avatar_id = get_field( 'avatar', $uID );
			if ( $avatar_id )
				echo wp_get_attachment_image( $avatar_id, 'post-thumbnail' );
			?>
			<strong><?php echo $user->display_name; ?></strong>
		</a>
		<br>
		<time><?php 
		$value = get_field( 'nascimento', $uID );
		$date = DateTime::createFromFormat( 'Ymd', $value );
		if ( $date ) echo date_i18n( 'd/m/Y', $date->getTimestamp() );
		?></time>
		– <?php the_field( 'cargo', $uID ); the_setor( $uID, ' – ' ); ?>
	</li>
<?php 
	endforeach;
?>
</ul>
<?php 	if ($link_to) : ?>
<a class='widget-more u' href='<?php echo $link_to; ?>'>Veja a lista completa</a>
<?php
		endif;
		echo $after_widget;
	}
 
}
add_action( 'widgets_init', create_function('', 'return register_widget("BirthdaysWidget");') );

// Período de Férias

class VacationWidget extends WP_Widget {
	function VacationWidget() {
		$widget_ops = array(
			'classname' => 'VacationWidget',
			'description' => 'Lista de períodos de férias'
		);
		$this->WP_Widget( 'VacationWidget', 'Período de férias', $widget_ops );
	}
 
	function form( $instance ) {
		$instance = wp_parse_args( (array) $instance, array( 'link_to' => '' ) );
		$link_to = $instance['link_to'];
		?><p>
			<label for="<?php echo $this->get_field_id('link_to'); ?>">
				Link para a lista completa: 
				<input class="widefat" id="<?php echo $this->get_field_id('link_to'); ?>" name="<?php echo $this->get_field_name('link_to'); ?>" type="url" value="<?php echo esc_attr($link_to); ?>" />
			</label>
		</p><?php
	}
 
	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['link_to'] = esc_url( $new_instance['link_to'] );
		return $instance;
	}
 
	function widget( $args, $instance ) {
		extract( $args, EXTR_SKIP );

		global $wpdb;
		$user_ids = $wpdb->get_col($wpdb->prepare( 
			"
			SELECT `user_id` 
			  FROM `{$wpdb->usermeta}` 
			 WHERE `meta_key` = %s 
			   AND `meta_value` >= %d 
			   AND `meta_value` <= %d 
			ORDER BY `meta_value` ASC 
			",
			'ferias_de',
			date( 'Ym01' ),
			date( 'Ymd', strtotime( 'last day of +1 month' ) )
		));
		if ( empty( $user_ids ) )
			return '';

		/*$user_query = new WP_User_Query(array(
			'include' => $user_ids
		));
		if ( empty( $user_query->results ) )
			return '';*/
		
		echo $before_widget;
		$link_to = empty( $instance['link_to'] ) ? '' : esc_url( $instance['link_to'] );
 
		echo "{$before_title}Período de férias{$after_title}";
 
		?><ul class='widget-list'><?php 
		$user_query->results = array_reverse( $user_query->results );
		foreach ( $user_ids as $user_id ) : 
			$user = get_userdata( $user_id );
			$uID = "user_{$user->ID}";
			?><li>
				<a href='<?php echo get_author_posts_url( $user->ID ); ?>'>
					<?php 
					$avatar_id = get_field( 'avatar', $uID );
					if ( $avatar_id )
						echo wp_get_attachment_image( $avatar_id, 'post-thumbnail' );
					?>
					<strong><?php echo $user->display_name; ?></strong>
				</a>
				<br>
				<time><?php 
				$de = get_field( 'ferias_de', $uID );
				$de = DateTime::createFromFormat( 'Ymd', $de );
				$ate = get_field( 'ferias_ate', $uID );
				$ate = DateTime::createFromFormat( 'Ymd', $ate );
				if ( $de && $ate ) 
					echo date_i18n( 'd/m/y', $de->getTimestamp() ) . ' » ' . date_i18n( 'd/m/y', $ate->getTimestamp() );
				?></time>
				<?php the_field( 'cargo', $uID ) ?> <?php the_setor( $uID, ' – ' ) ?>
			</li><?php 
		endforeach;
		?></ul><?php 
		if ($link_to) : 
			?><a class='widget-more u' href='<?php echo $link_to; ?>'>Veja a lista completa</a><?php 
		endif;
		echo $after_widget;
	}
 
}
add_action( 'widgets_init', create_function('', 'return register_widget("VacationWidget");') );

// Changes

class ChangesWidget extends WP_Widget {
	function ChangesWidget() {
		$widget_ops = array(
			'classname' => 'ChangesWidget',
			'description' => 'Lista de mudanças recentes'
		);
		$this->WP_Widget( 'ChangesWidget', 'Mudanças recentes', $widget_ops );
	}
 
	function form( $instance ) {
		$instance = wp_parse_args( (array) $instance, array( 'limit' => 10 ) );
		$limit = $instance['limit'];
?><p>
	<label for="<?php echo $this->get_field_id('limit'); ?>">
		Número de itens: 
		<input class="widefat" id="<?php echo $this->get_field_id('limit'); ?>" name="<?php echo $this->get_field_name('limit'); ?>" type="number" step="1" min="1" max="50" value="<?php echo esc_attr($limit); ?>" />
	</label>
</p><?php
	}
 
	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['limit'] = intval( $new_instance['limit'] );
		return $instance;
	}
 
	function widget( $args, $instance ) {
		extract( $args, EXTR_SKIP );
		$limit = empty( $instance['limit'] ) ? 10 : intval( $instance['limit'] );

		global $wpdb;
		$rows = $wpdb->get_results($wpdb->prepare( 
			"
			SELECT DISTINCT `user_id`, `meta_key`, `meta_value`
			  FROM `{$wpdb->usermeta}` 
			 WHERE `meta_key` LIKE %s 
			   AND `meta_value` <= %d 
			ORDER BY `meta_value` DESC 
			LIMIT {$limit} 
			",
			'mudancas_%_data',
			date( 'Ymd' )
		));
		if ( empty( $rows ) )
			return '';

		/*$user_query = new WP_User_Query(array(
			'include' => $user_ids
		));
		if ( empty( $user_query->results ) )
			return '';*/

		echo $before_widget;
		echo "{$before_title}Mudanças recentes{$after_title}";
?>
<ul class='widget-list'>
<?php 
	foreach ( $rows as $row ) : 
		$uID = $row->user_id;
		$user = get_userdata( $uID );
		preg_match( '/^mudancas_(.*?)_data/', $row->meta_key, $matches );
		$key = 'mudancas_' . $matches[1] . '_mudanca';
		$mudanca = get_user_meta( $row->user_id, $key, true );
		$date = DateTime::createFromFormat( 'Ymd', $row->meta_value );
?>
	<li>
		<a href='<?php echo get_author_posts_url( $uID ); ?>'><strong><?php echo $user->display_name; ?></strong></a>
		<br>
		<time><?php if ( $date ) echo date_i18n( 'd/m/Y', $date->getTimestamp() ); ?></time>
		- <?php echo $mudanca; ?>
	</li>
<?php 
	endforeach;
?>
</ul>
<?php 	
		echo $after_widget;
	}
 
}
add_action( 'widgets_init', create_function('', 'return register_widget("ChangesWidget");') );
