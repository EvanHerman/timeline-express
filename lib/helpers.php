<?php
/**
 * Timeline Express Helper Functions
 * By Code Parrots
 *
 * @link http://www.codeparrots.com
 *
 * @package TimelineExpressBase
 * @since 1.2
 */

/**
 * Custom CMB2 callback and sanitization functions
 *
 * @since 1.2
 */

/* Render content in the timeline express addon advertisments metabox */
add_action( 'cmb2_render_te_advert_metabox', 'cmb2_render_callback_te_advert_metabox', 10, 5 );

/* Render content in the help & doc metabox */
add_action( 'cmb2_render_te_help_docs_metabox', 'cmb2_render_callback_te_help_docs_metabox', 10, 5 );

/* Render custom bootstrap icons dropdown field */
add_action( 'cmb2_render_te_bootstrap_dropdown', 'cmb2_render_callback_te_bootstrap_dropdown', 10, 5 );

/* Sanitize custom bootstrap icons dropdown field */
add_filter( 'cmb2_sanitize_te_bootstrap_dropdown', 'cmb2_validate_te_bootstrap_dropdown_callback', 10, 2 );

/**
 * Output the Start and End content wrappers on the single timeline express template
 *
 * @since 1.2.8.5
 */
add_action( 'timeline_express_before_main_content', 'timeline_express_generate_page_wrapper_start', 10 );
add_action( 'timeline_express_after_main_content', 'timeline_express_generate_page_wrapper_end', 10 );

/**
 * Output the Timeline Express Sidebar on the single announcement template
 *
 * @since 1.2.8.5
 */
add_action( 'timeline_express_sidebar', 'timeline_express_generate_sidebar', 10 );

/**
 * Retreive plugin settings from the database
 *
 * @since 1.2
 * @return plugin options or defaults if not set
 */
