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
/* Render content in the timeline express addon advertisments metabox */
add_action( 'cmb2_render_te_advert_metabox', 'cmb2_render_callback_te_advert_metabox', 10, 5 );
/* Render content in the help & doc metabox */
add_action( 'cmb2_render_te_help_docs_metabox', 'cmb2_render_callback_te_help_docs_metabox', 10, 5 );
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
		'default-announcement-icon' => 'exclamation-triangle',
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
 * Render the custom 'Advertisment' metabox.
 *
 * @since v1.1.5
 *
 * @param int        $field field to render.
 * @param int/string $meta stored value for this field.
 * @param type       $object_id this specific fields id.
 * @param type       $object_type the type for this field.
 * @param type       $field_type_object the entire field object.
 */
function cmb2_render_callback_te_advert_metabox( $field, $meta, $object_id, $object_type, $field_type_object ) {
	include_once( TIMELINE_EXPRESS_PATH . 'lib/admin/metaboxes/partials/advertisment-metabox.php' );
}

/**
 * Render the custom 'Help & Documentation' metabox.
 *
 * @since v1.1.5
 *
 * @param int        $field field to render.
 * @param int/string $meta stored value for this field.
 * @param type       $object_id this specific fields id.
 * @param type       $object_type the type for this field.
 * @param type       $field_type_object the entire field object.
 */
function cmb2_render_callback_te_help_docs_metabox( $field, $meta, $object_id, $object_type, $field_type_object ) {
	include_once( TIMELINE_EXPRESS_PATH . 'lib/admin/metaboxes/partials/help-docs-metabox.php' );
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
		wp_enqueue_style( 'font-awesome', $http . '//netdna.bootstrapcdn.com/font-awesome/' . $font_awesome_version . '/css/font-awesome.min.css' , array(), $font_awesome_version );
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

	// Replace the unecessary stuff from the font awesome CSS icon file.
	$data = str_replace( ';' , '' , str_replace( ':before' , '' , str_replace( '}' , '' , str_replace( 'content' , '' , str_replace( '{' , '' , $split_dat_response[1] ) ) ) ) );
	$icon_data = explode( '.fa-' , $data );
	$i = 1;

	// Define & Build our icon array
	$bootstrap_icon_array = build_bootstrap_icons_array( $icon_data );

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
		$field_name = esc_attr( $field['id'] );
	}
	?>

	<!-- start the font awesome icon select -->
	<select class="selectpicker" name="<?php echo esc_attr( $field_name ); ?>" id="default-announcement-icon" name="<?php echo esc_attr( $field_name ); ?>">

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

/**
 * Helper function to build the bootstrap icons array
 * @param  array $icons the entire array of icons to filter
 * @return [type]        [description]
 */
function build_bootstrap_icons_array( $icon_data ) {
	// Confirm that $icons is an array and not empty
	if ( ! is_array( $icon_data ) || empty( $icon_data ) ) {
		return;
	}
	// Empty array for icon array
	$bootstrap_icon_array = array();
	// Loop
	foreach ( array_slice( $icon_data, 1 ) as $key => $value ) {
		$split_icon = explode( ':' , $value );
		if ( isset( $split_icon[1] ) ) {
			// Push to the array
			$bootstrap_icon_array[] = array( trim( 'fa-' . $split_icon[0] ) => trim( $split_icon[0] ) );
		}
	}
	// Return our array of icons
	return $bootstrap_icon_array;
}

/**
 * Include a Timeline Express template
 * @param  string $template_name Template name to load
 * @return null                Include the template needed
 * @since 1.2
 */
function get_timeline_express_template( $template_name = 'timeline-container' ) {
	/**
	 * Switch over the template name, return template
	 * - Check if a file exists locally (theme root), and load it.
	 * - Note: Users can create a directory (timeline-express), and copy over the announcement template into the theme root.
	 */
	switch ( $template_name ) {
		default:
		case 'timeline-container':
			if ( file_exists( get_template_directory() . '/timeline-express/timeline-express-container.php' ) ) {
				include( get_template_directory() . '/timeline-express/timeline-express-container.php' );
			} else {
				include( TIMELINE_EXPRESS_PATH . 'lib/public/partials/timeline-express-container.php' );
			}
			break;
		case 'single-announcement':
			if ( file_exists( get_template_directory() . '/timeline-express/single.timeline-express.php' ) ) {
				include( get_template_directory() . '/timeline-express/single.timeline-express.php' );
			} else {
				include( TIMELINE_EXPRESS_PATH . 'lib/public/partials/single.timeline-express.php' );
			}
			break;
	}
}

/**
 * Check if our Timeline Express Init class exists
 * if it does not, include our class file.
 *
 * @return null
 */
function does_timeline_express_init_class_exist() {
	if ( ! class_exists( 'Timeline_Express_Initialize' ) ) {
		include TIMELINE_EXPRESS_PATH . 'lib/classes/class.timeline-express-initialize.php';
	}
	return;
}

/**
 * Get the announcement icon chosen in the dropdown
 * @param  int $post_id The announcement ID to retreive the icon from
 * @return string       The announcement icon to use
 */
function timeline_express_get_announcement_icon( $post_id ) {
	return apply_filters( 'timeline_express_icon', get_post_meta( $post_id, 'announcement_icon', true ), $post_id );
}

/**
 * Get the announcement color chosen on the announcement edit page
 * @param  int $post_id The announcement ID to retreive the color from
 * @return string       The announcement color to use behind the icon
 */
