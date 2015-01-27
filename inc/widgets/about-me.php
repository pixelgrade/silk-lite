<?php
/**
 * Amelie About Me widget
 *
 * @package Amelie
 */

if ( ! function_exists( 'amelie_about_me_widget_init' ) ) :
	/**
	 * Register the widget for use in Appearance -> Widgets
	 */
	add_action( 'widgets_init', 'amelie_about_me_widget_init' );
	function amelie_about_me_widget_init() {
		register_widget( 'Amelie_About_Me_Widget' );
	}
endif;

if ( ! class_exists( 'Amelie_About_Me_Widget' ) ) :

	class Amelie_About_Me_Widget extends WP_Widget {
		var $default_title = '';

		/**
		 * Register widget with WordPress.
		 */
		public function __construct() {
			parent::__construct(
				'amelie-about-me',
				apply_filters( 'amelie_widget_name', esc_html__( 'Amelie About Me', 'amelie_txtd' ) ),
				array(
					'classname'   => 'widget_amelie_about_me',
					'description' => __( 'Display some info about you with an image background.', 'amelie_txtd' )
				)
			);

			$this->default_title = __( 'About Me', 'amelie_txtd' );

			add_action( 'admin_init', array( $this, 'admin_init' ) );
		}

		/**
		 * Front-end display of widget.
		 *
		 * @see WP_Widget::widget()
		 *
		 * @param array $args Widget arguments.
		 * @param array $instance Saved values from database.
		 */
		public function widget( $args, $instance ) {

			$instance = wp_parse_args( $instance, array(
				'title'   => '',
				'name'    => '',
				'text'    => '',
			) );

			echo $args['before_widget'] . PHP_EOL;

			// The Background Image - empty string in case of error
			echo wp_get_attachment_image( $instance['image_id'], 'amelie-masonry-image' ) . PHP_EOL;

			echo '<div class="amelie-about-me-widget__container">' . PHP_EOL;


			// The widget title
			$title = apply_filters( 'widget_title', $instance['title'], $instance, $this->id_base );
			if ( ! empty( $title ) ) {
				echo $args['before_title'] . $title . $args['after_title'] . PHP_EOL;
			}

			// The author's name
			if ( ! empty( $instance['name'] ) ) {
				echo '<div class="amelie-about-me-widget__name">' . $instance['name'] . '</div>' . PHP_EOL;
			}

			echo '<hr class="separator--line"/>' . PHP_EOL;

			// About the author
			if ( ! empty( $instance['filter'] ) ) {
				$text = wpautop($instance['text']);
			} else {
				$text = $instance['text'];
			}
			echo '<div class="amelie-about-me__text">' . $text . '</div>' . PHP_EOL;

			echo '</div><!-- .amelie-about-me-widget-container -->' . PHP_EOL;

			echo $args['after_widget'] . PHP_EOL;
		}

		/**
		 * Sanitize widget form values as they are saved.
		 *
		 * @see WP_Widget::update()
		 *
		 * @param array $new_instance Values just sent to be saved.
		 * @param array $old_instance Previously saved values from database.
		 *
		 * @return array Updated safe values to be saved.
		 */
		public function update( $new_instance, $old_instance ) {

			$instance = $old_instance;

			$instance['title']    = wp_strip_all_tags( $new_instance['title'] );
			$instance['name']     = wp_strip_all_tags( $new_instance['name'] );
			$instance['image_id'] = absint( $new_instance['image_id'] );
			$instance['text']     = stripslashes( wp_filter_post_kses( addslashes( $new_instance['text'] ) ) );
			$instance['filter']   = isset( $new_instance['filter'] );

			return $instance;
		}

		/**
		 * Back-end widget form.
		 *
		 * @see WP_Widget::form()
		 *
		 * @param array $instance Previously saved values from database.
		 */
		public function form( $instance ) {
			$instance = wp_parse_args(
				(array) $instance,
				array(
					'image_id' => '',
					'title'    => '',
					'name'     => '',
					'text'     => '',
				)
			);

			$title = isset( $instance['title'] ) ? $instance['title'] : false;
			if ( false === $title ) {
				$title = $this->default_title;
			}

			$image_id     = $instance['image_id'];

			$name = $instance['name'];
			$text = $instance['text'];
			?>

			<div class="amelie-about-me-widget-form">
				<p>
					<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php _e( 'Title:', 'amelie_txtd' ); ?></label>
					<input class="widefat" type="text" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" value="<?php echo esc_attr( $title ); ?>">
				</p>

				<p class="amelie-about-me-widget-image-control<?php echo ( $image_id ) ? ' has-image' : ''; ?>"
				   data-title="<?php esc_attr_e( 'Choose an Background Image', 'amelie_txtd' ); ?>"
				   data-update-text="<?php esc_attr_e( 'Update Image', 'amelie_txtd' ); ?>">
					<?php
					if ( ! empty( $image_id ) ) {
						echo wp_get_attachment_image( $image_id, 'medium', false );
					}
					?>
					<input class="amelie-about-me-image-id" type="hidden" name="<?php echo esc_attr( $this->get_field_name( 'image_id' ) ); ?>" id="<?php echo esc_attr( $this->get_field_id( 'image_id' ) ); ?>" value="<?php echo esc_attr( $image_id ); ?>">
					<a class="button amelie-about-me-widget-image-control__choose" href="#"><?php _e( 'Choose an Background Image', 'amelie_txtd' ); ?></a>
				</p>

				<p>
					<label for="<?php echo esc_attr( $this->get_field_id( 'name' ) ); ?>"><?php _e( 'Your Name:', 'amelie_txtd' ); ?></label>
					<input class="widefat" type="text" name="<?php echo esc_attr( $this->get_field_name( 'name' ) ); ?>" id="<?php echo esc_attr( $this->get_field_id( 'name' ) ); ?>" value="<?php echo esc_attr( $name ); ?>">
				</p>

				<p>
					<label for="<?php echo esc_attr( $this->get_field_id( 'text' ) ); ?>"><?php _e( 'About You:', 'amelie_txtd' ); ?></label>
					<textarea class="widefat" name="<?php echo esc_attr( $this->get_field_name( 'text' ) ); ?>" id="<?php echo esc_attr( $this->get_field_id( 'text' ) ); ?>" rows="4"><?php echo esc_textarea( $text ); ?></textarea>
				</p>

				<p>
					<input id="<?php echo $this->get_field_id( 'filter' ); ?>" name="<?php echo $this->get_field_name( 'filter' ); ?>" type="checkbox" <?php checked( isset( $instance['filter'] ) ? $instance['filter'] : 0 ); ?> />&nbsp;<label for="<?php echo $this->get_field_id( 'filter' ); ?>"><?php _e( 'Automatically add paragraphs', 'amelie_txtd' ); ?></label>
				</p>

			</div>
		<?php
		}

		public function admin_init() {
			global $pagenow;

			if ( 'widgets.php' == $pagenow ) {
				wp_enqueue_media();

				wp_enqueue_script( 'amelie-about-me-widget-admin', get_template_directory_uri() . '/inc/widgets/assets/js/about-me.js', array(
					'media-upload',
					'media-views'
				) );

				wp_localize_script(
					'amelie-about-me-widget-admin',
					'AmelieAboutMeWidget',
					array(
						'l10n' => array(
							'frameTitle'      => __( 'Choose an Background Image', 'amelie_txtd' ),
							'frameUpdateText' => __( 'Update Background Image', 'amelie_txtd' ),
						),
					)
				);

				if ( is_rtl() ) {
					wp_enqueue_style( 'amelie-about-me-widget-admin', get_template_directory_uri() . '/inc/widgets/assets/css/about-me-rtl.css' );
				} else {
					wp_enqueue_style( 'amelie-about-me-widget-admin', get_template_directory_uri() . '/inc/widgets/assets/css/about-me.css' );
				}
			}
		}
	} // Class Amelie About Me Widget

endif; ?>