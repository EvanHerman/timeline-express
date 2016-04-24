<?php
// Start with an underscore to hide fields from custom fields list
$prefix = 'announcement_';

// setup an empty field type for users to customize
$custom_field = array();

$timeline_express_options = timeline_express_get_options();

/**
 * Initiate the metabox
 */
$announcement_metabox = new_cmb2_box( array(
	'id'            => 'announcement_metabox',
	'title'         => __( 'Announcement Info.', 'timeline-express' ),
	'object_types'  => array( 'te_announcements' ), // Post type
	'context'       => 'advanced',
	'priority'      => 'high',
	'show_names'    => true, // Show field names on the left
) );

// Regular text field
$announcement_metabox->add_field( array(
	'name'       => __( 'Announcement Color', 'timeline-express' ),
	'desc'       => __( 'select the color for this announcement.', 'timeline-express' ),
	'id'         => $prefix . 'color',
	'type'       => 'colorpicker',
	'default'  => $timeline_express_options['default-announcement-color'],
) );

// URL text field
$announcement_metabox->add_field( array(
	'name' => __( 'Announcement Icon', 'timeline-express' ),
	'desc' => __( 'select an icon from the drop down above. This is used for the icon associated with the announcement.', 'timeline-express' ),
	'id'   => $prefix . 'icon',
	'type' => 'te_bootstrap_dropdown',
	'default' => 'fa-' . $timeline_express_options['default-announcement-icon'],
) );

// Email text field
$announcement_metabox->add_field( array(
	'name' => __( 'Announcement Date', 'timeline-express' ),
	'desc' => __( 'enter the date of the announcement. the announcements will appear in chronological order according to this date. ', 'timeline-express' ),
	'id'   => $prefix . 'date',
	'type' => 'te_date_time_stamp_custom',
	'default' => strtotime( date( 'm/d/Y' ) ),
) );

// Email text field
$announcement_metabox->add_field( array(
	'name' => __( 'Announcement Image', 'timeline-express' ),
	'desc' => __( 'select a banner image for this announcement (optional). (recommended 650px wide or larger)  ', 'timeline-express' ),
	'id'   => $prefix . 'image',
	'type' => 'file',
) );

/**
 * Initiate the sidebar metaboxs
 */

/**
 * Documentation sidebar Metabox
 */
$help_docs_metabox = new_cmb2_box( array(
	'id'            => 'help_docs_metabox',
	'title'         => __( 'Help & Documentation', 'timeline-express' ),
	'object_types'  => array( 'te_announcements' ),
	'context'    => 'side',
	'priority'   => 'low',
	'show_names'    => true,
) );

// Email text field
$help_docs_metabox->add_field( array(
	'name' => __( '', 'timeline-express' ),
	'desc' => __( '', 'timeline-express' ),
	'id'   => $prefix . 'help_docs',
	'type' => 'te_help_docs_metabox',
) );


/**
 * Check for our RSS feed transient
 * - if not found - execute the RSS Feed
 */
if ( false === ( $te_ad_rss_feed = get_transient( 'timeline_express_ad_rss_feed' ) ) ) {
	/* Get RSS Feed(s) */
	require_once( ABSPATH . WPINC . '/class-feed.php' );
	/* Create the SimplePie object */
	$feed = new SimplePie();
	/* Setup the URL */
	$feed_url = esc_url( 'http://www.wp-timelineexpress.com/?feed=ads' );
	/* Pass the URL */
	$feed->set_feed_url( $feed_url );
	/* Retreive last 3 advertisments */
	$feed->set_item_limit( 1 );
	/* Tell SimplePie to cache the feed using WordPress' cache class */
	$feed->set_cache_class( 'WP_Feed_Cache' );
	/* Tell SimplePie to use the WordPress class for retrieving feed files */
	$feed->set_file_class( 'WP_SimplePie_File' );
	$feed->enable_cache( true );
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
	$te_ad_rss_feed = $feed->get_items();
	// setup the transients
	if ( 0 < count( $te_ad_rss_feed ) ) {
		$ad_title = $te_ad_rss_feed[0]->get_title();
		$ad_image = $te_ad_rss_feed[0]->get_item_tags( '', 'customImage' );
		$ad_content = $te_ad_rss_feed[0]->get_item_tags( '', 'customContent' );
		$ad_link = $te_ad_rss_feed[0]->get_item_tags( '', 'productLink' );

		// store the data for later
		set_transient( 'timeline_express_ad_title', $ad_title );
		set_transient( 'timeline_express_ad_image', $ad_image[0]['child'][ null ]['img'][0]['attribs'][ null ]['src'] );
		set_transient( 'timeline_express_ad_content', $ad_content[0]['data'] );
		set_transient( 'timeline_express_ad_url', $ad_link[0]['data'] );
		// cache used for comparison
		set_transient( 'timeline_express_ad_rss_feed', $te_ad_rss_feed );
	}
}

/**
 * Render the Advertisment metabox when an RSS feed is Found
 * @since 1.0
 */
if ( $te_ad_rss_feed ) {
	// Create our advertisment metaboxes
	$advert_metabox = new_cmb2_box( array(
		'id'            => 'timeline_express_ads',
		'title'         => get_transient( 'timeline_express_ad_title' ),
		'object_types'  => array( 'te_announcements' ),
		'context'    => 'side',
		'priority'   => 'low',
		'show_names'    => true,
	) );

	// Advertisment Metabox Field
	$advert_metabox->add_field( array(
		'name' => __( '', 'timeline-express' ),
		'desc' => __( '', 'timeline-express' ),
		'id'   => $prefix . 'advertisments',
		'type' => 'te_advert_metabox',
	) );
}

// Filter here is to allow extra fields to be added
// loop to add fields to our array
$custom_fields = apply_filters( 'timeline_express_custom_fields', $custom_field );
$i = 0;
// first, check if any custom fields are defined...
if ( ! empty( $custom_fields ) ) {
	foreach ( $custom_fields as $user_defined_field ) {
		// Email text field
		$announcement_metabox->add_field( array(
			'name' => $custom_fields[ $i ]['name'],
			'desc' => $custom_fields[ $i ]['desc'],
			'id'   => $custom_fields[ $i ]['id'],
			'type' => $custom_fields[ $i ]['type'],
		) );
		$i++;
	}
}
