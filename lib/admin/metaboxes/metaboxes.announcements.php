<?php
/**
 * Timeline Express Metaboxes
 *
 * @author Code Parrots
 *
 * @package Timeline Express
 *
 * @since   1.0.0
 */

// Start with an underscore to hide fields from custom fields list
$prefix = 'announcement_';

$timeline_express_options = timeline_express_get_options();

// Setup the singular Name
$timeline_express_singular_name = apply_filters( 'timeline_express_singular_name', esc_html__( 'Announcement', 'timeline-express' ) );

/**
 * Initiate the metabox
 */
$announcement_metabox = new_cmb2_box(
	array(
		'id'           => 'announcement_metabox',
		/* translators: Timeline Express singular post type name (eg: Announcement) */
		'title'        => sprintf( esc_html( '%s Info.', 'timeline-express' ), $timeline_express_singular_name ),
		'object_types' => array( 'te_announcements' ),
		'context'      => 'advanced',
		'priority'     => 'high',
		'show_names'   => true,
	)
);

// Announcement Color
$announcement_metabox->add_field(
	array(
		/* translators: Timeline Express singular post type name (eg: Announcement) */
		'name'    => sprintf( esc_html( '%s Color', 'timeline-express' ), $timeline_express_singular_name ),
		/* translators: Timeline Express singular post type name (eg: Announcement) */
		'desc'    => sprintf( esc_html( 'Select the color for this %s.', 'timeline-express' ), strtolower( $timeline_express_singular_name ) ),
		'id'      => $prefix . 'color',
		'type'    => 'colorpicker',
		'default' => $timeline_express_options['default-announcement-color'],
	)
);

// Announcement Icon
$announcement_metabox->add_field(
	array(
		/* translators: Timeline Express singular post type name (eg: Announcement) */
		'name'    => sprintf( esc_html( '%s Icon', 'Timeline Express singular post type name (eg: Announcement)', 'timeline-express' ), $timeline_express_singular_name ),
		/* translators: Timeline Express singular post type name (eg: announcement) */
		'desc'    => sprintf( esc_html( 'Select an icon from the drop down above. This is used for the icon associated with the %s.', 'timeline-express' ), strtolower( $timeline_express_singular_name ) ),
		'id'      => $prefix . 'icon',
		'type'    => 'te_bootstrap_dropdown',
		'default' => 'fa-' . $timeline_express_options['default-announcement-icon'],
	)
);

// Announcement Date
$announcement_metabox->add_field(
	array(
		'name'        => sprintf(
			/* translators: Timeline Express singular post type name (eg: Announcement) */
			esc_html__( '%s Date', 'timeline-express' ),
			$timeline_express_singular_name
		),
		'desc'        => sprintf(
			/* translators: Timeline Express singular post type name - lowercase (eg: announcement) */
			esc_html__( 'Enter the date of the %s. Announcements will appear in chronological order according to this date.', 'timeline-express' ),
			strtolower( $timeline_express_singular_name )
		),
		'id'          => $prefix . 'date',
		'type'        => 'text_date_timestamp',
		'default'     => strtotime( 'now' ),
		'date_format' => te_dateformat_php_to_jqueryui( get_option( 'date_format' ) ),
	)
);


// Announcement Banner
$announcement_metabox->add_field(
	array(
		/* translators: Timeline Express singular post type name (eg: Announcement) */
		'name'    => sprintf( esc_html( '%s Banner', 'timeline-express' ), $timeline_express_singular_name ),
		/* translators: Timeline Express singular post type name - lowercase (eg: announcement) */
		'desc'    => sprintf( esc_html( 'Select a banner image for this %s (optional). (recommended 650px wide or larger)', 'timeline-express' ), strtolower( $timeline_express_singular_name ) ),
		'id'      => $prefix . 'image',
		'type'    => 'file',
		'options' => array(
			'url' => false, // Hide the text input for the url
		),
	)
);

/**
 * Custom Container Classes Metabox
 * Requires that the user defines a custom contant in functions.php
 * example: defined( 'TIMELINE_EXPRESS_CONTAINER_CLASSES', true )
 * @since 1.2
 */
if ( defined( 'TIMELINE_EXPRESS_CONTAINER_CLASSES' ) && TIMELINE_EXPRESS_CONTAINER_CLASSES ) {

	// Custom Announcement Container Info. Metabox
	$announcement_container_metabox = new_cmb2_box(
		array(
			'id'           => 'announcement_container_metabox',
			'title'        => esc_html__( 'Announcement Container Info.', 'timeline-express' ),
			'object_types' => array( 'te_announcements' ), // Post type
			'context'      => 'advanced',
			'priority'     => 'high',
			'show_names'   => true, // Show field names on the left
		)
	);

	// Custom Container Class(es)
	$announcement_container_metabox->add_field(
		array(
			'name' => esc_html__( 'Custom Container Class', 'timeline-express' ),
			'desc' => esc_html__( 'Enter the class that you would like added to this announcement container on the timeline.', 'timeline-express' ),
			'id'   => $prefix . 'container_classes',
			'type' => 'text',
		)
	);

}

