import timelineBlockIcons from './icons';

/**
 * Internal block libraries
 */
const { __ } = wp.i18n;

const {
    registerBlockType
} = wp.blocks;

const {
  InspectorControls,
  RichText
} = wp.editor;

const {
    Toolbar,
    Button,
    Tooltip,
    PanelBody,
    PanelRow,
    FormToggle,
    TextControl
} = wp.components;

/**
 * Register block
 */
export default registerBlockType( 'timeline-express/timeline-block', {
  title: __( 'Timeline', 'timeline-express' ),
  description: __( 'Display a beautiful timeline of events on your site.', 'timeline-express' ),
  category: 'widgets',
  icon: timelineBlockIcons.timeline,
  keywords: [
    __( 'Timeline', 'timeline-express' ),
    __( 'Express', 'timeline-express' ),
    __( 'CodeParrots', 'timeline-express' ),
  ],
  attributes: {
    title: {
      type: 'string',
      source: 'text',
      selector: '.contact-title',
    },
    displayLabels: {
      type: 'boolean',
      default: true,
    },
  },
  edit: props => {

    const { attributes: { title, displayLabels }, isSelected, className, setAttributes } = props;
    const toggleDisplayLabels = () => setAttributes( { displayLabels: ! displayLabels } );

    return [

      // Inspector Controls
      <InspectorControls key="contact-block-inspector-controls">
        <PanelBody
          title={ __( 'Contact Details Controls', 'timeline-express' ) }
        >
          <PanelRow>
            <label htmlFor="display-labels-toggle" >
              { __( 'Display Labels', 'timeline-express' ) }
            </label>
            <FormToggle
              id="display-labels-toggle"
              label={ __( 'Display Labels', 'timeline-express' ) }
              checked={ displayLabels }
              onChange={ toggleDisplayLabels }
            />
          </PanelRow>
        </PanelBody>
      </InspectorControls>,

      // Admin Block Markup
      <div
        className={ className }
        key={ className }
      >
        <div class="timeline-target"><img src={ timelineBlocks.preloader } className="te-preloader" />{ renderTimeline( true ) }</div>
      </div>
    ];
  },

  save: props => {

    const { attributes: { title, displayLabels }, className } = props;

    return (
      <div
      className={ className }
      key={ className }
      >
        [timeline-express]
      </div>
    );
  },
} );

/**
 * Render the timeline, AJAX handler
 *
 * @since NEXT
 */
function renderTimeline( replaceContent ) {

	var data = {
		'action': 'get_timeline_markup'
	};

	$.post( ajaxurl, data, function( response ) {

		if ( ! response.success ) {

			return;

		}

		if ( replaceContent ) {

			$( '.timeline-target' ).html( response.data );

		} else {

			return response.data;

		}

	} );

}


/**
 * Timeline Express Script
 *
 * @author Code Parrots <codeparrots@gmail.com>
 *
 * @since 1.0.0
 */

jQuery( window ).load( function() {

	// Dispatch event timelineLayoutStart when timeline layout starts
	window.dispatchEvent( new CustomEvent( 'timelineLayoutStart' ) );

	// add the necessary classes on page load
	jQuery( 'html' ).addClass( 'cssanimations csscolumns cssgradients cssreflections csstransforms csstransforms3d csstransitions' );

	var timeline_block = jQuery( '.cd-timeline-block' );

	// hide timeline blocks which are outside the viewport
	timeline_block.each( function() {

		/* If the animation is set to disabled, do not hide the items */
		if ( timelineBlocks.animation_disabled ) {

			return;

		}

		if ( jQuery( this ).offset().top > jQuery( '.edit-post-layout__content' ).scrollTop() + jQuery( '.edit-post-layout__content' ).height() * 0.75 ) {

			/* add the animation class */
			jQuery( this ).find( '.cd-timeline-img, .cd-timeline-content' ).addClass( 'is-hidden' );

		}

	} );

	/* If the animation is set to disabled, do not perform the scroll callback */
	if ( ! timelineBlocks.animation_disabled ) {

		/* on scolling, show/animate timeline blocks when enter the viewport */
		jQuery( '.edit-post-layout__content' ).on( 'scroll', function() {

			timeline_block.each( function() {

				if ( jQuery( this ).offset().top <= jQuery( '.edit-post-layout__content' ).scrollTop() + jQuery( '.edit-post-layout__content' ).height() * 0.75 && jQuery( this ).find( '.cd-timeline-img' ).hasClass( 'is-hidden' ) ) {

					jQuery( this ).find( '.cd-timeline-img, .cd-timeline-content' ).removeClass( 'is-hidden' ).addClass( 'bounce-in' );

				}

			} );

		} );

	}

	// Dispatch event timelineLayoutComplete when timeline layout is completed
	window.dispatchEvent( new CustomEvent( 'timelineLayoutComplete' ) );

} );
