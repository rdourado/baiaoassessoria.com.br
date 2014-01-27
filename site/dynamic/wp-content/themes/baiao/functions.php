<?php 

// Common

function year() { echo date( 'Y' ); }
function home() { echo home_url( '/' ); }
function name() { echo get_bloginfo( 'name' ); }
function rss() 	{ echo get_bloginfo( 'rss2_url' ); }
function url() 	{ echo get_stylesheet_directory_uri(); }

function logo() {
	$url  = get_stylesheet_directory_uri();
	$name = get_bloginfo( 'name' );
	$img  = '<img src="' . $url . '/img/logo.png" alt="' . $name . '" width="297" height="176">';
	if ( is_front_page() ) {
		$out = '<h1 class="logo">' . $img . '</h1>';
	} else {
		$home = home_url( '/' );
		$out  = '<div class="logo"><a href="' . $home . '">' . $img . '</a></div>';
	}
	echo $out . "\n";
}

function parent() {
	global $post;
	return $post->post_parent ? $post->post_parent : $post->ID;
}

function my_category() {
	global $post;
	$cats = get_the_category();
	echo $cats[0]->cat_name;
}

function encode_email( $e ) {
	$len = strlen( $e );
	$output = '';
	for ( $i = 0; $i < $len; $i++ ) 
		$output .= '&#' . ord( $e[$i] ) . ';';
	return $output;
}

function sanitize_number( $s ) {
	$out = array();
	$arr = str_split( $s );
	foreach( $arr as $c ) {
		if ( intval( $c ) )
			$out[] = intval( $c );
	}
	return implode( '', $out );
}

// Specific Functions

function institucional_title() {
	global $post;
	if ( $post->post_parent ) {
		echo __('Institucional', 'baiao') . ' / ' . __('Equipe', 'baiao');
	} else {
		echo __('Institucional', 'baiao');
	}
}

function slide_image() {
	global $post;
	$id = get_sub_field( 'slide_image' );
	echo wp_get_attachment_image( $id, 'rect_large' ) . "\n";
}

function highlight_image() {
	global $post;
	$id = get_sub_field( 'highlight_image' );
	echo wp_get_attachment_image( $id, 'rect_thumb' );
}

function equipe_image() {
	global $post;
	if ( has_post_thumbnail() ) {
		the_post_thumbnail( 'rect_thumb' );
	} else {
		$url = get_stylesheet_directory_uri();
		echo '<img src="' . $url . '/img/avatar.png" alt="">';
	}
}

function category_id() {
	$cat = get_category( get_query_var( 'cat' ) );
	return $cat->category_parent ? $cat->category_parent : $cat->cat_ID;
}

function category_quote( $cat_id = 0 ) {
	$cat_id = $cat_id ? $cat_id : category_id();
	the_field( 'quote', "category_{$cat_id}" );
}

function category_source( $cat_id = 0 ) {
	$cat_id = $cat_id ? $cat_id : category_id();
	the_field( 'source', "category_{$cat_id}" );
}

// Setup

add_action( 'after_setup_theme', 'my_setup' );
add_action( 'after_switch_theme', 'my_init_setup' );

function my_setup() {
	add_theme_support( 'automatic-feed-links' );			// RSS
	add_theme_support( 'html5' ); 							// HTML 5
	add_editor_style( 'css/editor.css' );					// CSS Editor
	
	register_nav_menu( 'primary', __('Menu', 'baiao') );	// Menu

	add_image_size( 'square_thumb',   60,  60, true );
	add_image_size( 'square_medium', 136, 136, true );
	add_image_size( 'square_large',  296, 276, true );

	add_image_size( 'rect_thumb',   296, 164, true );
	add_image_size( 'rect_thumb_2', 296, 196, true );
	add_image_size( 'rect_medium',  536, 226, true );
	add_image_size( 'rect_large',   940, 290, true );
}

function my_init_setup() {
	update_option( 'thumbnail_size_w', 296 );
	update_option( 'thumbnail_size_h', 276 );
	update_option( 'thumbnail_crop', 1 );
	
	update_option( 'medium_size_w', 536 );
	update_option( 'medium_size_h', 226 );
	update_option( 'medium_crop', 1 );
	
	update_option( 'large_size_w', 536 );
	update_option( 'large_size_h', 999 );
}

// Filters

remove_filter( 'the_excerpt', 'wpautop' );
add_filter( 'sanitize_file_name', 'make_filename_hash', 10 );
add_filter( 'default_hidden_meta_boxes', 'my_hidden_meta_boxes', 10, 2 );
add_filter( 'acf/update_value/name=redirect_to', 'my_acf_redirect', 10, 3 );
add_filter( 'acf/update_value/name=post_thumbnail', 'my_acf_post_thumbnail', 10, 3 );

function make_filename_hash( $filename ) {
	$info = pathinfo( $filename );
	$ext  = empty( $info['extension'] ) ? '' : '.' . $info['extension'];
	$name = basename( $filename, $ext );
	return md5( $name ) . $ext;
}

function my_hidden_meta_boxes( $hidden, $screen ) {
	if ( 'post' == $screen->base ) $hidden = array('slugdiv', 'trackbacksdiv', 'postexcerpt', 'commentstatusdiv', 'commentsdiv', 'authordiv', 'revisionsdiv');
		// removed 'postcustom',
	return $hidden;
}

function my_acf_redirect( $value, $post_id, $field ) {
	$url = get_permalink( $value );
	if ( $url ) update_post_meta( $post_id, '_redirect_to_url', $url );
	return $value;
}

function my_acf_post_thumbnail( $value, $post_id, $field ) {
	if ( $value ) update_post_meta( $post_id, '_thumbnail_id', $value );
	return $value;
}

// Actions

add_action( 'admin_menu', 'edit_admin_menu' );
add_action( 'template_redirect', 'my_redirect' );
add_action( 'wp_enqueue_scripts', 'my_scripts' );

function edit_admin_menu() {
	remove_menu_page( 'edit-comments.php' );
}

function my_redirect() {
	global $post;
	$url = esc_url( get_post_meta( $post->ID, '_redirect_to_url', true ) );
	if ( $url ) {
		wp_redirect( $url );
		exit();
	}
}

function my_scripts() {
	wp_deregister_script( 'jquery' );
	wp_register_script( 'jquery', 'http://code.jquery.com/jquery-1.10.1.min.js', false, null, true );
	wp_enqueue_script( 'jquery' );
	
	// wp_enqueue_script( 'scripts', get_stylesheet_directory_uri() . '/js/interface.min.js', array( 'jquery' ), filemtime( TEMPLATEPATH . '/js/interface.min.js' ), true );
}

// Shortcode

add_shortcode( 'alert', 'my_shortcode_alert' );

function my_shortcode_alert( $atts, $content = null ) {
	return '<p class="alert">' . $content . '</p>';
}
