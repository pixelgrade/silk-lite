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
		'presets_section' => array(
			'title'    => __( 'Style Presets', 'silk' ),
			'options' => array(
				'theme_style'   => array(
					'type'      => 'preset',
					'label'     => __( 'Select a style:', 'silk' ),
					'desc' => __( 'Conveniently change the design of your site with built-in style presets. Easy as pie.', 'silk' ),
					'default'   => 'silk',
					'choices_type' => 'awesome',
					'choices'  => array(
						'silk' => array(
							'label' => __( 'Silk', 'silk' ),
							'preview' => array(
								'color-text' => '#ffffff',
								'background-card' => '#a33b61',
								'background-label' => '#fcc9b0',
								'font-main' => 'Playfair Display',
								'font-alt' => 'MerriWeather',
							),
							'options' => array(
								'accent_color' => '#a33b61',
								'secondary_color' => '#fcc9b0',
								'headings_font' => 'Playfair Display',
								'body_font' => 'Merriweather',
								'nav_font' => 'Open Sans'
							)
						),


						'adler' => array(
							'label' => __( 'Adler', 'silk' ),
							'preview' => array(
								'color-text' => '#fff',
								'background-card' => '#0e364f',
								'background-label' => '#000000',
								'font-main' => 'Permanent Marker',
								'font-alt' => 'Droid Sans Mono',
							),
							'options' => array(
								'accent_color' => '#0e364f',
								'secondary_color' => '#68f3c8',
								'headings_font' => 'Permanent Marker',
								'body_font' => 'Droid Sans Mono',
								'nav_font' => 'Droid Sans'
							)
						),

						'royal' => array(
							'label' => __( 'Royal', 'silk' ),
							'preview' => array(
								'color-text' => '#ffffff',
								'background-card' => '#615375',
								'background-label' => '#46414c',
								'font-main' => 'Abril Fatface',
								'font-alt' => 'PT Serif',
							),
							'options' => array(
								'accent_color' => '#615375',
								'secondary_color' => '#8eb2c5',
								'headings_font' => 'Abril Fatface',
								'body_font' => 'PT Serif',
								'nav_font' => 'PT Sans'
							)
						),

						'queen' => array(
							'label' => __( 'Queen', 'silk' ),
							'preview' => array(
								'color-text' => '#fbedec',
								'background-card' => '#773347',
								'background-label' => '#41212a',
								'font-main' => 'Cinzel Decorative',
								'font-alt' => 'Gentium Basic',
							),
							'options' => array(
								'accent_color' => '#773347',
								'secondary_color' => '#41212a',
								'headings_font' => 'Cinzel Decorative',
								'body_font' => 'Gentium Basic',
								'nav_font' => 'Gentium Basic',

							)
						),
						'carrot' => array(
							'label' => __( 'Carrot', 'silk' ),
							'preview' => array(
								'color-text' => '#ffffff',
								'background-card' => '#df421d',
								'background-label' => '#85210a',
								'font-main' => 'Oswald',
								'font-alt' => 'PT Sans Narrow',
							),
							'options' => array(
								'accent_color' => '#df421d',
								'secondary_color' => '#85210a',
								'headings_font' => 'Oswald',
								'body_font' => 'PT Sans Narrow',
								'nav_font' => 'PT Sans'
							)
						),
						'velvet' => array(
							'label' => __( 'Velvet', 'silk' ),
							'preview' => array(
								'color-text' => '#ffffff',
								'background-card' => '#282828',
								'background-label' => '#000000',
								'font-main' => 'Pinyon Script',
								'font-alt' => 'Josefin Sans',
							),
							'options' => array(
								'accent_color' => '#282828',
								'secondary_color' => '#000000',
								'headings_font' => 'Pinyon Script',
								'body_font' => 'Josefin Sans',
								'nav_font' => 'Josefin Sans'
							)
						),

					)
				),
			)
		),
		'colors_section' => array(
			'title'    => __( 'Colors', 'silk' ),
			'options' => array(
				'accent_color'  => array(
					'type'      => 'color',
					'label'     => __( 'Accent Color', 'silk' ),
					'live' 		=> true,
					'default'   => '#a33b61',
					'css'  		=> array(
						array(
							'property' => 'color',
							'selector' => 'h1,
								.site-title,
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
								div#jp-relatedposts div.jp-relatedposts-items div.jp-relatedposts-post:hover .jp-relatedposts-post-title a,
								.menu-item--mega.hover > a'
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
								.archive__grid .format-quote .content-quote:after'
						),
						array(
							'property' => 'background-color',
							'selector' => '.widget_silk-popular-posts .popular-posts_item.large-thumbnail .bump-view:first-child:after',
							'callback_filter' => 'silk_important_css_rule'
						),
						array(
							'property' => 'border-color',
							'selector' => '.search-form .search-submit,
								.bypostauthor .comment__author-name'
						),
						array(
							'property' => 'fill',
							'selector' => 'html.svg .site-title text'
						),
						array(
							'property' => 'background-image',
							'selector' => '.single .entry-content a:hover,
								.page .entry-content a:hover,
								.comment__author-name a:hover,
								.bypostauthor .comment__author-name:hover,
								.site-main--single .entry-footer a:hover',
							'callback_filter' => 'silk_link_gradient'
						)

					),
				),
				'secondary_color' => array(
					'type' 		=> 'color',
					'label'		=> __( 'Secondary Accent Color', 'silk' ),
					'live'		=> true,
					'default'	=> '#fcc9b0',
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
								.archive__grid .format-quote blockquote:before'
						),
						array(
							'property' 	=> 'color',
							'media' 	=> 'screen and (min-width: 900px)',
							'selector' 	=> '.menu-item--mega .sub-menu-wrapper > .sub-menu > .menu-item:hover > a'
						),
						array(
							'property'	=> 'fill',
							'selector'	=> '#bar, .flex-direction-nav a .slider-arrow'
						),
						array(
							'property'	=> 'text-shadow',
							'selector'  => '.dropcap',
							'callback_filter' => 'silk_dropcap_text_shadow'
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
							'property'	=> 'box-shadow',
							'selector'	=> '.archive__grid .format-quote blockquote:after',
							'callback'	=> 'silk_quote_box_shadow'
						),
						array(
							'property'	=> 'border-image',
							'selector'	=> '.is--ancient-android .archive__grid .format-quote blockquote:after',
							'callback'	=> 'silk_quote_border_image'
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
						)
					)
				),
			)
		),



		/**
		 * FONTS - This section will handle different elements fonts (eg. headings, body)
		 */

		'typography_section' => array(
			'title'    => __( 'Fonts', 'silk' ),
			'options' => array(
				'headings_font' => array(
					'type'     => 'typography',
					'label'    => __( 'Headings', 'silk' ),
					'default'  => 'Playfair Display", serif',
					'selector' => 'h1,
						.site-title,
						h2,
						.card .entry-title,
						.flexslider .post .entry-title,
						.archive__grid > .grid__item .entry-title,
						.comment-form .archive__grid > p .entry-title,
						.comment-form .archive__grid > iframe .entry-title,
						h3,
						blockquote,
						.dropcap,
						.comment-number,
						.widget_silk-popular-posts .popular-posts_item.large-thumbnail .bump-view:first-child:after,
						.overlay--search .search-field,
						.widget a,
						.widget_silk_about_me .silk-about-me-widget__name,
						.jetpack_subscription_widget .widget-title,
						.widget_silk-popular-posts .popular-posts_item:nth-child(1) .bump-view,
						.widget_silk-popular-posts .popular-posts_item:nth-child(2) .bump-view,
						.widget_silk-popular-posts .popular-posts_item:nth-child(3) .bump-view ',
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
					'label'   => __( 'Body Text', 'silk' ),
					'default' => '"Merriweather", serif',
					'selector' => 'body,
						blockquote cite,
						.comments-title,
						.comment-reply-title,
						.widget_silk-popular-posts .popular-posts_item .bump-view,
						.widget_silk-popular-posts .categories-list a,
						.widget_silk-popular-posts .categories-list,
						.article-navigation .post-meta,
						.article-navigation .navigation-item__name,
						div#jp-relatedposts#jp-relatedposts div.jp-relatedposts-items p,
						div#jp-relatedposts#jp-relatedposts div.jp-relatedposts-items.jp-relatedposts-items h4.jp-relatedposts-post-title,
						h4,
						.widget-title,
						.site-description,
						.menu-item--mega .entry-meta',
					'load_all_weights' => true,
					'recommended' => array(
						'Merriweather',
						'Lato',
						'Open Sans',
						'PT Sans',
						'Cabin',
						'Gentium Book Basic',
						'PT Serif'
					),
				),
				'nav_font'		=> array(
					'type'		=> 'typography',
					'label' 	=> __( 'Navigation Font', 'silk' ),
					'default' 	=> 'Open Sans, sans-serif',
					'selector' 	=> '.btn,
						input[type="submit"],
						.widget.widget a.btn,
						.form-submit #submit,
						.separator--text span,
						.nav--mega .menu-link,
						.nav--toolbar > .menu-item > a,
						.nav--dropdown,
						div#infinite-handle span.handle__text,
						div.sharedaddy.sharedaddy h3.sd-title,
						div#jp-relatedposts#jp-relatedposts h3.jp-relatedposts-headline',
					'load_all_weights' => true,
					'recommended' => array(
						'Open Sans',
						'PT Sans',
						'Lato',
						'Cabin',
						'Open Sans'
					),
				)
			)
		)

	);

	return $options;
}

