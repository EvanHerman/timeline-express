<?php

if ( ! defined( 'ABSPATH' ) ) {

	exit;

}

class Timeline_Express_Content_Blocks {

	public function __construct() {

		add_action( 'enqueue_block_editor_assets', array( $this, 'enqueue_block_scripts' ) );

		add_action( 'wp_ajax_get_timeline_markup', array( $this, 'get_timeline_markup' ) );

	}

	/**
	 * Enqueue content block scripts.
	 *
	 * @action enqueue_block_editor_assets
	 *
	 * @since NEXT
	 */
	public function enqueue_block_scripts() {

		new Timeline_Express_Initialize();

		$minpath = SCRIPT_DEBUG ? '../admin/js/timeline-express-blocks.js' : '../admin/js/min/timeline-express-blocks.min.js';

		wp_enqueue_script( 'timeline-express-blocks', plugins_url( $minpath, __FILE__ ), array( 'wp-i18n', 'wp-element', 'wp-blocks', 'wp-components' ), TIMELINE_EXPRESS_VERSION_CURRENT, true );

		wp_localize_script(
			'timeline-express-blocks',
			'timelineBlocks',
			array(
				'preloader'          => admin_url( 'images/wpspin_light-2x.gif' ),
				'animation_disabled' => ( isset( $options['disable-animation'] ) && $options['disable-animation'] ) ? true : false,
				'getTimelineError'   => __( 'There was an error generating the timeline. Please try again.', 'timeline-express' ),
			)
		);

		$admin_block_styles = '
		.timeline-block-inspector-controls .components-base-control {
			display: block;
			width: 100%;
		}
		.timeline-block-inspector-controls .components-panel__row {
			margin-top: 10px;
		}
		.timeline-block-inspector-controls label {
			font-weight: 600;
		}
		.wp-block-timeline-express-timeline-block .te-preloader {
			display: block;
			padding: 5px 0;
			margin: 0 auto;
			max-width: 22px;
		}
		';

		// Block styles
		wp_add_inline_style( 'timeline-express-base', $admin_block_styles );
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
		$options   = timeline_express_get_options();

		$defaults = array(
			'limit'   => ! $limit ? -1 : $limit,
			'order'   => ! $order ? $options['announcement-display-order'] : $order,
			'display' => ! $timeframe ? $options['announcement-time-frame'] : $timeframe,
		);

		apply_filters( 'timeline_express_disable_cache', '__return_true' );

		$timeline_express_init = new Timeline_Express_Initialize();

		wp_send_json_success( $timeline_express_init->generate_timeline_express( $options, $defaults ) );

	}

}

new Timeline_Express_Content_Blocks();
