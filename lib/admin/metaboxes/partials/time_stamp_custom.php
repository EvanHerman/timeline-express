<?php

// get date picker depencies
CMB2_JS::add_dependencies( array( 'jquery-ui-core', 'jquery-ui-datepicker' ) );
?>

<style>
	#ui-datepicker-div { z-index: 99999 !important; }
	#wpbody-content { overflow: hidden !important; }
	.cmb_id_announcement_image td .cmb_upload_button { height: 32px !important; }
</style>

<?php
if( $meta && isset( $meta ) ) {
	echo '<input class="cmb2-text-small cmb2-datepicker" type="text" name="', $field->args['id'], '" id="', $field->args['id'], '" value="', '' !== $meta ? apply_filters( 'timeline_express_admin_render_date_format', date( 'm/d/Y' , $meta ), $meta ) : $field->args['default'], '" />';
	echo '<p class="cmb_metabox_description">'.$field->args['desc'].'</p>';
} else{
	echo '<input class="cmb2-text-small cmb2-datepicker" type="text" name="', $field->args['id'], '" id="', $field->args['id'], '" value="' . apply_filters( 'timeline_express_admin_render_date_format', date('m/d/Y' ), false ) .'" />';
	echo '<p class="cmb_metabox_description">'.$field->args['desc'].'</p>';
}
