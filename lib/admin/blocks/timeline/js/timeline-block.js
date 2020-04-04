import timelineBlockIcons from './icons';

/**
 * Internal block libraries
 */
const { __ } = wp.i18n;

const {
  registerBlockType
} = wp.blocks;

const {
  InspectorControls
} = wp.editor;

const {
  PanelBody,
  PanelRow,
  TextControl,
  SelectControl
} = wp.components;

/**
 * Register block
 */
export default registerBlockType( 'timeline-express/timeline-block', {
  title: __( 'Timeline', 'timeline-express' ),
  description: __( 'Display a beautiful timeline of events on your site.', 'timeline-express' ),
  category: 'widgets',
  icon: timelineBlockIcons.timelineIcon,
  keywords: [
    __( 'Timeline', 'timeline-express' ),
    __( 'Express', 'timeline-express' ),
    __( 'CodeParrots', 'timeline-express' ),
  ],
  attributes: {
    announcementLimit: {
      type: 'string',
      default: '10',
    },
    displayOrder: {
      type: 'string',
      default: timelineBlock.displayOrder,
    },
    timeFrame: {
      type: 'string',
      default: timelineBlock.timeFrame,
    },
  },
  edit: props => {

    const { attributes: { announcementLimit, displayOrder, timeFrame }, className, setAttributes } = props;

    return [

      <InspectorControls key="timeline-block-inspector-controls">
        <PanelBody
          title={ __( 'Timeline Express', 'timeline-express' ) }
          className="timeline-block-inspector-controls"
        >

          <PanelRow>
            <TextControl
              type="number"
              min="0"
              id="announcement-limit"
              label={ sprintf( __( '%s Limit', 'timeline-express' ), timelineBlock.announcementSingular ) }
              value={ announcementLimit }
              onChange={ ( announcementLimit ) => props.setAttributes( { announcementLimit } ) }
            />
          </PanelRow>
          <p className="description">{ __( 'Set the number of announcemnets to display on the timeline. Set to 0 for no limit.', 'timeline-express' ) }</p>

          <PanelRow>
            <SelectControl
              id="display-order"
              label={ __( 'Display Order', 'timeline-express' ) }
              options={ [
                { label: __( 'Ascending', 'timeline-express' ), value: 'ASC' },
                { label: __( 'Descending', 'timeline-express' ), value: 'DESC' },
              ] }
              value={ displayOrder }
              onChange={ ( displayOrder ) => props.setAttributes( { displayOrder } ) }
            />
          </PanelRow>
          <p className="description">{ __( 'Set the display order of the announcements.', 'timeline-express' ) }</p>

          <PanelRow>
            <SelectControl
              id="time-frame"
              label={ __( 'Time Frame', 'timeline-express' ) }
              options={ [
                { label: __( 'All (Past + Future)', 'timeline-express' ), value: 'all' },
                { label: __( 'Future', 'timeline-express' ), value: 'future' },
                { label: __( 'Past', 'timeline-express' ), value: 'past' },
              ] }
              value={ timeFrame }
              onChange={ ( timeFrame ) => props.setAttributes( { timeFrame } ) }
            />
          </PanelRow>
          <p className="description">{ __( 'Set the time frame for the announcements.', 'timeline-express' ) }</p>

        </PanelBody>
      </InspectorControls>,

      <div
        className={ className }
        key={ className }
      >
        <div class="timeline-target"><img src={ timelineBlock.preloader } className="te-preloader" />{ renderTimeline( props.attributes ) }</div>
      </div>

    ];
  },

  save: props => {

    const { attributes: { announcementLimit, displayOrder, timeFrame }, className } = props;

    return (
      <div
        className={ className }
        key={ className }
      >
        [timeline-express limit={ announcementLimit } order={ displayOrder } display={ timeFrame }]
      </div>
    );

  },
} );

/**
 * Render the timeline, AJAX handler
 *
 * @since NEXT
 */
function renderTimeline( atts ) {

	jQuery( '.timeline-target' ).html( '<img src="' + timelineBlock.preloader + '" class="te-preloader" />' );

	var data = {
		'action': 'get_timeline_markup',
		'announcementLimit': atts.announcementLimit,
		'displayOrder': atts.displayOrder,
		'timeFrame': atts.timeFrame,
	};

	jQuery.post( ajaxurl, data, function( response ) {

		if ( ! response.success ) {

			jQuery( '.timeline-target' ).html( timelineBlock.getTimelineError );

			return;

		}

		jQuery( '.timeline-target' ).html( response.data );

	} );

}

jQuery( 'body' ).on( 'click', '.timeline-express-read-more-link', function( e ) {
  e.preventDefault();
} );
