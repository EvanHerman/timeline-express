/* Timeline Express Script */
/* By Evan Herman - http://www.Evan-Herman.com/contact/ */


/* Run on document load */
/* Script Used To Fadein Announcements */
jQuery(document).ready(function(){

	// add the necessary classes on page load
	jQuery( 'html' ).addClass( 'cssanimations csscolumns cssgradients cssreflections csstransforms csstransforms3d csstransitions' );

	var timeline_block = jQuery( '.cd-timeline-block' );

	// Check for collisions
	check_collisions( timeline_block );

	//hide timeline blocks which are outside the viewport
	timeline_block.each( function() {
		/* If the animation is set to disabled, do not hide the items */
		if ( timeline_express_data.animation_disabled ) {
			return;
		}
		if( jQuery(this).offset().top > jQuery( window ).scrollTop() + jQuery( window ).height() * 0.75 ) {
			/* add the animation class */
			jQuery( this ).find( '.cd-timeline-img, .cd-timeline-content' ).addClass( 'is-hidden' );
		}
	});

	/* If the animation is set to disabled, do not perform the scroll callback */
	if ( ! timeline_express_data.animation_disabled ) {
		/* on scolling, show/animate timeline blocks when enter the viewport */
		jQuery( window ).on( 'scroll', function() {
			timeline_block.each( function() {
				if( jQuery( this ).offset().top <= jQuery( window ).scrollTop() + jQuery( window ).height() * 0.75 && jQuery( this ).find( '.cd-timeline-img' ).hasClass( 'is-hidden' ) ) {
					jQuery( this ).find( '.cd-timeline-img, .cd-timeline-content' ).removeClass( 'is-hidden' ).addClass( 'bounce-in' );
				}
			});
		});
	}

	var $masonryContainer = jQuery( '.timeline-express' );
	$masonryContainer.imagesLoaded( function() {
		$masonryContainer.masonry({ itemSelector : '.cd-timeline-block', });
		jQuery( '.timeline-express' ).fadeTo( 'fast' , 1 );
	});
});

/**
 * Check collisions between containers
 * @param  {[type]} containers [description]
 * @return {[type]}            [description]
 */
function check_collisions( containers ) {
	var x = 1;
	containers.each( function() {
		var curr_item = jQuery( this )[0];
		var current_item_position = getPositions( curr_item );

		var next_item = ( jQuery( this ).next().hasClass( 'cd-timeline-block' ) ) ? jQuery( this ).next().next()[0] : false;

		if ( next_item ) {
			var next_item_position = getPositions( next_item );
			if ( comparePositions( current_item_position, next_item_position ) ) {
				var current_margin_bottom = jQuery( this ).css( 'margin-bottom' ).replace( 'px', '' ).trim();
				current_margin_bottom = parseInt( current_margin_bottom ) + parseInt( 30 );
				jQuery( this ).css( 'margin-bottom', current_margin_bottom + 'px' );
				check_collisions( jQuery( '.cd-timeline-block' ) );
			} else {
				initialize_timeline_express_container( '.timeline-express' );
			}
		}
		x++;
	});
}

// Get positions of box
function getPositions( box ) {
  var $box = jQuery(box);
  var pos = $box.position();
  var width = $box.width();
  var height = $box.height();
	// Top position, top position + height of container
	return [ pos.top, pos.top + height ];
}

// Compare the positions, for collisions
function comparePositions( p1, p2 ) {
  var x1 = p1[0] < p2[0] ? p1 : p2;
  var x2 = p1[0] < p2[0] ? p2 : p1;
	return x1[1] > x2[0] || x1[0] === x2[0] ? true : false;
}

/**
 * Initialize the timeline container, passing in the parent element ID/class (.timeline-express)
 * @param  object timeline_express_container The container to initialize (eg: .timeline-express)
 * @return object                            The masonry instance passed back for usage
 */
function initialize_timeline_express_container( timeline_express_container ) {
	if ( typeof timeline_express_container === 'undefined' ) {
		/* Store the timeline parent container */
		timeline_express_container = document.querySelector( '.timeline-express' );
	}
	// layout the masonry timeline
	var msnry = new Masonry( timeline_express_container, {
		"itemSelector" : ".cd-timeline-block"
	});
	setTimeout( function() {
		// layout the masonry timeline
		var msnry = new Masonry( timeline_express_container, {
			"itemSelector" : ".cd-timeline-block"
		});
	}, 50);
	return msnry;
}
