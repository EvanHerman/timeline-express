<?php
/**
 * Display an admin notice after 2 weeks of installation
 *
 * @since 1.3.0
 */
class Timeline_Express_Two_Weeks_Notice {

	public function __construct() {

		$this->init();

	}

	public function init() {

		if ( get_option( 'timeline-express_rating_nobug', false ) ) {

			return;

		}

		if ( ! get_option( 'timeline_express_install_date' ) ) {

			update_option( 'timeline_express_install_date', strtotime( 'now' ) );

		}

		add_action( 'admin_notices', array( $this, 'admin_notice' ) );
		add_action( 'admin_init', array( $this, 'dismiss_rating_notice' ), 10 );

	}

	/**
	 * Display the admin notice
	 *
	 * @since 1.3.0
	 */
	public function admin_notice() {

		$screen = get_current_screen();

		if ( ! isset( $screen->post_type ) || 'te_announcements' !== $screen->post_type ) {

			return;

		}

		$two_weeks_after_install = strtotime( '+2 weeks', get_option( 'timeline_express_install_date', strtotime( 'now' ) ) );

		if ( $two_weeks_after_install > strtotime( 'now' ) ) {

			return;

		}

		if ( current_user_can( 'manage_options' ) ) {

			printf(
				'<div class="notice notice-info codeparrots-2-week-notice">
					<p>%s</p>
				</div>',
				wp_kses_post( $this->get_message() )
			);

		}

	}

	/**
	 * Dismiss the two week notice
	 *
	 * @since 1.3.0
	 */
	public function dismiss_rating_notice() {

		$rating_nobug = filter_input( INPUT_GET, 'timeline_express_rating_nobug', FILTER_SANITIZE_STRING );

		if ( ! $rating_nobug || 'true' !== $rating_nobug ) {

			return;

		}

		update_option( 'timeline-express_rating_nobug', '1' );

		wp_redirect( $_SERVER['HTTP_REFERER'], '200' );

		exit;

	}

	/**
	 * Retrieve the message for the admin notice
	 *
	 * @return string
	 *
	 * @since 1.3.0
	 */
	public function get_message() {

		return sprintf(
			'%1$s
			<p>
				<a href="https://wordpress.org/support/plugin/timeline-express/reviews/" target="_blank" class="button-primary">
					%2$s
				</a>
				<a href="https://www.wp-timelineexpress.com/pricing/" target="_blank" class="button-secondary">
					%3$s
				</a>
				<a href="%4$s" class="button-secondary">
					%5$s
				</a>
				<a href="%6$s" class="button-secondary">
					%7$s
				</a>
			</p>',
			esc_html__( 'It looks like you have been using Timeline Express for two weeks now. If you are enjoying the plugin we would love it if you could leave us a 5 star review!', 'timeline-express' ),
			esc_html__( 'Leave a Review', 'timeline-express' ),
			esc_html__( 'Upgrade to Pro', 'timeline-express' ),
			esc_url( admin_url( 'edit.php?post_type=te_announcements&page=timeline-express-addons' ) ),
			esc_html__( 'View Add-Ons', 'timeline-express' ),
			esc_url( $this->get_dismissal_url() ),
			esc_html__( 'Dismiss', 'timeline-express' )
		);

	}

	/**
	 * Get the URL for the admin notice dismissible
	 *
	 * @return string
	 *
	 * @since 1.3.0
	 */
	public function get_dismissal_url() {

		return add_query_arg(
			array(
				'timeline_express_rating_nobug' => 'true',
			)
		);

	}

}
