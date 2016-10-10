<?php
/**
 * Display an admin notice after 2 weeks of installation
 *
 * @since 1.3
 */
class Timeline_Express_Two_Weeks_Notice {

	public function init() {

		if ( get_option( 'timeline-express_rating_nobug', false ) ) {

			return;

		}

		if ( ! get_option( 'timeline_express_install_date' ) ) {

			update_option( 'timeline_express_install_date', strtotime( 'now' ) );

		}

		add_action( 'admin_notices', array( $this, 'admin_notice' ) );
		add_action( 'admin_init',    array( $this, 'dismiss_rating_notice' ), 10 );

	}

	public function admin_notice() {

		$screen = get_current_screen();

		if ( ! isset( $screen->post_type ) || 'te_announcements' !== $screen->post_type ) {

			return;

		}

		$install_date            = get_option( 'timeline_express_install_date', strtotime( 'now' ) );

		$two_weeks_after_install = strtotime( '+2 weeks', $install_date );

		if ( $two_weeks_after_install > strtotime( 'now' ) ) {

			return;

		}

		if( current_user_can( 'manage_options' ) ) {

			?>

			<div class="notice notice-info codeparrots-tracking-notice">
				<p><?php echo wp_kses_post( $this->get_message() ); ?></p>
			</div>

			<?php

		}

		return;

	}

	public function dismiss_rating_notice() {

		$rating_nobug = ( filter_input( INPUT_GET, 'timeline_express_rating_nobug' ) ) ? filter_input( INPUT_GET, 'timeline_express_rating_nobug', FILTER_SANITIZE_STRING ) : false;

		if ( ! $rating_nobug || 'true' !== $rating_nobug ) {

			return;

		}

		update_option( 'timeline-express_rating_nobug', '1' );

	}

	/**
	 * Retrieve the message for the admin notice.
	 *
	 * @return string
	 */
	public function get_message() {

		$message = esc_html__( 'It looks like you have been enjoying Timeline Express for 2 weeks now! If you are enjoying the plugin we would love it if you could leave us a 5 star review in the WordPress.org repsository!', 'timeline-express' );

		$message .= ' <p><a href="https://wordpress.org/support/plugin/timeline-express/reviews/" target="_blank" class="button-primary">'. esc_html__( 'Leave a Review', 'timeline-express' ) .'</a>';

		$message .= ' <a href="https://www.wp-timelineexpress.com/pricing/" target="_blank" class="button-secondary">'. esc_html__( 'Upgrade to Pro', 'timeline-express' ) .'</a>';

		$message .= ' <a href="'. esc_url( admin_url( 'edit.php?post_type=te_announcements&page=timeline-express-addons' ) ) .'" class="button-secondary">'. esc_html__( 'View Add-Ons', 'timeline-express' ) .'</a>';

		$message .= ' <a href="'. esc_url( $this->get_dismissal_url() ) .'" class="button-secondary">'. esc_html__( 'Dismiss', 'timeline-express' ) .'</a></p>';

		return $message;

	}

	/**
	 * Get the URL for the admin notice dismissabl
	 *
	 * @return string
	 */
	public function get_dismissal_url() {

		return add_query_arg( array( 'timeline_express_rating_nobug' => 'true' ), admin_url() );

	}


}
$timeline_express_two_week_notice = new Timeline_Express_Two_Weeks_Notice;
