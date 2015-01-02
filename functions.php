<?php
/**
 * Cinnamon functions and definitions
 *
 * @package Cinnamon
 */

/**
 * Set the content width based on the theme's design and stylesheet.
 */
if ( ! isset( $content_width ) ) {
	$content_width = 640; /* pixels */
}

if ( ! function_exists( 'cinnamon_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function cinnamon_setup() {

	/*
	 * Make theme available for translation.
	 * Translations can be filed in the /languages/ directory.
	 * If you're building a theme based on Cinnamon, use a find and replace
	 * to change 'cinnamon' to the name of your theme in all the template files
	 */
	load_theme_textdomain( 'cinnamon', get_template_directory() . '/languages' );

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	/*
	 * Enable support for Post Thumbnails on posts and pages.
	 *
	 * @link http://codex.wordpress.org/Function_Reference/add_theme_support#Post_Thumbnails
	 */
	add_theme_support( 'post-thumbnails' );

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus( array(
		'primary' => __( 'Primary Menu', 'cinnamon' ),
	) );

	/*
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support( 'html5', array(
		'search-form', 'comment-form', 'comment-list', 'gallery', 'caption',
	) );

	/*
	 * Enable support for Post Formats.
	 * See http://codex.wordpress.org/Post_Formats
	 */
	add_theme_support( 'post-formats', array(
		'aside',
	) );

	// Adding editor style
	add_editor_style( array(
		'//fonts.googleapis.com/css?family=Lato:400,900,400italic,900italic',
		'editor.css'
	) );

	// Adding title tag support
	add_theme_support( 'title-tag' );
}
endif; // cinnamon_setup
add_action( 'after_setup_theme', 'cinnamon_setup' );

/**
 * Register widget area.
 *
 * @link http://codex.wordpress.org/Function_Reference/register_sidebar
 */
if( ! function_exists( 'cinnamon_widgets_init' ) ) :
function cinnamon_widgets_init() {
	register_sidebar( array(
		'name'          => __( 'Sidebar', 'cinnamon' ),
		'id'            => 'sidebar-1',
		'description'   => '',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h1 class="widget-title">',
		'after_title'   => '</h1>',
	) );
}
endif;
add_action( 'widgets_init', 'cinnamon_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
if ( ! function_exists( 'cinnamon_scripts' ) ) :
function cinnamon_scripts() {
	wp_enqueue_style( 'cinnamon-google-font', '//fonts.googleapis.com/css?family=Lato:300,400,900,300italic,400italic,900italic' );
	
	wp_enqueue_style( 'cinnamon-style', get_stylesheet_uri(), array( 'dashicons' ), '1.0' );

	wp_enqueue_script( 'cinnamon-script', get_template_directory_uri() . '/js/cinnamon.js', array( 'jquery' ), '20141201', true );

	wp_enqueue_script( 'cinnamon-navigation', get_template_directory_uri() . '/js/navigation.js', array(), '20120206', true );

	wp_enqueue_script( 'cinnamon-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), '20130115', true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
endif;
add_action( 'wp_enqueue_scripts', 'cinnamon_scripts' );

/**
 * Display color scheme based on one accent color choosen by user
 */
if( ! function_exists( 'cinnamon_color_scheme' ) ) :
function cinnamon_color_scheme(){
	$color_scheme = get_theme_mod( 'color_scheme', false );

	if( $color_scheme ){
		wp_add_inline_style( 'cinnamon-style', $color_scheme );
	}
}
endif;
add_action( 'wp_enqueue_scripts', 'cinnamon_color_scheme' );

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Custom functions that act independently of the theme templates.
 */
require get_template_directory() . '/inc/extras.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Third party plugins compatibility
 */
require get_template_directory() . '/inc/plugin-compatibility-jetpack.php';