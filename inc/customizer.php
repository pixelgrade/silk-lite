<?php
/**
 * Silk Theme Customizer
 * @package Silk
 */


/**
 * Change some default texts and add our own custom settings
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function silk_customize_register ( $wp_customize ) {

	/*
	 * Change defaults
	 */

	// Add postMessage support for site title and tagline and title color.
	$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';

	// Rename the label to "Display Site Title & Tagline" in order to make this option clearer.
	$wp_customize->get_control( 'display_header_text' )->label = __( 'Display Site Title &amp; Tagline', 'silk_txtd' );

	/*
	 * Add custom settings
	 */

	$wp_customize->add_section( 'silk_theme_options', array(
		'title'             => __( 'Theme', 'silk_txtd' ),
		'priority'          => 30,
	) );

	$wp_customize->add_setting( 'silk_single_column_archives', array(
		'default'           => '',
		'sanitize_callback' => 'silk_sanitize_checkbox',
	) );

	$wp_customize->add_control( 'silk_single_column_archives', array(
		'label'             => __( 'Display single column posts on front page and archives.', 'silk_txtd' ),
		'section'           => 'silk_theme_options',
		'type'              => 'checkbox',
	) );

	$wp_customize->add_setting( 'silk_disable_search_in_toolbar', array(
		'default'           => '',
		'sanitize_callback' => 'silk_sanitize_checkbox',
	) );

	$wp_customize->add_control( 'silk_disable_search_in_toolbar', array(
		'label'             => __( 'Hide search button in toolbar', 'silk_txtd' ),
		'section'           => 'silk_theme_options',
		'type'              => 'checkbox',
	) );

	$wp_customize->add_setting( 'silk_site_title_outline', array(
		'default'           => '0',
		'sanitize_callback' => 'silk_sanitize_site_title_outline',
	) );

	$wp_customize->add_control( 'silk_site_title_outline', array(
		'label'   => __( 'Site Title Outline', 'silk_txtd' ),
		'section' => 'silk_theme_options',
		'type'    => 'select',
		'choices' => array(
			'0' => __( '0', 'silk_txtd' ),
			'1' => __( '-1', 'silk_txtd' ),
			'2' => __( '-2', 'silk_txtd' ),
			'3' => __( '-3', 'silk_txtd' ),
		),
	) );
}
add_action( 'customize_register', 'silk_customize_register' );

/**
 * Sanitize the checkbox.
 *
 * @param boolean $input.
 * @return boolean true if is 1 or '1', false if anything else
 */
function silk_sanitize_checkbox( $input ) {
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
function silk_sanitize_site_title_outline( $outline ) {
	if ( ! in_array( $outline, array( '0', '1', '2', '3' ) ) ) {
		$outline = '0';
	}

	return $outline;
}

/**
 * JavaScript that handles the Customizer AJAX logic
 */
function silk_customizer_js() {
	wp_enqueue_script( 'silk_customizer', get_stylesheet_directory_uri() . '/assets/js/customizer.js', array( 'customize-preview' ), '1.0.0', true );
}
add_action( 'customize_preview_init', 'silk_customizer_js' ); ?>