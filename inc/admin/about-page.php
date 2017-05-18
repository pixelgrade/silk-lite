<?php
/**
 * Silk Lite Theme About Page logic.
 *
 * @package Silk Lite
 */

function silklite_admin_setup() {
	/**
	 * Load the About page class
	 */
	require_once 'ti-about-page/class-ti-about-page.php';

	/*
	* About page instance
	*/
	$config = array(
		// Menu name under Appearance.
		'menu_name'               => esc_html__( 'About Silk Lite', 'silk-lite' ),
		// Page title.
		'page_name'               => esc_html__( 'About Silk Lite', 'silk-lite' ),
		// Main welcome title
		'welcome_title'         => sprintf( esc_html__( 'Welcome to %s! - Version ', 'silk-lite' ), 'Silk Lite' ),
		// Main welcome content
		'welcome_content'       => esc_html__( ' Silk Lite is a free magazine-style theme designed to empower fashion bloggers to write more beautiful stories into an eye-candy playground.', 'silk-lite' ),
		/**
		 * Tabs array.
		 *
		 * The key needs to be ONLY consisted from letters and underscores. If we want to define outside the class a function to render the tab,
		 * the will be the name of the function which will be used to render the tab content.
		 */
		'tabs'                    => array(
			'getting_started'  => esc_html__( 'Getting Started', 'silk-lite' ),
			'recommended_actions' => esc_html__( 'Recommended Actions', 'silk-lite' ),
			'recommended_plugins' => esc_html__( 'Useful Plugins','silk-lite' ),
			'support'       => esc_html__( 'Support', 'silk-lite' ),
			'changelog'        => esc_html__( 'Changelog', 'silk-lite' ),
			'free_pro'         => esc_html__( 'Free VS PRO', 'silk-lite' ),
		),
		// Support content tab.
		'support_content'      => array(
			'first' => array (
				'title' => esc_html__( 'Contact Support','silk-lite' ),
				'icon' => 'dashicons dashicons-sos',
				'text' => __( 'We want to make sure you have the best experience using Silk Lite. If you <strong>do not have a paid upgrade</strong>, please post your question in our community forums.','silk-lite' ),
				'button_label' => esc_html__( 'Contact Support','silk-lite' ),
				'button_link' => esc_url( 'https://wordpress.org/support/theme/silk-lite' ),
				'is_button' => true,
				'is_new_tab' => true
			),
			'second' => array(
				'title' => esc_html__( 'Documentation','silk-lite' ),
				'icon' => 'dashicons dashicons-book-alt',
				'text' => esc_html__( 'Need more details? Please check our full documentation for detailed information on how to use Silk Lite.','silk-lite' ),
				'button_label' => esc_html__( 'Read The Documentation','silk-lite' ),
				'button_link' => 'https://pixelgrade.com/silk-lite-documentation/',
				'is_button' => false,
				'is_new_tab' => true
			)
		),
		// Getting started tab
		'getting_started' => array(
			'first' => array(
				'title' => esc_html__( 'Go to Customizer','silk-lite' ),
				'text' => esc_html__( 'Using the WordPress Customizer you can easily customize every aspect of the theme.','silk-lite' ),
				'button_label' => esc_html__( 'Go to Customizer','silk-lite' ),
				'button_link' => esc_url( admin_url( 'customize.php' ) ),
				'is_button' => true,
				'recommended_actions' => false,
				'is_new_tab' => true
			),
			'second' => array (
				'title' => esc_html__( 'Recommended actions','silk-lite' ),
				'text' => esc_html__( 'We have compiled a list of steps for you, to take make sure the experience you will have using one of our products is very easy to follow.','silk-lite' ),
				'button_label' => esc_html__( 'Recommended actions','silk-lite' ),
				'button_link' => esc_url( admin_url( 'themes.php?page=silk-lite-welcome&tab=recommended_actions' ) ),
				'button_ok_label' => esc_html__( 'You are good to go!','silk-lite' ),
				'is_button' => false,
				'recommended_actions' => true,
				'is_new_tab' => false
			),
			'third' => array(
				'title' => esc_html__( 'Read the documentation','silk-lite' ),
				'text' => esc_html__( 'Need more details? Please check our full documentation for detailed information on how to use Silk Lite.','silk-lite' ),
				'button_label' => esc_html__( 'Documentation','silk-lite' ),
				'button_link' => 'https://pixelgrade.com/silk-lite-documentation/',
				'is_button' => false,
				'recommended_actions' => false,
				'is_new_tab' => true
			)
		),
		// Free vs pro array.
		'free_pro'                => array(
			'free_theme_name'     => 'Silk Lite',
			'pro_theme_name'      => 'Silk PRO',
			'pro_theme_link'      => 'https://pixelgrade.com/themes/silk-lite/?utm_source=silk-lite-clients&utm_medium=about-page&utm_campaign=silk-lite#pro',
			'get_pro_theme_label' => sprintf( __( 'View %s', 'silk-lite' ), 'Silk Pro' ),
			'features'            => array(
				array(
					'title'       => esc_html__( 'Exquisite Design', 'silk-lite' ),
					'description' => esc_html__( 'Design is a great way to share appealing stories. Silk helps you to become a better storyteller into the digital world. Thanks to a very human approach in terms of interaction, a gentle and eye-candy typography and stylish details, you can definitely reach the right audience.', 'silk-lite' ),
					'is_in_lite'  => 'true',
					'is_in_pro'   => 'true',
				),
				array(
					'title'       => esc_html__( 'Mobile-Ready and Responsive for All Devices', 'silk-lite' ),
					'description' => esc_html__( 'One of the perks of living these days is the tremendous chance to stay connected with everything you love without boundaries. That’s why SIlk is mobile-ready and facilitates your users to easily enjoy your content, no matter the device they like to use on a daily basis.', 'silk-lite' ),
					'is_in_lite'  => 'true',
					'is_in_pro'   => 'true',
				),
				array(
					'title'       => esc_html__( 'Social Integration', 'silk-lite' ),
					'description' => esc_html__( 'Let your voice be heard by the right people. Aim to build a strong community around your fashion blog and start a smart dialogue with those who admire your work. Facebook, Twitter, Instagram, you name it, but be aware that all can boost your content and increase awareness.', 'silk-lite' ),
					'is_in_lite'  => 'true',
					'is_in_pro'   => 'true',
				),
				array(
					'title'       => esc_html__( 'Personalize to Match Your Style', 'silk-lite' ),
					'description' => esc_html__( 'Having different tastes and preferences might be tricky for users, but not with Silk onboard. It has an intuitive and catchy interface which allows you to change fonts, colors or layout sizes in a blink of an eye.', 'silk-lite' ),
					'is_in_lite'  => 'false',
					'is_in_pro'   => 'true',
				),
				array(
					'title'       => esc_html__( 'Featured Posts Slider', 'silk-lite' ),
					'description' => esc_html__( 'Showcase the latest posts from a category under menu without losing precious time and money. Highlight those articles you feel proud about with no effort and let people know about your appetite for a topic or another.', 'silk-lite' ),
					'is_in_lite'  => 'false',
					'is_in_pro'   => 'true',
				),
				array(
					'title'       => __( 'Support Best-In-Business', 'silk-lite' ),
					'description' => __( 'You will benefit by priority support from a caring and devoted team, eager to help and to spread happiness. We work hard to provide a flawless experience for those who vote us with trust and choose to be our special clients.','silk-lite' ),
					'is_in_lite'  => 'false',
					'is_in_pro'   => 'true',
				),
				array(
					'title'       => esc_html__( 'Comprehensive Help Guide', 'silk-lite' ),
					'description' => esc_html__( 'Extensive documentation that will help you get your site up quickly and seamlessly.', 'silk-lite' ),
					'is_in_lite'  => 'false',
					'is_in_pro'   => 'true',
				),
				array(
					'title'       => esc_html__( 'No credit footer link', 'silk-lite' ),
					'description' => esc_html__( 'Remove "Theme: Silk Lite by Pixelgrade" copyright from the footer area.', 'silk-lite' ),
					'is_in_lite'  => 'false',
					'is_in_pro'   => 'true',
				)
			),
		),
		// Plugins array.
		'recommended_plugins'        => array(
			'already_activated_message' => esc_html__( 'Already activated', 'silk-lite' ),
			'version_label' => esc_html__( 'Version: ', 'silk-lite' ),
			'install_label' => esc_html__( 'Install and Activate', 'silk-lite' ),
			'activate_label' => esc_html__( 'Activate', 'silk-lite' ),
			'deactivate_label' => esc_html__( 'Deactivate', 'silk-lite' ),
			'content'                   => array(
				array(
					'slug' => 'jetpack'
				),
				array(
					'slug' => 'wordpress-seo'
				),
				array(
					'slug' => 'gridable'
				)
			),
		),
		// Required actions array.
		'recommended_actions'        => array(
			'install_label' => esc_html__( 'Install and Activate', 'silk-lite' ),
			'activate_label' => esc_html__( 'Activate', 'silk-lite' ),
			'deactivate_label' => esc_html__( 'Deactivate', 'silk-lite' ),
			'content'            => array(
				'jetpack' => array(
					'title'       => 'Jetpack',
					'description' => __( 'It is highly recommended that you install Jetpack so you can enable the <b>Portfolio</b> content type for adding and managing your projects. Plus, Jetpack provides a whole host of other useful things for you site.', 'silk-lite' ),
					'check'       => defined( 'JETPACK__VERSION' ),
					'plugin_slug' => 'jetpack',
					'id' => 'jetpack'
				),
			),
		),
	);
	TI_About_Page::init( $config );
}
add_action('after_setup_theme', 'silklite_admin_setup');
