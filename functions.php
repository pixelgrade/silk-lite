<?php
/**
 * Silk Lite functions and definitions
 *
 * @package Silk Lite
 */

if ( ! function_exists( 'silklite_setup' ) ) :
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */
	function silklite_setup() {

		/*
		 * Make theme available for translation.
		 * Translations can be filed in the /languages/ directory.
		 */
		load_theme_textdomain( 'silk-lite', get_template_directory() . '/languages' );

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
		add_image_size( 'silklite-tiny-image', 125, 90, true );

		//used for related posts sidebar
		add_image_size( 'silklite-small-image', 190, 85, true );

		//used as featured image for posts on archive pages
		//also for the background image of About Me widget
		add_image_size( 'silklite-masonry-image', 450, 9999, false );

		//Provide an image thumbnail that is the full content width
		add_image_size( 'silklite-single-content-image', 850, 9999, false );

		//used for the post thumbnail of posts on archives when displayed in a single column (no masonry)
		//and for the single post featured image
		add_image_size( 'silklite-single-image', 1024, 9999, false );

		// This theme uses wp_nav_menu() in three locations.
		register_nav_menus( array(
			'primary'          => esc_html__( 'Primary Menu', 'silk-lite' ),
			'top_header_left'  => esc_html__( 'Top Header Left Menu', 'silk-lite' ),
			'top_header_right' => esc_html__( 'Top Header Right Menu', 'silk-lite' ),
			'footer'           => esc_html__( 'Footer Menu', 'silk-lite' ),
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
		 * Enable support for custom logo.
		 */
		add_theme_support( 'custom-logo', array(
			'width'       => 1000,
			'height'      => 500,
			'flex-height' => true,
			'header-text' => array(
				'site-title',
				'site-description-text',
			)
		) );

		add_image_size( 'silk-site-logo', 1000, 500, false );

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
		add_editor_style( array( 'editor-style.css', silklite_fonts_url() ) );

		add_theme_support( 'customizer_style_manager' );
	}
endif; // silklite_setup
add_action( 'after_setup_theme', 'silklite_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function silklite_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'silklite_content_width', 850, 0 );
}
add_action( 'after_setup_theme', 'silklite_content_width', 0 );
/**
 * Adjusts content_width value depending on situation.
 */
function silklite_content_with_sidebar_width() {
	if ( ! is_active_sidebar( 'sidebar-1' ) ) {
		$GLOBALS['content_width'] = apply_filters( 'silklite_content_with_sidebar_width', 1250, 0 ); /* pixels */
	}
	//for attachments the $content_width is set in image.php
}
add_action( 'template_redirect', 'silklite_content_with_sidebar_width' );
/**
 * Add custom image sizes attribute to enhance responsive image functionality
 * for content images
 *
 * @since Silk Lite 1.1.0
 *
 * @param string $sizes A source size value for use in a 'sizes' attribute.
 * @param array  $size  Image size. Accepts an array of width and height
 *                      values in pixels (in that order).
 * @return string A source size value for use in a content image 'sizes' attribute.
 */
function silklite_content_image_sizes_attr( $sizes, $size ) {
	$width = $size[0];
	if ( is_active_sidebar( 'sidebar-1' ) ) {
		850 <= $width && $sizes = '(max-width: 739px) 94vw, (max-width: 969px) 88vw, (max-width: 1199px) 860px, 850px';
	} else {
		850 <= $width && $sizes = '(max-width: 739px) 94vw, (max-width: 969px) 88vw, (max-width: 1199px) 860px, 1250px';
	}
	850 > $width && 740 <= $width && $sizes = '(max-width: 739px) 94vw, (max-width: ' . $width . 'px) 88vw, ' . $width . 'px';
	740 > $width && $sizes = '(max-width: ' . $width . 'px) 94vw, ' . $width . 'px';
	return $sizes;
}
add_filter( 'wp_calculate_image_sizes', 'silklite_content_image_sizes_attr', 10 , 2 );
/**
 * Add custom image sizes attribute to enhance responsive image functionality
 * for post thumbnails
 *
 * @since Silk Lite 1.1.0
 *
 * @param array $attr Attributes for the image markup.
 * @param int   $attachment Image attachment ID.
 * @param array $size Registered image size or flat array of height and width dimensions.
 * @return array A source size value for use in a post thumbnail 'sizes' attribute.
 */
function silklite_post_thumbnail_sizes_attr( $attr, $attachment, $size ) {
	if ( is_active_sidebar( 'sidebar-1' ) ) {
		$attr['sizes'] = '(max-width: 739px) 94vw, (max-width: 969px) 88vw, (max-width: 1199px) 860px, 850px';
	} else {
		$attr['sizes'] = '(max-width: 739px) 94vw, (max-width: 969px) 88vw, (max-width: 1199px) 860px, 1250px';
	}
	return $attr;
}
add_filter( 'wp_get_attachment_image_attributes', 'silklite_post_thumbnail_sizes_attr', 10 , 3 );

/**
 * Register widget area.
 *
 * @link http://codex.wordpress.org/Function_Reference/register_sidebar
 */
function silklite_widgets_init() {
	register_sidebar( array(
		'name'          => esc_html__( 'Sidebar', 'silk-lite' ),
		'id'            => 'sidebar-1',
		'description'   => esc_html__( 'Add widgets here to appear in your main sidebar.', 'silk-lite' ),
		'before_widget' => '<div class="grid__item"><aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside></div>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );

	register_sidebar( array(
		'name'          => esc_html__( 'Footer', 'silk-lite' ),
		'id'            => 'footer-1',
		'description'   => esc_html__( 'Add widgets here to appear in your footer sidebar.', 'silk-lite' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );
}
add_action( 'widgets_init', 'silklite_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function silklite_scripts_styles() {
	$theme = wp_get_theme( get_template() );

	// FontAwesome Stylesheet
	wp_enqueue_style( 'font-awesome', get_template_directory_uri() . '/assets/css/font-awesome.css', array(), '4.2.0' );

	// Default Fonts
	wp_enqueue_style( 'silklite-fonts', silklite_fonts_url(), array(), null );

	// Main Stylesheet
	wp_enqueue_style( 'silklite-style', get_stylesheet_uri(), array( 'font-awesome', 'silklite-fonts' ), $theme->get( 'Version' ) );
	wp_style_add_data( 'silklite-style', 'rtl', 'replace' );

	// Register Velocity.js plugin
	wp_register_script( 'velocity', get_template_directory_uri() . '/assets/js/velocity.js', array(), '1.1.0', true );

	// Enqueue Silk Lite Custom Scripts
	wp_enqueue_script( 'silklite-scripts', get_template_directory_uri() . '/assets/js/main.js', array(
		'jquery',
		'masonry',
		'hoverIntent',
		'imagesloaded',
		'velocity',
	), $theme->get( 'Version' ), true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'silklite_scripts_styles' );

function silklite_gutenberg_styles() {
	wp_enqueue_style( 'silk-lite-gutenberg', get_theme_file_uri( '/editor.css' ), false );
	wp_enqueue_style( 'silk-lite-fonts', silklite_fonts_url() );
}
add_action( 'enqueue_block_editor_assets', 'silklite_gutenberg_styles' );

/**
 * Registers/enqueues the scripts related to media JS APIs
 *
 */
function silklite_wp_enqueue_media() {
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
				'frameTitle'      => esc_html__( 'Choose a Background Image', 'silk-lite' ),
				'frameUpdateText' => esc_html__( 'Update Background Image', 'silk-lite' ),
			),
		)
	);
}
add_action( 'wp_enqueue_media', 'silklite_wp_enqueue_media' );

/**
 * Custom template tags for this theme.
 */
require_once trailingslashit( get_template_directory() ) . 'inc/template-tags.php';

/**
 * Custom functions that act independently of the theme templates.
 */
require_once trailingslashit( get_template_directory() ) . 'inc/extras.php';

/**
 * Customizer additions.
 */
require_once trailingslashit( get_template_directory() ) . 'inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
require_once trailingslashit( get_template_directory() ) . 'inc/jetpack.php';

/**
 * Load the Hybrid Media Grabber class
 */
require_once trailingslashit( get_template_directory() ) . 'inc/silklite-hybrid-media-grabber.php';

/**
 * Load custom widgets
 */
require_once trailingslashit( get_template_directory() ) . 'inc/widgets/popular-posts.php';
require_once trailingslashit( get_template_directory() ) . 'inc/widgets/about-me.php';

/**
 * Admin dashboard related logic.
 */
require_once trailingslashit( get_template_directory() ) . 'inc/admin.php';

/**
 * Various plugins integrations.
 */
require_once trailingslashit( get_template_directory() ) . 'inc/integrations.php';
