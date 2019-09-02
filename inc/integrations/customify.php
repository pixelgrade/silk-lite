<?php
/**
 * Silk Lite Customizer Options Config
 *
 * @package Silk Lite
 * @since 1.4.0
 */
/**
 * Hook into the Customify's fields and settings.
 *
 * The config can turn to be complex so is best to visit:
 * https://github.com/pixelgrade/customify
 *
 * @param array $options Contains the plugin's options array right before they are used, so edit with care
 *
 * @return array The returned options are required, if you don't need options return an empty array
 */
add_filter( 'customify_filter_fields', 'silklite_add_customify_options', 11, 1 );
add_filter( 'customify_filter_fields', 'silklite_add_customify_style_manager_section', 12, 1 );

add_filter( 'customify_filter_fields', 'silklite_fill_customify_options', 20 );

define( 'SILKLITE_SM_COLOR_PRIMARY', '#A33B61' );
define( 'SILKLITE_SM_COLOR_SECONDARY', '#FCC9B0' );
define( 'SILKLITE_SM_COLOR_TERTIARY', '#A33B61' );

define( 'SILKLITE_SM_DARK_PRIMARY', '#000000' );
define( 'SILKLITE_SM_DARK_SECONDARY', '#403B3C' );
define( 'SILKLITE_SM_DARK_TERTIARY', '#403B3C' );

define( 'SILKLITE_SM_LIGHT_PRIMARY', '#FFFFFF' );
define( 'SILKLITE_SM_LIGHT_SECONDARY', '#B8B6B7' );
define( 'SILKLITE_SM_LIGHT_TERTIARY', '#B8B6B7' );

function silklite_add_customify_options( $options ) {
	$options['opt-name'] = 'silk_options';

	$options['sections'] = array();

	return $options;
}

/**
 * Add the Style Manager cross-theme Customizer section.
 *
 * @param array $options
 *
 * @return array
 */
function silklite_add_customify_style_manager_section( $options ) {
	// If the theme hasn't declared support for style manager, bail.
	if ( ! current_theme_supports( 'customizer_style_manager' ) ) {
		return $options;
	}

	if ( ! isset( $options['sections']['style_manager_section'] ) ) {
		$options['sections']['style_manager_section'] = array();
	}

	$new_config = array(
		'options' => array(
			'sm_color_primary' => array(
				'default' => SILKLITE_SM_COLOR_PRIMARY,
				'connected_fields' => array(
					// low
					'accent_color',

					// medium
					'site_title_color',
				),
			),
			'sm_color_secondary' => array(
				'default' => SILKLITE_SM_COLOR_SECONDARY,
				'connected_fields' => array(
					// medium
					'secondary_color',
				),
			),
			'sm_color_tertiary' => array(
				'default' => SILKLITE_SM_COLOR_TERTIARY,
			),
			'sm_dark_primary' => array(
				'default' => SILKLITE_SM_DARK_PRIMARY,
				'connected_fields' => array(
					// high
					'top_bar_bg_color',

					// striking
					'footer_bg_color',

					// always dark
					'links_color'
				),
			),
			'sm_dark_secondary' => array(
				'default' => SILKLITE_SM_DARK_SECONDARY,
				'connected_fields' => array(
					// always dark
					'content_text_color'
				),
			),
			'sm_dark_tertiary' => array(
				'default' => SILKLITE_SM_DARK_TERTIARY,
			),
			'sm_light_primary' => array(
				'default' => SILKLITE_SM_LIGHT_PRIMARY,
				'connected_fields' => array(
					'footer_text_color',
					'content_background_color'
				),
			),
			'sm_light_secondary' => array(
				'default' => SILKLITE_SM_LIGHT_SECONDARY,
				'connected_fields' => array(
					'top_bar_text_color',
				),
			),
			'sm_light_tertiary' => array(
				'default' => SILKLITE_SM_LIGHT_TERTIARY,
			),
		),
	);

	// The section might be already defined, thus we merge, not replace the entire section config.
	if ( class_exists( 'Customify_Array' ) && method_exists( 'Customify_Array', 'array_merge_recursive_distinct' ) ) {
		$options['sections']['style_manager_section'] = Customify_Array::array_merge_recursive_distinct( $options['sections']['style_manager_section'], $new_config );
	} else {
		$options['sections']['style_manager_section'] = array_merge_recursive( $options['sections']['style_manager_section'], $new_config );
	}

	return $options;
}

