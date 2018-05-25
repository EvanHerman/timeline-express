<?php
/**
 * Timeline Express :: Base Class
 *
 * @author Code Parrots
 *
 * @link http://www.codeparrots.com
 *
 * @package Timeline_Express
 *
 * @since 1.2
 */

// If the class exists, abort
if ( class_exists( 'TimelineExpressBase' ) ) {

	return;

}

class TimelineExpressBase {

	public function __construct() {

		/* Include helper functions */
		include_once TIMELINE_EXPRESS_PATH . 'lib/helpers.php';

		/* Include Admin Class file */
		include_once TIMELINE_EXPRESS_PATH . 'lib/classes/class-timeline-express-admin.php';

		/* Include Public Class file */
		include_once TIMELINE_EXPRESS_PATH . 'lib/classes/class-timeline-express-public.php';

		/* Include Compatibility Class file */
		include_once TIMELINE_EXPRESS_PATH . 'lib/classes/class-timeline-express-compat.php';

		/* Register our custom timeline express image size (350px x 120px) */
		add_image_size( 'timeline-express', '350', '120', true );

		/* Regiser our custom timeline express thumbnail image size (200px x 120px) - Used in the admin table */
		add_image_size( 'timeline-express-thumbnail', '200', '120', true );

	}

	/**
	 * Plugin activation function
	 */
	public function timeline_express_activate() {

		/* Setup the plugin activation redirect */
		update_option( 'timeline_express_do_activation_redirect', true );

	}

	/**
	 * Plugin deactivation function
	 */
	public function timeline_express_deactivate() {

		/* Clear the re-write rules, so on next activation we can re-flush them */
		delete_option( 'post_type_rules_flushed_te-announcements' );

	}

	/**
	 * Plugin deactivation function
	 */
	public function timeline_express_activate_redirect() {

		/* User can disable the activation redirect, if it gets annoying */
		if ( defined( 'TIMELINE_EXPRESS_DISABLED_ACTIVATION_REDIRECT' ) ) {

			return;

		}

		if ( get_option( 'timeline_express_do_activation_redirect', false ) ) {

			delete_option( 'timeline_express_do_activation_redirect' );

			// Check if this is an update or first install
			$announcement_count = wp_count_posts( 'te_announcements' );

			if ( ! isset( $announcement_count ) || 0 === $announcement_count->publish ) {

				/* Redirect to the welcome page -  Initial install */
				wp_safe_redirect( admin_url( 'admin.php?page=timeline-express-welcome' ) );

			} else {

				/* Redirect to the welcome page (whats new tab)-  Update install */
				wp_safe_redirect( admin_url( 'admin.php?page=timeline-express-welcome&tab=timeline-express-getting-started' ) );

			}
		}

	}

	/**
	 * Sanitize and save our options to the database
	 *
	 * @param   array $options Options array to update.
	 *
	 * @since   1.2
	 */
	public static function timeline_express_save_options( $options ) {

		// When the nonce is not set, abort
		if ( ! isset( $_POST['timeline_express_settings_nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['timeline_express_settings_nonce'] ) ), 'timeline_express_save_settings' ) ) {

			wp_die(
				esc_html__( 'Sorry, the nonce security check did not pass. Please go back to the settings page, refresh the page and try to save your settings again.', 'timeline-express' ),
				__( 'Failed Nonce Security Check', 'timeline-express' ),
				array(
					'response'       => 500,
					'back_link'      => true,
					'text_direction' => ( is_rtl() ) ? 'rtl' : 'ltr',
				)
			);

		}

		/* Retreive our default options to update */
		$timeline_express_options = timeline_express_get_options();

		/* Update our options */
		$timeline_express_options['announcement-time-frame']                     = sanitize_text_field( $options['announcement-time-frame'] );
		$timeline_express_options['announcement-display-order']                  = sanitize_text_field( $options['announcement-display-order'] );
		$timeline_express_options['excerpt-trim-length']                         = (int) sanitize_text_field( $options['excerpt-trim-length'] );
		$timeline_express_options['excerpt-random-length']                       = (int) ( isset( $options['excerpt-random-length'] ) ) ? 1 : 0;
		$timeline_express_options['date-visibility']                             = sanitize_text_field( $options['date-visibility'] );
		$timeline_express_options['read-more-visibility']                        = sanitize_text_field( $options['read-more-visibility'] );
		$timeline_express_options['default-announcement-icon']                   = sanitize_text_field( $options['default-announcement-icon'] );
		$timeline_express_options['default-announcement-color']                  = sanitize_text_field( $options['default-announcement-color'] );
		$timeline_express_options['announcement-bg-color']                       = sanitize_text_field( $options['announcement-bg-color'] );
		$timeline_express_options['announcement-box-shadow-color']               = sanitize_text_field( $options['announcement-box-shadow-color'] );
		$timeline_express_options['announcement-background-line-color']          = sanitize_text_field( $options['announcement-background-line-color'] );
		$timeline_express_options['no-events-message']                           = sanitize_text_field( $options['no-events-message'] );
		$timeline_express_options['announcement-appear-in-searches']             = sanitize_text_field( $options['announcement-appear-in-searches'] );
		$timeline_express_options['delete-announcement-posts-on-uninstallation'] = (int) ( isset( $options['delete-announcement-posts-on-uninstallation'] ) ) ? 1 : 0;
		$timeline_express_options['disable-animation']                           = (int) ( isset( $options['disable-animation'] ) ) ? 1 : 0;

		/* Delete the transient, to refresh the frontend timeline (display order, excerpt length etc.) */
		delete_timeline_express_transients();

		return $timeline_express_options;

	}
}
