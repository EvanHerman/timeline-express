/* Timeline Express Script */
/* By Evan Herman - http://www.Evan-Herman.com/contact/ */


/* Run on document load */
/* Script Used To Fadein Announcements */
jQuery(document).ready(function(){

	// add the necessary classes on page load
	jQuery( 'html' ).addClass( 'cssanimations csscolumns cssgradients cssreflections csstransforms csstransforms3d csstransitions' );

	var timeline_block = jQuery( '.cd-timeline-block' );

	//hide timeline blocks which are outside the viewport
	timeline_block.each(function(){
		if( jQuery(this).offset().top > jQuery( window ).scrollTop() + jQuery( window ).height() * 0.75 ) {
			/* If the animation is set to disabled, do not hide the items */
			if ( timeline_express_data.animation_disabled ) {
				return;
			}
			/* add the animation class */
			jQuery( this ).find( '.cd-timeline-img, .cd-timeline-content' ).addClass( 'is-hidden' );
		}
	});

	/* on scolling, show/animate timeline blocks when enter the viewport */
	jQuery( window ).on( 'scroll', function() {
		timeline_block.each( function() {
			if( jQuery( this ).offset().top <= jQuery( window ).scrollTop() + jQuery( window ).height() * 0.75 && jQuery( this ).find( '.cd-timeline-img' ).hasClass( 'is-hidden' ) ) {
				jQuery( this ).find( '.cd-timeline-img, .cd-timeline-content' ).removeClass( 'is-hidden' ).addClass( 'bounce-in' );
			}
		});
	});

	var $masonryContainer = jQuery( '#cd-timeline' );
	$masonryContainer.imagesLoaded( function() {
		$masonryContainer.masonry({ itemSelector : '.cd-timeline-block', });
		jQuery( '#cd-timeline' ).fadeTo( 600 , 1 );
	});
});
