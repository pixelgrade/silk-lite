<?php
/**
 * Silk Lite About Me widget
 *
 * @package Silk Lite
 */

if ( ! function_exists( 'silk_about_me_widget_init' ) ) :
	/**
	 * Register the widget for use in Appearance -> Widgets
	 */
	add_action( 'widgets_init', 'silk_about_me_widget_init' );
	function silk_about_me_widget_init() {
		register_widget( 'SilkLite_About_Me_Widget' );
	}
endif;

if ( ! class_exists( 'SilkLite_About_Me_Widget' ) ) :

	class SilkLite_About_Me_Widget extends WP_Widget {
		var $default_title = '';

		/**
		 * Register widget with WordPress.
		 */
		public function __construct() {
			parent::__construct(
				'silklite-about-me',
				apply_filters( 'silk_widget_name', esc_html__( 'Silk Lite About Me', 'silk-lite' ) ),
				array(
					'classname'   => 'widget_silk_about_me',
					'description' => esc_html__( 'Display some info about you with an image background.', 'silk-lite' )
				)
			);

			$this->default_title = esc_html__( 'About Me', 'silk-lite' );

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

			$args['before_widget'] = substr( $args['before_widget'], 0, -1 ) . ' tabindex="0">';
			echo $args['before_widget'] . "\n";

			// The Background Image - empty string in case of error
			$thumb = wp_get_attachment_image_src( $instance['image_id'], 'silk-masonry-image' );
			if ( false !== $thumb ) {
				$thumb = $thumb[0];
			} else {
				$thumb = '';
			}
			echo '<div class="silk-about-me-widget__image" style="background-image: url('. $thumb .');"></div>' . "\n";

			echo '<div class="silk-about-me-widget__container">' . "\n";


			// The widget title
			$title = apply_filters( 'widget_title', $instance['title'], $instance, $this->id_base );
			if ( ! empty( $title ) ) {
				echo $args['before_title'] . $title . $args['after_title'] . "\n";
			}

			// The author's name
			if ( ! empty( $instance['name'] ) ) {
				echo '<div class="silk-about-me-widget__name">' . $instance['name'] . '</div>' . "\n";
			}

			echo '<span class="separator separator-wrapper--white">';
			get_template_part( 'assets/svg/separator-simple' );
			echo '</span>';

			// About the author
			if ( ! empty( $instance['filter'] ) ) {
				$text = wpautop( $instance['text'] );
			} else {
				$text = $instance['text'];
			}
			echo '<div class="silk-about-me__text">' . $text . '</div>' . "\n";

			echo '</div><!-- .silk-about-me-widget-container -->' . "\n";

			echo $args['after_widget'] . "\n";

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

			<div class="silk-about-me-widget-form">
				<p>
					<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php _e( 'Title:', 'silk-lite' ); ?></label>
					<input class="widefat" type="text" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" value="<?php echo esc_attr( $title ); ?>">
				</p>

				<p class="silk-about-me-widget-image-control<?php echo ( $image_id ) ? ' has-image' : ''; ?>"
				   data-title="<?php esc_attr_e( 'Choose an Background Image', 'silk-lite' ); ?>"
				   data-update-text="<?php esc_attr_e( 'Update Image', 'silk-lite' ); ?>">
					<?php
					if ( ! empty( $image_id ) ) {
						echo wp_get_attachment_image( $image_id, 'medium', false );
					}
					?>
					<input class="silk-about-me-image-id" type="hidden" name="<?php echo esc_attr( $this->get_field_name( 'image_id' ) ); ?>" id="<?php echo esc_attr( $this->get_field_id( 'image_id' ) ); ?>" value="<?php echo esc_attr( $image_id ); ?>">
					<a class="button silk-about-me-widget-image-control__choose" href="#"><?php esc_html_e( 'Choose an Background Image', 'silk-lite' ); ?></a>
				</p>

				<p>
					<label for="<?php echo esc_attr( $this->get_field_id( 'name' ) ); ?>"><?php esc_html_e( 'Your Name:', 'silk-lite' ); ?></label>
					<input class="widefat" type="text" name="<?php echo esc_attr( $this->get_field_name( 'name' ) ); ?>" id="<?php echo esc_attr( $this->get_field_id( 'name' ) ); ?>" value="<?php echo esc_attr( $name ); ?>">
				</p>

				<p>
					<label for="<?php echo esc_attr( $this->get_field_id( 'text' ) ); ?>"><?php esc_html_e( 'About You:', 'silk-lite' ); ?></label>
					<textarea class="widefat" name="<?php echo esc_attr( $this->get_field_name( 'text' ) ); ?>" id="<?php echo esc_attr( $this->get_field_id( 'text' ) ); ?>" rows="4"><?php echo esc_textarea( $text ); ?></textarea>
				</p>

				<p>
					<input id="<?php echo $this->get_field_id( 'filter' ); ?>" name="<?php echo $this->get_field_name( 'filter' ); ?>" type="checkbox" <?php checked( isset( $instance['filter'] ) ? $instance['filter'] : 0 ); ?> />&nbsp;<label for="<?php echo $this->get_field_id( 'filter' ); ?>"><?php esc_html_e( 'Automatically add paragraphs', 'silk-lite' ); ?></label>
				</p>

			</div>
		<?php
		}

		public function admin_init() {
			global $pagenow;

			if ( 'widgets.php' == $pagenow ) {
				//the scripts are enqueued on wp_enqueue_media - see functions.php
				wp_enqueue_media();

				if ( is_rtl() ) {
					wp_enqueue_style( 'silk-about-me-widget-admin', get_template_directory_uri() . '/inc/widgets/assets/css/about-me-rtl.css' );
				} else {
					wp_enqueue_style( 'silk-about-me-widget-admin', get_template_directory_uri() . '/inc/widgets/assets/css/about-me.css' );
				}
			}
		}

	} // Class Silk About Me Widget

endif; ?>