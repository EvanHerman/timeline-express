<?php
/**
 * Test class for our base Timeline Express class
 *
 * @package Timeline Express
 * @since 1.2
 */

class TE_Base_Tests extends WP_UnitTestCase {

	// store global options
	public $options, $base_class;

	public function setUp() {
		$this->options = timeline_express_get_options();
		include_once( TIMELINE_EXPRESS_PATH . 'lib/classes/class.timeline-express.php' );
		$this->base_class = new TimelineExpressBase();
	}

	// test plugin activation
	public function test_timeline_express_activate() {
		$this->base_class->timeline_express_activate();
		$this->assertEquals( get_option( 'timeline_express_do_activation_redirect' ), true );
	}
}
