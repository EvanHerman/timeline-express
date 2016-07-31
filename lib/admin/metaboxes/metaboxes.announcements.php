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
	'desc'       => __( 'Select the color for this announcement.', 'timeline-express' ),
	'id'         => $prefix . 'color',
	'type'       => 'colorpicker',
	'default'  => $timeline_express_options['default-announcement-color'],
) );

// URL text field
$announcement_metabox->add_field( array(
	'name' => __( 'Announcement Icon', 'timeline-express' ),
	'desc' => __( 'Select an icon from the drop down above. This is used for the icon associated with the announcement.', 'timeline-express' ),
	'id'   => $prefix . 'icon',
	'type' => 'te_bootstrap_dropdown',
	'default' => 'fa-' . $timeline_express_options['default-announcement-icon'],
) );

// Announcement Date
$announcement_metabox->add_field( array(
	'name' => __( 'Announcement Date', 'timeline-express' ),
	'desc' => __( 'Enter the date of the announcement. the announcements will appear in chronological order according to this date. ', 'timeline-express' ),
	'id'   => $prefix . 'date',
	'type' => 'te_date_time_stamp_custom',
	'default' => strtotime( date( 'm/d/Y' ) ),
) );

// Announcement Image
$announcement_metabox->add_field( array(
	'name' => __( 'Announcement Image', 'timeline-express' ),
	'desc' => __( 'Select a banner image for this announcement (optional). (recommended 650px wide or larger)', 'timeline-express' ),
	'id'   => $prefix . 'image',
	'type' => 'file',
) );

/**
 * Custom Container Classes Metabox
 * Requires that the user defines a custom contant in functions.php
 * example: defined( 'TIMELINE_EXPRESS_CONTAINER_CLASSES', true )
 * @since 1.2
 */
if ( defined( 'TIMELINE_EXPRESS_CONTAINER_CLASSES' ) && TIMELINE_EXPRESS_CONTAINER_CLASSES ) {
	$announcement_container_metabox = new_cmb2_box( array(
		'id'            => 'announcement_container_metabox',
		'title'         => __( 'Announcement Container Info.', 'timeline-express' ),
		'object_types'  => array( 'te_announcements' ), // Post type
		'context'       => 'advanced',
		'priority'      => 'high',
		'show_names'    => true, // Show field names on the left
	) );

	// Container class
	$announcement_container_metabox->add_field( array(
		'name' => __( 'Custom Container Class', 'timeline-express' ),
		'desc' => __( 'Enter the class that you would like added to this announcement container on the timeline.', 'timeline-express' ),
		'id'   => $prefix . 'container_classes',
		'type' => 'text',
	) );
}

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
	'name' => '',
	'desc' => '',
	'id'   => $prefix . 'help_docs',
	'type' => 'te_help_docs_metabox',
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

// Action hook to allow users to hook in and define new metaboxes
do_action( 'timeline_express_metaboxes', $timeline_express_options );

/**
 * Localize the datepicker fields for international Users
 * @resource https://github.com/WebDevStudios/CMB2-Snippet-Library/blob/master/filters-and-actions/localize-date-format.php
 * @since 1.2.2
 */
add_filter( 'cmb2_localized_data', 'timeline_express_internationalize_datepicker' );
function timeline_express_internationalize_datepicker( $l10n ) {
	switch ( get_option( 'date_format' ) ) {
		// EG: 04/15/2016 - April 15th, 2016
		default:
		case 'm/d/Y':
			$l10n['defaults']['date_picker']['dateFormat'] = 'mm/dd/yy';
			break;
		// EG: 2016-04-15 - April 15th, 2016
		case 'd/m/Y':
		case 'd/M/Y':
		case 'd-m-Y':
			$l10n['defaults']['date_picker']['dateFormat'] = 'dd/mm/yy';
			break;
		case 'Y-m-d':
			$l10n['defaults']['date_picker']['dateFormat'] = 'yy-mm-dd';
			break;
		case 'F j, Y':
			$l10n['defaults']['date_picker']['dateFormat'] = 'MM d, yy';
			break;
		case 'j F Y':
			$l10n['defaults']['date_picker']['dateFormat'] = 'd M yy';
			break;
	}
	return apply_filters( 'timeline_express_date_picker_format', $l10n );
}