function silklite_fill_customify_options( $options ) {
	$new_config = array(
		'colors_section' => array(
			'title'       => '',
			'type'      => 'hidden',
			'options' => array(
				'accent_color'  => array(
					'type'    => 'hidden_control',
					'live' 		=> true,
					'default'   => SILKLITE_SM_COLOR_PRIMARY,
					'css'  		=> array(
						array(
							'property' => 'color',
							'selector' => 'h1,
								h2,
								.card .entry-title,
								.flexslider .post .entry-title,
								.archive__grid > .grid__item .entry-title,
								.comment-form .archive__grid > p .entry-title,
								.comment-form .archive__grid > iframe .entry-title,
								h4,
								.widget-title,
								h1 a,
								.site-title a,
								h2 a,
								h3 a,
								a:hover,
								.dropcap,
								.bypostauthor .comment__author-name,
								.nav--main > .menu-item:hover > a,
								.widget a:hover,
								.jetpack_subscription_widget input[type="submit"],
								.widget_silk-popular-posts .popular-posts_item.large-thumbnail .bump-view,
								div#infinite-handle span.handle__text,
								#infinite-handle[id] span,
								div#jp-relatedposts div.jp-relatedposts-items div.jp-relatedposts-post:hover .jp-relatedposts-post-title a,
								.nav--main > li.hover > a,
								.nav--floating li:hover > *,
								.page-numbers.prev, 
								.page-numbers.next,
								.pagination a:hover'
						),
						array(
							'property' => 'color',
							'selector' => '.overlay--search .search-field::-webkit-input-placeholder'
						),
						array(
							'property' => 'color',
							'selector' => '.overlay--search .search-field:-moz-placeholder'
						),
						array(
							'property' => 'color',
							'selector' => '.overlay--search .search-field::-moz-placeholder'
						),
						array(
							'property' => 'color',
							'selector' => '.overlay--search .search-field:-ms-input-placeholder'
						),
						array(
							'property' => 'outline-color',
							'selector' => 'select:focus,
								textarea:focus,
								input[type="text"]:focus,
								input[type="password"]:focus,
								input[type="datetime"]:focus,
								input[type="datetime-local"]:focus,
								input[type="date"]:focus,
								input[type="month"]:focus,
								input[type="time"]:focus,
								input[type="week"]:focus,
								input[type="number"]:focus,
								input[type="email"]:focus,
								input[type="url"]:focus,
								input[type="search"]:focus,
								input[type="tel"]:focus,
								input[type="color"]:focus,
								.form-control:focus'
						),
						array(
							'property' => 'background-color',
							'selector' => '.btn,
								input[type="submit"],
								.widget.widget a.btn,
								.form-submit #submit,
								.menu-item--mega .sub-menu-wrapper > .sub-menu,
								.widget_silk_about_me,
								.jetpack_subscription_widget,
								.archive__grid .sticky:before,
								.archive__grid .format-quote .content-quote:after,
								.highlight:before,
								.overlay__close:hover:before, 
								.overlay__close:hover:after, 
								.overlay__close:focus:before, 
								.overlay__close:focus:after,
								.pagination span.current'
						),
						array(
							'property' => 'background-color',
							'selector' => '.widget_silk-popular-posts .popular-posts_item.large-thumbnail .bump-view:first-child:after',
							'callback_filter' => 'silklite_important_css_rule'
						),
						array(
							'property' => 'border-color',
							'selector' => '.search-form .search-submit,
								.bypostauthor .comment__author-name'
						),
					),
				),
				'secondary_color' => array(
					'type'    => 'hidden_control',
					'live'		=> true,
					'default'	=> SILKLITE_SM_COLOR_SECONDARY,
					'css'		=> array(
						array(
							'property' 	=> 'color',
							'selector' 	=> '.separator--text,
								.separator-wrapper--accent,
								.color-secondary,
								.site-footer a:hover,
								.top-bar svg:hover,
								.floating-nav .top-bar .nav--toolbar > .menu-item > a:hover,
								.floating-nav .top-bar .site-title:hover,
								.separator--text.separator--text,
								.widget_silk_about_me a,
								.archive__grid .format-quote blockquote:before,
								.menu-item--mega .sub-menu-wrapper > .sub-menu > .menu-item:hover > a'
						),
						array(
							'property'	=> 'fill',
							'selector'	=> '#bar, .flex-direction-nav a .slider-arrow'
						),
						array(
							'property'	=> 'background-color',
							'selector'	=> '.comment-number,
								.widget_silk-popular-posts .popular-posts_item.large-thumbnail .bump-view:first-child:after,
								.site-description-after,
								.overlay--search .search-form > label:after,
								.widget_silk-popular-posts .popular-posts_item.large-thumbnail:after,
								.archive__grid .format-quote blockquote:after'
						),
						array(
							'property'	=> 'border-color',
							'selector'	=> '.is--ancient-android .archive__grid .format-quote blockquote:after',
							'callback'	=> 'silklite_quote_border_image'
						),
						array(
							'property'	=> 'background-color',
							'media' 	=> 'screen and (min-width: 900px)',
							'selector'	=> '.commentlist:before'
						),
						array(
							'property'  => 'border-color',
							'selector'  => 'li.comment .children li:before,
								li.pingback .children li:before,
								li.trackback .children li:before,
								.jetpack_subscription_widget:before'
						),
						array(
							'property'	=> 'border-color',
							'selector'  => '.dropcap',
							'callback_filter' => 'silklite_secondary_dropcap_cb'
						),
					)
				),
				'site_title_color'  => array(
					'type'    => 'hidden_control',
					'live' 		=> true,
					'default'   => SILKLITE_SM_COLOR_PRIMARY,
					'css'  		=> array(
						array(
							'property' => 'color',
							'selector' => '.site-title'
						),
						array(
							'property' => 'fill',
							'selector' => 'html.svg .site-title text'
						)
					),
				),
				'links_color'  => array(
					'type'    => 'hidden_control',
					'live' 		=> true,
					'default'   => '#000000',
					'css'  		=> array(
						array(
							'property' => 'color',
							'selector' => 'a'
						),
						array(
							'property' => 'background-color',
							'selector' => '.nav--main:before'
						),
					),
				),
				// Top Bar
				'top_bar_text_color'  => array(
					'type'    => 'hidden_control',
					'live' 		=> true,
					'default'   => '#b8b6b7',
					'css'  		=> array(
						array(
							'property' => 'color',
							'selector' => '.top-bar, .top-bar.fixed, 
										.nav--toolbar > .menu-item > a,
										.floating-nav .top-bar .site-title, 
										.floating-nav .top-bar .nav--toolbar > .menu-item > a,
										.nav--toolbar .nav__item--search > button'
						),
						array(
							'property' => 'fill',
							'selector' => '.svg .top-bar .flag__img text'
						),
					),
				),
				'top_bar_bg_color'  => array(
					'type'    => 'hidden_control',
					'live' 		=> true,
					'default'   => SILKLITE_SM_DARK_PRIMARY,
					'css'  		=> array(
						array(
							'property' => 'background-color',
							'selector' => '.top-bar'
						),
					),
				),
				'content_background_color'  => array(
					'type'    => 'hidden_control',
					'live' 		=> true,
					'default'   => '#ffffff',
					'css'  		=> array(
						array(
							'property' => 'background-color',
							'selector' => 'body,
								.site-description-text,
								.nav--main,
								.sub-menu-wrapper,
								.nav--floating,
								.nav--main > .menu-item-has-children.hover > a:before, 
								.nav--main > .menu-item--mega.hover > a:before,
								.separator--text span,
								.sub-menu-wrapper .sub-menu,
								.commentlist > li:last-child:not(.parent):before,
								.article-navigation .navigation-item .arrow,
								.overlay--search,
								.main-navigation,
								.nav--main .sub-menu, 
								.nav--main .children,
								.nav--is-open .button-toggle'
						),
						array(
							'property' => 'stroke',
							'selector' => '.site-title svg text'
						),
						array(
							'property' => 'fill',
							'selector' => '#clepsydra #mask'
						),
						array(
							'property' => 'color',
							'selector' => '.btn,
							    input[type="submit"], 
							    .widget.widget a.btn, 
							    .form-submit #submit, 
							    .skip-link.screen-reader-text, 
							    .site-footer aside.widget_wpcom_instagram_widget .skip-link.widget-title, 
							    .site-footer .null-instagram-feed .skip-link.widget-title, 
							    .skip-link.jp-relatedposts-post-excerpt, 
							    .skip-link.jp-relatedposts-post-context,
							    pre::before, .menu-item--mega .sub-menu-wrapper > .sub-menu > .menu-item > a,
								.archive__grid .sticky, 
								.archive__grid .sticky .entry-title a, 
								.archive__grid .sticky .entry-meta,
								.sticky a:hover,
								.sidebar--main .widget.shrink:after',
						),
						array(
							'property' => 'border-color',
							'selector' => '.card .entry-image-border, 
								.flexslider .post .entry-image-border, 
								.archive__grid > .grid__item .entry-image-border, 
								.comment-form .archive__grid > p .entry-image-border, 
								.comment-form .archive__grid > iframe .entry-image-border,
								.flexslider .entry-thumbnail-border'
						),
						array(
							'property'	=> 'border-color',
							'selector'  => '.dropcap',
							'callback_filter' => 'silklite_background_dropcap_cb'
						),
					),
				),
				'content_text_color' => array(
					'type'    => 'hidden_control',
					'live' => true,
					'default' => SILKLITE_SM_DARK_SECONDARY,
					'css' => array(
						array(
							'property' => 'color',
							'selector' => 'body,
								.nav--floating a, 
								.nav--floating button,
								.sub-menu-wrapper,
								.overlay--search .search-field'
						),
						array(
							'property' => 'background-color',
							'selector' => 'pre::before,
										   .nav-icon,
										   .nav-icon:after, 
										   .nav-icon:before'
						),
						array(
							'property' => 'border-color',
							'selector' => '.nav--main > .menu-item-has-children.hover > a:before, 
								.nav--main > .menu-item--mega.hover > a:before',
							'callback_filter' => 'silklite_color_opacity_adjust_cb'
						),
						array(
							'property' => 'border-color',
							'selector' => 'pre'
						),
					),
				),
				// Footer
				'footer_text_color'  => array(
					'type'    => 'hidden_control',
					'live' 		=> true,
					'default'   => '#FFFFFF',
					'css'  		=> array(
						array(
							'property' => 'color',
							'selector' => '.site-footer, .site-footer a'
						),
						array(
							'property' => 'fill',
							'selector' => '#arrow'
						)
					),
				),
				'footer_bg_color'  => array(
					'type'    => 'hidden_control',
					'live' 		=> true,
					'default'   => SILKLITE_SM_DARK_PRIMARY,
					'css'  		=> array(
						array(
							'property' => 'background-color',
							'selector' => '.site-footer'
						),
						array(
							'property' => 'color',
							'selector' => '.site-footer select'
						),
					),
				),
			)
		),
	);

	if ( class_exists( 'Customify_Array' ) && method_exists( 'Customify_Array', 'array_merge_recursive_distinct' ) ) {
		$options['sections'] = Customify_Array::array_merge_recursive_distinct( $options['sections'], $new_config );
	} else {
		$options['sections'] = array_merge_recursive( $options['sections'], $new_config );
	}

	return $options;
}

