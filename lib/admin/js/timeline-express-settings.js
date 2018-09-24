( function( $ ) {

	/**
	 * Toggle the active cache setting.
	 */
	var toggleCache = {

		init: function() {

			var labelText = this.checked ? timelineExpressSettings.siwtchLabels.toggleCache.enabled : timelineExpressSettings.siwtchLabels.toggleCache.disabled,
					$label    = $( this ).closest( '.p-switch' ).find( 'label' );

			$label.text( labelText );

			toggleCache.toggleCache( this.checked );

		},

		toggleCache: function( cacheEnabled ) {

			var data = {
				'action': 'timeline_express_toggle_cache',
				'cacheEnabled': cacheEnabled,
			};

			$.post( ajaxurl, data, function( response ) {} );

		},

	};

	$( document ).on( 'change', '.timeline-express-toggle-cache', toggleCache.init );

} )( jQuery );
