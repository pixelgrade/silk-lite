<?php
/**
 * Custom functions that act independently of the theme templates
 *
 * Eventually, some of the functionality here could be replaced by core features
 *
 * @package Silk Lite
 */

/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 *
 * @return array
 */
function silklite_body_classes( $classes ) {
	// Adds a class of group-blog to blogs with more than 1 published author.
	if ( is_multi_author() ) {
		$classes[] = 'group-blog';
	}

	if ( ( is_single() || is_page() || is_home() || is_archive() || is_search() ) && is_active_sidebar( 'sidebar-1' ) ) {
		$classes[] = 'has_sidebar';
	}

	return $classes;
}
add_filter( 'body_class', 'silklite_body_classes' );

/**
 * Extend the default WordPress post classes.
 *
 * @since Silk Lite 1.0
 *
 * @param array $classes A list of existing post class values.
 *
 * @return array The filtered post class list.
 */
function silklite_post_classes( $classes ) {

	if ( is_archive() || is_home() || is_search() ) {
		$classes[] = 'grid__item';
	}

	return $classes;
}
add_filter( 'post_class', 'silklite_post_classes' );

// This function should come from Customify, but we need to do our best to make things happen
if ( ! function_exists( 'pixelgrade_option' ) ) {
	/**
	 * Get option from the database
	 *
	 * @param string $option The option name.
	 * @param mixed  $default Optional. The default value to return when the option was not found or saved.
	 * @param bool   $force_default Optional. When true, we will use the $default value provided for when the option was not saved at least once.
	 *                            When false, we will let the option's default set value (in the Customify settings) kick in first, then our $default.
	 *                            It basically, reverses the order of fallback, first the option's default, then our own.
	 *                            This is ignored when $default is null.
	 *
	 * @return mixed
	 */
	function pixelgrade_option( $option, $default = null, $force_default = false ) {
		/** @var PixCustomifyPlugin $pixcustomify_plugin */
		global $pixcustomify_plugin;

		if ( $pixcustomify_plugin !== null ) {
			// Customify is present so we should get the value via it
			// We need to account for the case where a option has an 'active_callback' defined in it's config
			$options_config = $pixcustomify_plugin->get_options_configs();
			if ( ! empty( $options_config ) && ! empty( $options_config[ $option ] ) && ! empty( $options_config[ $option ]['active_callback'] ) ) {
				// This option has an active callback
				// We need to "question" it
				//
				// IMPORTANT NOTICE:
				//
				// Be extra careful when setting up the options to not end up in a circular logic
				// due to callbacks that get an option and that option has a callback that gets the initial option - INFINITE LOOPS :(
				if ( is_callable( $options_config[ $option ]['active_callback'] ) ) {
					// Now we call the function and if it returns false, this means that the control is not active
					// Hence it's saved value doesn't matter
					$active = call_user_func( $options_config[ $option ]['active_callback'] );
					if ( empty( $active ) ) {
						// If we need to force the default received; we respect that
						if ( true === $force_default && null !== $default ) {
							return $default;
						} else {
							// Else we return false
							// because we treat the case when the active callback returns false as if the option would be non-existent
							// We do not return the default configured value in this case
							return false;
						}
					}
				}
			}

			// Now that the option is truly active, we need to see if we are not supposed to force over the option's default value
			if ( $default !== null && false === $force_default ) {
				// We will not pass the received $default here so Customify will fallback on the option's default value, if set
				$customify_value = $pixcustomify_plugin->get_option( $option );

				// We only fallback on the $default if none was given from Customify
				if ( null === $customify_value ) {
					return $default;
				}
			} else {
				$customify_value = $pixcustomify_plugin->get_option( $option, $default );
			}

			return $customify_value;
		} elseif ( false === $force_default ) {
			// In case there is no Customify present and we were not supposed to force the default
			// we want to know what the default value of the option should be according to the configuration
			// For this we will fire the all-gathering-filter that Customify uses
			$config = apply_filters( 'customify_filter_fields', array() );

			// Next we will search for this option and see if it has a default value set ('default')
			if ( ! empty( $config['sections'] ) && is_array( $config['sections'] ) ) {
				foreach ( $config['sections'] as $section ) {
					if ( ! empty( $section['options'] ) && is_array( $section['options'] ) ) {
						foreach ( $section['options'] as $option_id => $option_config ) {
							if ( $option_id == $option ) {
								// We have found our option (the option ID should be unique)
								// It's time to deal with it's default, if it has one
								if ( isset( $option_config['default'] ) ) {
									return $option_config['default'];
								}

								// If the targeted option doesn't have a default value
								// there is no point in searching further because the option IDs should be unique
								// Just return the $default
								return $default;
							}
						}
					}
				}
			}
		}

		// If all else failed, return the default (even if it's null)
		return $default;
	}
}

