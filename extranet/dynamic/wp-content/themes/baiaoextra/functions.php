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
	the_field( $field, "user_{$current_user->ID}" );
}

function user_avatar( $class = 'avatar' ) {
	global $current_user;
	$attr = array( 'class' => $class );
	$avatar_id = get_field( 'avatar', "user_{$current_user->ID}" );
	if ( $avatar_id )
		echo wp_get_attachment_image( $avatar_id, 'user-avatar', false, $attr );
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
// Actions
// 

add_action( 'after_setup_theme', 'my_setup' );
add_action( 'wp_enqueue_scripts', 'my_scripts' );
add_action( 'template_redirect', 'my_auth_redirect' );
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

	// Empresas
	$sql = "SELECT DISTINCT `meta_value` FROM `$wpdb->postmeta` 
			WHERE `meta_key` LIKE %s 
			AND `meta_value` LIKE %s";
	$results = $wpdb->get_col( $wpdb->prepare( $sql, 'departamentos_%_nome', "%{$value}%" ) );
	foreach ( $results as $result ) 
		echo $result . "\n";

	// Departamentos
	$sql = "SELECT DISTINCT `post_title` FROM `$wpdb->posts` 
			WHERE `post_type` = %s 
			AND `post_status` = %s 
			AND `post_title` LIKE %s";
	$results = $wpdb->get_col( $wpdb->prepare( $sql, 'empresa', 'publish', "%{$value}%" ) );
	foreach ( $results as $result ) 
		echo $result . "\n";

	// 
    die();
}

// 
// Custom Post Type
// 

/*add_action( 'init', 'register_cpt_galeria' );

function register_cpt_galeria() {

	$labels = array( 
		'name' => 'Galerias',
		'singular_name' => 'Galeria',
		'add_new' => 'Add New',
		'add_new_item' => 'Add New Galeria',
		'edit_item' => 'Edit Galeria',
		'new_item' => 'New Galeria',
		'view_item' => 'View Galeria',
		'search_items' => 'Search Galerias',
		'not_found' => 'No galerias found',
		'not_found_in_trash' => 'No galerias found in Trash',
		'parent_item_colon' => 'Parent Galeria:',
		'menu_name' => 'Galerias',
	);

	$args = array( 
		'labels' => $labels,
		'hierarchical' => false,
		
		'supports' => array( 'title', 'editor', 'excerpt', 'author', 'thumbnail', 'custom-fields', 'comments', 'revisions' ),
		'taxonomies' => array( 'category', 'post_tag' ),
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

	register_post_type( 'galeria', $args );
}*/

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
               AND `meta_value` LIKE %s 
			ORDER BY `meta_value` DESC 
			LIMIT 50 
            ",
            'nascimento',
            date( 'Ym' ) . '%'
        ));
        if ( ! $user_ids )
        	return '';

		$user_query = new WP_User_Query(array(
			'include' => $user_ids
		));
		if ( empty( $user_query->results ) )
			return '';

		echo $before_widget;
		$link_to = empty( $instance['link_to'] ) ? '' : esc_url( $instance['title'] );
 
		echo "{$before_title}Aniversariantes do mês{$after_title}";

?>
<ul class='widget-list'>
<?php 
	foreach ( $user_query->results as $user_obj ) : 
		$user = $user_obj->data;
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
		- <?php the_field( 'cargo', $uID ) ?> - <?php the_field( 'setor', $uID ) ?>
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

		$user_query = new WP_User_Query(array(
			'number' 	=> 5,
			'orderby' 	=> 'meta_value_num',
			'order' 	=> 'ASC',
			'meta_key' 		=> 'ferias_de',
			'meta_value' 	=> date( 'Ymd' ),
			'meta_compare' 	=> '>'
		));
		if ( empty( $user_query->results ) )
			return '';

		echo $before_widget;
		$link_to = empty( $instance['link_to'] ) ? '' : esc_url( $instance['title'] );
 
		echo "{$before_title}Período de férias{$after_title}";
 
?>
<ul class='widget-list'>
<?php 
	foreach ( $user_query->results as $user_obj ) : 
		$user = $user_obj->data;
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
		$value = get_field( 'ferias_de', $uID );
		$date = DateTime::createFromFormat( 'Ymd', $value );
		if ( $date ) echo date_i18n( 'd/m/Y', $date->getTimestamp() );
		?></time>
		- <?php the_field( 'cargo', $uID ) ?> - <?php the_field( 'setor', $uID ) ?>
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
		$instance = wp_parse_args( (array) $instance, array( 'link_to' => '' ) );
		$link_to = $instance['link_to'];
?><p>
	<!-- <label for="<?php echo $this->get_field_id('link_to'); ?>">
		Link para a lista completa: 
		<input class="widefat" id="<?php echo $this->get_field_id('link_to'); ?>" name="<?php echo $this->get_field_name('link_to'); ?>" type="url" value="<?php echo esc_attr($link_to); ?>" />
	</label> -->
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
             WHERE `meta_key` LIKE %d 
               AND `meta_value` < %d 
			ORDER BY `meta_value` DESC 
			LIMIT 50 
            ",
            'mudancas_%_data',
            date( 'Ymd' )
        ));
		if ( empty( $user_ids ) )
			return '';

		$user_query = new WP_User_Query(array(
			'include' => $user_ids
		));
		if ( empty( $user_query->results ) )
			return '';

		echo $before_widget;
		$link_to = empty( $instance['link_to'] ) ? '' : esc_url( $instance['title'] );
 
		echo "{$before_title}Mudanças recentes{$after_title}";
 
?>
<ul class='widget-list'>
<?php 
	foreach ( $user_query->results as $user_obj ) : 
		$user = $user_obj->data;
		$uID = "user_{$user->ID}";
?>
	<li>
		<a href='<?php echo get_author_posts_url( $user->ID ); ?>'>
			<strong><?php echo $user->display_name; ?></strong>
		</a>
		<br>
		<time><?php 
		$value = get_field( 'nascimento', $uID );
		$date = DateTime::createFromFormat( 'Ymd', $value );
		if ( $date ) echo date_i18n( 'd/m/Y', $date->getTimestamp() );
		?></time>
		- <?php the_field( 'cargo', $uID ) ?> - <?php the_field( 'setor', $uID ) ?>
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
add_action( 'widgets_init', create_function('', 'return register_widget("ChangesWidget");') );
