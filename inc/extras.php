<?php
/**
 * Custom functions that act independently of the theme templates
 *
 * Eventually, some of the functionality here could be replaced by core features
 *
 * @package Silk
 */

/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 *
 * @return array
 */
function silk_body_classes( $classes ) {
	// Adds a class of group-blog to blogs with more than 1 published author.
	if ( is_multi_author() ) {
		$classes[] = 'group-blog';
	}

	if ( ( is_single() || is_page() || is_home() || is_archive() || is_search() ) && is_active_sidebar( 'sidebar-1' ) ) {
		$classes[] = 'has_sidebar';
	}

	return $classes;
}

add_filter( 'body_class', 'silk_body_classes' );

/**
 * Extend the default WordPress post classes.
 *
 * @since Silk 1.0
 *
 * @param array $classes A list of existing post class values.
 *
 * @return array The filtered post class list.
 */
function silk_post_classes( $classes ) {
	$post_format = get_post_format();

	if ( is_archive() || is_home() || is_search() ) {
		$classes[] = 'grid__item';
	}

	return $classes;
}

add_filter( 'post_class', 'silk_post_classes' );

if ( version_compare( $GLOBALS['wp_version'], '4.1', '<' ) ) :
	/**
	 * Filters wp_title to print a neat <title> tag based on what is being viewed.
	 *
	 * @param string $title Default title text for current view.
	 * @param string $sep Optional separator.
	 *
	 * @return string The filtered title.
	 */
	function silk_wp_title( $title, $sep ) {
		if ( is_feed() ) {
			return $title;
		}

		global $page, $paged;

		// Add the blog name
		$title .= get_bloginfo( 'name', 'display' );

		// Add the blog description for the home/front page.
		$site_description = get_bloginfo( 'description', 'display' );
		if ( $site_description && ( is_home() || is_front_page() ) ) {
			$title .= " $sep $site_description";
		}

		// Add a page number if necessary:
		if ( ( $paged >= 2 || $page >= 2 ) && ! is_404() ) {
			$title .= " $sep " . sprintf( __( 'Page %s', 'silk' ), max( $paged, $page ) );
		}

		return $title;
	}

	add_filter( 'wp_title', 'silk_wp_title', 10, 2 );

	/**
	 * Title shim for sites older than WordPress 4.1.
	 *
	 * @link https://make.wordpress.org/core/2014/10/29/title-tags-in-4-1/
	 * @todo Remove this function when WordPress 4.3 is released.
	 */
	function silk_render_title() {
		?>
		<title><?php wp_title( '|', true, 'right' ); ?></title>
	<?php
	}

	add_action( 'wp_head', 'silk_render_title' );
endif;

if ( ! function_exists( 'silk_fonts_url' ) ) :
	/**
	 * Register Google fonts for Silk.
	 * @since Silk 1.0
	 *
	 * @return string Google fonts URL for the theme.
	 */
	function silk_fonts_url() {
		$fonts_url = '';
		$fonts     = array();
		$subsets   = 'latin,latin-ext';

		/* Translators: If there are characters in your language that are not
		* supported by Libre Baskerville, translate this to 'off'. Do not translate
		* into your own language.
		*/
		if ( 'off' !== _x( 'on', 'Libre Baskerville font: on or off', 'silk' ) ) {
			$fonts[] = 'Libre Baskerville:400,700,400italic';
		}

		/* Translators: If there are characters in your language that are not
		* supported by Playfair Display, translate this to 'off'. Do not translate
		* into your own language.
		*/
		if ( 'off' !== _x( 'on', 'Playfair Display font: on or off', 'silk' ) ) {
			$fonts[] = 'Playfair Display:400,700,900,400italic,700italic,900italic';
		}

		/* Translators: If there are characters in your language that are not
		* supported by Merriweather, translate this to 'off'. Do not translate
		* into your own language.
		*/
		if ( 'off' !== _x( 'on', 'Merriweather font: on or off', 'silk' ) ) {
			$fonts[] = 'Merriweather:400italic,400,300,700';
		}

		/* translators: To add an additional character subset specific to your language, translate this to 'greek', 'cyrillic', 'devanagari' or 'vietnamese'. Do not translate into your own language. */
		$subset = _x( 'no-subset', 'Add new subset (greek, cyrillic, devanagari, vietnamese)', 'silk' );

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
				'family' => urlencode( implode( '|', $fonts ) ),
				'subset' => urlencode( $subsets ),
			), '//fonts.googleapis.com/css' );
		}

		return $fonts_url;
	}
