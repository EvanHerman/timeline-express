<?php
$screen = get_current_screen();
$screen_base = $screen->base;
$http = ( is_ssl() ) ? 'https:' : 'http:';
$font_awesome_version = apply_filters( 'timeline_express_font_awesome_version', '4.5.0' );

// Store our response in a transient for faster page loading
if ( false === ( $response = get_transient( 'te_font_awesome_transient' ) ) ) {
	// get the icons out of the css file
	// based on https or http...
	$response = wp_remote_get( $http . '//netdna.bootstrapcdn.com/font-awesome/' . $font_awesome_version . '/css/font-awesome.css' );

	if( is_wp_error( $response ) ) {
		// load font awesome locally
		$response = wp_remote_get( TIMELINE_EXPRESS_URL . 'lib/icons/css/font-awesome.css' );
	}

	// It wasn't there, so regenerate the data and save the transient
	set_transient( 'te_font_awesome_transient', $response );
}


// splot the response body, and store the icon classes in a variable
$split_dat_response = explode( 'icons */' , $response['body'] );

// empty array for icon array
$bootstrap_icon_array = array();

// replace the unecessary stuff
$data = str_replace( ';' , '' , str_replace( ':before' , '' , str_replace( '}' , '' , str_replace( 'content' , '' , str_replace( '{' , '' , $split_dat_response[1] ) ) ) ) );
$icon_data = explode( '.fa-' , $data );
$i = 1;

foreach( array_slice($icon_data,1) as $key => $value) {
	$split_icon = explode( ':' , $value );
	if( isset( $split_icon[1] ) ) {
		$bootstrap_icon_array[] = array( trim( 'fa-' . $split_icon[0] ) => trim( $split_icon[0] ) );
	}
	$i++;
}

$flat_bootstrap_icon_array = array();
foreach($bootstrap_icon_array as $array) {
	foreach($array as $k=>$v) {
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
	if( isset( $field->args['id'] ) ) {
		$field_name = $field->args['id'];
	} else {
		$field_name = 'default-announcement-icon';
	}
?>

<!-- start the font awesome icon select -->
<select class="selectpicker" name="<?php echo $field_name; ?>" id="default-announcement-icon>">

	<?php
		/* sort the bootstrap icons alphabetically */
		sort( $flat_bootstrap_icon_array );
		foreach( $flat_bootstrap_icon_array as $icon ) {
	?>

	<option class="fa" data-icon="fa-<?php echo $icon; ?>" <?php selected( 'fa-'.$icon, $escaped_value ); ?>><?php echo $icon; ?></option>

	<?php
		}
	?>

</select>
<!-- end select -->

<?php
if( 'te_announcements_page_timeline-express-settings' != $screen_base ) {
	echo '<p class="cmb_metabox_description">'.$field->args['desc'].'</p>';
}