function timeline_express_get_announcement_icon_color( $post_id ) {
	return apply_filters( 'timeline_express_icon_color', get_post_meta( $post_id, 'announcement_color', true ), $post_id );
}

/**
 * Retreive the timeline express announcement image
 * @param  int    $post_id The announcement (post) ID whos image you want to retreive.
 * @param  string $image_size (optional) The image size to retreive.
 * @return Announcement image markup.
 */
function timeline_express_get_announcement_image( $post_id, $image_size = 'timeline-express' ) {
	/* Escaped on output in the timeline/single page */
	echo apply_filters( 'timeline_express_image', wp_get_attachment_image(
		get_post_meta( $post_id, 'announcement_image_id', true ),
		apply_filters( 'timeline_express_announcement_img_size', apply_filters( 'timeline-express-announcement-img-size', $image_size, $post_id ), $post_id ), /* Legacy filter name - maintain formatting */
		false,
		array(
			'title' => esc_attr__( get_the_title() ),
			'class' => 'announcement-banner-image',
		)
	), $post_id );
}

/**
 * Retreive the timeline express announcement date
 * @param int    $post_id The announcement (post) ID whos image you want to retreive.
 * @return Timeline_Express_Initialize::get_announcement_date() Execute the function to retreive the date.
 */
function timeline_express_get_announcement_date( $post_id ) {
	return apply_filters( 'timeline_express_date', date_i18n( apply_filters( 'timeline_express_date_format', get_option( 'date_format' ) ), get_post_meta( $post_id, 'announcement_date', true ) ), $post_id );
}

/**
 * Retreive the timeline express announcement content.
 * Note: Cannot be used on the single announcement template.
 * @param  int $post_id The announcement (post) ID whos content you want to retreive.
 * @return array The announcement content, passed through the_content() filter.
 */
function timeline_express_get_announcement_content( $post_id ) {
	$announcement_object = get_post( $post_id );
	return ( isset( $announcement_object->post_content ) ) ? apply_filters( 'the_content', $announcement_object->post_content ) : '';
}

/**
 * Get the announcement excerpt
 * @param  int $post_id The announcement (post) ID whos excerpt you want to retreive.
 * @return string       The announcement excerpt
 */
function timeline_express_get_announcement_excerpt( $post_id ) {
	/* Setup the excerpt length */
	$excerpt = the_excerpt( get_the_content( $post_id ) );
	return apply_filters( 'timeline_express_frontend_excerpt', $excerpt, $post_id );
}

/**
 * Setup a custom or random excerpt length based on the options set in the settings
 * @return string The announcement excerpt
 * @since 1.2
 */
add_filter( 'excerpt_length', 'timeline_express_custom_excerpt_length' );
function timeline_express_custom_excerpt_length( $length ) {
	$timeline_express_options = timeline_express_get_options();
	if ( 1 === $timeline_express_options['excerpt-random-length'] ) {
		$random_length = (int) rand( apply_filters( 'timeline_express_random_excerpt_min', 50 ), apply_filters( 'timeline_express_random_excerpt_max', 200 ) );
		return (int) $random_length;
	}
	return $length;
}

/**
 * Filter the read more links to a custom state
 * @since 1.2
 */
add_filter( 'excerpt_more', 'timeline_express_custom_read_more' );
function timeline_express_custom_read_more() {
	global $post;
	$timeline_express_options = timeline_express_get_options();
	if ( '1' !== $timeline_express_options['read-more-visibility'] ) {
		return;
	}
	return apply_filters( 'timeline_express_read_more_link', '... <a class="' . esc_attr__( apply_filters( 'timeline_express_read_more_class', 'timeline-express-read-more-link', $post->ID ) ) . '" href="'. esc_attr__( esc_url( get_permalink( $post->ID ) ) ) . '"> ' . esc_attr__( apply_filters( 'timeline_express_read_more_text', __( 'Read more', 'timeline-express' ), $post->ID ) ) . '</a>', $post->ID );
}

/**
 * Generate an excerpt of random length
 * @param  int $post_id The announcement ID to retreive the excerpt
 * @return string       The announcement excerpt of random length
 */
function timeline_express_generate_random_announcement( $post_id ) {
	return apply_filters( 'timeline_express_random_excerpt', get_the_content( $post_id ), $post_id );
}

/**
 * Retreive a custom, user defined, field object.
 * This is used after you define custom fields using the timeline_express_custom_fields filter.
 *
 * @param int    $post_id The announcement (post) ID whos content you want to retreive.
 * @param string $meta_id The ID of the metabox, whos value you want to retrieve.
 * @param bool   $array True/False to return an array. Optional. Default: true.
 * @return array The announcement content, passed through the_content() filter.
 */
function timeline_express_get_custom_meta( $post_id, $meta_name, $array = true ) {
	/* If no post id was passed in, abort */
	if ( ! $post_id ) {
		return esc_attr__( 'You forgot to include the announcement ID.', 'timeline-express' );
	}
	/* If no meta name was passed in, abort */
	if ( ! $meta_name ) {
		return esc_attr__( 'You forgot to include the meta key.', 'timeline-express' );
	}
	/* Return the post meta, or false if nothing was found */
	return ( get_post_meta( $post_id, $meta_name, true ) ) ? get_post_meta( $post_id, $meta_name, true ) : false;
}
?>