/**
 * Sidebar Metaboxs
 */

// Documentation Metabox
$help_docs_metabox = new_cmb2_box(
	array(
		'id'           => 'help_docs_metabox',
		'title'        => esc_html__( 'Help & Documentation', 'timeline-express' ),
		'object_types' => array( 'te_announcements' ),
		'context'      => 'side',
		'priority'     => 'low',
		'show_names'   => true,
	)
);

// Support & Documentation
$help_docs_metabox->add_field(
	array(
		'name' => '',
		'desc' => '',
		'id'   => $prefix . 'help_docs',
		'type' => 'te_help_docs_metabox',
	)
);

$advertisment_data = te_get_advertisment();

// Advertisement Metabox
$advert_metabox = new_cmb2_box(
	array(
		'id'           => 'advert_metabox',
		'title'        => $advertisment_data['title'],
		'object_types' => array( 'te_announcements' ),
		'context'      => 'side',
		'priority'     => 'low',
		'show_names'   => true,
	)
);

// Advertisment Field (image & content)
$advert_metabox->add_field(
	array(
		'name'    => '',
		'desc'    => '',
		'id'      => $prefix . 'advertisments',
		'type'    => 'te_advert_metabox',
		'ad_data' => $advertisment_data,
	)
);

// Filter here is to allow extra fields to be added
// loop to add fields to our array
/**
 * Filter tp allow users to define custom fields
 *
 * Fields will display on Timeline Express announcement posts
 *
 * @var [type]
 */
$custom_fields = apply_filters( 'timeline_express_custom_fields', array() );

$i = 0;

// first, check if any custom fields are defined...
if ( ! empty( $custom_fields ) ) {

	foreach ( $custom_fields as $user_defined_field ) {

		// Email text field
		$announcement_metabox->add_field( $custom_fields[ $i ] );

		$i++;

	}
}

// Action hook to allow users to hook in and define new metaboxes
do_action( 'timeline_express_metaboxes', $timeline_express_options );

/**
 * Localize the datepicker fields for international Users
 *
 * @resource https://github.com/WebDevStudios/CMB2-Snippet-Library/blob/master/filters-and-actions/localize-date-format.php
 *
 * @since 1.2.2
 */
add_filter( 'cmb2_localized_data', 'timeline_express_internationalize_datepicker' );

function timeline_express_internationalize_datepicker( $l10n ) {

	$date_format = get_option( 'date_format' );

	$l10n['defaults']['date_picker']['dateFormat'] = te_dateformat_php_to_jqueryui( $date_format );

	return apply_filters( 'timeline_express_date_picker_format', $l10n );

}

/**
 * Get our advertisment & store it in a transient for later reference
 *
 * @param  string        $part Optional, part of the ad to retreive
 *
 * @return array/string
 *
 * @since 1.2.9
 */
function te_get_advertisment( $part = '' ) {

	$advertisment = get_transient( 'timeline_express_ad_transient' );

	// Check for a transient before continuing
	if ( ! $advertisment ) {

		$advertisment = te_get_random_ad();

		if ( isset( $advertisment['start_date'] ) && isset( $advertisment['end_date'] ) ) {

			if ( strtotime( 'now' ) < $advertisment['start_date'] || strtotime( 'now' ) > $advertisment['end_date'] ) {

				$advertisment = te_get_advertisment();

			}
		}

		set_transient( 'timeline_express_ad_transient', $advertisment, 1 * HOUR_IN_SECONDS );

	}

	if ( '' !== $part && isset( $advertisment[ $part ] ) ) {

		return $advertisment[ $part ];

	}

	return $advertisment;

}

/**
 * Return a random advertisment from the directory
 *
 * @return array Array of advertisment data
 *
 * @since 1.2.9
 */
function te_get_random_ad() {

	$advertisements = include_once( TIMELINE_EXPRESS_PATH . 'lib/admin/metaboxes/partials/advertisements/advertisements-array.php' );

	// Remove any items from the array that are inactive (Halloween ad., etc.)
	// eg: start date hasn't occured OR end date has passed
	foreach ( $advertisements as $advertisment => $ad_data ) :

		if ( isset( $ad_data['start_date'] ) && isset( $ad_data['end_date'] ) ) {

			if ( $ad_data['start_date'] > strtotime( 'now' ) || $ad_data['end_date'] < strtotime( 'now' ) ) {

				unset( $advertisements[ $advertisment ] );

			}
		}

	endforeach;

	return $advertisements[ array_rand( $advertisements ) ];

}
