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
function silklite_customize_register( $wp_customize ) {

	/*
	 * Change defaults
	 */

	// Add postMessage support for site title and tagline and title color.
	$wp_customize->get_setting( 'blogname' )->transport        = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport = 'postMessage';

	// Rename the label to "Display Site Title & Tagline" in order to make this option clearer.
	$wp_customize->get_control( 'display_header_text' )->label = esc_html__( 'Display Site Title &amp; Tagline', 'silk-lite' );

	// Add a pretty icon to Site Identity
	$wp_customize->get_section('title_tagline')->title = '&#x1f465; ' . esc_html__('Site Identity', 'silk-lite');

	// View Pro
	$wp_customize->add_section( 'silklite_style_view_pro', array(
		'title'       => '' . esc_html__( 'View PRO Version', 'silk-lite' ),
		'priority'    => 2,
		'description' => sprintf(
			__( '<div class="upsell-container">
					<h2>Need More? Go PRO</h2>
					<p>Take it to the next level. See the features below:</p>
					<ul class="upsell-features">
                            <li>
                            	<h4>Personalize to Match Your Style</h4>
                            	<div class="description">Having different tastes and preferences might be tricky for users, but not with Silk onboard. It has an intuitive and catchy interface which allows you to change <strong>fonts, colors or layout sizes</strong> in a blink of an eye.</div>
                            </li>

                            <li>
                            	<h4>Featured Posts Slider</h4>
                            	<div class="description">Bring your best stories in the front of the world by adding them into the posts slider. It’s an extra opportunity to grab attention and to refresh some content that is still meaningful. Don’t miss any occasion to increase the value of your stories.</div>
                            </li>

                            <li>
                            	<h4>Custom Mega Menu</h4>
                            	<div class="description">Showcase the latest posts from a category under menu without losing precious time and money. Highlight those articles you feel proud about with no effort and let people know about your appetite for a topic or another.</div>
                            </li>

                            <li>
                            	<h4>Premium Customer Support</h4>
                            	<div class="description">You will benefit by priority support from a caring and devoted team, eager to help and to spread happiness. We work hard to provide a flawless experience for those who vote us with trust and choose to be our special clients.</div>
                            </li>
                            
                    </ul> %s </div>', 'silk-lite' ),
			sprintf( '<a href="%1$s" target="_blank" class="button button-primary">%2$s</a>', esc_url( silklite_get_pro_link() ), esc_html__( 'View Silk PRO', 'silk-lite' ) )
		),
	) );

	$wp_customize->add_setting( 'silklite_style_view_pro_desc', array(
		'default'           => '',
		'sanitize_callback' => 'silklite_sanitize_checkbox',
	) );
	$wp_customize->add_control( 'silklite_style_view_pro_desc', array(
		'section' => 'silklite_style_view_pro',
		'type'    => 'hidden',
	) );


	// Style Presets
	$wp_customize->add_section( 'silklite_style_presets', array(
		'title'       => '&#x1f3ad; ' . esc_html__( 'Style Presets', 'silk-lite' ),
		'priority'    => 29,
		'description' => sprintf(
			__( '<p>%s provides you hand-crafted style presets so that you never go out of trends and add some real value to the full package. You can instantly achieve a different visual approach and level up the users interest. </p><p> Our designer did his best to carefully match the colors and fonts so that you can easily refresh the overall style of your website.</p>', 'silk-lite' ),
			sprintf( '<a href="%1$s" target="_blank">%2$s</a>', esc_url( silklite_get_pro_link() ), esc_html__( 'Silk Pro', 'silk-lite' ) )
		)
	) );

	$wp_customize->add_setting( 'silklite_style_presets_desc', array(
		'default'           => '',
		'sanitize_callback' => 'silklite_sanitize_checkbox',
	) );
	$wp_customize->add_control( 'silklite_style_presets_desc', array(
		'section' => 'silklite_style_presets',
		'type'    => 'hidden',
	) );


	// Colors
	$wp_customize->add_section( 'silklite_colors', array(
		'title'       => '&#x1f3a8; ' . esc_html__( 'Colors', 'silk-lite' ),
		'priority'    => 30,
		'description' => sprintf(
			__( '<p>Play around with colors that fits your vision, your mood or both of them. You can smoothly make a design twist to quickly catch your wide preferences.</p><p>%s to switch colors and fonts in order to nurture your visual approach.</p>', 'silk-lite' ),
			sprintf( '<a href="%1$s" target="_blank">%2$s</a>', esc_url( silklite_get_pro_link() ), esc_html__( 'Upgrade to Silk Pro', 'silk-lite' )
			)
		)
	) );

	$wp_customize->add_setting( 'silklite_colors_desc', array(
		'default'           => '',
		'sanitize_callback' => 'silklite_sanitize_checkbox',
	) );
	$wp_customize->add_control( 'silklite_colors_desc', array(
		'section' => 'silklite_colors',
		'type'    => 'hidden',
	) );

	// Fonts
	$wp_customize->add_section( 'silklite_fonts', array(
		'title'       => '&#x1f4dd; ' . esc_html__( 'Fonts', 'silk-lite' ),
		'priority'    => 31,
		'description' => sprintf(
			__( '<p>Typography can make it or break it. %s gives you a generous playground to match your needs in terms of fonts and sizes.</p><p>You have full-access to 600+ Google Fonts to mingle with for fine-tuning your style.', 'silk-lite' ),
			sprintf( '<a href="%1$s" target="_blank">%2$s</a>', esc_url( silklite_get_pro_link() ), esc_html__( 'Silk Pro', 'silk-lite' )
			)
		)
	) );


	$wp_customize->add_setting( 'silklite_fonts_desc', array(
		'default'           => '',
		'sanitize_callback' => 'silklite_sanitize_checkbox',
	) );
	$wp_customize->add_control( 'silklite_fonts_desc', array(
		'section' => 'silklite_fonts',
		'type'    => 'hidden',
	) );


	/*
	 * Add custom settings
	 */

	$wp_customize->add_section( 'silklite_theme_options', array(
		'title'    => '&#x1f506; ' . esc_html__( 'Theme Options', 'silk-lite' ),
		'priority' => 25,
	) );

	$wp_customize->add_setting( 'silklite_single_column_archives', array(
		'default'           => '',
		'sanitize_callback' => 'silklite_sanitize_checkbox',
	) );

	$wp_customize->add_control( 'silklite_single_column_archives', array(
		'label'   => esc_html__( 'Display single column posts on front page and archives.', 'silk-lite' ),
		'section' => 'silklite_theme_options',
		'type'    => 'checkbox',
	) );

	$wp_customize->add_setting( 'silklite_single_featured_image', array(
		'default'           => '',
		'sanitize_callback' => 'silklite_sanitize_checkbox',
	) );

	$wp_customize->add_control( 'silklite_single_featured_image', array(
		'label'   => esc_html__( 'Display the featured image on single posts.', 'silk-lite' ),
		'section' => 'silklite_theme_options',
		'type'    => 'checkbox',
	) );

	$wp_customize->add_setting( 'silklite_disable_search_in_toolbar', array(
		'default'           => '',
		'sanitize_callback' => 'silklite_sanitize_checkbox',
	) );

	$wp_customize->add_control( 'silklite_disable_search_in_toolbar', array(
		'label'   => esc_html__( 'Hide search button in top header bar', 'silk-lite' ),
		'section' => 'silklite_theme_options',
		'type'    => 'checkbox',
	) );

	$wp_customize->add_setting( 'silklite_site_title_outline', array(
		'default'           => '3',
		'sanitize_callback' => 'silklite_sanitize_site_title_outline',
		'transport'         => 'postMessage',
	) );

	$wp_customize->add_control( 'silklite_site_title_outline', array(
		'label'   => esc_html__( 'Site Title Outline', 'silk-lite' ),
		'section' => 'silklite_theme_options',
		'type'    => 'select',
		'choices' => array(
			'0'   => esc_html__( '0', 'silk-lite' ),
			'1.2' => esc_html__( '-1', 'silk-lite' ),
			'3'   => esc_html__( '-2', 'silk-lite' ),
			'5'   => esc_html__( '-3', 'silk-lite' ),
			'10'  => esc_html__( '-4', 'silk-lite' ),
		),
	) );

	$wp_customize->add_setting( 'silklite_footer_copyright', array(
		'default'           => '',
		'sanitize_callback' => 'wp_kses_post',
	) );

	$wp_customize->add_control( 'silklite_footer_copyright', array(
		'label'       => esc_html__( 'Additional Copyright Text', 'silk-lite' ),
		'description' => '',
		'section'     => 'silklite_theme_options',
		'type'        => 'text',
	) );
}

add_action( 'customize_register', 'silklite_customize_register', 15 );

/**
 * Sanitize the checkbox.
 *
 * @param boolean $input .
 *
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
 *
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
 * This will be added in the preview part
 */
function silklite_customizer_preview_assets() {
	wp_enqueue_script( 'silklite_customizer_preview', get_template_directory_uri() . '/assets/js/customizer_preview.js', array( 'customize-preview' ), '1.0.4', true );
}

add_action( 'customize_preview_init', 'silklite_customizer_preview_assets' );

/**
 * Assets that will be loaded for the customizer sidebar
 */
function silklite_customizer_assets() {
	wp_enqueue_style( 'silklite_customizer_style', get_template_directory_uri() . '/assets/css/admin/customizer.css', null, '1.0.4', false );

	wp_enqueue_script( 'silklite_customizer', get_template_directory_uri() . '/assets/js/customizer.js', array( 'jquery' ), '1.0.4', false );

	// uncomment this to put back your dismiss notice
	// update_user_meta( get_current_user_id(), 'silk_upgrade_dismissed_notice', 0 );
	if ( isset( $_GET['silk-upgrade-dismiss'] ) && check_admin_referer( 'silk-upgrade-dismiss-' . get_current_user_id() ) ) {
		update_user_meta( get_current_user_id(), 'silk_upgrade_dismissed_notice', 'forever' );
		return;
	}

	$dismiss_user = get_user_meta( get_current_user_id(), 'silk_upgrade_dismissed_notice', true );
	if ( $dismiss_user === 'forever' ) {
		return;
	} elseif ( empty( $dismiss_user ) || ( is_numeric( $dismiss_user ) && $dismiss_user < 2  ) ) {

		$value = $dismiss_user + 1;
		update_user_meta( get_current_user_id(), 'silk_upgrade_dismissed_notice', $value );
		return;
	}

	$localized_strings = array(
		'upsell_link'     => silklite_get_pro_link(),
		'upsell_label'    => esc_html__( 'Upgrade to Silk Pro', 'silk-lite' ),
		'pro_badge_label' => esc_html__( 'Pro', 'silk-lite' ) . '<span class="star"></span>',
		'dismiss_link' => esc_url( wp_nonce_url( add_query_arg( 'silk-upgrade-dismiss', 'forever' ), 'silk-upgrade-dismiss-' . get_current_user_id() ) )
	);

	wp_localize_script( 'silklite_customizer', 'silkCustomizerObject', $localized_strings );
}

add_action( 'customize_controls_enqueue_scripts', 'silklite_customizer_assets' );

/**
 * Generate a link to the Silk Lite info page.
 */
function silklite_get_pro_link() {
	return 'https://pixelgrade.com/themes/blogging/silk-lite?utm_source=silk-lite-clients&utm_medium=customizer&utm_campaign=silk-lite#pro';
}

function silk_add_customify_options( $config ) {

	$config['sections'] = array();
	$config['panels'] = array();

	return $config;
}
add_filter( 'customify_filter_fields', 'silk_add_customify_options' );
?>