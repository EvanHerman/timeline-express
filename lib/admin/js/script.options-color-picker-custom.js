/**
 * Timeline Express Color Picker Scripts
 * Initialize our color pickers
 *
 * @author CodeParrots
 *
 * @since  1.2
 *
 * @link http://www.codeparrots.com
*/
jQuery(document).ready( function() {

	if( jQuery( '.color-picker-field' ).length ) {

		// Add Color Picker to all inputs that have 'color-field' class
		jQuery('.color-picker-field').wpColorPicker();

		// disable sortable on the metaboxes
		jQuery('.meta-box-sortables').sortable({
			disabled: true
		});

		jQuery('.postbox .hndle').css('cursor', 'pointer');

	}

} );

// Excerpt trim length toggle
function changeRandomTrimLengthCheckbox() {

	var newOptinValue = jQuery('input[name="excerpt-random-length"]').prop('checked');

	if ( newOptinValue === '1' ) {

		jQuery('input[name="excerpt-trim-length"]').fadeOut('fast',function() {

			jQuery('input[name="excerpt-random-length"]').css('margin-left','0em');

		});

		jQuery('#random-lenth-text-container').removeClass('random-length-text');

	} else {

		jQuery('input[name="excerpt-random-length"]').css('margin-left','.5em');

		jQuery('input[name="excerpt-trim-length"]').fadeIn('fast');

		jQuery('#random-lenth-text-container').addClass('random-length-text');

	}

}

// Delete announcements checkbox toggle
function toggleDeleteCheckClass() {

	var deletePostsCheckboxValue = jQuery('input[name="delete-announcement-posts-on-uninstallation"]').prop('checked');

	if ( deletePostsCheckboxValue === true ) {

		jQuery('.delete-no').addClass('delete-yes');

		jQuery('.delete-yes').removeClass('delete-no');

	} else {

		jQuery('.delete-yes').addClass('delete-no');

		jQuery('.delete-no').removeClass('delete-yes');

	}

}
