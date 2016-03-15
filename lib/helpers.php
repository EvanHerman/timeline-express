<?php
/**
 * Timeline Express Helper Functions
 * By Code Parrots
 *
 * @link http://www.codeparrots.com
 *
 * @package WordPress
 * @subpackage Component
 * @since 1.2
 */

/**
 * Custom CMB2 callback and sanitization functions
 *
 * @since 1.2
 */
/* Render custom date_time_stamp field */
add_action( 'cmb2_render_te_date_time_stamp_custom', 'cmb2_render_te_date_time_stamp_custom', 10, 5 );
/* Render content in the about metabox */
add_action( 'cmb2_render_te_about_metabox', 'cmb2_render_callback_te_about_metabox', 10, 5 );
/* Render custom bootstrap icons dropdown field */
add_action( 'cmb2_render_te_bootstrap_dropdown', 'cmb2_render_callback_te_bootstrap_dropdown', 10, 5 );

/* Sanitize custom date_time_stamp field */
add_filter( 'cmb2_sanitize_te_date_time_stamp_custom', 'cmb2_sanitize_te_date_time_stamp_custom_callback', 10, 2 );
/* Sanitize custom bootstrap icons dropdown field */
add_filter( 'cmb2_sanitize_te_bootstrap_dropdown', 'cmb2_validate_te_bootstrap_dropdown_callback', 10, 2 );

/**
 * Retreive plugin settings from the database
 *
 * @since 1.2
 * @return plugin options or defaults if not set
 */
function timeline_express_get_options() {
	$timeline_express_defaultvals	= array(
		'announcement-time-frame' => '0',
		'announcement-display-order' => 'ASC',
		'excerpt-trim-length' => '250',
		'excerpt-random-length' => '0',
		'date-visibility'	=> '1',
		'read-more-visibility'	=> '1',
		'default-announcement-icon' => 'fa-exclamation-triangle',
		'default-announcement-color' => '#75CE66',
		'announcement-box-shadow-color' => '#B9C5CD',
		'announcement-background-line-color' => '#D7E4ED',
		'announcement-bg-color' => '#EFEFEF',
		'no-events-message' => __( 'No announcements found', 'timeline-express' ),
		'announcement-appear-in-searches' => 'true',
		'delete-announcement-posts-on-uninstallation' => '0',
		'version'	=> TIMELINE_EXPRESS_VERSION_CURRENT,
	);
	return get_option( TIMELINE_EXPRESS_OPTION, $timeline_express_defaultvals );
}

/**
 * Generate our metaboxes to assign to our announcements
 *
 * @since 1.2
 */
function timeline_express_announcement_metaboxes() {
	require_once TIMELINE_EXPRESS_PATH . 'lib/admin/metaboxes/metaboxes.announcements.php';
}

/**
 * CMB2 Specific functions
 * Render and sanitize our metaboxes
 * (note: individual custom metaboxes are defined inside of /admin/metaboxes/partials/)
 *
 * @since 1.2
 */

/**
 * Function cmb_render_te_bootstrap_dropdown()
 * Render the custom bootstrap dropdown
 *
 * @param int        $field field to render.
 * @param int/string $escaped_value stored value for this field.
 * @param type       $object_id this specific fields id.
 * @param type       $object_type the type for this field.
 * @param type       $field_type_object the entire field object.
 * @since v1.1.5.7
 */
function cmb2_render_callback_te_bootstrap_dropdown( $field, $escaped_value, $object_id, $object_type, $field_type_object ) {
	include_once( TIMELINE_EXPRESS_PATH . 'lib/admin/metaboxes/partials/bootstrap_icon_dropdown.php' );
}

/**
 * Function cmb2_render_te_date_time_stamp_custom()
 * Render the custom time stamp field
 *
 * @param int  $field field to render.
 * @param type $meta stored value retreived from the database.
 * @param type $object_id this specific fields id.
 * @param type $object_type the type for this field.
 * @param type $field_type_object the entire field object.
 * @since v1.1.5.7
 */
function cmb2_render_te_date_time_stamp_custom( $field, $meta, $object_id, $object_type, $field_type_object ) {
	include_once( TIMELINE_EXPRESS_PATH . 'lib/admin/metaboxes/partials/time_stamp_custom.php' );
}

/**
 * Render the custom 'about' metabox.
 *
 * @since v1.1.5
 *
 * @param int        $field field to render.
 * @param int/string $meta stored value for this field.
 * @param type       $object_id this specific fields id.
 * @param type       $object_type the type for this field.
 * @param type       $field_type_object the entire field object.
 */
function cmb2_render_callback_te_about_metabox( $field, $meta, $object_id, $object_type, $field_type_object ) {
	include_once( TIMELINE_EXPRESS_PATH . 'lib/admin/metaboxes/partials/about-metabox.php' );
}

/**
 * Custom sanitization function for our custom time stamp field.
 *
 * @since @v1.1.5
 * @param int $value UNIX time stamp value stored in the database.
 * @param int $new new UNIX time stamp value to store in the database.
 */
function cmb2_sanitize_te_date_time_stamp_custom_callback( $value, $new ) {
	if ( isset( $new ) && '' !== $new ) {
		return apply_filters( 'timeline_express_sanitize_date_format', strtotime( $new ), $new );
	}
	/* If all else fails, return current date/time UNIX time stamp */
	return strtotime( 'now' );
}