if ( ! function_exists( 'silklite_important_css_rule' ) ) {
	function silklite_important_css_rule( $value, $selector, $property, $unit ) {
		$output = $selector . '{ ' .
		          $property . ': ' . $value . ' !important;' .
		          ' }';

		return $output;
	}
}

if ( ! function_exists( 'silklite_quote_border_image' ) ) {
	function silklite_quote_border_image( $value, $selector, $property, $unit ) {
		$output = $selector . '{
			-webkit-border-image: -webkit-linear-gradient(left, ' . $value . ' 0%, ' . $value . ' 40%, transparent 40.1%, transparent 50%, transparent 59.9%, ' . $value . ' 60%, ' . $value . ' 100%) 20%;
			-o-border-image: linear-gradient(to right, ' . $value . ' 0%, ' . $value . ' 40%, transparent 40.1%, transparent 50%, transparent 59.9%, ' . $value . ' 60%, ' . $value . ' 100%) 20%;
			border-image: linear-gradient(to right, ' . $value . ' 0%, ' . $value . ' 40%, transparent 40.1%, transparent 50%, transparent 59.9%, ' . $value . ' 60%, ' . $value . ' 100%) 20%;
		}';

		return $output;
	}
}

if ( ! function_exists( 'silklite_secondary_dropcap_cb' ) ) {
	function silklite_secondary_dropcap_cb( $value, $selector, $property, $unit ) {
	    $gap = pixelgrade_option( 'content_background_color', 'white' );
		$output = $selector . '{
			text-shadow: 2px 2px 0 ' . $gap . ', 4px 4px 0 ' . $value .
        '}';

		return $output;
	}
}