endif;

/**
 * Sets the authordata global when viewing an author archive.
 * This provides backwards compatibility with
 * http://core.trac.wordpress.org/changeset/25574
 * It removes the need to call the_post() and rewind_posts() in an author
 * template to print information about the author.
 * @global WP_Query $wp_query WordPress Query object.
 * @return void
 */
function silk_setup_author() {
	global $wp_query;

	if ( $wp_query->is_author() && isset( $wp_query->post ) ) {
		$GLOBALS['authordata'] = get_userdata( $wp_query->post->post_author );
	}
}

add_action( 'wp', 'silk_setup_author' );

if ( ! function_exists( 'silk_comment' ) ) :
	/*
	 * Individual comment layout
	 */
	function silk_comment( $comment, $args, $depth ) {
		static $comment_number;

		if ( ! isset( $comment_number ) ) {
			$comment_number = $args['per_page'] * ( $args['page'] - 1 ) + 1;
		} else {
			$comment_number ++;
		}

		$GLOBALS['comment'] = $comment; ?>
	<li <?php comment_class( empty( $args['has_children'] ) ? '' : 'parent' ); ?>>
		<article id="comment-<?php comment_ID() ?>" class="comment-article  media">
			<span class="comment-number"><?php echo $comment_number ?></span>
			<?php
			//grab the avatar - by default the Mystery Man
			$avatar = get_avatar( $comment ); ?>

			<aside class="comment__avatar  media__img"><?php echo $avatar; ?></aside>

			<div class="media__body">
				<header class="comment__meta comment-author">
					<?php printf( '<span class="comment__author-name">%s</span>', get_comment_author_link() ) ?>
					<time class="comment__time" datetime="<?php comment_time( 'c' ); ?>">
						<a href="<?php echo esc_url( get_comment_link( get_comment_ID() ) ) ?>" class="comment__timestamp"><?php printf( __( 'on %s at %s', 'silk' ), get_comment_date(), get_comment_time() ); ?> </a>
					</time>
					<div class="comment__links">
						<?php
						//we need some space before Edit
						edit_comment_link( __( 'Edit', 'silk' ), '  ' );

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
						<p><?php _e( 'Your comment is awaiting moderation.', 'silk' ) ?></p>
					</div>
				<?php endif; ?>
				<section class="comment__content comment">
					<?php comment_text() ?>
				</section>
			</div>
		</article>
		<!-- </li> is added by WordPress automatically -->
	<?php
	} // don't remove this bracket!
endif; //silk_comment

/**
 * Filter comment_form_defaults to remove the notes after the comment form textarea.
 *
 * @param array $defaults
 *
 * @return array
 */
function silk_comment_form_remove_notes_after( $defaults ) {
	$defaults['comment_notes_after'] = '';

	return $defaults;
}

add_filter( 'comment_form_defaults', 'silk_comment_form_remove_notes_after' );

/**
 * Filter wp_link_pages to wrap current page in span.
 *
 * @param string $link
 *
 * @return string
 */
function silk_link_pages( $link ) {
	if ( is_numeric( $link ) ) {
		return '<span class="current">' . $link . '</span>';
	}

	return $link;
}

add_filter( 'wp_link_pages_link', 'silk_link_pages' );

/**
 * Wrap more link
 */
function silk_read_more_link( $link ) {
	return '<div class="more-link-wrapper">' . $link . '</div>';
}

