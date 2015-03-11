<?php
/**
 * basis functions and definitions
 *
 * @package basis
 */

/**
 * Set the content width based on the theme's design and stylesheet.
 */
if ( ! isset( $content_width ) ) {
	$content_width = 640; /* pixels */
}

if ( ! function_exists( 'basis_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function basis_setup() {

	/*
	 * Make theme available for translation.
	 * Translations can be filed in the /languages/ directory.
	 * If you're building a theme based on basis, use a find and replace
	 * to change 'basis' to the name of your theme in all the template files
	 */
	load_theme_textdomain( 'basis', get_template_directory() . '/languages' );

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	/*
	 * Let WordPress manage the document title.
	 * By adding theme support, we declare that this theme does not use a
	 * hard-coded <title> tag in the document head, and expect WordPress to
	 * provide it for us.
	 */
	add_theme_support( 'title-tag' );

	/*
	 * Enable support for Post Thumbnails on posts and pages.
	 *
	 * @link http://codex.wordpress.org/Function_Reference/add_theme_support#Post_Thumbnails
	 */
	add_theme_support( 'post-thumbnails' );

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus( array(
		'primary' => __( 'Primary Menu', 'basis' ),
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
		'aside', 'image', 'video', 'quote', 'link',
	) );

	// Set up the WordPress core custom background feature.
	add_theme_support( 'custom-background', apply_filters( 'basis_custom_background_args', array(
		'default-color' => 'ffffff',
		'default-image' => '',
	) ) );
}
endif; // basis_setup
add_action( 'after_setup_theme', 'basis_setup' );

/**
 * Register widget area.
 *
 * @link http://codex.wordpress.org/Function_Reference/register_sidebar
 */
function basis_widgets_init() {
	register_sidebar( array(
		'name'          => __( 'Sidebar', 'basis' ),
		'id'            => 'sidebar-1',
		'description'   => '',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h1 class="widget-title">',
		'after_title'   => '</h1>',
	) );
}
add_action( 'widgets_init', 'basis_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function basis_scripts() {
	wp_enqueue_style( 'basis-style', get_stylesheet_uri() );
    // Main Style
    wp_enqueue_style( 'northwest-style',  get_stylesheet_directory_uri() . '/css/style-min.css' );

	wp_enqueue_script( 'basis-navigation', get_template_directory_uri() . '/js/navigation.js', array(), '20120206', true );

	wp_enqueue_script( 'basis-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), '20130115', true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'basis_scripts' );

/**
 * Implement the Custom Header feature.
 */
//require get_template_directory() . '/inc/custom-header.php';

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
 * Load Jetpack compatibility file.
 */
require get_template_directory() . '/inc/jetpack.php';

/**
 * Extend the user contact methods to include Twitter, Facebook and Google+
 *
 * @since basis 1.0
 *
 * @param array List of user contact methods
 * @return array The filtered list of updated user contact methods
 */
function basis_new_contactmethods( $contactmethods ) {
	// Add Twitter
	$contactmethods['twitter'] = 'Twitter';

	//add Facebook
	$contactmethods['facebook'] = 'Facebook';

	//add Google Plus
	$contactmethods['googleplus'] = 'Google+';

	return $contactmethods;
}
add_filter( 'user_contactmethods', 'basis_new_contactmethods', 10, 1 );




/**
 * Extend Customizer Features
 *
 * @since basis 1.0
 *
 */
function basis_customizer( $wp_customize ) {

	// add "Content Options" section
	$wp_customize->add_section( 'basis_content_options_section' , array(
		'title'      => __( 'Content Options', 'basis' ),
		'priority'   => 100,
	) );
	
	// add setting for page comment toggle checkbox
	$wp_customize->add_setting( 'basis_page_comment_toggle', array( 
		'default' => 1 
	) );
	
	// add control for page comment toggle checkbox
	$wp_customize->add_control( 'basis_page_comment_toggle', array(
		'label'     => __( 'Show comments on pages?', 'basis' ),
		'section'   => 'basis_content_options_section',
		'priority'  => 10,
		'type'      => 'checkbox'
	) );
}
add_action( 'customize_register', 'basis_customizer' );
