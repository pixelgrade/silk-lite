<?php
/**
 * Add extra controls in the Customizer
 *
 * @package Silk
 */

function silk_add_customify_options( $options ) {

	$options['opt-name'] = 'silk_options';


	/**
	 * COLORS - This section will handle different elements colors (eg. links, headings)
	 */
	$options['sections'] = array(
		'colors_section' => array(
			'title'    => __( 'Colors', 'silk_txtd' ),
			'options' => array(
				'accent_color'   => array(
					'type'      => 'color',
					'label'     => __( 'Accent Color', 'silk_txtd' ),
					'live' => true,
					'default'   => '#ffeb00',
					'css'  => array(
						array(
							'property'     => 'color',
							'selector' => 'blockquote a:hover,
												.format-quote .edit-link a:hover,
												.content-quote blockquote:before,
												.widget a:hover,
												.widget_blog_subscription input[type="submit"],
												.widget_blog_subscription a:hover,
												blockquote a:hover',

						),
						array(
							'property'     => 'outline-color',
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
												.form-control:focus',
						),
						array(
							'property'     => 'border-color',
							'selector' => '.widget_blog_subscription input[type="submit"]',
						),
						array(
							'property'     => 'background',
							'selector' => '.highlight:before,
												.arcsilk__grid .accent-box,
												.sticky:after,
												.content-quote blockquote:after',
						),
						array(
							'property'		=> 'box-shadow',
							'selector'	=> '.content-quote blockquote:after',
							'callback_filter' => 'accent_color_box_shadow'
						)
					),
				),
				'headings_color' => array(
					'type'      => 'color',
					'label'     => __( 'Headings Color', 'silk_txtd' ),
					'live' => true,
					'default'   => '#171617',
					'css'  => array(
						array(
							'property'     => 'color',
							'selector' => '.site-title a, h1, h2, h3, blockquote, .dropcap, .single .entry-content:before, .page .entry-content:before',
						)
					)
				),
				'body_color'     => array(
					'type'      => 'color',
					'label'     => __( 'Body Color', 'silk_txtd' ),
					'live' => true,
					'default'   => '#3d3e40',
					'css'  => array(
						array(
							'selector' => 'body, .posted-on a, .entry-title a',
							'property'     => 'color'
						)
					)
				),

				'border_color'	=> array(
					'type'      => 'color',
					'label'     => __( 'Border Color', 'silk_txtd' ),
					'live' => true,
					'default'   => '#171617',
					'css'  => array(
						array(
							'selector' => 'body:before, body:after',
							'media' => 'screen and (min-width: 1000px)',
							'property'     => 'background'
						),
						array(
							'selector' => '#infinite-footer, .site-footer',
							'property'     => 'background-color'
						),
					)
				)
			)
		),



		/**
		 * FONTS - This section will handle different elements fonts (eg. headings, body)
		 */

		'typography_section' => array(
			'title'    => __( 'Fonts', 'silk_txtd' ),
			'options' => array(
				'headings_font' => array(
					'type'     => 'typography',
					'label'    => __( 'Headings', 'silk_txtd' ),
					'default'  => 'Playfair Display", serif',
					'selector' => '.dropcap,  .single .entry-content:before,  .page .entry-content:before,
									.site-title, h1, h2, h3, h4, h5, h6,
									.fs-36px,  .arcsilk__grid .entry-title,
									blockquote',
					'font_weight' => false,
					'load_all_weights' => true,
					'subsets' => true,
					'recommended' => array(
							'Playfair Display',
							'Oswald',
							'Lato',
							'Open Sans',
							'Exo',
							'PT Sans',
							'Ubuntu',
							'Vollkorn',
							'Lora',
							'Arvo',
							'Josefin Slab',
							'Crete Round',
							'Kreon',
							'Bubblegum Sans',
							'The Girl Next Door',
							'Pacifico',
							'Handlee',
							'Satify',
							'Pompiere'
						)
				),
				'body_font'     => array(
					'type'    => 'typography',
					'label'   => __( 'Body Text', 'silk_txtd' ),
					'default' => '"Droid Serif", serif',
					'selector' => 'html body',
					'load_all_weights' => true,
					'recommended' => array(
						'Droid Serif',
						'Lato',
						'Open Sans',
						'PT Sans',
						'Cabin',
						'Gentium Book Basic',
						'PT Serif'
					)
				)
			)
		)

	);

	return $options;
}

if ( !function_exists('accent_color_box_shadow') ) {
	function accent_color_box_shadow( $value, $selector, $property, $unit ) {
		$output = $selector .'{ 
									-webkit-box-shadow: '. $value .' 5.5em 0 0;
										box-shadow: '. $value .' 5.5em 0 0; 
								}';
		return $output;
	}
}

add_filter( 'customify_filter_fields', 'silk_add_customify_options' ); ?>