if ( !function_exists('silk_important_css_rule') ) {
	function silk_important_css_rule( $value, $selector, $property, $unit ) {
		$output = $selector .'{ ' .
			$property . ': ' . $value . ' !important;' .
		' }';
		return $output;
	}
}

if ( !function_exists('silk_link_gradient') ) {
	function silk_link_gradient( $value, $selector, $property, $unit ) {
		$output = $selector .'{
			background-image: -webkit-linear-gradient(top, ' . $value . ' 0%, ' . $value . ' 100%);
			background-image: linear-gradient(to bottom, ' . $value . ' 0%, ' . $value . ' 100%);
		}';
		return $output;
	}
}

if ( !function_exists('silk_quote_box_shadow') ) {
	function silk_quote_box_shadow( $value, $selector, $property, $unit ) {
		$output = $selector .'{
			box-shadow: ' . $value . ' 5.5em 0 0;
		}';
		return $output;
	}
}

if ( !function_exists('silk_quote_border_image') ) {
	function silk_quote_border_image( $value, $selector, $property, $unit ) {
		$output = $selector .'{
			-webkit-border-image: -webkit-linear-gradient(left, ' . $value . ' 0%, ' . $value . ' 40%, transparent 40.1%, transparent 50%, transparent 59.9%, ' . $value . ' 60%, ' . $value . ' 100%) 20%;
			-o-border-image: linear-gradient(to right, ' . $value . ' 0%, ' . $value . ' 40%, transparent 40.1%, transparent 50%, transparent 59.9%, ' . $value . ' 60%, ' . $value . ' 100%) 20%;
			border-image: linear-gradient(to right, ' . $value . ' 0%, ' . $value . ' 40%, transparent 40.1%, transparent 50%, transparent 59.9%, ' . $value . ' 60%, ' . $value . ' 100%) 20%;
		}';
		return $output;
	}
}

if ( !function_exists('silk_dropcap_text_shadow') ) {
	function silk_dropcap_text_shadow( $value, $selector, $property, $unit ) {
		$output = $selector . '{
			text-shadow: 2px 2px 0 white, 4px 4px 0 ' . $value .
		'}';
		return $output;
	}
}

add_filter( 'customify_filter_fields', 'silk_add_customify_options' ); ?>