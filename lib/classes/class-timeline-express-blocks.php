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
			[
				'preloader'          => admin_url( 'images/wpspin_light-2x.gif' ),
				'animation_disabled' => ( isset( $options['disable-animation'] ) && $options['disable-animation'] ) ? true : false,
			]
		);
	}

	/**
	 * Render the timeline markup, AJAX handler
	 *
	 * @return mixed Markup for the timeline
	 */
	public function get_timeline_markup() {

		$options = timeline_express_get_options();

		$defaults = array(
			'limit'   => -1,
			'order'   => $options['announcement-display-order'],
			'display' => $options['announcement-time-frame'],
		);

		$timeline_express_init = new Timeline_Express_Initialize();

		wp_send_json_success( $timeline_express_init->generate_timeline_express( $options, $defaults ) );

	}

}

new Timeline_Express_Content_Blocks();