if ( ! function_exists( 'silklite_secondary_dropcap_cb_customizer_preview' ) ) {

	function silklite_secondary_dropcap_cb_customizer_preview() {
		$js = "
			function silklite_secondary_dropcap_cb( value, selector, property, unit ) {
				var css = '',
                    background = wp.customize( 'silk_options[content_background_color]' )(),
					style = document.getElementById('silklite_secondary_dropcap_cb_style_tag'),
					head = document.head || document.getElementsByTagName('head')[0];

				css += selector + ' { ' + 'text-shadow: 2px 2px 0 ' + background + ', 4px 4px 0 ' + value + ';' + ' } ';

				if ( style !== null ) {
					style.innerHTML = css;
				} else {
					style = document.createElement('style');
					style.setAttribute('id', 'silklite_secondary_dropcap_cb_style_tag');

					style.type = 'text/css';
					if ( style.styleSheet ) {
						style.styleSheet.cssText = css;
					} else {
						style.appendChild(document.createTextNode(css));
					}

					head.appendChild(style);
				}
			}" . PHP_EOL;

		wp_add_inline_script( 'customify-previewer-scripts', $js );
	}
	add_action( 'customize_preview_init', 'silklite_secondary_dropcap_cb_customizer_preview' );
}

if ( ! function_exists( 'silklite_background_dropcap_cb_customizer_preview' ) ) {

	function silklite_background_dropcap_cb_customizer_preview() {
		$js = "
			function silklite_background_dropcap_cb( value, selector, property, unit ) {
				setTimeout(function() {
					var css = '',
	                    shadow = wp.customize( 'silk_options[secondary_color]' )(),
						style = document.getElementById('silklite_background_dropcap_cb_style_tag'),
						head = document.head || document.getElementsByTagName('head')[0];
					
					css += selector + ' { ' + 'text-shadow: 2px 2px 0 ' + value + ', 4px 4px 0 ' + shadow + ';' + ' } ';
	
					if ( style !== null ) {
						style.innerHTML = css;
					} else {
						style = document.createElement('style');
						style.setAttribute('id', 'silklite_background_dropcap_cb_style_tag');
	
						style.type = 'text/css';
						if ( style.styleSheet ) {
							style.styleSheet.cssText = css;
						} else {
							style.appendChild(document.createTextNode(css));
						}
	
						head.appendChild(style);
					}
				}, 0);
			}" . PHP_EOL;

		wp_add_inline_script( 'customify-previewer-scripts', $js );
	}
	add_action( 'customize_preview_init', 'silklite_background_dropcap_cb_customizer_preview' );
}