add_filter( 'the_content_more_link', 'silk_read_more_link' );

/**
 * Constrain the excerpt length
 */
function silk_excerpt_length( $length ) {
	return 18;
}

add_filter( 'excerpt_length', 'silk_excerpt_length', 999 );


if ( ! class_exists( 'Silk_Walker_Primary_Mega_Menu' ) && class_exists( 'Walker_Nav_Menu' ) ):

	/**
	 * Special menu walker to generate the mega menu system of the primary menu location
	 *
	 * @uses Walker_Nav_Menu
	 */
	class Silk_Walker_Primary_Mega_Menu extends Walker_Nav_Menu {

		protected $has_megamenu;

		/**
		 * Starts the list before the elements are added.
		 *
		 * @see Walker::start_lvl()
		 *
		 * @since 3.0.0
		 *
		 * @param string $output Passed by reference. Used to append additional content.
		 * @param int    $depth  Depth of menu item. Used for padding.
		 * @param array  $args   An array of arguments. @see wp_nav_menu()
		 */
		public function start_lvl( &$output, $depth = 0, $args = array() ) {
			$indent = str_repeat( "\t", $depth );
			$output .= "\n" . $indent . '<ul class="sub-menu" aria-hidden="true" role="menu">' . "\n";
		}

		/**
		 * Start the element output.
		 * modification - add main/sub classes to li's and links
		 *
		 * @see Walker::start_el()
		 *
		 * @since 3.0.0
		 *
		 * @param string $output Passed by reference. Used to append additional content.
		 * @param object $item   Menu item data object.
		 * @param int    $depth  Depth of menu item. Used for padding.
		 * @param array  $args   An array of arguments. @see wp_nav_menu()
		 * @param int    $id     Current item ID.
		 */
		public function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {

			$indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';

			$this->has_megamenu = $this->main_has_megamenu( $item, $depth );

			if ( ! is_array( $args ) ) {
				$args = (array) $args;
			}

			// depth dependent classes
			$depth_classes = array( 'depth-' . $depth );

			$depth_class_names = esc_attr( implode( ' ', $depth_classes ) );

			// passed classes
			$classes     = empty( $item->classes ) ? array() : (array) $item->classes;
			$classes[] = 'nav--top__item-' . $item->ID;

			//add this in case we fallback on wp_page_menu
			if ( ! array_search( 'menu-item', $classes ) ) {
				$classes[] = 'menu-item';
			}

			if ( true === $this->has_megamenu ) {
				$classes[] = 'menu-item--mega';
			}
			$class_names = esc_attr( join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item,  $args, $depth ) ) );

			// build html
			/**
			 * Filter the ID applied to a menu item's list item element.
			 *
			 * @since 3.0.1
			 * @since 4.1.0 The `$depth` parameter was added.
			 *
			 * @param string $menu_id The ID that is applied to the menu item's `<li>` element.
			 * @param object $item    The current menu item.
			 * @param array  $args    An array of {@see wp_nav_menu()} arguments.
			 * @param int    $depth   Depth of menu item. Used for padding.
			 */
			$id = apply_filters( 'nav_menu_item_id', 'nav--top__item-'. $item->ID, $item, $args, $depth );
			$id = $id ? ' id="' . esc_attr( $id ) . '"' : '';

			$output .= $indent . '<li ' . $id . '" class="nav__item ' . $depth_class_names . ' ' . $class_names . '">' . "\n";

			if ( empty( $item->title ) && empty( $item->url ) ) {
				$item->url = get_permalink( $item->ID );
				$item->title = $item->post_title;
			}

			$atts = array();
			$atts['title']  = ! empty( $item->attr_title ) ? $item->attr_title : '';
			$atts['target'] = ! empty( $item->target )     ? $item->target     : '';
			$atts['rel']    = ! empty( $item->xfn )        ? $item->xfn        : '';
			$atts['href']   = ! empty( $item->url )        ? $item->url        : '';

			/**
			 * Filter the HTML attributes applied to a menu item's anchor element.
			 *
			 * @since 3.6.0
			 * @since 4.1.0 The `$depth` parameter was added.
			 *
			 * @param array $atts {
			 *     The HTML attributes applied to the menu item's `<a>` element, empty strings are ignored.
			 *
			 *     @type string $title  Title attribute.
			 *     @type string $target Target attribute.
			 *     @type string $rel    The rel attribute.
			 *     @type string $href   The href attribute.
			 * }
			 * @param object $item  The current menu item.
			 * @param array  $args  An array of {@see wp_nav_menu()} arguments.
			 * @param int    $depth Depth of menu item. Used for padding.
			 */
			$atts = apply_filters( 'nav_menu_link_attributes', $atts, $item, $args, $depth );

			$attributes = '';
			foreach ( $atts as $attr => $value ) {
				if ( ! empty( $value ) ) {
					$value = ( 'href' === $attr ) ? esc_url( $value ) : esc_attr( $value );
					$attributes .= ' ' . $attr . '="' . $value . '"';
				}
			}
			$attributes .= ' class="menu-link ' . ( $depth > 0 ? 'sub-menu-link' : 'main-menu-link' ) . '"';

			$item_output = $args['before'];
			$item_output .= '<a'. $attributes .'>';
			/** This filter is documented in wp-includes/post-template.php */
			$item_output .= $args['link_before'] . apply_filters( 'the_title', $item->title, $item->ID ) . $args['link_after'];
			$item_output .= '</a>';
			$item_output .= $args['after'];

			if ( 0 === $depth && ( $this->has_children || $this->has_megamenu ) ) {
				//the mega menu wrapper
				$item_output .= '<div class="sub-menu-wrapper">' . "\n";
			}

			/**
			 * Filter a menu item's starting output.
			 *
			 * The menu item's starting output only includes `$args->before`, the opening `<a>`,
			 * the menu item's title, the closing `</a>`, and `$args->after`. Currently, there is
			 * no filter for modifying the opening and closing `<li>` for a menu item.
			 *
			 * @since 3.0.0
			 *
			 * @param string $item_output The menu item's starting HTML output.
			 * @param object $item        Menu item data object.
			 * @param int    $depth       Depth of menu item. Used for padding.
			 * @param array  $args        An array of {@see wp_nav_menu()} arguments.
			 */
			$output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
		}

		/**
		 * Ends the element output, if needed.
		 *
		 * @see Walker::end_el()
		 *
		 * @since 3.0.0
		 *
		 * @param string $output Passed by reference. Used to append additional content.
		 * @param object $item   Page data object. Not used.
		 * @param int    $depth  Depth of page. Not Used.
		 * @param array  $args   An array of arguments. @see wp_nav_menu()
		 */
		public function end_el( &$output, $item, $depth = 0, $args = array() ) {

			$item_output = '';

			if ( 0 === $depth ) {

				if ( 'category' == $item->object ) {
					/**
					 * This is a mega menu so we need to output some posts with featured images
					 */

					$numberposts = 4; //we start of with 4 posts and decrease from here

					$post_args = array(
						'posts_per_page' => $numberposts,
						'offset'         => 0,
						'post_type'      => 'post',
						'post_status'    => 'publish',
						'cat'            => $item->object_id,
					);

					$menuposts = new WP_Query( $post_args );

					if ( $menuposts->have_posts() ) {

						//the first post is a big one
						$menuposts->the_post();

						if ( has_post_thumbnail() ) {
							$thumb = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID() ), 'silk-mega-menu-big-image' );

							$menu_post_image = '<a href="' . get_permalink()
							                   . '" title="'
							                   . the_title_attribute( array( 'echo' => false ) )
							                   .'" class="entry-image" style="background-image:url(' . $thumb[0] . ')"></a>' . "\n";
						} else {
							$menu_post_image = '';
						}

						$item_output .=
						'<article class="submenu__card  card">' . "\n" .
							$menu_post_image .
							'<header class="entry-header">' . "\n" .
								'<div class="entry-meta">' . "\n" .
									silk_get_posted_on_and_cats() . "\n" .
								'</div><!-- .entry-meta -->' . "\n" .
								'<a href="' . get_permalink() . '"><h2 class="entry-title">' . get_the_title() . '</h2></a>' . "\n" .
							'</header><!-- .entry-header -->' . "\n" .
							'<a class="separator  separator--text" role="presentation" href="' . get_permalink() . '">
								<span>' . __( 'More', 'silk' ) . '</span>
							</a>' . "\n" .
						'</article>' . "\n";

						//if we still have posts - it's time for the little ones
						if ( $menuposts->have_posts() ) {

							$item_output .= '<ul class="submenu__thumbs">' . "\n";

							while ( $menuposts->have_posts() )  : $menuposts->the_post();

								if ( has_post_thumbnail() ) {
									$menu_post_image = '<a href="' . get_permalink() . '" title="' . the_title_attribute( array( 'echo' => false ) ) .'">' .get_the_post_thumbnail( get_the_ID(), 'silk-tiny-image' ) . '</a>' . "\n";
								} else {
									$menu_post_image = '';
								}

								$item_output .=
									'<li>' . "\n" .
										'<article class="thumb  flag">' . "\n" .
											'<div class="flag__img">' . "\n" .
												$menu_post_image .
											'</div>' . "\n" .
											'<div class="flag__body">' . "\n" .
												'<div class="entry-meta  entry-meta--card  align-left">' . silk_get_posted_on_and_cats() . '</div>' . "\n" .
												'<a href="' . get_permalink() . '"><h3 class="entry-title  align-left">' . get_the_title() . '</h3></a>' . "\n" .
											'</div>' . "\n" .
										'</article>' . "\n" .
									'</li>' . "\n";

							endwhile;

							$item_output .= '</ul>' . "\n";
						}

						wp_reset_postdata();

					}
				}

				if ( $this->has_children || $this->has_megamenu ) {
					$item_output .= '</div>' . "\n"; //close the .sub-menu-wrapper
				}
			}

			$output .= $item_output;
			$output .= '</li>' . "\n";
		}

		/**
		 * Traverse elements to create list from elements.
		 *
		 * Display one element if the element doesn't have any children otherwise,
		 * display the element and its children. Will only traverse up to the max
		 * depth and no ignore elements under that depth. It is possible to set the
		 * max depth to include all depths, see walk() method.
		 *
		 * This method should not be called directly, use the walk() method instead.
		 *
		 * @since 2.5.0
		 *
		 * @param object $element           Data object.
		 * @param array  $children_elements List of elements to continue traversing.
		 * @param int    $max_depth         Max depth to traverse.
		 * @param int    $depth             Depth of current element.
		 * @param array  $args              An array of arguments.
		 * @param string $output            Passed by reference. Used to append additional content.
		 * @return null Null on failure with no changes to parameters.
		 */
		public function display_element( $element, &$children_elements, $max_depth, $depth, $args, &$output ) {

			if ( ! $element ) {
				return;
			}

			$id_field = $this->db_fields['id'];
			$id       = $element->$id_field;

			//display this element
			$this->has_children = ! empty( $children_elements[ $id ] );
			if ( isset( $args[0] ) && is_array( $args[0] ) ) {
				$args[0]['has_children'] = $this->has_children; // Backwards compatibility.
			}

			$temp_classes = $element->classes;
			if ( $this->has_children ) {
				$temp_classes[] = 'menu-item--parent';
			} else {
				$temp_classes[] = 'menu-item--no-children';
			}
			$element->classes = $temp_classes;

			$cb_args = array_merge( array( &$output, $element, $depth ), $args );
			call_user_func_array( array( $this, 'start_el' ), $cb_args );

			// descend only when the depth is right and there are childrens for this element
			if ( ( 0 == $max_depth || $max_depth > $depth + 1 ) && isset( $children_elements[ $id ] ) ) {
				foreach ( $children_elements[ $id ] as $child ){

					if ( ! isset( $newlevel ) ) {
						$newlevel = true;
						//start the child delimiter
						$cb_args = array_merge( array( &$output, $depth ), $args );
						call_user_func_array( array( $this, 'start_lvl' ), $cb_args );
					}
					$this->display_element( $child, $children_elements, $max_depth, $depth + 1, $args, $output );
				}
				unset( $children_elements[ $id ] );
			}

			if ( isset($newlevel) && $newlevel ){
				//end the child delimiter
				$cb_args = array_merge( array( &$output, $depth ), $args );
				call_user_func_array( array( $this, 'end_lvl' ), $cb_args );
			}

			//end this element
			$cb_args = array_merge( array( &$output, $element, $depth ), $args );
			call_user_func_array( array( $this, 'end_el' ), $cb_args );
		}

		private function main_has_megamenu( $item, $depth ) {

			if ( 0 === $depth && 'category' == $item->object ) {

				$post_args = array(
					'posts_per_page' => 1,
					'offset'         => 0,
					'post_type'      => 'post',
					'post_status'    => 'publish',
					'cat'            => $item->object_id,
				);

				$menuposts = new WP_Query( $post_args );

				if ( $menuposts->have_posts() ) {
					return true;
				}
			}

			return false;
		}

	} # class

