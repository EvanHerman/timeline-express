<?php
/**
 * Uninstall our plugin options, and all of our Announcements
 *
 * @package Timeline Express
 * @since 1.2
 */

//if uninstall not called from WordPress exit
if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
	exit();
}

$options = get_option( TIMELINE_EXPRESS_OPTION );

/* If the user has set to delete the announcement on uninstall, do so */
if ( isset( $options['delete-announcement-posts-on-uninstallation'] ) && '1' === $options['delete-announcement-posts-on-uninstallation'] ) {
	global $wpdb;
	/* SQL query for to delete all announcement posts */
	$sql = $wpdb->get_results( $wpdb->prepare( 'DELETE FROM %s WHERE post_type = "te_announcements"', $wpdb->posts ), ARRAY_A );
}

/* Delete Timeline Express options */
delete_option( TIMELINE_EXPRESS_OPTION );

/* For site options in multisite */
delete_site_option( TIMELINE_EXPRESS_OPTION );

/* Delete Our Transients */
delete_transient( 'timeline_express_ad_rss_feed' );
delete_transient( 'timeline_express_ad_title' );
delete_transient( 'timeline_express_ad_image' );
delete_transient( 'timeline_express_ad_content' );
delete_transient( 'timeline_express_ad_url' );
delete_transient( 'te_font_awesome_transient' );
delete_transient( 'timeline-express-query' );
