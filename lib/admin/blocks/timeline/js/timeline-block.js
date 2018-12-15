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
      default: '-1',
    },
    displayOrder: {
      type: 'string',
      default: 'ASC',
    },
    timeFrame: {
      type: 'string',
      default: 'all',
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
              min="-1"
              id="announcement-limit"
              label={ __( 'Announcement Limit', 'timeline-express' ) }
              value={ announcementLimit }
              onChange={ ( announcementLimit ) => props.setAttributes( { announcementLimit } ) }
            />
          </PanelRow>

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

          <PanelRow>
            <SelectControl
              id="time-frame"
              label={ __( 'Display Time Frame', 'timeline-express' ) }
              options={ [
                { label: __( 'All (Past + Future)', 'timeline-express' ), value: 'all' },
                { label: __( 'Future', 'timeline-express' ), value: 'future' },
                { label: __( 'Past', 'timeline-express' ), value: 'past' },
              ] }
              value={ timeFrame }
              onChange={ ( timeFrame ) => props.setAttributes( { timeFrame } ) }
            />
          </PanelRow>

        </PanelBody>
      </InspectorControls>,

      <div
        className={ className }
        key={ className }
      >
        <div class="timeline-target"><img src={ timelineBlocks.preloader } className="te-preloader" />{ renderTimeline( props.attributes ) }</div>
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

	$( '.timeline-target' ).html( '<img src="' + timelineBlocks.preloader + '" class="te-preloader" />' );

	var data = {
		'action': 'get_timeline_markup',
		'announcementLimit': atts.announcementLimit,
		'displayOrder': atts.displayOrder,
		'timeFrame': atts.timeFrame,
	};

	$.post( ajaxurl, data, function( response ) {

		if ( ! response.success ) {

			$( '.timeline-target' ).html( timelineBlocks.getTimelineError );

			return;

		}

		$( '.timeline-target' ).html( response.data );

	} );

}
