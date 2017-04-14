<?php
/**
 * Test class for our base Timeline Express class
 *
 * @package Timeline Express
 * @since 1.2
 */

class TE_Base_Tests extends WP_UnitTestCase {

	// store global options
	private $options, $base_class;

	public function setUp() {
		$this->options = timeline_express_get_options();
		include_once( TIMELINE_EXPRESS_PATH . 'lib/classes/class-timeline-express-base.php' );
		$this->base_class = new Timeline_Express_Base();
	}

	public function tearDown() {

	}

	// test plugin activation
	public function test_timeline_express_activate() {
		$this->base_class->timeline_express_activate();
		$this->assertEquals( get_option( 'timeline_express_do_activation_redirect' ), true );
	}

	public function test_timeline_express_deactivate() {
		$this->base_class->timeline_express_deactivate();
		$this->assertEmpty( get_option( 'post_type_rules_flushed_te-announcements' ) );
	}

	/**
	 * @todo
	 * Test the correct template is returned on single announcements
	public function test_single_announcement_template_exists() {
		$post = new stdClass();
		$post->post_type = 'te_announcements';
		$template = $this->base_class->timeline_express_single_announcement_template( '' );
		$this->assertEquals( get_stylesheet_directory() . 'single.php', $template );
	}
	*/

	/**
	 * @todo
	 * Test plugin activation redirects
	public function test_timeline_express_activate_redirect() {
		// Define the constant
		if ( ! defined( 'TIMELINE_EXPRESS_DISABLED_ACTIVATION_REDIRECT' ) ) {
			define( 'TIMELINE_EXPRESS_DISABLED_ACTIVATION_REDIRECT', true );
		}
	}
	*/
}
