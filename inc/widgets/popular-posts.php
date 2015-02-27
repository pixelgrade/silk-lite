<?php
/**
 * Popular Posts widget based on the Jetpack Stats
 * See: http://jetpack.me/
 *
 * @package Silk
 */

/*
 * Currently, this widget depends on the Stats Module. To not load this file
 * when the Stats Module is not active would potentially bypass Jetpack's
 * fatal error detection on module activation, so we always load this file.
 * Instead, we don't register the widget if the Stats Module isn't active.
 */

if ( ! function_exists('silk_popular_posts_widget_init') ) :
	/**
	 * Register our Popular Posts widget for use in Appearance -> Widgets
	 */
	add_action( 'widgets_init', 'silk_popular_posts_widget_init' );

	function silk_popular_posts_widget_init() {
		// Currently, this widget depends on the Stats Module
		if (
			( !defined( 'IS_WPCOM' ) || !IS_WPCOM )
			&&
			!function_exists( 'stats_get_csv' )
		) {
			return;
		}

		register_widget( 'Silk_Popular_Posts_Widget' );
	}
endif;

if ( ! class_exists('Silk_Popular_Posts_Widget') ) :

	class Silk_Popular_Posts_Widget extends WP_Widget {

		var $alt_option_name = 'widget_silk_popularposts';
		var $default_title = '';

		function __construct() {
			parent::__construct(
				'silk-popular-posts',
				apply_filters( 'silk_widget_name', __( 'Silk Popular Posts', 'silk_txtd' ) ),
				array(
					'description' => __( 'Shows your most viewed posts.', 'silk_txtd' ),
				)
			);

			$this->default_title = __( 'Popular Posts', 'silk_txtd' );
		}

		function form( $instance ) {
			$title = isset( $instance['title'] ) ? $instance['title'] : false;
			if ( false === $title ) {
				$title = $this->default_title;
			}

			$count = isset( $instance['count'] ) ? (int) $instance['count'] : 5;
			if ( $count < 1 || 10 < $count ) {
				$count = 10;
			}

			?>

		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php esc_html_e( 'Title:', 'silk_txtd' ); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'count' ); ?>"><?php esc_html_e( 'Maximum number of posts to show (no more than 10):', 'silk_txtd' ); ?></label>
			<input id="<?php echo $this->get_field_id( 'count' ); ?>" name="<?php echo $this->get_field_name( 'count' ); ?>" type="number" value="<?php echo (int) $count; ?>" min="1" max="10" />
		</p>

		<p><?php esc_html_e( 'Popular Posts by views are calculated from 24-48 hours of stats. They take a while to change.', 'silk_txtd' ); ?></p>

		<?php
		}

		function update( $new_instance, $old_instance ) {
			$instance = array();
			$instance['title'] = wp_kses( $new_instance['title'], array() );
			if ( $instance['title'] === $this->default_title ) {
				$instance['title'] = false; // Store as false in case of language change
			}

			$instance['count'] = (int) $new_instance['count'];
			if ( $instance['count'] < 1 || 10 < $instance['count'] ) {
				$instance['count'] = 10;
			}

			return $instance;
		}

		function widget( $args, $instance ) {
			$title = isset( $instance['title'] ) ? $instance['title'] : false;
			if ( false === $title ) {
				$title = $this->default_title;
			}
			$title = apply_filters( 'widget_title', $title );

			$count = isset( $instance['count'] ) ? (int) $instance['count'] : 5;
			if ( $count < 1 || 10 < $count ) {
				$count = 10;
			}
			$count = apply_filters( 'silk_popular_posts_widget_count', $count );

			$get_image_options = array(
				'fallback_to_avatars' => false,
				'thumbnail_size' => 285,
			);

			$get_image_options = apply_filters( 'silk_popular_posts_widget_image_options', $get_image_options );

			$posts = $this->get_by_views( $count );

			if ( ! $posts ) {
				$posts = $this->get_fallback_posts();
			}

			echo $args['before_widget'];
			if ( ! empty( $title ) ) {
				echo $args['before_title'] . $title . $args['after_title'];
			}

			if ( ! $posts ) {
				if ( current_user_can( 'edit_theme_options' ) ) {
					echo '<p>' . sprintf(
						__( 'There are no posts to display. <a href="%s">Want more traffic?</a>', 'silk_txtd' ),
						'http://en.support.wordpress.com/getting-more-site-traffic/'
					) . '</p>';
				}

				echo $args['after_widget'];
				return;
			}

			//the first post has a nice image unlike the rest
			$post = array_shift( $posts );
			$image = Jetpack_PostImages::get_image( $post['post_id'], array( 'fallback_to_avatars' => true ) );
			$post['image'] = $image['src'];
			if ( 'blavatar' != $image['from'] && 'gravatar' != $image['from'] ) {
				$size = (int) $get_image_options['thumbnail_size'];
				$post['image'] = jetpack_photon_url( $post['image'], array( 'resize' => "$size" ) );
			}
			echo '<ol>';
			?>
			<li class='popular-posts_item large-thumbnail'>
				<?php do_action( 'silk_widget_popular_posts_before_post', $post['post_id'] ); ?>
				<a href="<?php echo esc_url( $post['permalink'] ); ?>" title="<?php echo esc_attr( wp_kses( $post['title'], array() ) ); ?>" class="bump-view" data-bump-view="tp">
					<img src="<?php echo esc_url( $post['image'] ); ?>" alt="<?php echo esc_attr( wp_kses( $post['title'], array() ) ); ?>" />
				</a>
				<?php
					$cats_list = silk_get_cats_list( $post['post_id'] );

					if ( ! empty( $cats_list ) ) {
						echo '<div class="categories-list">' . $cats_list . '</div>';
					}
				?>
				<a href="<?php echo esc_url( $post['permalink'] ); ?>" class="bump-view  title" data-bump-view="tp">
					<?php echo esc_html( wp_kses( $post['title'], array() ) ); ?>
				</a>
				<?php do_action( 'silk_widget_popular_posts_after_post', $post['post_id'] ); ?>
			</li>
			<?php

			// the rest of the posts are just text
			foreach ( $posts as $post ) :
				?>
				<li class='popular-posts_item'>
					<?php do_action( 'silk_widget_popular_posts_before_post', $post['post_id'] ); ?>
					<a href="<?php echo esc_url( $post['permalink'] ); ?>" class="bump-view" data-bump-view="tp">
						<?php echo esc_html( wp_kses( $post['title'], array() ) ); ?>
					</a>
					<?php
					$cats_list = silk_get_cats_list( $post['post_id'] );

					if ( ! empty( $cats_list ) ) {
						echo '<div class="categories-list">' . $cats_list . '</div>';
					}
					?>
					<?php do_action( 'silk_widget_popular_posts_after_post', $post['post_id'] ); ?>
				</li>
			<?php
			endforeach;
			echo '</ol>';

			echo $args['after_widget'];
		}

		function get_by_views( $count ) {
			$days = (int) apply_filters( 'jetpack_top_posts_days', 2 );

			if ( $days < 1 ) {
				$days = 2;
			}

			if ( $days > 10 ) {
				$days = 10;
			}

			$post_view_posts = stats_get_csv( 'postviews', array( 'days' => absint( $days ), 'limit' => 11 ) );
			if ( ! $post_view_posts ) {
				return array();
			}

			$post_view_ids = array_filter( wp_list_pluck( $post_view_posts, 'post_id' ) );
			if ( ! $post_view_ids ) {
				return array();
			}

			return $this->get_posts( $post_view_ids, $count );
		}

		function get_fallback_posts() {
			if ( current_user_can( 'edit_theme_options' ) ) {
				return array();
			}

			$post_query = new WP_Query;

			$posts = $post_query->query( array(
				'posts_per_page' => 1,
				'post_status' => 'publish',
				'post_type' => array( 'post' ),
				'no_found_rows' => true,
			) );

			if ( ! $posts ) {
				return array();
			}

			$post = array_pop( $posts );

			return $this->get_posts( $post->ID, 1 );
		}

		function get_posts( $post_ids, $count ) {
			$counter = 0;

			$posts = array();
			foreach ( (array) $post_ids as $post_id ) {
				$post = get_post( $post_id );

				if ( ! $post ) {
					continue;
				}

				// Only posts, no attachments or pages
				if ( 'attachment' == $post->post_type || 'page' == $post->post_type ) {
					continue;
				}

				// hide private and password protected posts
				if ( 'publish' != $post->post_status || ! empty( $post->post_password ) || empty( $post->ID ) ) {
					continue;
				}

				// Both get HTML stripped etc on display
				if ( empty( $post->post_title ) ) {
					$title_source = $post->post_content;
					$title = wp_html_excerpt( $title_source, 50 );
					$title .= '&hellip;';
				} else {
					$title = $post->post_title;
				}

				$permalink = get_permalink( $post->ID );

				$posts[] = compact( 'title', 'permalink', 'post_id' );
				$counter++;

				if ( $counter == $count ) {
					break; // only need to load and show x number of posts
				}
			}

			return apply_filters( 'silk_widget_get_popular_posts', $posts, $post_ids, $count );
		}

	} //Class Silk Popular Posts Widget

endif; ?>