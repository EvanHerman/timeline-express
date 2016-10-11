<?php
/**
 * WP Plugin Usage Tracker.
 *
 * Copyright (c) 2016 Code Parrots
 *
 * WP Plugin Usage Tracker is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 2 of the License, or
 * any later version.
 *
 * WP Plugin Usage Tracker is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * @author     Code Parrots
 * @version    1.0.0
 * @copyright  (c) 2016 Code Parrots
 * @license    http://www.gnu.org/licenses/gpl-2.0.txt GNU LESSER GENERAL PUBLIC LICENSE
 * @package    wp-plugin-usage-tracker
*/

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) exit;

use KeenIO\Client\KeenIOClient;

/**
 * WP_Plugin_Usage_Tracker class.
 */
class WP_Plugin_Usage_Tracker {

	/**
	 * Prefix of the plugin using this library.
	 * @var string
	 */
	private $plugin_prefix;

	/**
	 * Plugin name identifier that will be sent to Keen.io
	 * @var string
	 */
	private $plugin_name;

	/**
	 * Keen.io Project ID.
	 * @var string
	 */
	private $project_id;

	/**
	 * Keen.io Writekey.
	 * @var string
	 */
	private $write_key;

	/**
	 * Keen.io Client.
	 * @var object
	 */
	public $client;

	/**
	 * Get things started.
	 *
	 * @since 1.3
	 */
	public function __construct() {

		$this->plugin_prefix     = sanitize_title( 'timeline-express' );
		$this->plugin_name       = strip_tags( 'Timeline Express' );
		$this->project_id        = TIMELINE_EXPRESS_TRACKING_PROJECT_ID;
		$this->write_key         = TIMELINE_EXPRESS_TRACKING_WRITE_KEY;

		require __DIR__ . '/vendor/autoload.php';

		$this->client = KeenIOClient::factory(
			array(
				'projectId' => $this->project_id,
				'writeKey'  => $this->write_key
			)
		);

	}

	/**
	 * Run hooks.
	 *
	 * @return void
	 */
	public function init() {

		add_action( 'admin_notices', array( $this, 'admin_notice' ) );
		add_action( 'admin_init',    array( $this, 'approve_tracking' ), 10 );
		add_action( 'admin_init',    array( $this, 'schedule_tracking' ), 10 );

		if( $this->is_tracking_enabled() ) {

			add_filter( 'cron_schedules', array( $this, 'cron_schedules' ) );

			add_action( $this->plugin_prefix.'_usage_tracking', array( $this, 'track' ) );

		}

	}

	/**
	 * Show admin notice.
	 *
	 * @return void
	 */
	public function admin_notice() {

		if ( get_option( $this->plugin_prefix . '_nobug', false ) ) {

			return;

		}

		if ( ! function_exists( 'get_current_screen' ) ) {

			require_once(ABSPATH . 'wp-admin/includes/screen.php');

		}

		$screen = get_current_screen();

		if ( ! isset( $screen->post_type ) || 'te_announcements' !== $screen->post_type ) {

			return;

		}

		if( current_user_can( 'manage_options' ) && ! $this->is_tracking_enabled() ) {

			?>

			<div class="notice notice-info codeparrots-tracking-notice">
				<p><?php echo wp_kses_post( $this->get_message() ); ?></p>
			</div>

			<?php

		}

	}

	/**
	 * Retrieve the message for the admin notice.
	 *
	 * @return string
	 */
	public function get_message() {

		$message = esc_html__( 'Allow Timeline Express to track plugin usage? Tracking will help improve Timeline Express by allowing us to gather anonymous usage data so we know which configurations, plugins and themes to test with. No sensitive data is tracked.', 'timeline-express' );

		$message .= ' <p><a href="'. esc_url( $this->get_tracking_approval_url() ) .'" class="button-primary">'. esc_html__( 'Allow', 'timeline-express' ) .'</a>';

		$message .= ' <a href="'. esc_url( $this->get_tracking_denied_url() ) .'" class="button-secondary">'. esc_html__( 'Do not allow', 'timeline-express' ) .'</a></p>';

		return $message;

	}

