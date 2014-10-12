/* 
Timeline Express by Evan Herman - http://www.Evan-Herman.com
	- Initialize our color pickers
*/
jQuery(document).ready(function() {

    // Add Color Picker to all inputs that have 'color-field' class
    jQuery('.color-picker-field').wpColorPicker();
     
	// disable sortable on the metaboxes
	jQuery('.meta-box-sortables').sortable({
			disabled: true
		});

    jQuery('.postbox .hndle').css('cursor', 'pointer');	

	 
});