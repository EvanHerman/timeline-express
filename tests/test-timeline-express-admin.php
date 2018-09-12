<?php
/**
 * Test class for our admin side of Timeline Express
 *
 * @package Timeline Express
 * @since 1.2
 */

class TE_Admin_Tests extends WP_UnitTestCase {

	// store global options
	private $options, $base_class, $admin_class;

	public function setUp() {
		// Navigate to the edit post page
		set_current_screen( 'edit-post' );
		// setup our options
		$this->options = timeline_express_get_options();
		// include the base class to access funcitons
		include_once( TIMELINE_EXPRESS_PATH . 'lib/classes/class-timeline-express.php' );
		$this->base_class  = new TimelineExpressBase();
		$this->admin_class = new Timeline_Express_Admin();
		wp_set_current_user( self::factory()->user->create( [
			'role' => 'administrator',
		] ) );
	}

	/**
	 * Test that our admin menus were created properly
	 */
	public function test_timeline_express_admin_menus() {
		// Register the custom post type
		$this->admin_class->timeline_express_generate_announcement_post_type();
		// Register the admin menus
		$this->admin_class->timeline_express_admin_menus();

		$post_types = get_post_types();

		$this->assertArrayHasKey( 'te_announcements', $post_types );

		$expected = array();

		$expected['timeline-express-settings'] = 'http://example.org/wp-admin/edit.php?post_type=te_announcements&#038;page=timeline-express-settings';
		$expected['timeline-express-addons'] = 'http://example.org/wp-admin/edit.php?post_type=te_announcements&#038;page=timeline-express-addons';
		$expected['timeline-express-welcome'] = 'http://example.org/wp-admin/edit.php?post_type=te_announcements&#038;page=timeline-express-welcome';

		foreach ( $expected as $name => $value ) {

			$this->assertEquals( $value, menu_page_url( $name, false ) );

		}
	}

	/**
	 * Test that our setitngs werer registered properly
	 */
	public function test_timeline_express_register_settings() {
		$this->assertNotNull( get_option( 'timeline_express_storage' ) );
	}
}
