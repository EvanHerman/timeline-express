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
	'default' => $timeline_express_options['default-announcement-icon'],
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

$advert_metabox_title = ( false === get_transient( 'timeline_express_advert_metabox_title' ) ) ? 'Addon' : get_transient( 'timeline_express_advert_metabox_title' );

$advert_metabox = new_cmb2_box( array(
	'id'            => 'timeline_express_ads',
	'title'         => $advert_metabox_title,
	'object_types'  => array( 'te_announcements' ),
	'context'    => 'side',
	'priority'   => 'low',
	'show_names'    => true,
) );

// Author metabox (custom)
$advert_metabox->add_field( array(
	'name' => __( '', 'timeline-express' ),
	'desc' => __( '', 'timeline-express' ),
	'id'   => $prefix . 'advertisments',
	'type' => 'te_advert_metabox',
) );

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
