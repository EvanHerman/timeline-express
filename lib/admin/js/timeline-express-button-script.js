/* Custom Timeline Express TinyMCE Button -> Shortcode */
( function() {

	tinymce.PluginManager.add( 'timeline_express', function( editor, url ) {

		function disabled_button_on_click() {

			this.disabled( ! this.disabled() );

			editor.insertContent( '[timeline-express]' );

		}

		function re_enable_button() {

			var state = this.enabled();

		}

		editor.on( 'keyup', function() {

			// re-enable our button once the shortcode has been deleted
			// we'll wait all the way till [timeline-express]
			if ( editor.getContent().indexOf( '[timeline-express]' ) > -1 ) {

				editor.controlManager.setDisabled( 'timeline_express_shortcode_button', true );

			} else {

				editor.controlManager.setDisabled( 'timeline_express_shortcode_button', false );

			}

		} );

		// Add a button that drops in our shortcode
		editor.addButton( 'timeline_express_shortcode_button', {
			title: 'Timeline Express Shortcode',
			text: false,
			image: url + '/../../images/timeline-express-menu-icon.png',
			onclick: disabled_button_on_click
		} );

		// disable the button if the shortcode exists (when loading a previously saved page/post etc)
		editor.onSetContent.add( function( editor, o ) {

			if ( editor.getContent().indexOf( '[timeline-express]' ) > -1 ) {

				editor.controlManager.setDisabled( 'timeline_express_shortcode_button', true );

			}

		} );

	} );

}() );
