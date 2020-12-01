<?php
/**
 * Friends Header Widget
 *
 * A widget that allows you to define the header for your own friends page.
 *
 * @package Friends
 * @since 0.8
 */

/**
 * This is the class for the Friends Header Widget.
 *
 * @package Friends
 * @author Alex Kirk
 */
class Friends_Widget_Header extends WP_Widget {
	/**
	 * Constructor
	 */
	public function __construct() {
		parent::__construct(
			'friends-widget-header',
			__( 'Friends Header', 'friends' ),
			array(
				'description' => __( 'The header for your friends page.', 'friends' ),
			)
		);
	}

	/**
	 * Render the widget.
	 *
	 * @param array $args Sidebar arguments.
	 * @param array $instance Widget instance settings.
	 */
	public function widget( $args, $instance ) {
		$instance = wp_parse_args( $instance, $this->defaults() );
		$friends = Friends::get_instance();

		$title = apply_filters( 'friends_header_widget_title', $instance['title'] );
		$title = apply_filters( 'widget_title', $title );
		echo $args['before_widget'];
		if ( ! empty( $title ) ) {
			echo $args['before_title'] . $title . $args['after_title'];
		}

		?><div id="post-format-switcher">
			<select name="post-format">
				<option value=""><?php _e( 'All Posts', 'friends' ); ?></option>
				<?php foreach ( get_post_format_strings() as $format => $title ) : ?>
					<option value="<?php echo esc_attr( $format ); ?>"><?php echo esc_attr( $title ); ?></option>
				<?php endforeach; ?>
			</select>
			</div>

			<?php if ( $friends->frontend->author ) : ?>
				<p>
				<?php
				echo wp_kses(
					// translators: %1$s is a site name, %2$s is a URL.
					sprintf( __( 'Visit %1$s. Back to <a href=%2$s>your friends page</a>.', 'friends' ), '<a href="' . esc_url( $friends->frontend->author->user_url ) . '" class="auth-link" data-token="' . esc_attr( get_user_option( 'friends_out_token', $friends->frontend->author->ID ) ) . '">' . esc_html( $friends->frontend->author->display_name ) . '</a>', '"' . esc_attr( site_url( '/friends/' ) ) . '"' ),
					array(
						'a' => array(
							'href'       => array(),
							'class'      => array(),
							'data-token' => array(),
						),
					)
				);
				?>
				</p>
			<?php endif; ?>

		<?php
		echo $args['after_widget'];
	}

	/**
	 * Widget configuration form.
	 *
	 * @param array $instance The current settings.
	 */
	public function form( $instance ) {
		$instance = array_merge( $this->defaults(), $instance );
		?>
		<p>
		<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label>
		<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $instance['title'] ); ?>" />
		</p>
		<p>
		<input id="<?php echo $this->get_field_id( 'show_post_formats' ); ?>" name="<?php echo $this->get_field_name( 'show_post_formats' ); ?>" type="checkbox" value="1"<?php checked( $instance['show_post_formats'] ); ?> /> <label for="<?php echo $this->get_field_id( 'show_post_formats' ); ?>"><?php _e( 'Show Post Formats', 'friends' ); ?></label>

		</p>
		<?php
	}

	/**
	 * Update widget configuration.
	 *
	 * @param array $new_instance New settings.
	 * @param array $old_instance Old settings.
	 * @return array Sanitized instance settings.
	 */
	public function update( $new_instance, $old_instance ) {
		$instance = array();
		$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
		$instance['show_post_formats'] = isset( $new_instance['show_post_formats'] ) && $new_instance['show_post_formats'];
		return $instance;
	}

	/**
	 * Return an associative array of default values
	 *
	 * These values are used in new widgets.
	 *
	 * @return array Array of default values for the Widget's options
	 */
	public function defaults() {
		return array(
			'title'             => __( 'Friends', 'friends' ),
			'show_post_formats' => true,
		);
	}

	/**
	 * Register this widget.
	 */
	public static function register() {
		register_widget( __CLASS__ );
	}
}