endif;


if ( ! class_exists( 'Silk_Walker_Page_Primary' ) && class_exists( 'Walker_Page' ) ):
	/**
	 * Create HTML list of pages for the primary menu when no menu assigned to location
	 *
	 * @uses Walker_Page
	 */
	class Silk_Walker_Page_Primary extends Walker_Page {
		/**
		 * @see Walker::start_lvl()
		 * @since 2.1.0
		 *
		 * @param string $output Passed by reference. Used to append additional content.
		 * @param int $depth Depth of page. Used for padding.
		 * @param array $args
		 */
		public function start_lvl( &$output, $depth = 0, $args = array() ) {
			$indent = str_repeat( "\t", $depth );
			$output .= "\n" . $indent . '<ul class="sub-menu" aria-hidden="true" role="menu">' . "\n";
		}

		/**
		 * @see Walker::start_el()
		 * @since 2.1.0
		 *
		 * @param string $output Passed by reference. Used to append additional content.
		 * @param object $page Page data object.
		 * @param int $depth Depth of page. Used for padding.
		 * @param int $current_page Page ID.
		 * @param array $args
		 */
		public function start_el( &$output, $page, $depth = 0, $args = array(), $current_page = 0 ) {

			$indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';

			$css_class = array( 'page_item', 'page-item-' . $page->ID );

			if ( isset( $args['pages_with_children'][ $page->ID ] ) ) {
				$css_class[] = 'menu-item-has-children';
			}

			if ( ! empty( $current_page ) ) {
				$_current_page = get_post( $current_page );
				if ( $_current_page && in_array( $page->ID, $_current_page->ancestors ) ) {
					$css_class[] = 'current_page_ancestor';
				}
				if ( $page->ID == $current_page ) {
					$css_class[] = 'current_page_item';
				} elseif ( $_current_page && $page->ID == $_current_page->post_parent ) {
					$css_class[] = 'current_page_parent';
				}
			} elseif ( $page->ID == get_option( 'page_for_posts' ) ) {
				$css_class[] = 'current_page_parent';
			}

			//add some classes used with regular menus
			$css_class[] = 'nav--top__item-' . $page->ID;
			$css_class[] = 'menu-item';
			$css_class[] = 'nav__item';
			$css_class[] = 'depth-' . $depth;

			/**
			 * Filter the list of CSS classes to include with each page item in the list.
			 *
			 * @since 2.8.0
			 *
			 * @see wp_list_pages()
			 *
			 * @param array   $css_class    An array of CSS classes to be applied
			 *                             to each list item.
			 * @param WP_Post $page         Page data object.
			 * @param int     $depth        Depth of page, used for padding.
			 * @param array   $args         An array of arguments.
			 * @param int     $current_page ID of the current page.
			 */
			$css_classes = implode( ' ', apply_filters( 'page_css_class', $css_class, $page, $depth, $args, $current_page ) );

			/**
			 * Filter the ID applied to a menu item's list item element.
			 *
			 * @since 3.0.1
			 * @since 4.1.0 The `$depth` parameter was added.
			 *
			 * @param string $menu_id The ID that is applied to the menu item's `<li>` element.
			 * @param object $item    The current menu item.
			 * @param array  $args    An array of {@see wp_nav_menu()} arguments.
			 * @param int    $depth   Depth of menu item. Used for padding.
			 */
			$css_id = apply_filters( 'nav_menu_item_id', 'nav--top__item-'. $page->ID, $page, $args, $depth );
			$css_id = $css_id ? ' id="' . esc_attr( $css_id ) . '"' : '';

			if ( '' === $page->post_title ) {
				$page->post_title = sprintf( __( '#%d (no title)', 'silk' ), $page->ID );
			}

			$args['link_before'] = empty( $args['link_before'] ) ? '' : $args['link_before'];
			$args['link_after'] = empty( $args['link_after'] ) ? '' : $args['link_after'];

			$link_classes = ' class="menu-link ' . ( $depth > 0 ? 'sub-menu-link' : 'main-menu-link' ) . '"';

			/** This filter is documented in wp-includes/post-template.php */
			$output .= $indent . sprintf(
				'<li %s class="%s"><a %s href="%s">%s%s%s</a>',
				$css_id,
				$css_classes,
				$link_classes,
				get_permalink( $page->ID ),
				$args['link_before'],
				apply_filters( 'the_title', $page->post_title, $page->ID ),
				$args['link_after']
			);

			if ( ! empty( $args['show_date'] ) ) {
				if ( 'modified' == $args['show_date'] ) {
					$time = $page->post_modified;
				} else {
					$time = $page->post_date;
				}

				$date_format = empty( $args['date_format'] ) ? '' : $args['date_format'];
				$output .= ' ' . mysql2date( $date_format, $time );
			}

			if ( 0 === $depth && isset( $args['pages_with_children'][ $page->ID ] ) ) {
				//the mega menu wrapper
				$output .= '<div class="sub-menu-wrapper">' . "\n";
			}
		}

		/**
		 * @see Walker::end_el()
		 * @since 2.1.0
		 *
		 * @param string $output Passed by reference. Used to append additional content.
		 * @param object $page Page data object. Not used.
		 * @param int $depth Depth of page. Not Used.
		 * @param array $args
		 */
		public function end_el( &$output, $page, $depth = 0, $args = array() ) {
			if ( $this->has_children ) {
				$output .= '</div>' . "\n"; //close the .sub-menu-wrapper
			}
			$output .= "</li>\n";
		}

	} #class

