<?php
/**
 * Custom functions that act independently of the theme templates
 *
 * Eventually, some of the functionality here could be replaced by core features
 *
 * @package Amelie
 */

/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 *
 * @return array
 */
function amelie_body_classes( $classes ) {
	// Adds a class of group-blog to blogs with more than 1 published author.
	if ( is_multi_author() ) {
		$classes[] = 'group-blog';
	}

	if ( ( is_single() || is_page() || is_home() || is_archive() || is_search() ) && is_active_sidebar( 'sidebar-1' ) ) {
		$classes[] = 'has_sidebar';
	}

	return $classes;
}

add_filter( 'body_class', 'amelie_body_classes' );

/**
 * Extend the default WordPress post classes.
 *
 * @since Amelie 1.0
 *
 * @param array $classes A list of existing post class values.
 *
 * @return array The filtered post class list.
 */
function amelie_post_classes( $classes ) {
	$post_format = get_post_format();

	if ( is_archive() || is_home() || is_search() ) {
		$classes[] = 'grid__item';
	}

	return $classes;
}

add_filter( 'post_class', 'amelie_post_classes' );

if ( version_compare( $GLOBALS['wp_version'], '4.1', '<' ) ) :
	/**
	 * Filters wp_title to print a neat <title> tag based on what is being viewed.
	 *
	 * @param string $title Default title text for current view.
	 * @param string $sep Optional separator.
	 *
	 * @return string The filtered title.
	 */
	function amelie_wp_title( $title, $sep ) {
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
			$title .= " $sep " . sprintf( __( 'Page %s', 'amelie_txtd' ), max( $paged, $page ) );
		}

		return $title;
	}

	add_filter( 'wp_title', 'amelie_wp_title', 10, 2 );

	/**
	 * Title shim for sites older than WordPress 4.1.
	 *
	 * @link https://make.wordpress.org/core/2014/10/29/title-tags-in-4-1/
	 * @todo Remove this function when WordPress 4.3 is released.
	 */
	function amelie_render_title() {
		?>
		<title><?php wp_title( '|', true, 'right' ); ?></title>
	<?php
	}

	add_action( 'wp_head', 'amelie_render_title' );
endif;

