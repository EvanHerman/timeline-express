<?php
/**
 * Test class for our base Timeline Express class
 *
 * @package Timeline Express
 * @since 1.2
 */

class TE_Base_Tests extends WP_UnitTestCase {

	// store global options
	public $options;

	public function setUp() {
		$this->$options = timeline_express_get_options();
	}

	// test plugin activation
	public function test_timeline_express_activate() {
		timeline_express_activate();
		$this->assertEquals( get_option( 'timeline_express_do_activation_redirect' ), true );
	}
}