if ( ! function_exists('silklite_color_opacity_adjust_cb') ) {
	function silklite_color_opacity_adjust_cb( $value, $selector, $property, $unit ) {

		// Get our color
		if ( empty( $value ) || ! preg_match( '/^#[a-f0-9]{6}$/i', $value ) ) {
			return '';
		}

		$r = hexdec( $value[1] . $value[2] );
		$g = hexdec( $value[3] . $value[4] );
		$b = hexdec( $value[5] . $value[6] );

		// if it is not a dark color, just go for the default way
		$output = $selector . ' {' .
			$property . ': rgba(' . $r .',' . $g . ',' . $b .', 0.1);
		}';

		return $output;
	}
}

if ( ! function_exists('silklite_color_opacity_adjust_cb_customizer_preview') ) {

	function silklite_color_opacity_adjust_cb_customizer_preview() {

	    $js = "
	        function hexdec(hexString) {
				hexString = (hexString + '').replace(/[^a-f0-9]/gi, '');
				return parseInt(hexString, 16)
			}
			function silklite_color_opacity_adjust_cb( value, selector, property, unit ) {

				var css = '',
					style = document.getElementById('silklite_color_opacity_adjust_cb_style_tag'),
					head = document.head || document.getElementsByTagName('head')[0],
					r = hexdec(value[1] + '' + value[2]),
					g = hexdec(value[3] + '' + value[4]),
					b = hexdec(value[5] + '' + value[6]);

				css += selector + ' { ' + property + ': rgba(' + r + ',' + g + ',' + b + ',0.1); } ';

				if ( style !== null ) {
					style.innerHTML = css;
				} else {
					style = document.createElement('style');
					style.setAttribute('id', 'silklite_color_opacity_adjust_cb_style_tag');

					style.type = 'text/css';
					if ( style.styleSheet ) {
						style.styleSheet.cssText = css;
					} else {
						style.appendChild(document.createTextNode(css));
					}

					head.appendChild(style);
				}
			}" . PHP_EOL;

		wp_add_inline_script( 'customify-previewer-scripts', $js );
	}
	add_action( 'customize_preview_init', 'silklite_color_opacity_adjust_cb_customizer_preview' );
}