if ( ! function_exists( 'silklite_fonts_url' ) ) :
	/**
	 * Register Google fonts for Silk Lite.
	 * @since Silk Lite 1.0
	 *
	 * @return string Google fonts URL for the theme.
	 */
	function silklite_fonts_url() {
		$fonts_url = '';
		$fonts     = array();
		$subsets   = 'latin,latin-ext';

		/* Translators: If there are characters in your language that are not
		* supported by Libre Baskerville, translate this to 'off'. Do not translate
		* into your own language.
		*/
		if ( 'off' !== _x( 'on', 'Libre Baskerville font: on or off', 'silk-lite' ) ) {
			$fonts[] = 'Libre Baskerville:400,700,400italic';
		}

		/* Translators: If there are characters in your language that are not
		* supported by Playfair Display, translate this to 'off'. Do not translate
		* into your own language.
		*/
		if ( 'off' !== _x( 'on', 'Playfair Display font: on or off', 'silk-lite' ) ) {
			$fonts[] = 'Playfair Display:400,700,900,400italic,700italic,900italic';
		}

		/* Translators: If there are characters in your language that are not
		* supported by Merriweather, translate this to 'off'. Do not translate
		* into your own language.
		*/
		if ( 'off' !== _x( 'on', 'Merriweather font: on or off', 'silk-lite' ) ) {
			$fonts[] = 'Merriweather:400italic,400,300,700';
		}

		/* translators: To add an additional character subset specific to your language, translate this to 'greek', 'cyrillic', 'devanagari' or 'vietnamese'. Do not translate into your own language. */
		$subset = _x( 'no-subset', 'Add new subset (greek, cyrillic, devanagari, vietnamese)', 'silk-lite' );

		if ( 'cyrillic' == $subset ) {
			$subsets .= ',cyrillic,cyrillic-ext';
		} elseif ( 'greek' == $subset ) {
			$subsets .= ',greek,greek-ext';
		} elseif ( 'devanagari' == $subset ) {
			$subsets .= ',devanagari';
		} elseif ( 'vietnamese' == $subset ) {
			$subsets .= ',vietnamese';
		}

		if ( $fonts ) {
			$fonts_url = add_query_arg( array(
				'family' => rawurlencode( implode( '|', $fonts ) ),
				'subset' => rawurlencode( $subsets ),
			), '//fonts.googleapis.com/css' );
		}

		return $fonts_url;
	}
endif;

if ( ! function_exists( 'silklite_comment' ) ) :
	/*
	 * Individual comment layout
	 */
	function silklite_comment( $comment, $args, $depth ) {
		static $comment_number;

		if ( ! isset( $comment_number ) ) {
			$comment_number = $args['per_page'] * ( $args['page'] - 1 ) + 1;
		} else {
			$comment_number ++;
		}

		?>
	<li <?php comment_class( empty( $args['has_children'] ) ? '' : 'parent' ); ?>>
		<article id="comment-<?php comment_ID() ?>" class="comment-article  media">
			<span class="comment-number"><?php echo esc_html( $comment_number ); ?></span>
			<?php
			//grab the avatar - by default the Mystery Man
			$avatar = get_avatar( $comment ); ?>

			<aside class="comment__avatar  media__img"><?php echo $avatar; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></aside>

			<div class="media__body">
				<header class="comment__meta comment-author">
					<?php
					/* translators: %s: The comment author link. */
					printf( '<span class="comment__author-name">%s</span>', get_comment_author_link() ) ?>
					<time class="comment__time" datetime="<?php comment_time( 'c' ); ?>">
						<a href="<?php echo esc_url( get_comment_link( get_comment_ID() ) ) ?>" class="comment__timestamp"><?php
							/* translators: %1$s: The comment date, %2$s: The comment time.  */
							printf( esc_html__( 'on %1$s at %2$s', 'silk-lite' ), esc_html( get_comment_date() ), esc_html( get_comment_time() ) ); ?> </a>
					</time>
					<div class="comment__links">
						<?php
						//we need some space before Edit
						edit_comment_link( esc_html__( 'Edit', 'silk-lite' ), '  ' );

						comment_reply_link( array_merge( $args, array(
							'depth'     => $depth,
							'max_depth' => $args['max_depth'],
						) ) );
						?>
					</div>
				</header>
				<!-- .comment-meta -->
				<?php if ( '0' == $comment->comment_approved ) : ?>
					<div class="alert info">
						<p><?php esc_html_e( 'Your comment is awaiting moderation.', 'silk-lite' ) ?></p>
					</div>
				<?php endif; ?>
				<section class="comment__content comment">
					<?php comment_text(); ?>
				</section>
			</div>
		</article>
		<!-- </li> is added by WordPress automatically -->
	<?php
	}
