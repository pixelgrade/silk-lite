<?php
/**
 * Silk functions and definitions
 *
 * @package Silk
 */

/**
 * Set the content width based on the theme's design and stylesheet.
 */
if ( ! isset( $content_width ) ) {
	$content_width = 662; /* pixels */
}

if ( ! function_exists( 'silk_content_width' ) ) :
	/**
	 * Adjusts content_width value depending on situation.
	 */
	function silk_content_width() {
		global $content_width;

		if ( ! is_active_sidebar( 'sidebar-1' ) ) {
			$content_width = 1062; /* pixels */
		}

		//for attachments the $content_width is set in image.php
	}
endif; //silk_content_width
add_action( 'template_redirect', 'silk_content_width' );

if ( ! function_exists( 'silk_setup' ) ) :
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */
	function silk_setup() {

		/*
		 * Make theme available for translation.
		 * Translations can be filed in the /languages/ directory.
		 */
		load_theme_textdomain( 'silk_txtd', get_template_directory() . '/languages' );

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

		//used for the small post thumbnails of the mega menu and next/prev post
		add_image_size( 'silk-tiny-image', 125, 90, true );

		//used for related posts sidebar
		add_image_size( 'silk-small-image', 190, 85, true );

		//used for the post thumbnail of the big mega menu post
		add_image_size( 'silk-mega-menu-big-image', 340, 340, false );

		//used as featured image for posts on archive pages
		//also for the background image of About Me widget
		add_image_size( 'silk-masonry-image', 450, 9999, false );

		//used for the post thumbnail of the featured posts in the home slider
		add_image_size( 'silk-slider-image', 650, 430, true );

		//used for the post thumbnail of posts on archives when displayed in a single column (no masonry)
		//and for the single post featured image
		add_image_size( 'silk-single-image', 1024, 9999, false );

		// This theme uses wp_nav_menu() in three locations.
		register_nav_menus( array(
			'primary'          => __( 'Primary Menu', 'silk_txtd' ),
			'top_header_left'  => __( 'Top Header Left Menu', 'silk_txtd' ),
			'top_header_right' => __( 'Top Header Right Menu', 'silk_txtd' ),
			'hamburger' 	   => __( 'Hamburger Menu', 'silk_txtd' ),
			'footer'           => __( 'Footer Menu', 'silk_txtd' ),
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
			'gallery',
			'image',
			'audio',
			'video',
			'quote',
			'link',
		) );

		/*
		 * Add editor custom style to make it look more like the frontend
		 * Also enqueue the custom Google Fonts also
		 */
		add_editor_style( array( 'editor-style.css', silk_fonts_url() ) );

		// Set up the WordPress core custom background feature.
		add_theme_support( 'custom-background', apply_filters( 'silk_custom_background_args', array(
			'default-color' => 'ffffff',
			'default-image' => '',
		) ) );
	}
endif; // silk_setup
add_action( 'after_setup_theme', 'silk_setup' );

/**
 * Register widget area.
 *
 * @link http://codex.wordpress.org/Function_Reference/register_sidebar
 */
function silk_widgets_init() {
	register_sidebar( array(
		'name'          => __( 'Sidebar', 'silk_txtd' ),
		'id'            => 'sidebar-1',
		'description'   => __( 'Add widgets here to appear in your main sidebar.', 'silk_txtd' ),
		'before_widget' => '<div class="grid__item"><aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside></div>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );

	register_sidebar( array(
		'name'          => __( 'Footer', 'silk_txtd' ),
		'id'            => 'footer-1',
		'description'   => __( 'Add widgets here to appear in your footer sidebar.', 'silk_txtd' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );
}

add_action( 'widgets_init', 'silk_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function silk_scripts_styles() {

	//FontAwesome Stylesheet
	wp_enqueue_style( 'silk-font-awesome-style', get_stylesheet_directory_uri() . '/assets/css/font-awesome.css', array(), '4.2.0' );

	//Main Stylesheet
	wp_enqueue_style( 'silk-style', get_stylesheet_uri(), array( 'silk-font-awesome-style' ) );

	//Default Fonts
	wp_enqueue_style( 'silk-fonts', silk_fonts_url(), array(), null );

	//Enqueue jQuery
	wp_enqueue_script( 'jquery' );

	//Enqueue Masonry
	wp_enqueue_script( 'masonry' );

	//only include the slider script if we have at least 2 featured posts
	if ( silk_has_featured_posts( 2 ) ) {
		//Enqueue FlexSlider plugin
		wp_enqueue_script( 'silk-flexslider', get_stylesheet_directory_uri() . '/assets/js/jquery.flexslider.js', array( 'jquery' ), '2.2.2', true );

		wp_localize_script( 'silk-flexslider', 'silkFeaturedSlider', array(
			'prevText' => __( 'Previous', 'silk_txtd' ),
			'nextText' => __( 'Next', 'silk_txtd' ),
		) );

	}

	//Enqueue ImagesLoaded plugin
	wp_enqueue_script( 'silk-imagesloaded', get_stylesheet_directory_uri() . '/assets/js/imagesloaded.js', array(), '3.1.8', true );

	//Enqueue HoverIntent
	wp_enqueue_script( 'hoverIntent' );

	//Enqueue Velocity.js plugin
	wp_enqueue_script( 'silk-velocity', get_stylesheet_directory_uri() . '/assets/js/velocity.js', array(), '1.1.0', true );

	//Enqueue Silk Custom Scripts
	wp_enqueue_script( 'silk-scripts', get_stylesheet_directory_uri() . '/assets/js/main.js', array(
		'jquery',
		'masonry',
		'hoverIntent',
		'silk-imagesloaded',
		'silk-velocity',
	), '1.0.0', true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}

add_action( 'wp_enqueue_scripts', 'silk_scripts_styles' );

/**
 * Registers/enqueues the scripts related to media JS APIs
 *
 */
function silk_wp_enqueue_media() {
	/*
	 * Register the about-me.js here so we can upload images in the customizer
	 */
	if ( ! wp_script_is( 'silk-about-me-widget-admin', 'registered' ) ) {
		wp_register_script( 'silk-about-me-widget-admin', get_template_directory_uri() . '/inc/widgets/assets/js/about-me.js', array(
			'media-upload',
			'media-views',
		) );
	}

	wp_enqueue_script( 'silk-about-me-widget-admin' );

	wp_localize_script(
		'silk-about-me-widget-admin',
		'SilkAboutMeWidget',
		array(
			'l10n' => array(
				'frameTitle'      => __( 'Choose a Background Image', 'silk_txtd' ),
				'frameUpdateText' => __( 'Update Background Image', 'silk_txtd' ),
			),
		)
	);
}

add_action( 'wp_enqueue_media', 'silk_wp_enqueue_media' );

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
require get_template_directory() . '/inc/widgets/about-me.php';

/**
 * Load Customify plugin configuration
 */
require get_template_directory() . '/inc/customify_config.php';

/**
 * Load Recommended/Required plugins notification
 */
require get_template_directory() . '/inc/required-plugins/required-plugins.php';

/**
 * Load the theme update logic
 */
require_once( get_template_directory() . '/inc/wp-updates-theme.php' );
new WPUpdatesThemeUpdater_1221( 'http://wp-updates.com/api/2/theme', basename( get_template_directory() ) ); ?>