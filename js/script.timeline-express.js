/* Timeline Express Script */
/* By Evan Herman - http://www.Evan-Herman.com/contact/ */


/* Run on document load */
/* Script Used To Fadein Announcements */
jQuery(document).ready(function(){

	// add the necessary classes on page load
	jQuery( 'html' ).addClass( 'cssanimations csscolumns cssgradients cssreflections csstransforms csstransforms3d csstransitions' );

	var timeline_block = jQuery('.cd-timeline-block');

	//hide timeline blocks which are outside the viewport
	timeline_block.each(function(){
		if(jQuery(this).offset().top > jQuery(window).scrollTop()+jQuery(window).height()*0.75) {
			jQuery(this).find('.cd-timeline-img, .cd-timeline-content').addClass('is-hidden');
		}
	});

	//on scolling, show/animate timeline blocks when enter the viewport
	jQuery(window).on('scroll', function(){
		timeline_block.each(function(){
			if( jQuery(this).offset().top <= jQuery(window).scrollTop()+jQuery(window).height()*0.75 && jQuery(this).find('.cd-timeline-img').hasClass('is-hidden') ) {
				jQuery(this).find('.cd-timeline-img, .cd-timeline-content').removeClass('is-hidden').addClass('bounce-in');
			}
		});
	});
	
	var $masonryContainer = jQuery( '#cd-timeline' );
	$masonryContainer.imagesLoaded( function() {
		$masonryContainer.masonry({itemSelector : '.cd-timeline-block',});
	});
	
	var entry_content_width = jQuery( '#cd-timeline' ).parents('div').css('width');
	var width = jQuery(window).width() + parseInt(17);
	var timeline_content_width = jQuery( '.cd-timeline-content' ).css('width');

	// medium content width (twenty thirteen)
	if ( width <= 822 && ( entry_content_width.replace( 'px' , '' ) <= '475' && entry_content_width.replace( 'px' , '' ) <= '800' ) ) {
		jQuery( '.cd-timeline-content' ).removeClass( 'timeline-width34' );
	} else if ( width >= 822 && ( entry_content_width.replace( 'px' , '' ) >= '475' && entry_content_width.replace( 'px' , '' ) <= '800' ) ) {
		jQuery( '.cd-timeline-content' ).addClass( 'timeline-width34' );
	}
	
	// narrow content widths (twenty fourteen)
	if ( width <= 822 && entry_content_width.replace( 'px' , '' ) <= '475' ) {
		jQuery( '.cd-timeline-content' ).removeClass( 'timeline-width30' );
	} else if ( width >= 822 && entry_content_width.replace( 'px' , '' ) <= '475' ) {
		jQuery( '.cd-timeline-content' ).addClass( 'timeline-width30' );
	}
	
	// if the content is narrow (twenty thirteen)
	if ( timeline_content_width.replace( 'px' , '' ) < 262 ) {
		jQuery( '.cd-timeline-content' ).find( '.timeline-date' ).addClass( 'timeline-date-left' );
	}
	
	// resize funciton
	jQuery(window).resize(function() {
	
		var width = jQuery(window).width() + parseInt(17);
		var entry_content_width = jQuery( '#cd-timeline' ).parents('div').css('width');
		var timeline_content_width = jQuery( '.cd-timeline-content' ).css('width');
				
		if ( width >= '822' && entry_content_width.replace( 'px' , '' ) <= '475' ) {	
			jQuery( '.cd-timeline-content' ).addClass( 'timeline-width30' );
		}
		
		if ( width >= '822' && timeline_content_width.replace( 'px' , '' ) < 262 ) {
			jQuery( '.cd-timeline-content' ).find( '.timeline-date' ).addClass( 'timeline-date-left' );
		} else {
			jQuery( '.cd-timeline-content' ).find( '.timeline-date' ).removeClass( 'timeline-date-left' );
		}
		
		if ( ( width < '822' ) ) {
			
			jQuery( '#cd-timeline' ).masonry('reload');
			jQuery( '.cd-timeline-content' ).removeClass( 'timeline-width30' ).removeClass( 'timeline-width34' );
			
		
		}
		
	});
	
});