if ( ! function_exists( 'amelie_fonts_url' ) ) :
	/**
	 * Register Google fonts for Amelie.
	 * @since Amelie 1.0
	 *
	 * @return string Google fonts URL for the theme.
	 */
	function amelie_fonts_url() {
		$fonts_url = '';
		$fonts     = array();
		$subsets   = 'latin,latin-ext';

		/* Translators: If there are characters in your language that are not
		* supported by Libre Baskerville, translate this to 'off'. Do not translate
		* into your own language.
		*/
		if ( 'off' !== _x( 'on', 'Libre Baskerville font: on or off', 'amelie_txtd' ) ) {
			$fonts[] = 'Libre Baskerville:400,700,400italic';
		}

		/* Translators: If there are characters in your language that are not
		* supported by Playfair Display, translate this to 'off'. Do not translate
		* into your own language.
		*/
		if ( 'off' !== _x( 'on', 'Playfair Display font: on or off', 'amelie_txtd' ) ) {
			$fonts[] = 'Playfair Display:400,700,900,400italic,700italic,900italic';
		}

		/* Translators: If there are characters in your language that are not
		* supported by Merryweather, translate this to 'off'. Do not translate
		* into your own language.
		*/
		if ( 'off' !== _x( 'on', 'Merryweather font: on or off', 'amelie_txtd' ) ) {
			$fonts[] = 'Merryweather:400italic,400,300,700';
		}

		/* translators: To add an additional character subset specific to your language, translate this to 'greek', 'cyrillic', 'devanagari' or 'vietnamese'. Do not translate into your own language. */
		$subset = _x( 'no-subset', 'Add new subset (greek, cyrillic, devanagari, vietnamese)', 'amelie_txtd' );

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
function amelie_setup_author() {
	global $wp_query;

	if ( $wp_query->is_author() && isset( $wp_query->post ) ) {
		$GLOBALS['authordata'] = get_userdata( $wp_query->post->post_author );
	}
}

add_action( 'wp', 'amelie_setup_author' );

/*
 * Individual comment layout
 */
function amelie_comment( $comment, $args, $depth ) {
	static $comment_number;

	if ( ! isset( $comment_number ) ) {
		$comment_number = $args['per_page'] * ( $args['page'] - 1 ) + 1;
	} else {
		$comment_number ++;
	}

	$GLOBALS['comment'] = $comment; ?>
<li <?php comment_class(); ?>>
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
					<a href="<?php echo esc_url( get_comment_link( get_comment_ID() ) ) ?>" class="comment__timestamp"><?php printf( __( 'on %s at %s', 'amelie_txtd' ), get_comment_date(), get_comment_time() ); ?> </a>
				</time>
				<div class="comment__links">
					<?php
					//we need some space before Edit
					edit_comment_link( __( 'Edit', 'amelie_txtd' ), '  ' );

					comment_reply_link( array_merge( $args, array(
						'depth'     => $depth,
						'max_depth' => $args['max_depth']
					) ) );
					?>
				</div>
			</header>
			<!-- .comment-meta -->
			<?php if ( $comment->comment_approved == '0' ) : ?>
				<div class="alert info">
					<p><?php _e( 'Your comment is awaiting moderation.', 'amelie_txtd' ) ?></p>
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

/**
 * Filter wp_link_pages to wrap current page in span.
 *
 * @param $link
 *
 * @return string
 */
function amelie_link_pages( $link ) {
	if ( is_numeric( $link ) ) {
		return '<span class="current">' . $link . '</span>';
	}

	return $link;
}

add_filter( 'wp_link_pages_link', 'amelie_link_pages' );

/**
 * Wrap more link
 */
function amelie_read_more_link( $link ) {
	return '<div class="more-link-wrapper">' . $link . '</div>';
}

add_filter( 'the_content_more_link', 'amelie_read_more_link' );


if ( ! class_exists( "Amelie_Walker_Primary_Mega_Menu" ) && class_exists( 'Walker_Nav_Menu' ) ):

	/**
	 * Special menu walker to generate the mega menu system of the primary menu location
	 */
	class Amelie_Walker_Primary_Mega_Menu extends Walker_Nav_Menu {

		public function start_lvl( &$output, $depth = 0, $args = array() ) {
			$output .= '<ul class="sub-menu" aria-hidden="true" role="menu">' . PHP_EOL;
		}

		public function end_lvl( &$output, $depth = 0, $args = array() ) {
			$output .= "</ul>" . PHP_EOL;
		}

		public function display_element( $element, &$children_elements, $max_depth, $depth = 0, $args, &$output ) {
			$id_field = $this->db_fields['id'];

			// check whether there are children for the given ID
			$element->hasChildren = isset( $children_elements[ $element->$id_field ] ) && ! empty( $children_elements[ $element->$id_field ] );

			$temp_classes = $element->classes;
			if ( ! empty( $children_elements[ $element->$id_field ] ) ) {
				$temp_classes[] = 'menu-item--parent';
			} else {
				$temp_classes[] = 'menu-item--no-children';
			}
			$element->classes = $temp_classes;

			Walker_Nav_Menu::display_element( $element, $children_elements, $max_depth, $depth, $args, $output );
		}

		// add main/sub classes to li's and links
		public function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {
			global $wp_query;

			if ( ! is_array( $args ) ) {
				$args = (array) $args;
			}

			// depth dependent classes
			$depth_classes = array( 'depth-' . $depth );

			$depth_class_names = esc_attr( implode( ' ', $depth_classes ) );

			// passed classes
			$classes     = empty( $item->classes ) ? array() : (array) $item->classes;
			$has_subnav = $this->main_has_subnav( $item, $depth );
			if ( true === $has_subnav ) {
				$classes[] = 'menu-item--mega';
			}
			$class_names = esc_attr( implode( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item ) ) );

			// build html
			$output .= '<li id="nav--top__item-' . $item->ID . '" class="nav__item ' . $depth_class_names . ' ' . $class_names . '">' . PHP_EOL;

			// link attributes
			$attributes = ! empty( $item->attr_title ) ? ' title="' . esc_attr( $item->attr_title ) . '"' : '';
			$attributes .= ! empty( $item->target ) ? ' target="' . esc_attr( $item->target ) . '"' : '';
			$attributes .= ! empty( $item->xfn ) ? ' rel="' . esc_attr( $item->xfn ) . '"' : '';
			$attributes .= ! empty( $item->url ) ? ' href="' . esc_attr( $item->url ) . '"' : '';
			$attributes .= ' class="menu-link ' . ( $depth > 0 ? 'sub-menu-link' : 'main-menu-link' ) . '"';

			$item_output = sprintf
			(
				'%1$s<a%2$s>%3$s%4$s%5$s</a>%6$s',
				$args['before'],
				$attributes,
				$args['link_before'],
				apply_filters( 'the_title', $item->title, $item->ID ),
				$args['link_after'],
				$args['after']
			) . PHP_EOL;

			if ( $depth === 0 && $this->main_has_subnav( $item, $depth ) ) {
				//the mega menu wrapper
				$item_output .= '<div class="sub-menu-wrapper">' . PHP_EOL;
			}

			// build html
			$output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
		}

		public function end_el( &$output, $item, $depth = 0, $args = array() ) {

			$item_output = '';

			if ( $depth == 0 ) {

				if ( $item->object == 'category' ) {

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
							$menu_post_image = '<a href="' . get_permalink() . '"><div class="entry-image  entry-image--card" >' . get_the_post_thumbnail( get_the_ID(), 'amelie-small-image' ) . '</div></a>' . PHP_EOL;
						} else {
							$menu_post_image = '';
						}

						$item_output .=
						'<article class="article  submenu__article--large">' . PHP_EOL .
							$menu_post_image .
							'<header class="entry-header  entry-header--card">' . PHP_EOL .
								'<div class="entry-meta  entry-meta--card">' . PHP_EOL .
									amelie_get_posted_on_and_cats() . PHP_EOL .
								'</div><!-- .entry-meta -->' . PHP_EOL .
								'<a href="' . get_permalink() . '"><h1 class="entry-title  entry-title--card">' . get_the_title() . '</h1></a>' . PHP_EOL .
							'</header><!-- .entry-header -->' . PHP_EOL .
							'<a class="separator" role="presentation" href="' . get_permalink() . '"><span>' . _( 'More', 'amelie_txtd' ) . '</span></a>' . PHP_EOL .
						'</article>' . PHP_EOL;

						//if we still have posts - it's time for the little ones
						if ( $menuposts->have_posts() ) {

							$item_output .= '<ul class="submenu__small-articles">' . PHP_EOL;

							while ( $menuposts->have_posts() )  : $menuposts->the_post();

								if ( has_post_thumbnail() ) {
									$menu_post_image = '<a href="' . get_permalink() . '">' .get_the_post_thumbnail( get_the_ID(), 'amelie-small-image' ) . '</a>' . PHP_EOL;
								} else {
									$menu_post_image = '';
								}

								$item_output .=
									'<li>' . PHP_EOL .
										'<article class="article  flag">' . PHP_EOL .
											'<div class="flag__img  entry-image  entry-image--thumb">' . PHP_EOL .
												$menu_post_image .
											'</div>' . PHP_EOL .
											'<div class="flag__body  article__content">' . PHP_EOL .
												'<div class="entry-meta--card  align-left">' . amelie_get_posted_on_and_cats() . '</div>' . PHP_EOL .
												'<a href="' . get_permalink() . '"><h3 class="entry-title  entry-title--thumb  align-left">' . get_the_title() . '</h3></a>' . PHP_EOL .
											'</div>' . PHP_EOL .
										'</article>' . PHP_EOL .
									'</li>' . PHP_EOL;

							endwhile;

							$item_output .= '</ul>' . PHP_EOL;
						}

						wp_reset_postdata();

					}
				}

				if ( $this->main_has_subnav( $item, $depth ) ) {
					$item_output .= '</div>' . PHP_EOL; //close the .sub-menu-wrapper
				}

			}


			$output .= $item_output;
			$output .= "</li>" . PHP_EOL;
		}

		private function main_has_subnav( $item, $depth ) {

			if ( true === $this->has_children ) {
				return true;
			}

			if ( 0 === $depth && $item->object == 'category' ) {

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

endif; ?>