	/**
	 * Get the url of the approval button.
	 *
	 * @return string
	 */
	protected function get_tracking_approval_url() {

		return add_query_arg( array( 'timeline_express_tracker' => 'approved', 'plugin' => $this->plugin_prefix ), admin_url() );

	}

	/**
	 * Get the url of the approval button.
	 *
	 * @return string
	 */
	protected function get_tracking_denied_url() {

		return add_query_arg( array( 'timeline_express_tracker' => 'denied', 'plugin' => $this->plugin_prefix ), admin_url() );

	}

	/**
	 * Set the required flags to approve the tracking.
	 *
	 * @return void
	 */
	public function approve_tracking() {

		if(
			isset( $_GET['timeline_express_tracker'] )
			&& $_GET['timeline_express_tracker'] == 'approved'
			&& isset( $_GET['plugin'] )
			&& $_GET['plugin'] == $this->plugin_prefix
			&& current_user_can( 'manage_options' )
		) {

			update_option( $this->plugin_prefix . '_tracking', true );

			wp_redirect( admin_url() );
			exit;

		}

		if(
			isset( $_GET['timeline_express_tracker'] )
			&& $_GET['timeline_express_tracker'] == 'denied'
			&& isset( $_GET['plugin'] )
			&& $_GET['plugin'] == $this->plugin_prefix
			&& current_user_can( 'manage_options' )
		) {

			$this->disable_tracking();

		}

	}

	/**
	 * Retrieves the data to send to Keen.io
	 *
	 * @return array
	 */
	public function get_data() {

		$data = array();

		$data['php_version']    = phpversion();
		$data['wp_version']     = get_bloginfo( 'version' );
		$data['server']         = isset( $_SERVER['SERVER_SOFTWARE'] ) ? $_SERVER['SERVER_SOFTWARE']: '';

		$data['multisite']      = is_multisite();
		$data['theme']          = $this->get_theme_name();
		$data['locale']         = get_locale();
		$data['active_plugins'] = $this->get_active_plugins();

		$data['timeline_express_version'] = TIMELINE_EXPRESS_VERSION_CURRENT;
		$data['timeline_express_type'] = 'Free';

		return $data;

	}

	/**
	 * Retrieve the current theme's name and version.
	 *
	 * @return string
	 */
	private function get_theme_name() {

		$theme_data = wp_get_theme();
		$theme      = $theme_data->Name . ' ' . $theme_data->Version;

		return $theme;

	}

	/**
	 * Get list of activated plugins.
	 *
	 * @return array
	 */
	private function get_active_plugins() {

		$active_plugins = get_option( 'active_plugins', array() );

		return $active_plugins;

	}

	/**
	 * Register a new cron schedule with WP.
	 *
	 * @param  array $schedules existing ones.
	 * @return array
	 */
	public function cron_schedules( $schedules ) {

		$schedules['monthly'] = array(
			'interval' => 30 * DAY_IN_SECONDS,
			'display' => 'Once a month'
		);

		return $schedules;

	}

	/**
	 * Determines whether tracking is enabled for this plugin.
	 *
	 * @return boolean
	 */
	private function is_tracking_enabled() {

		return (bool) get_option( $this->plugin_prefix . '_tracking', false );

	}

	/**
	 * Disables the tracking for a plugin.
	 *
	 * @return void
	 */
	public function disable_tracking() {

		update_option( $this->plugin_prefix . '_nobug', true );
		delete_option( $this->plugin_prefix . '_tracking' );
		wp_clear_scheduled_hook( $this->plugin_prefix.'_usage_tracking' );

	}

	/**
	 * Use this method to schedule the tracking.
	 *
	 * @return void
	 */
	public function schedule_tracking() {

		if( $this->is_tracking_enabled() && ! wp_next_scheduled ( $this->plugin_prefix.'_usage_tracking' ) ) {

			wp_schedule_event( time(), 'monthly', $this->plugin_prefix.'_usage_tracking' );

		}

	}

	/**
	 * Send the data to Keen.io
	 *
	 * @param  array $data the data to send.
	 * @return void
	 */
	private function send_data( $data ) {

		$this->client->addEvent( $this->plugin_name, $data );

	}

	/**
	 * Task triggered by the cron Event.
	 *
	 * @return void
	 */
	public function track() {

		$this->send_data( $this->get_data() );

	}

}
