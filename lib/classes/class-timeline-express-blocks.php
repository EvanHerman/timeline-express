<?php

if ( ! defined( 'ABSPATH' ) ) {

	exit;

}

class Timeline_Express_Content_Blocks {

	private $options;

	public function __construct() {

		$this->options = timeline_express_get_options();

		add_action( 'enqueue_block_editor_assets', array( $this, 'enqueue_block_scripts' ) );

		add_action( 'wp_ajax_get_timeline_markup', array( $this, 'get_timeline_markup' ) );

	}

	/**
	 * Enqueue content block scripts.
	 *
	 * @action enqueue_block_editor_assets
	 *
	 * @since 1.8.0
	 */
	public function enqueue_block_scripts() {

		$suffix  = SCRIPT_DEBUG ? '' : '.min';
		$minpath = SCRIPT_DEBUG ? '../admin/js/timeline-express-blocks.js' : '../admin/js/min/timeline-express-blocks.min.js';

		new Timeline_Express_Initialize();

		wp_enqueue_script( 'timeline-express-blocks', plugins_url( $minpath, __FILE__ ), array( 'wp-i18n', 'wp-element', 'wp-blocks', 'wp-components' ), TIMELINE_EXPRESS_VERSION_CURRENT, true );

		wp_localize_script(
			'timeline-express-blocks',
			'timelineBlock',
			array(
				'preloader'            => admin_url( 'images/wpspin_light-2x.gif' ),
				'animation_disabled'   => ( isset( $this->options['disable-animation'] ) && $this->options['disable-animation'] ) ? true : false,
				'getTimelineError'     => __( 'There was an error generating the timeline. Please try again.', 'timeline-express' ),
				'displayOrder'         => $this->options['announcement-display-order'],
				'timeFrame'            => ( '0' === $this->options['announcement-time-frame'] ) ? 'future' : ( '1' === $this->options['announcement-time-frame'] ? 'all' : 'past' ),
				'announcementSingular' => (string) apply_filters( 'timeline_express_singular_name', esc_html__( 'Announcement', 'timeline-express' ) ),
			)
		);

		wp_enqueue_style( 'timeline-express-blocks', plugins_url( "../admin/blocks/timeline/css/timeline-block{$suffix}.css", __FILE__ ), array(), TIMELINE_EXPRESS_VERSION_CURRENT, 'all' );

	}

	/**
	 * Render the timeline markup, AJAX handler
	 *
	 * @return mixed Markup for the timeline
	 */
	public function get_timeline_markup() {

		$limit     = filter_input( INPUT_POST, 'announcementLimit', FILTER_SANITIZE_NUMBER_INT );
		$order     = filter_input( INPUT_POST, 'displayOrder', FILTER_SANITIZE_STRING );
		$timeframe = filter_input( INPUT_POST, 'timeFrame', FILTER_SANITIZE_STRING );

		$defaults = array(
			'limit'   => ! $limit ? -1 : $limit,
			'order'   => ! $order ? $this->options['announcement-display-order'] : $order,
			'display' => ! $timeframe ? $this->options['announcement-time-frame'] : $timeframe,
		);

		apply_filters( 'timeline_express_disable_cache', '__return_true' );

		$timeline_express_init = new Timeline_Express_Initialize();

		wp_send_json_success( $timeline_express_init->generate_timeline_express( $this->options, $defaults ) );

	}

}

new Timeline_Express_Content_Blocks();