/**
 * Custom sanitization function for our custom time stamp field.
 *
 * @since @v1.1.5
 * @param string $override_value -.
 * @param string $value new icon value to store in the database.
 */
function cmb2_validate_te_bootstrap_dropdown_callback( $override_value, $value ) {
	if ( isset( $value ) && '' !== $value ) {
		return 'fa-' . trim( $value );
	}
	return '';
}

/**
 * Enqueue Font Awesome from netdna CDN if accessible.
 * if not, load from a local copy.
 *
 * @since v1.1.5.7
 */
function timeline_express_enqueue_font_awesome() {
	$font_awesome_version = apply_filters( 'timeline_express_font_awesome_version', '4.5.0' );
	$http = ( is_ssl() ) ? 'https:' : 'http:';
	/* Check if CDN is reachable, if so - get em' */
	if ( wp_remote_get( $http . '//netdna.bootstrapcdn.com/font-awesome/' . $font_awesome_version . '/css/font-awesome.css' ) ) {
		/* Enqueue font awesome for use in column display */
		wp_enqueue_style( 'font-awesome' , $http . '//netdna.bootstrapcdn.com/font-awesome/' . $font_awesome_version . '/css/font-awesome.min.css' , array(), $font_awesome_version );
	} else {
		/* If not, load the local version */
		wp_enqueue_style( 'font-awesome', TIMELINE_EXPRESS_URL . 'lib/icons/css/font-awesome.min.css', array(), $font_awesome_version );
	}
}

/**
 * Construct a dropdown for our bootstrap icons.
 *
 * @param string $field the field type being displayed.
 * @param string $meta the stored value in the database.
 * @since v1.1.5.7
 */
function timeline_express_build_bootstrap_icon_dropdown( $field, $meta ) {
	$screen = get_current_screen();
	$screen_base = $screen->base;
	$http = ( is_ssl() ) ? 'https:' : 'http:';
	$font_awesome_version = apply_filters( 'timeline_express_font_awesome_version', '4.5.0' );

	// Store our response in a transient for faster page loading.
	if ( false === ( $response = get_transient( 'te_font_awesome_transient' ) ) ) {
		// Retreive the icons out of the css file.
		$response = wp_remote_get( $http . '//netdna.bootstrapcdn.com/font-awesome/' . $font_awesome_version . '/css/font-awesome.css' );
		if ( is_wp_error( $response ) ) {
			// Load font awesome locally.
			$response = wp_remote_get( TIMELINE_EXPRESS_URL . 'lib/icons/css/font-awesome.css' );
		}

		// It wasn't there, so regenerate the data and save the transient.
		set_transient( 'te_font_awesome_transient', $response );
	}

	// Split the response body, and store the icon classes in a variable.
	$split_dat_response = explode( 'icons */' , $response['body'] );

	// Define an empty array to store our icons in.
	$bootstrap_icon_array = array();

	// Replace the unecessary stuff from the font awesome CSS icon file.
	$data = str_replace( ';' , '' , str_replace( ':before' , '' , str_replace( '}' , '' , str_replace( 'content' , '' , str_replace( '{' , '' , $split_dat_response[1] ) ) ) ) );
	$icon_data = explode( '.fa-' , $data );
	$i = 1;

	foreach ( array_slice( $icon_data, 1 ) as $key => $value ) {
		$split_icon = explode( ':' , $value );
		if ( isset( $split_icon[1] ) ) {
			$bootstrap_icon_array[] = array( trim( 'fa-' . $split_icon[0] ) => trim( $split_icon[0] ) );
		}
		$i++;
	}

	$flat_bootstrap_icon_array = array();
	foreach ( $bootstrap_icon_array as $array ) {
		foreach ( $array as $k => $v ) {
			$flat_bootstrap_icon_array[ $k ] = $v;
		}
	}
	?>

	<script>
	jQuery( document ).ready( function() {
		jQuery('.selectpicker').selectpicker({
			style: 'btn-info',
			size: 6
		});
	});
	</script>
	<style>
		.dropdown-toggle { background: transparent !important; border: 1px solid rgb(201, 201, 201) !important; }
		.dropdown-toggle .caret { border-top-color: #333 !important; }
		.ui-datepicker-prev:hover, .ui-datepicker-next:hover { cursor: pointer; }
	</style>

	<?php
	// Check which page were on, set name appropriately.
	if ( isset( $field->args['id'] ) ) {
		$field_name = $field->args['id'];
	} else {
		$field_name = 'default-announcement-icon';
	}
	?>

	<!-- start the font awesome icon select -->
	<select class="selectpicker" name="<?php echo esc_attr( $field_name ); ?>" id="default-announcement-icon>">

		<?php
		/* sort the bootstrap icons alphabetically */
		sort( $flat_bootstrap_icon_array );
		foreach ( $flat_bootstrap_icon_array as $icon ) {
		?>

		<option class="fa" data-icon="fa-<?php echo esc_attr( $icon ); ?>" <?php selected( 'fa-'.$icon , $meta ); ?>><?php echo esc_html( $icon ); ?></option>

		<?php } ?>

	</select>
	<!-- end select -->

	<?php
	if ( 'te_announcements_page_timeline-express-settings' !== $screen_base ) {
		echo '<p class="cmb_metabox_description">' . esc_html( $field->args['desc'] ) . '</p>';
	}
}

?>
