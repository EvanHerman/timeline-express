/**
 * Timeline Express Script
 *
 * @author Code Parrots <codeparrots@gmail.com>
 *
 * @since 1.0.0
 */

jQuery( document ).ready(function(){

	// Dispatch event timelineLayoutStart when timeline layout starts
	window.dispatchEvent( new CustomEvent( 'timelineLayoutStart' ) );

	// add the necessary classes on page load
	jQuery( 'html' ).addClass( 'cssanimations csscolumns cssgradients cssreflections csstransforms csstransforms3d csstransitions' );

	var timeline_block = jQuery( '.cd-timeline-block' );

	//hide timeline blocks which are outside the viewport
	timeline_block.each( function() {

		/* If the animation is set to disabled, do not hide the items */
		if ( timeline_express_data.animation_disabled ) {

			return;

		}

		if ( jQuery( this ).offset().top > jQuery( window ).scrollTop() + jQuery( window ).height() * 0.75 ) {

			/* add the animation class */
			jQuery( this ).find( '.cd-timeline-img, .cd-timeline-content' ).addClass( 'is-hidden' );

		}

	} );

	/* If the animation is set to disabled, do not perform the scroll callback */
	if ( ! timeline_express_data.animation_disabled ) {

		/* on scolling, show/animate timeline blocks when enter the viewport */
		jQuery( window ).on( 'scroll', function() {

			timeline_block.each( function() {

				if ( jQuery( this ).offset().top <= jQuery( window ).scrollTop() + jQuery( window ).height() * 0.75 && jQuery( this ).find( '.cd-timeline-img' ).hasClass( 'is-hidden' ) ) {

					jQuery( this ).find( '.cd-timeline-img, .cd-timeline-content' ).removeClass( 'is-hidden' ).addClass( 'bounce-in' );

				}

			} );

		} );

	}

	// Dispatch event timelineLayoutComplete when timeline layout is completed
	window.dispatchEvent( new CustomEvent( 'timelineLayoutComplete' ) );

} );
