<?php
/**
 * Silk Lite Theme Customizer
 * @package Silk Lite
 */


/**
 * Change some default texts and add our own custom settings
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function silklite_customize_register ( $wp_customize ) {

	/*
	 * Change defaults
	 */

	// Add postMessage support for site title and tagline and title color.
	$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';

	// Rename the label to "Display Site Title & Tagline" in order to make this option clearer.
	$wp_customize->get_control( 'display_header_text' )->label = __( 'Display Site Title &amp; Tagline', 'silk-lite' );

	/*
	 * Add custom settings
	 */

	$wp_customize->add_section( 'silklite_theme_options', array(
		'title'             => __( 'Theme', 'silk-lite' ),
		'priority'          => 30,
	) );

	$wp_customize->add_setting( 'silklite_single_column_archives', array(
		'default'           => '',
		'sanitize_callback' => 'silklite_sanitize_checkbox',
	) );

	$wp_customize->add_control( 'silklite_single_column_archives', array(
		'label'             => __( 'Display single column posts on front page and archives.', 'silk-lite' ),
		'section'           => 'silklite_theme_options',
		'type'              => 'checkbox',
	) );

	$wp_customize->add_setting( 'silklite_single_featured_image', array(
		'default'           => '',
		'sanitize_callback' => 'silklite_sanitize_checkbox',
	) );

	$wp_customize->add_control( 'silklite_single_featured_image', array(
		'label'             => __( 'Display the featured image on single posts.', 'silk-lite' ),
		'section'           => 'silklite_theme_options',
		'type'              => 'checkbox',
	) );

	$wp_customize->add_setting( 'silklite_disable_search_in_toolbar', array(
		'default'           => '',
		'sanitize_callback' => 'silklite_sanitize_checkbox',
	) );

	$wp_customize->add_control( 'silklite_disable_search_in_toolbar', array(
		'label'             => __( 'Hide search button in top header bar', 'silk-lite' ),
		'section'           => 'silklite_theme_options',
		'type'              => 'checkbox',
	) );

	$wp_customize->add_setting( 'silklite_site_title_outline', array(
		'default'           => '3',
		'sanitize_callback' => 'silklite_sanitize_site_title_outline',
		'transport' => 'postMessage',
	) );

	$wp_customize->add_control( 'silklite_site_title_outline', array(
		'label'   => __( 'Site Title Outline', 'silk-lite' ),
		'section' => 'silklite_theme_options',
		'type'    => 'select',
		'choices' => array(
			'0' => __( '0', 'silk-lite' ),
			'1.2' => __( '-1', 'silk-lite' ),
			'3' => __( '-2', 'silk-lite' ),
			'5' => __( '-3', 'silk-lite' ),
			'10' => __( '-4', 'silk-lite' ),
		),
	) );

	$wp_customize->add_setting( 'silklite_footer_copyright', array(
		'default'           => '',
		'sanitize_callback' => 'wp_kses_post',
	) );

	$wp_customize->add_control( 'silklite_footer_copyright', array(
		'label'             => __( 'Additional Copyright Text', 'silk-lite' ),
		'description' => '',
		'section'           => 'silklite_theme_options',
		'type'              => 'text',
	) );
}
add_action( 'customize_register', 'silklite_customize_register' );

/**
 * Sanitize the checkbox.
 *
 * @param boolean $input.
 * @return boolean true if is 1 or '1', false if anything else
 */
function silklite_sanitize_checkbox( $input ) {
	if ( 1 == $input ) {
		return true;
	} else {
		return false;
	}
}

/**
 * Sanitize the Site Title Outline value.
 *
 * @param string $outline Outline thickness.
 * @return string Filtered outline (0|1|2|3).
 */
function silklite_sanitize_site_title_outline( $outline ) {
	if ( ! in_array( $outline, array( '0', '1.2', '3', '5', '10' ) ) ) {
		$outline = '3';
	}

	return $outline;
}

/**
 * JavaScript that handles the Customizer AJAX logic
 */
function silklite_customizer_js() {
	wp_enqueue_script( 'silklite_customizer', get_template_directory_uri() . '/assets/js/customizer.js', array( 'customize-preview' ), '1.0.3', true );
}
add_action( 'customize_preview_init', 'silklite_customizer_js' ); ?>