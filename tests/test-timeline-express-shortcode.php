<?php
/**
 * @group edd_shortcode
 */
class Tests_Shortcode extends WP_UnitTestCase {

	public $options, $init_class, $announcement_id;

	public function setUp() {
		parent::setUp();
		// Include the base class
		include_once( TIMELINE_EXPRESS_PATH . 'lib/classes/class.timeline-express-initialize.php' );
		$this->init_class = new Timeline_Express_Initialize( array() );
		$this->options = timeline_express_get_options();
	}

	public function tearDown() {
		parent::tearDown();
	}

	/**
 * Test that our shortcode has been properly registered and is available
 */
	public function test_shortcodes_are_registered() {
		global $shortcode_tags;
		$this->assertArrayHasKey( 'timeline-express', $shortcode_tags );
	}

	public function test_timeline_express_shortcode() {
		$this->assertInternalType( 'string', $this->init_class->generate_timeline_express( $this->options, array() ) );
		/* Test no announcements found */
		$this->assertContains( '<h2>', $this->init_class->generate_timeline_express( $this->options, array() ) );
		/* Update option to 'all announcements' */
		$this->options['announcement-time-frame'] = '1';
		/* Update the option with the new value */
		update_option( TIMELINE_EXPRESS_OPTION, $this->options );
		/* Create test announcements */
		self::setup_test_announcement( $this->factory->post );
		/* Test that we now have an announcement returned - after creating one above*/
		$this->assertContains( '<section id="cd-timeline" class="cd-container">', $this->init_class->generate_timeline_express( $this->options, array() ) );
	}

	/**
	 * Static function to setup some test data
	 */
	public static function setup_test_announcement( $post_factory ) {
		// include the helpers class, so we can quickly create announcements for testing
		$announcement_id = $post_factory->create( array( 'post_title' => 'Test Announcement', 'post_type' => 'te_announcements', 'post_status' => 'publish' ) );
		// Setup test meta
		$exp_values = array(
			'announcement_color' => '#FF6347',
			'announcement_icon' => 'fa-bluetooth-b',
			'announcement_date' => strtotime( '04/20/2020' ),
			'announcement_image' => 'http://www.test.com',
		);
		// Update the test meta
		foreach ( $exp_values as $meta_name => $meta_value ) {
			update_post_meta( $announcement_id, $meta_name, $meta_value );
		}
	}
}
