<?php
/**
 * Amelie functions and definitions
 *
 * @package Amelie
 */

/**
 * Set the content width based on the theme's design and stylesheet.
 */
if ( ! isset( $content_width ) ) {
	$content_width = 640; /* pixels */
}

if ( ! function_exists( 'amelie_setup' ) ) :
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */
	function amelie_setup() {

		/*
		 * Make theme available for translation.
		 * Translations can be filed in the /languages/ directory.
		 */
		load_theme_textdomain( 'amelie_txtd', get_template_directory() . '/languages' );

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
		add_image_size( 'amelie-tiny-image', 125, 90, true );
		add_image_size( 'amelie-small-image', 300, 9999, false );
		add_image_size( 'amelie-masonry-image', 450, 9999, false );
		add_image_size( 'amelie-single-image', 1024, 9999, false );
		add_image_size( 'amelie-site-logo', 1000, 500, false );

		// This theme uses wp_nav_menu() in three locations.
		register_nav_menus( array(
			'primary'          => __( 'Primary Menu', 'amelie_txtd' ),
			'top_header_left'  => __( 'Top Header Left Menu', 'amelie_txtd' ),
			'top_header_right' => __( 'Top Header Right Menu', 'amelie_txtd' ),
			'footer'           => __( 'Footer Menu', 'amelie_txtd' ),
		) );

		/*
		 * Switch default core markup for search form, comment form, and comments
		 * to output valid HTML5.
		 */
		add_theme_support( 'html5', array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
		) );

		/*
		 * Enable support for Post Formats.
		 * See http://codex.wordpress.org/Post_Formats
		 */
		add_theme_support( 'post-formats', array(
			'aside',
			'image',
			'video',
			'quote',
			'link',
		) );

		/*
		 * Add editor custom style to make it look more like the frontend
		 * Also enqueue the custom Google Fonts also
		 */
		add_editor_style( array( 'editor-style.css', amelie_fonts_url() ) );

		// Set up the WordPress core custom background feature.
		add_theme_support( 'custom-background', apply_filters( 'amelie_custom_background_args', array(
			'default-color' => 'ffffff',
			'default-image' => '',
		) ) );
	}
endif; // amelie_setup
add_action( 'after_setup_theme', 'amelie_setup' );

/**
 * Register widget area.
 *
 * @link http://codex.wordpress.org/Function_Reference/register_sidebar
 */
function amelie_widgets_init() {
	register_sidebar( array(
		'name'          => __( 'Sidebar', 'amelie_txtd' ),
		'id'            => 'sidebar-1',
		'description'   => __( 'Add widgets here to appear in your main sidebar.', 'amelie_txtd' ),
		'before_widget' => '<div class="grid__item"><aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside></div>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );

	register_sidebar( array(
		'name'          => __( 'Footer', 'amelie_txtd' ),
		'id'            => 'footer-1',
		'description'   => __( 'Add widgets here to appear in your footer sidebar.', 'amelie_txtd' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );
}

add_action( 'widgets_init', 'amelie_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function amelie_scripts_styles() {

	//FontAwesome Stylesheet
	wp_enqueue_style( 'amelie-font-awesome-style', get_stylesheet_directory_uri() . '/assets/css/font-awesome.css', array(), '4.2.0' );

	//Main Stylesheet
	wp_enqueue_style( 'hive-style', get_stylesheet_uri(), array( 'amelie-font-awesome-style' ) );

	//Default Fonts
	wp_enqueue_style( 'amelie-fonts', amelie_fonts_url(), array(), null );

	//Enqueue jQuery
	wp_enqueue_script( 'jquery' );

	//Enqueue Masonry
	wp_enqueue_script( 'masonry' );

	//only include the slider script if we have at least 2 featured posts
	if ( amelie_has_featured_posts( 2 ) ) {
		//Enqueue FlexSlider plugin
		wp_enqueue_script( 'amelie-flexslider', get_stylesheet_directory_uri() . '/assets/js/jquery.flexslider.js', array('jquery'), '2.2.2', true );

	}

	//Enqueue ImagesLoaded plugin
	wp_enqueue_script( 'amelie-imagesloaded', get_stylesheet_directory_uri() . '/assets/js/imagesloaded.js', array(), '3.1.8', true );

	//Enqueue HoverIntent plugin
	wp_enqueue_script( 'amelie-hoverintent', get_stylesheet_directory_uri() . '/assets/js/jquery.hoverIntent.js', array( 'jquery' ), '1.8.0', true );

	//Enqueue Velocity.js plugin
	wp_enqueue_script( 'amelie-velocity', get_stylesheet_directory_uri() . '/assets/js/velocity.js', array(), '1.1.0', true );

	//Enqueue Amelie Custom Scripts
	wp_enqueue_script( 'amelie-scripts', get_stylesheet_directory_uri() . '/assets/js/main.js', array(
		'jquery',
		'masonry',
		'amelie-imagesloaded',
		'amelie-hoverintent',
		'amelie-velocity'
	), '1.0.0', true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}

add_action( 'wp_enqueue_scripts', 'amelie_scripts_styles' );

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
 * Load custom widgets
 */
require get_template_directory() . '/inc/widgets/popular-posts.php';
require get_template_directory() . '/inc/widgets/about-me.php'; ?>