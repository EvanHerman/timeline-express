<?php
$screen = get_current_screen();
$screen_base = $screen->base;
$http = ( is_ssl() ) ? 'https:' : 'http:';
$font_awesome_version = apply_filters( 'timeline_express_font_awesome_version', '4.6.1' );

// Store our response in a transient for faster page loading
if ( false === ( $response = get_transient( 'te_font_awesome_transient' ) ) ) {
	// get the icons out of the css file
	// based on https or http...
	$response = wp_remote_get( $http . '//netdna.bootstrapcdn.com/font-awesome/' . $font_awesome_version . '/css/font-awesome.css' );

	if ( is_wp_error( $response ) ) {
		// load font awesome locally
		$response = wp_remote_get( TIMELINE_EXPRESS_URL . 'lib/icons/css/font-awesome.css' );
	}

	// It wasn't there, so regenerate the data and save the transient
	set_transient( 'te_font_awesome_transient', $response, 12 * HOUR_IN_SECONDS );
}


// splot the response body, and store the icon classes in a variable
$split_dat_response = explode( 'icons */' , $response['body'] );


// replace the unecessary stuff
$data = str_replace( ';' , '' , str_replace( ':before' , '' , str_replace( '}' , '' , str_replace( 'content' , '' , str_replace( '{' , '' , $split_dat_response[1] ) ) ) ) );
$icon_data = explode( '.fa-' , $data );
$i = 1;

// Get our icon array
$bootstrap_icon_array = build_bootstrap_icons_array( $icon_data );

$flat_bootstrap_icon_array = array();
foreach ( $bootstrap_icon_array as $array ) {
	foreach ( $array as $k => $v ) {
		 $flat_bootstrap_icon_array[$k] = $v;
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
// check which page were on, set name appropriately
if ( isset( $field->args['id'] ) ) {
	$field_name = $field->args['id'];
} else {
	$field_name = 'default-announcement-icon';
}
?>

<!-- start the font awesome icon select -->
<select class="selectpicker" name="<?php esc_attr_e( $field_name ); ?>" id="default-announcement-icon>">

	<?php
	/* sort the bootstrap icons alphabetically */
	sort( $flat_bootstrap_icon_array );
	foreach ( $flat_bootstrap_icon_array as $icon ) {
	?>
		<option class="fa" data-icon="fa-<?php esc_attr_e( $icon ); ?>" <?php selected( 'fa-'.$icon, $escaped_value ); ?>><?php esc_attr_e( $icon ); ?></option>
	<?php
	}
	?>

</select>
<!-- end select -->

<?php
if ( 'te_announcements_page_timeline-express-settings' !== $screen_base ) {
	echo '<p class="cmb_metabox_description">' . esc_attr__( $field->args['desc'] ).'</p>';
}
