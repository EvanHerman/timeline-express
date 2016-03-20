<?php
/**
 * Timeline Express :: Addons Page Class
 * By Code Parrots
 *
 * @link http://www.codeparrots.com
 *
 * @package WordPress
 * @subpackage Component
 * @since 1.2
 **/

class Timeline_Express_Addons {
	/**
	 * Main constructor
	 */
	public function __construct() {
		$this->render_addons_page();
	}

	/**
	 * Render the addons page content
	 *
	 * @return string addons page contents
	 */
	public function render_addons_page() {
		ob_start();
		include_once( TIMELINE_EXPRESS_PATH . 'lib/admin/pages/page.addons.php' );
		return ob_get_contents();
	}

	/**
	 * Query the main site for our add-ons
	 *
	 * @return array RSS add-on items returned from our site.
	 */
	private function get_addons_rss_feed() {
		/* Get RSS Feed(s) */
		require_once( ABSPATH . WPINC . '/class-feed.php' );
		/* Create the SimplePie object */
		$feed = new SimplePie();
		$feed_url = esc_url( 'https://evan-herman.com/feed/?post_type=download&download_category=timeline-express&download_tag=addon' );
		/* Set the URL of the feed you're retrieving */
		$feed->set_feed_url( $feed_url );
		/* Tell SimplePie to cache the feed using WordPress' cache class */
		$feed->set_cache_class( 'WP_Feed_Cache' );
		/* Tell SimplePie to use the WordPress class for retrieving feed files */
		$feed->set_file_class( 'WP_SimplePie_File' );
		$feed->enable_cache( true ); // temporary
		/* Tell SimplePie how long to cache the feed data in the WordPress database */
		$feed->set_cache_duration( apply_filters( 'wp_feed_cache_transient_lifetime', 43200, $feed_url ) );
		/* Run any other functions or filters that WordPress normally runs on feeds */
		do_action_ref_array( 'wp_feed_options', array( $feed, $feed_url ) );
		/* Initiate the SimplePie instance */
		$feed->init();
		/* Tell SimplePie to send the feed MIME headers */
		$feed->handle_content_type();
		if ( $feed->error() ) {
			return $feed = new WP_Error( 'simplepie-error', $feed->error() );
		}
		return $feed->get_items();
	}
}
new Timeline_Express_Addons;