function silklite_add_default_color_palette( $color_palettes ) {

	$color_palettes = array_merge( array(
		'default' => array(
			'label'   => esc_html__( 'Theme Default', 'silk-lite' ),
			'preview' => array(
				'background_image_url' => 'https://cloud.pixelgrade.com/wp-content/uploads/2018/09/vivid-autumn-palette-400x156.png',
			),
			'options' => array(
				'sm_color_primary'   => SILKLITE_SM_COLOR_PRIMARY,
				'sm_color_secondary' => SILKLITE_SM_COLOR_SECONDARY,
				'sm_color_tertiary'  => SILKLITE_SM_COLOR_TERTIARY,
				'sm_dark_primary'    => SILKLITE_SM_DARK_PRIMARY,
				'sm_dark_secondary'  => SILKLITE_SM_DARK_SECONDARY,
				'sm_dark_tertiary'   => SILKLITE_SM_DARK_TERTIARY,
				'sm_light_primary'   => SILKLITE_SM_LIGHT_PRIMARY,
				'sm_light_secondary' => SILKLITE_SM_LIGHT_SECONDARY,
				'sm_light_tertiary'  => SILKLITE_SM_LIGHT_TERTIARY,
			),
		),
	), $color_palettes );

	return $color_palettes;
}

add_filter( 'customify_get_color_palettes', 'silklite_add_default_color_palette' );