endif;

if ( ! function_exists( 'silk_custom_wp_page_menu' ) ) :

	/**
	 * Display the list of pages with a home link in case there is no menu in the primary location
	 *
	 * @param array|string $args {
	 *     Optional. Arguments to generate a page menu. {@see wp_list_pages()}
	 *     for additional arguments.
	 *
	 * @type string     $sort_column How to short the list of pages. Accepts post column names.
	 *                               Default 'menu_order, post_title'.
	 * @type string     $menu_class  Class to use for the div ID containing the page list. Default 'menu'.
	 * @type bool       $echo        Whether to echo the list or return it. Accepts true (echo) or false (return).
	 *                               Default true.
	 * @type string     $link_before The HTML or text to prepend to $show_home text. Default empty.
	 * @type string     $link_after  The HTML or text to append to $show_home text. Default empty.
	 * @type int|string $show_home   Whether to display the link to the home page. Can just enter the text
	 *                               you'd like shown for the home link. 1|true defaults to 'Home'.
	 * }
	 * @return string html menu
	 */
	function silk_custom_wp_page_menu( $args = array() ) {
		$defaults = array( 'show_home' => true, 'sort_column' => 'menu_order, post_title', 'menu_class' => 'menu', 'echo' => true, 'link_before' => '', 'link_after' => '' );
		$args = wp_parse_args( $args, $defaults );

		/**
		 * Filter the arguments used to generate a page-based menu.
		 *
		 * @since 2.7.0
		 *
		 * @see wp_page_menu()
		 *
		 * @param array $args An array of page menu arguments.
		 */
		$args = apply_filters( 'wp_page_menu_args', $args );

		$menu = '';

		$list_args = $args;

		// Show Home in the menu
		if ( ! empty($args['show_home']) ) {
			if ( true === $args['show_home'] || '1' === $args['show_home'] || 1 === $args['show_home'] ) {
				$text = __( 'Home', 'silk' );
			} else {
				$text = $args['show_home'];
			}
			$class = '';
			if ( is_front_page() && ! is_paged() ) {
				$class .= 'class="current_page_item"';
			}

			$menu .= '<li ' . $class . '><a class="menu-link main-menu-link" href="' . home_url( '/' ) . '">' . $args['link_before'] . $text . $args['link_after'] . '</a></li>';
			// If the front page is a page, add it to the exclude list
			if ( 'page' == get_option( 'show_on_front' ) ) {
				if ( ! empty( $list_args['exclude'] ) ) {
					$list_args['exclude'] .= ',';
				} else {
					$list_args['exclude'] = '';
				}
				$list_args['exclude'] .= get_option( 'page_on_front' );
			}
		}

		$list_args['echo'] = false;
		$list_args['title_li'] = '';
		$list_args['walker'] = new Silk_Walker_Page_Primary();

		$menu .= str_replace( array( "\r", "\n", "\t" ), '', wp_list_pages( $list_args ) );

		/**
		 * We had to create a modified version of the core one because of this
		 * To have ul instead of div here - a option for this would be nice :)
		 */
		if ( $menu ) {
			$menu = '<ul class="' . esc_attr( $args['menu_class'] ) . '">' . $menu . '</ul>' . "\n";
		}

		/**
		 * Filter the HTML output of a page-based menu.
		 *
		 * @since 2.7.0
		 *
		 * @see wp_page_menu()
		 *
		 * @param string $menu The HTML output.
		 * @param array  $args An array of arguments.
		 */
		$menu = apply_filters( 'wp_page_menu', $menu, $args );
		if ( $args['echo'] ) {
			echo $menu;
		} else {
			return $menu;
		}
	} #function