function timeline_express_get_options() {

	return apply_filters(
		'timeline_express_options',
		get_option(
			TIMELINE_EXPRESS_OPTION,
			array(
				'announcement-time-frame'            => '1',
				'announcement-display-order'         => 'ASC',
				'excerpt-trim-length'                => 50,
				'excerpt-random-length'              => 0,
				'date-visibility'                    => '1',
				'read-more-visibility'               => '1',
				'default-announcement-icon'          => 'exclamation-triangle',
				'default-announcement-color'         => '#75CE66',
				'announcement-box-shadow-color'      => '#B9C5CD',
				'announcement-background-line-color' => '#D7E4ED',
				'announcement-bg-color'              => '#EFEFEF',
				'no-events-message'                  => esc_html__( 'No announcements found', 'timeline-express' ),
				'announcement-appear-in-searches'    => 'true',
				'disable-animation'                  => 0,
				'delete-announcement-posts-on-uninstallation' => 0,
				'version'                            => TIMELINE_EXPRESS_VERSION_CURRENT,
			)
		)
	);

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
 *
 * @since v1.1.5.7
 */
function cmb2_render_callback_te_bootstrap_dropdown( $field, $escaped_value ) {

	timeline_express_build_bootstrap_icon_dropdown( $field, $escaped_value );

}

/**
 * Render the custom 'Advertisment' metabox.
 *
 * @param int        $field field to render.
 * @param int/string $meta stored value for this field.
 * @param type       $object_id this specific fields id.
 * @param type       $object_type the type for this field.
 * @param type       $field_type_object the entire field object.
 *
 * @since v1.1.5
 */
function cmb2_render_callback_te_advert_metabox( $field, $meta, $object_id, $object_type, $field_type_object ) {

	include_once( TIMELINE_EXPRESS_PATH . 'lib/admin/metaboxes/partials/advertisment-metabox.php' );

}

/**
 * Render the custom 'Help & Documentation' metabox.
 *
 * @param int        $field field to render.
 * @param int/string $meta stored value for this field.
 * @param type       $object_id this specific fields id.
 * @param type       $object_type the type for this field.
 * @param type       $field_type_object the entire field object.
 *
 * @since v1.1.5
 */
function cmb2_render_callback_te_help_docs_metabox( $field, $meta, $object_id, $object_type, $field_type_object ) {

	include_once( TIMELINE_EXPRESS_PATH . 'lib/admin/metaboxes/partials/help-docs-metabox.php' );

}

/**
 * Custom sanitization function for our custom time stamp field.
 *
 * @param  string $override_value   null.
 * @param  string $value new icon   Value to store in the database.
 *
 * @since @v1.1.5
 */
function cmb2_validate_te_bootstrap_dropdown_callback( $override_value, $value ) {

	if ( isset( $value ) && ! empty( $value ) ) {

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

	$local_font_awesome = ( ! defined( 'TIMELINE_EXPRESS_FONT_AWESOME_LOCAL' ) || ( defined( 'TIMELINE_EXPRESS_FONT_AWESOME_LOCAL' ) && TIMELINE_EXPRESS_FONT_AWESOME_LOCAL ) ) ? true : false;

	if ( $local_font_awesome ) {

		/* If not, load the local version */
		wp_enqueue_style( 'font-awesome', TIMELINE_EXPRESS_URL . 'lib/icons/css/font-awesome.min.css', array(), '4.7.0' );

		return;

	}

	$font_awesome_version = apply_filters( 'timeline_express_font_awesome_version', '4.7.0' );

	$http = ( is_ssl() ) ? 'https:' : 'http:';

	/* Enqueue font awesome for use in column display */
	wp_enqueue_style( 'font-awesome', $http . '//netdna.bootstrapcdn.com/font-awesome/' . $font_awesome_version . '/css/font-awesome.min.css', array(), $font_awesome_version );

}

/**
 * Construct a dropdown for our bootstrap icons.
 *
 * @param string $field   The field type being displayed.
 * @param string $meta    The stored value in the database.
 *
 * @since v1.1.5.7
 */
function timeline_express_build_bootstrap_icon_dropdown( $field, $meta ) {

	$screen = get_current_screen();

	$screen_base = $screen->base;

	$http = ( is_ssl() ) ? 'https:' : 'http:';

	$font_awesome_version = apply_filters( 'timeline_express_font_awesome_version', '4.7.0' );

	$response = get_transient( 'te_font_awesome_transient' );

	// Store our response in a transient for faster page loading.
	if ( ! $response ) {

		// Retreive the icons out of the css file.
		$response = wp_remote_get( $http . '//netdna.bootstrapcdn.com/font-awesome/' . $font_awesome_version . '/css/font-awesome.css' );

		if ( is_wp_error( $response ) ) {

			// Load font awesome locally.
			$response = wp_remote_get( TIMELINE_EXPRESS_URL . 'lib/icons/css/font-awesome.css' );

		}

		// It wasn't there, so regenerate the data and save the transient.
		set_transient( 'te_font_awesome_transient', $response, 12 * HOUR_IN_SECONDS );

	}

	/* If the response body is empty, abort */
	if ( empty( $response['body'] ) || ! isset( $response['body'] ) ) {

		return printf( '<em>' . esc_html__( 'There was an error processing the bootstrap icons.', 'timeline-express' ) . '</em>' );

	}

	// Icons
	$pattern = '/(\.(?:fa-(?:\w+(?:-)?)+):before(?:,\s*\.(?:fa-(?:\w+(?:-)?)+):before)*)\s*{\s*content:\s*"(.+)";\s*}/';

	$sub_pattern = '/(fa-.+?):before/';

	preg_match_all( $pattern, $response['body'], $matches, PREG_SET_ORDER );

	$icons = array();

	foreach ( $matches as $match ) {

		preg_match_all( $sub_pattern, $match[1], $sub_matches, PREG_SET_ORDER );

		foreach ( $sub_matches as $sub_match ) {

			$icons[ str_replace( 'fa-', '', $sub_match[1] ) ] = $match[2];

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

		$field_name = $field['id'];

	}
	?>

	<!-- start the font awesome icon select -->
	<select class="selectpicker" name="<?php echo esc_attr( $field_name ); ?>" id="default-announcement-icon" name="<?php echo esc_attr( $field_name ); ?>">

		<?php

		ksort( $icons );

		/* sort the bootstrap icons alphabetically */
		foreach ( $icons as $icon_name => $icon_content ) { ?>

			<option class="fa" data-icon="fa-<?php echo esc_attr( $icon_name ); ?>" <?php selected( 'fa-' . $icon_name, $meta ); ?>><?php echo esc_html( $icon_name ); ?></option>

		<?php } ?>

	</select>
	<!-- end select -->

	<?php
	if ( 'te_announcements_page_timeline-express-settings' !== $screen_base ) {

		echo '<p class="cmb2-metabox-description">' . esc_html( $field->args['desc'] ) . '</p>';

	}

}

/**
 * Include a specified Timeline Express template
 *
 * @param  string $template_name  Template name to load
 *
 * @return null                    Include the template needed
 *
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
			$file_name = 'timeline-express-container';
			break;

		case 'single-announcement':
			$file_name = 'single-timeline-express-content';
			break;

		case 'page-wrappers-start':
			$file_name = 'timeline-express-page-wrappers-start';
			break;

		case 'page-wrappers-end':
			$file_name = 'timeline-express-page-wrappers-end';
			break;

		case 'timeline-express-sidebar':
			$file_name = 'timeline-express-sidebar';
			break;

	}

	// check for and load file
	if ( file_exists( get_stylesheet_directory() . '/timeline-express/' . $file_name . '.php' ) ) {

		include( get_stylesheet_directory() . '/timeline-express/' . $file_name . '.php' );

		return;

	}

	include( TIMELINE_EXPRESS_PATH . 'lib/public/partials/' . $file_name . '.php' );

}

/**
 * Helper function to retreive the timeline express single announcement templates
 * This is redundant, but will be easier for our users to use in their themes
 */
function timeline_express_content() {

	// check for and load file
	if ( file_exists( get_stylesheet_directory() . '/timeline-express/single-timeline-express-content.php' ) ) {

		include( get_stylesheet_directory() . '/timeline-express/single-timeline-express-content.php' );

		return;

	}

	include( TIMELINE_EXPRESS_PATH . 'lib/public/partials/single-timeline-express-content.php' );

}

/**
 * Helper function used to clear out the timeline express transients
 * This is fired when the settings are saved, and when an announcement is updated/published
 *
 * @param integer $page_id The page ID to delete transients for
 *
 * @since 1.2
 */
function delete_timeline_express_transients( $page_id = false ) {

	$transient_name = ( $page_id ) ? 'timeline-express-query-' . $page_id : 'timeline-express-query';

	global $wpdb;

	// Query the database for all transients with the text 'timeline-express-query'
	$results = $wpdb->get_results(
		$wpdb->prepare(
			"SELECT * from `{$wpdb->prefix}options` WHERE option_name LIKE %s;", '%' . $wpdb->esc_like( $transient_name ) . '%' // @codingStandardsIgnoreLine
		)
	);

	// if we have some results, continue
	if ( $results && ! empty( $results ) ) {

		// loop and delete our transient
		foreach ( $results as $transient ) {

			delete_transient( str_replace( '_transient_', '', $transient->option_name ) );

		}
	}

}

/**
 * Check if our Timeline Express Init class exists
 * if it does not, include our class file.
 */
function does_timeline_express_init_class_exist() {

	if ( class_exists( 'Timeline_Express_Initialize' ) ) {

		return;

	}

	include TIMELINE_EXPRESS_PATH . 'lib/classes/class-timeline-express-initialize.php';

}

/**
 * Get the full icon HTML markup
 *
 * @param  int $post_id  The announcement ID to retreive the icon from
 *
 * @return string           The HTML markup to return
 */
function timeline_express_get_announcement_icon_markup( $post_id, $link = true ) {

	$timeline_express_options = timeline_express_get_options();

	$custom_icon_html = apply_filters( 'timeline_express_custom_icon_html', apply_filters( 'timeline-express-custom-icon-html', false, $post_id, $timeline_express_options ), $post_id, $timeline_express_options );

	$icon_container_class = ' icon-no-readmore';

	/* Generate the Icon */
	if ( $custom_icon_html ) {

		return $custom_icon_html;

	}

	/* If read more visibility is set to true, wrap the icon in a link. */
	if ( '1' === $timeline_express_options['read-more-visibility'] && $link ) {

		$icon_container_class = '';

		?>

		<a class="cd-timeline-icon-link" href="<?php echo esc_attr( apply_filters( 'timeline_express_announcement_permalink', get_the_permalink( $post_id ), $post_id ) ); ?>">

			<?php

	}

	?>

		<div class="cd-timeline-img cd-picture<?php echo esc_attr( $icon_container_class ); ?>" style="background:<?php echo esc_attr( timeline_express_get_announcement_icon_color( $post_id ) ); ?>;">

			<!-- Custom Action Hook -->
			<?php if ( defined( 'TIMELINE_EXPRESS_YEAR_ICONS' ) && TIMELINE_EXPRESS_YEAR_ICONS ) { ?>

				<!-- Standard Font Awesome Icon -->
				<span class="year">

					<strong>

						<?php

							$date = date_i18n( 'Y', timeline_express_get_announcement_date_timestamp( $post_id ) );

							echo esc_html( apply_filters( 'timeline_express_frontend_year_icons', $date, timeline_express_get_announcement_date_timestamp( $post_id ) ) );

						?>

					</strong>

				</span>

			<?php } else { ?>

				<!-- Standard Font Awesome Icon -->
				<span class="fa <?php echo esc_attr( timeline_express_get_announcement_icon( $post_id ) ); ?>" title="<?php echo esc_attr( get_the_title( $post_id ) ); ?>"></span>

			<?php } ?>

		</div> <!-- cd-timeline-img -->

	<?php

	/* If read more visibility is set to true, wrap the icon in a link. */
	if ( '1' === $timeline_express_options['read-more-visibility'] && $link ) {

		?>

		</a>

		<?php

	}

}

/**
 * Get the announcement icon chosen in the dropdown
 *
 * @param  int $post_id   The announcement ID to retreive the icon from
 *
 * @return string             The announcement icon to use
 */
function timeline_express_get_announcement_icon( $post_id ) {

	return apply_filters( 'timeline_express_icon', get_post_meta( $post_id, 'announcement_icon', true ), $post_id );

}

/**
 * Get the announcement color chosen on the announcement edit page
 *
 * @param  int $post_id   The announcement ID to retreive the color from
 *
 * @return string             The announcement color to use behind the icon
 */
function timeline_express_get_announcement_icon_color( $post_id ) {

	return apply_filters( 'timeline_express_icon_color', get_post_meta( $post_id, 'announcement_color', true ), $post_id );

}

/**
 * Retreive the timeline express announcement image
 *
 * @param  int    $post_id     The announcement (post) ID whos image you want to retreive.
 * @param  string $image_size  (optional) The image size to retreive.
 *
 * @return mixed                Announcement image markup.
 */
function timeline_express_get_announcement_image( $post_id, $image_size = 'timeline-express' ) {

	if ( ! get_post_meta( $post_id, 'announcement_image_id', true ) && ! get_post_meta( $post_id, 'announcement_image', true ) ) {

		return;

	}

	/**
	 * Filter the announcement image, allow users to set this to false to short circuit the announcement image.
	 *
	 * @var bool|string
	 */
	$image = apply_filters( 'timeline-express-announcement-img', ( get_post_meta( $post_id, 'announcement_image_id', true ) ) ? (int) get_post_meta( $post_id, 'announcement_image_id', true ) : get_post_meta( $post_id, 'announcement_image', true ), $post_id );

	if ( empty( $image ) ) {

		return;

	}

	/**
	 * Filter the announcement image size
	 *
	 * @var string
	 */
	$image_size = (string) apply_filters( 'timeline-express-announcement-img-size', $image_size, $post_id );

	/**
	* If on a single page announcement, return the srcset image - for proper responsive images
	 *
	* @since 1.2.7
	*/
	if ( is_single() ) {

		$img_src = ( is_integer( $image ) ) ? wp_get_attachment_image_url( $image, $image_size ) : $image;

		$image_attributes = array(
			'class' => 'announcement-banner-image',
			'src'   => esc_url( $img_src ),
			'sizes' => '(max-width: 100%) 75vw, 680px',
			'alt'   => get_the_title(),
		);

		$img_srcset = wp_get_attachment_image_srcset( get_post_meta( $post_id, 'announcement_image_id', true ), $image_size );

		if ( $img_srcset ) {

			$image_attributes['srcset'] = $img_srcset;

		}

		?>

		<img <?php echo timeline_express_map_html_attributes( $image_attributes ); ?>>

		<?php

		return;

	}

	$announcement_image = apply_filters(
		'timeline_express_image',
		wp_get_attachment_image(
			get_post_meta( $post_id, 'announcement_image_id', true ),
			$image_size,
			false,
			array(
				'alt'   => esc_attr( get_the_title() ),
				'class' => 'announcement-banner-image',
			)
		),
		$post_id
	);

	if ( empty( $announcement_image ) ) {

		$image_attributes = array(
			'class' => 'announcement-banner-image external-image',
			'alt'   => get_the_title(),
			'src'   => get_post_meta( $post_id, 'announcement_image', true ),
		);

		$announcement_image = '<img ' . timeline_express_map_html_attributes( $image_attributes ) . '>';

	}

	/* Escaped on output in the timeline/single page */
	return $announcement_image;

}

/**
 * Map an array to HTML attributes
 *
 * @param  array $attribute_array Array of HTML attributes
 *
 * @return string                 String of attributes to be used in the final HTML element.
 */
function timeline_express_map_html_attributes( $attribute_array ) {

	if ( ! $attribute_array || empty( $attribute_array ) ) {

		return;

	}

	return join(
		' ',
		array_map(
			function( $key ) use ( $attribute_array ) {

				if ( is_bool( $attribute_array[ $key ] ) ) {

					return $attribute_array[ $key ] ? $key : '';

				}

					return $key . '="' . $attribute_array[ $key ] . '"';

			},
			array_keys( $attribute_array )
		)
	);

}

/**
 * Retreive the timeline express announcement date
 *
 * @param int $post_id   The announcement (post) ID whos image you want to retreive.
 *
 * @return string             Execute the function to retreive the date.
 */
function timeline_express_get_announcement_date( $post_id ) {

	$announcement_date = ( get_post_meta( $post_id, 'announcement_date', true ) ) ? get_post_meta( $post_id, 'announcement_date', true ) : strtotime( 'now' );

	return apply_filters( 'timeline_express_frontend_date_filter', date_i18n( apply_filters( 'timeline_express_custom_date_format', get_option( 'date_format' ) ), $announcement_date ), $post_id );

}

/**
 * Retreive the timeline express announcement date timestamp
 *
 * @param int $post_id The announcement (post) ID whos image you want to retreive.
 *
 * @return string   The UNIX timestamp announcement_date value
 */
function timeline_express_get_announcement_date_timestamp( $post_id ) {

	return ( get_post_meta( $post_id, 'announcement_date', true ) ) ? get_post_meta( $post_id, 'announcement_date', true ) : strtotime( 'now' );

}


/**
 * Get the announcement excerpt
 *
 * @param  int $post_id The announcement (post) ID whos excerpt you want to retreive.
 *
 * @return string       The announcement excerpt
 */
function timeline_express_get_announcement_excerpt( $post_id ) {

	/* Setup the excerpt */
	return apply_filters( 'the_content', apply_filters( 'timeline_express_frontend_excerpt', get_the_excerpt(), $post_id ) );

}

/**
 * Setup a custom or random excerpt length based on the options set in the settings
 *
 * @return string The announcement excerpt
 *
 * @since 1.2
 */
function timeline_express_custom_excerpt_length( $length ) {

	global $post;

	// if not an announcement post, abort
	if ( 'te_announcements' !== get_post_type( $post ) ) {

		return $length;

	}

	$timeline_express_options = timeline_express_get_options();

	if ( 1 === $timeline_express_options['excerpt-random-length'] ) {

		$random_length = (int) rand( apply_filters( 'timeline_express_random_excerpt_min', 50 ), apply_filters( 'timeline_express_random_excerpt_max', 200 ) );

		return (int) $random_length;

	}

	return (int) apply_filters( 'timeline_express_excerpt_length', $timeline_express_options['excerpt-trim-length'] );

}
add_filter( 'excerpt_length', 'timeline_express_custom_excerpt_length', 999 );

/**
 * Trim the excerpt and add ellipses to the end fo it
 *
 * @param  string $more  The default HTML markup for the read more link.
 *
 * @since 1.2
 */
function timeline_express_custom_read_more( $more ) {

	global $post;

	// if not timeline post
	if ( 'te_announcements' !== get_post_type( $post ) ) {

		return $more;

	}

	$timeline_express_options = timeline_express_get_options();

	// if read more visibility is set to hidden
	if ( '1' !== $timeline_express_options['read-more-visibility'] ) {

		return '';

	}

	// return the default
	return apply_filters( 'timeline_express_read_more_ellipses', '...' );

}
add_filter( 'excerpt_more', 'timeline_express_custom_read_more', 999 );

/**
 * Hook in and generate a read more link below each announcement
 *
 * @return string HTML markup for the new read me link.
 */
function timeline_express_custom_read_more_link() {

	global $post;

	$timeline_express_options = timeline_express_get_options();

	// if read more visibility is set to hidden
	if ( '1' !== $timeline_express_options['read-more-visibility'] ) {

		return;

	}

	echo wp_kses_post( apply_filters( 'timeline_express_read_more_link', '<a class="' . esc_attr( apply_filters( 'timeline_express_read_more_class', 'timeline-express-read-more-link', $post->ID ) ) . '" href="' . apply_filters( 'timeline_express_announcement_permalink', get_permalink( $post->ID ), $post->ID ) . '"> ' . esc_attr( apply_filters( 'timeline_express_read_more_text', esc_html__( 'Read more', 'timeline-express' ), $post->ID ) ) . '</a>', $post->ID ) );

}
add_action( 'timeline-express-after-excerpt', 'timeline_express_custom_read_more_link', 10 );

/**
 * Generate an excerpt of random length
 *
 * @param  int $post_id The announcement ID to retreive the excerpt
 *
 * @return string       The announcement excerpt of random length
 */
function timeline_express_generate_random_announcement( $post_id ) {

	return apply_filters( 'the_content', apply_filters( 'timeline_express_random_excerpt', get_the_excerpt(), $post_id ) );

}

/**
 * Retreive a custom, user defined, field object.
 * This is used after you define custom fields using the timeline_express_custom_fields filter.
 *
 * @param  int    $post_id    The announcement (post) ID whos content you want to retreive.
 * @param  string $meta_name  The name of the meta field (id), whos value you want to retrieve.
 * @param  bool   $array      True/False to return an array. Optional. Default: true.
 *
 * @return array              The announcement content, passed through the_content() filter.
 */
function timeline_express_get_custom_meta( $post_id, $meta_name, $array = true ) {

	/* If no post id was passed in, abort */
	if ( ! $post_id ) {

		return esc_html__( 'You forgot to include the announcement ID.', 'timeline-express' );

	}

	/* If no meta name was passed in, abort */
	if ( ! $meta_name ) {

		return esc_html__( 'You forgot to include the meta key.', 'timeline-express' );

	}

	/* Return the post meta, or false if nothing was found */
	return ( get_post_meta( $post_id, $meta_name, $array ) ) ? get_post_meta( $post_id, $meta_name, $array ) : false;

}

/**
 * Check if any add-ons are installed
 *
 * @since 1.3.0
 */
function get_timeline_express_add_ons() {

	$addons = get_option( 'timeline_express_installed_add_ons', array() );

	ksort( $addons );

	return $addons;

}

/**
 * Check if any add-ons are installed
 *
 * @since 1.3.0
 */
function add_timeline_express_add_on( $add_on_slug ) {

	$installed_add_ons = get_timeline_express_add_ons();

	if ( isset( $installed_add_ons[ $add_on_slug ] ) ) {

		return;

	}

	$installed_add_ons[ $add_on_slug ] = ucwords( str_replace( '-', ' ', $add_on_slug ) );

	update_option( 'timeline_express_installed_add_ons', $installed_add_ons );

	return;

}

/**
 * Check if any add-ons are installed
 *
 * @since 1.3.0
 */
function remove_timeline_express_add_on( $add_on_slug ) {

	$installed_add_ons = get_timeline_express_add_ons();

	if ( isset( $installed_add_ons[ $add_on_slug ] ) ) {

		unset( $installed_add_ons[ $add_on_slug ] );

	}

	update_option( 'timeline_express_installed_add_ons', $installed_add_ons );

	return;

}

if ( ! function_exists( 'timeline_express_generate_page_wrapper_start' ) ) {
	/**
	 * Generate the Timeline Express beginning page wrappers
	 *
	 * @return mixed
	 *
	 * @since 1.2.8.6
	 */
	function timeline_express_generate_page_wrapper_start() {

		get_timeline_express_template( 'page-wrappers-start' );

	}
}

if ( ! function_exists( 'timeline_express_generate_page_wrapper_end' ) ) {
	/**
	 * Generate the Timeline Express ending page wrappers
	 *
	 * @return mixed
	 *
	 * @since 1.2.8.6
	 */
	function timeline_express_generate_page_wrapper_end() {

		get_timeline_express_template( 'page-wrappers-end' );

	}
}

if ( ! function_exists( 'timeline_express_generate_sidebar' ) ) {
	/**
	 * Generate the Timeline Express ending page wrappers
	 *
	 * @return mixed
	 *
	 * @since 1.2.8.6
	 */
	function timeline_express_generate_sidebar() {

		get_timeline_express_template( 'timeline-express-sidebar' );

	}
}

/**
 * Options helpers
 */

/**
 * Genereate the options title and description text
 *
 * @param $active_tab string The current active tab.
 *
 * @since 1.3.0
 */
function timeline_express_generate_options_header( $active_tab ) {

	if ( 'base' === $active_tab ) {

		?>

		<h1 id="timeline-express-page-header">
			<?php esc_html_e( 'Timeline Express Settings', 'timeline-express' ); ?>
		</h1>

		<p class="description">
			<?php esc_html_e( 'Alter your timeline settings here. You can adjust some of the visual settings as well as the display order using the settings below.', 'timeline-express' ); ?>
		</p>

		<?php

		return;

	}

	do_action( 'timeline_express_add_on_options_page_header', $active_tab );

}

/**
 * Generate the options tabs
 *
 * @param $active_tab string The current active tab.
 *
 * @since 1.3.0
 */
function timeline_express_generate_options_tabs( $active_tab ) {

	$active_add_ons = get_timeline_express_add_ons();

	if ( ! empty( $active_add_ons ) ) {

		?>

		<h2 class="nav-tab-wrapper te-options">

		<?php

		$active_add_ons = array(
			'base' => __( 'Timeline Express', 'timeline-express' ),
		) + $active_add_ons;

		foreach ( $active_add_ons as $add_on_slug => $add_on_name ) {

			$active = ( $active_tab === $add_on_slug ) ? 'nav-tab-active' : '';

			printf(
				'<a href="%1$s" class="nav-tab %2$s">%3$s</a>',
				admin_url( 'edit.php?post_type=te_announcements&page=timeline-express-settings&tab=' . $add_on_slug ),
				esc_attr( $active ),
				esc_html( $add_on_name )
			);

		}

		?>

		</h2>

		<?php

	}

}

/*
 * Matches each symbol of PHP date format standard
 * with jQuery equivalent codeword
 * @author Tristan Jahier
 */
function te_dateformat_php_to_jqueryui( $php_format ) {

	$acceptable_formats = (array) apply_filters(
		'timeline_express_jqueryui_acceptable_formats',
		array(
			'm/d/Y',
			'd/m/Y',
			'Y-m-d',
			'Y-d-m',
			'd-m-Y',
			'm-d-Y',
		)
	);

	/**
	 * Loop over each acceptable format and add an associated . date format
	 * eg: m/d/Y => m.d.Y, Y-d-m => Y.d.m etc.
	 *
	 * @var array
	 */
	foreach ( $acceptable_formats as $format ) {

		$acceptable_formats[] = str_replace( '-', '.', str_replace( '/', '.', $format ) );

	}

	$date_format = in_array( $php_format, array_unique( $acceptable_formats ), true ) ? $php_format : 'm/d/Y';

	// if all else fails, return m/d/Y format (eg: 07/17/2017)
	return (string) apply_filters( 'timeline_epxress_jqueryui_date_format', $date_format );

}
