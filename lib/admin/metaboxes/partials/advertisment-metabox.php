<?php
/**
 * Timeline Express Support Metabox template
 *
 * @package Timeline Express
 * @since 1.2
 */

/* Get RSS Feed(s) */
require_once( ABSPATH . WPINC . '/class-feed.php' );
/* Create the SimplePie object */
$feed = new SimplePie();

/* Setup the URL */
$feed_url = esc_url( 'http://www.wp-timelineexpress.com/feed/timeline-express-ads' );

/* Pass the URL */
$feed->set_feed_url( $feed_url );

/* Retreive last 3 advertisments */
$feed->set_item_limit( 3 );

/* Tell SimplePie to cache the feed using WordPress' cache class */
$feed->set_cache_class( 'WP_Feed_Cache' );

/* Tell SimplePie to use the WordPress class for retrieving feed files */
$feed->set_file_class( 'WP_SimplePie_File' );
$feed->enable_cache( false ); // temporary

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

$ads = $feed->get_items();

/* Randomize the feed, so a different item appears at random */
shuffle( $ads );

/* Loop and setup the ad */
foreach ( $ads as $add_on ) {
	$addon_title = $add_on->get_title();
	/* Set the transient to use in the metbaox title */
	set_transient( 'timeline_express_advert_metabox_title', esc_attr__( $addon_title ), 12 * HOUR_IN_SECONDS );
	$ad_image = $add_on->get_item_tags( '', 'customImage' );
	$ad_content = $add_on->get_item_tags( '', 'customContent' );
	echo '<img src="' . esc_url( $ad_image[0]['child'][ null ]['img'][0]['attribs'][ null ]['src'] ) . '" style="max-width:100%;" />';
	echo '<p class="description" style="margin:8px 0 0 0;">' . esc_attr__( $ad_content[0]['data'] ) . '</p>';
	echo '<a href="#" target="_blank" class="button button-primary">' . esc_attr__( 'View Addon', 'timeline-express' ) . '</a>';
}