endif;

/**
 * Filter comment_form_defaults to remove the notes after the comment form textarea.
 *
 * @param array $defaults
 *
 * @return array
 */
function silklite_comment_form_remove_notes_after( $defaults ) {
	$defaults['comment_notes_after'] = '';

	return $defaults;
}
add_filter( 'comment_form_defaults', 'silklite_comment_form_remove_notes_after' );

/**
 * Filter wp_link_pages to wrap current page in span.
 *
 * @param string $link
 *
 * @return string
 */
function silklite_link_pages( $link ) {
	if ( is_numeric( $link ) ) {
		return '<span class="current">' . $link . '</span>';
	}

	return $link;
}
add_filter( 'wp_link_pages_link', 'silklite_link_pages' );

/**
 * Wrap more link
 */
function silklite_read_more_link( $link ) {
	return '<div class="more-link-wrapper">' . $link . '</div>';
}
add_filter( 'the_content_more_link', 'silklite_read_more_link' );

/**
 * Constrain the excerpt length
 */
function silklite_excerpt_length( $length ) {
	return 18;
}
add_filter( 'excerpt_length', 'silklite_excerpt_length', 999 );

/**
 * Add "Styles" drop-down
 */
function silklite_mce_editor_buttons( $buttons ) {
	array_unshift( $buttons, 'styleselect' );
	return $buttons;
}
add_filter( 'mce_buttons_2', 'silklite_mce_editor_buttons' );

/**
 * Add styles/classes to the "Styles" drop-down
 */
function silklite_mce_before_init( $settings ) {

	$style_formats = array(
		array( 'title' => esc_html__( 'Intro Text', 'silk-lite' ), 'selector' => 'p', 'classes' => 'intro' ),
		array( 'title' => esc_html__( 'Dropcap', 'silk-lite' ), 'inline' => 'span', 'classes' => 'dropcap' ),
		array( 'title' => esc_html__( 'Highlight', 'silk-lite' ), 'inline' => 'span', 'classes' => 'highlight' ),
		array( 'title' => esc_html__( 'Two Columns', 'silk-lite' ), 'selector' => 'p', 'classes' => 'twocolumn', 'wrapper' => true ),
	);

	$settings['style_formats'] = json_encode( $style_formats );

	return $settings;
}
add_filter( 'tiny_mce_before_init', 'silklite_mce_before_init' );

/**
 * Get the featured image thumb size depending on whether we are using a single column layout or masonry
 *
 * @return string
 */
function silklite_get_thumbnail_size() {
	return get_theme_mod( 'silklite_single_column_archives', false ) ? 'silklite-single-image' : 'silklite-masonry-image';
}

/**
 * Fix skip link focus in IE11.
 *
 * This does not enqueue the script because it is tiny and because it is only for IE11,
 * thus it does not warrant having an entire dedicated blocking script being loaded.
 *
 * @link https://git.io/vWdr2
 */
function silklite_skip_link_focus_fix() {
	// The following is minified via `terser --compress --mangle -- js/skip-link-focus-fix.js`.
	?>
	<script>
		/(trident|msie)/i.test(navigator.userAgent)&&document.getElementById&&window.addEventListener&&window.addEventListener("hashchange",function(){var t,e=location.hash.substring(1);/^[A-z0-9_-]+$/.test(e)&&(t=document.getElementById(e))&&(/^(?:a|select|input|button|textarea)$/i.test(t.tagName)||(t.tabIndex=-1),t.focus())},!1);
	</script>
	<?php
}
// We will put this script inline since it is so small.
add_action( 'wp_print_footer_scripts', 'silklite_skip_link_focus_fix' );
