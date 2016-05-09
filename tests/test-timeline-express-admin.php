<?php
/**
 * Test class for our admin side of Timeline Express
 *
 * @package Timeline Express
 * @since 1.2
 */

class TE_Admin_Tests extends WP_UnitTestCase {

	// store global options
	private $options, $base_class;

	public function setUp() {
		// Navigate to the edit post page
		set_current_screen( 'edit-post' );
		// setup our options
		$this->options = timeline_express_get_options();
		// include the base class to access funcitons
		include_once( TIMELINE_EXPRESS_PATH . 'lib/classes/class.timeline-express.php' );
		$this->base_class = new TimelineExpressBase();
	}

	public function tearDown() {

	}

	/**
	 * Test that our admin menus were created properly
	 */
	public function test_timeline_express_admin_menus() {
		global $menu;
		// Settings Page
		$this->arrayHasKey( 'timeline-express-settings', $menu );
		// Welcome Page
		$this->arrayHasKey( 'timeline-express-settings', $menu );
		// Addons page
		$this->arrayHasKey( 'timeline-express-welcome', $menu );
		// CPT registered properly
		$this->arrayHasKey( 'edit.php?post_type=te_announcements', $menu );
	}

	/**
	 * Test that our setitngs werer registered properly
	 */
	public function test_timeline_express_register_settings() {
		$this->assertNotNull( get_option( 'timeline_express_storage' ) );
		$this->assertNotEmpty( get_option( 'timeline_express_storage' ) );
	}
}