endif;

/**
 * Add "Styles" drop-down
 */
add_filter( 'mce_buttons_2', 'silk_mce_editor_buttons' );
function silk_mce_editor_buttons( $buttons ) {
	array_unshift( $buttons, 'styleselect' );
	return $buttons;
}

/**
 * Add styles/classes to the "Styles" drop-down
 */
add_filter( 'tiny_mce_before_init', 'silk_mce_before_init' );
function silk_mce_before_init( $settings ) {

	$style_formats = array(
		array( 'title' => __( 'Intro Text', 'silk' ), 'selector' => 'p', 'classes' => 'intro' ),
		array( 'title' => __( 'Dropcap', 'silk' ), 'inline' => 'span', 'classes' => 'dropcap' ),
		array( 'title' => __( 'Highlight', 'silk' ), 'inline' => 'span', 'classes' => 'highlight' ),
		array( 'title' => __( 'Two Columns', 'silk' ), 'selector' => 'p', 'classes' => 'twocolumn', 'wrapper' => true ),
	);

	$settings['style_formats'] = json_encode( $style_formats );

	return $settings;
}

/**
 * Get the featured image thumb size depending on whether we are using a single column layout or masonry
 *
 * @return string
 */
function silk_get_thumbnail_size() {
	return get_theme_mod( 'silk_single_column_archives', false ) ? 'silk-single-image' : 'silk-masonry-image';
} ?>