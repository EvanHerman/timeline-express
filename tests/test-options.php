<?php
/**
 * Test class to test out that our custom post type, and associated meta are working.
 *
 * @package Timeline Express
 * @since 1.2
 */
class TE_Options_Test extends WP_UnitTestCase {

	// Define private options var
	private $options, $base_class;

	/**
	 * Test out our options save and return expected valies.
	 */
	public function setUp() {
		parent::setUp();
		// Store our options
		$this->options = timeline_express_get_options();
		// Include the base class
		include_once( TIMELINE_EXPRESS_PATH . 'lib/classes/class-timeline-express.php' );
		$this->base_class = new TimelineExpressBase();
	}

	public function tearDown() {
		parent::tearDown();
	}

	public function test_options_sanitization() {
		// create a nonce
		$_POST['timeline_express_settings_nonce'] = wp_create_nonce( 'timeline_express_save_settings' );
		// create an array of test data
		$new_options_array = array(
			'announcement-time-frame' => '2',
			'announcement-display-order' => 'DESC',
			'excerpt-trim-length' => 300,
			'excerpt-random-length' => 0,
			'date-visibility' => '1',
			'read-more-visibility' => '0',
			'default-announcement-icon' => 'wordpress',
			'default-announcement-color' => '#c43434',
			'announcement-bg-color' => '#86d228',
			'announcement-box-shadow-color' => '#83ccd6',
			'announcement-background-line-color' => '#cfe354',
			'no-events-message' => 'This is a test. Warning - this is a test. Not a warning, just a test.',
			'announcement-appear-in-searches' => '1',
			'delete-announcement-posts-on-uninstallation' => '1',
		);
		// update our options
		$this->base_class->timeline_express_save_options( $new_options_array );
		// retreive the new options array
		$new_options_array = timeline_express_get_options();
		// loop over existing options, and assert they equal the new options set above
		foreach ( $new_options_array as $name => $value ) {
			$this->assertEquals( $value, $new_options_array[ $name ] );
		}
	}

	/**
	 * Test the announcement time frame option
	 */
	public function test_announcement_time_frame_option() {
		// Check the default is correct
		$this->assertEquals( $this->options['announcement-time-frame'], '1' );
		// Test announcement time frame
		$this->options['announcement-time-frame'] = '0';
		// Update the option with the new value
		update_option( TIMELINE_EXPRESS_OPTION, $this->options );
		// Get new options
		$options = timeline_express_get_options();
		// Assert the new value is correct
		$this->assertEquals( $options['announcement-time-frame'], '0' );
	}

	/**
	 * Test the announcement display order option
	 */
	public function test_announcement_display_order_option() {
		// Check the default is correct
		$this->assertEquals( $this->options['announcement-display-order'], 'ASC' );
		// Update the announcement display order option with the new value
		$this->options['announcement-display-order'] = 'DESC';
		// Update the option with the new value
		update_option( TIMELINE_EXPRESS_OPTION, $this->options );
		// Get new options
		$options = timeline_express_get_options();
		// Assert the new value is correct
		$this->assertEquals( $options['announcement-display-order'], 'DESC' );
	}

	/**
	 * Test the announcement trim length option
	 */
	public function test_announcement_excerpt_trim_length_option() {
		// Check the default is correct
		$this->assertEquals( $this->options['excerpt-trim-length'], '50' );
		// Test announcement time frame
		$this->options['excerpt-trim-length'] = '500';
		// Update the option with the new value
		update_option( TIMELINE_EXPRESS_OPTION, $this->options );
		// Get new options
		$options = timeline_express_get_options();
		// Assert the new value is correct
		$this->assertEquals( $options['excerpt-trim-length'], '500' );
	}

	/**
	 * Test the announcement random length option
	 */
	public function test_announcement_excerpt_random_length_option() {
		// Check the default is correct
		$this->assertEquals( $this->options['excerpt-random-length'], '0' );
		// Test announcement time frame
		$this->options['excerpt-random-length'] = '1';
		// Update the option with the new value
		update_option( TIMELINE_EXPRESS_OPTION, $this->options );
		// Get new options
		$options = timeline_express_get_options();
		// Assert the new value is correct
		$this->assertEquals( $options['excerpt-random-length'], '1' );
	}

	/**
	 * Test the announcement date visibility option
	 */
	public function test_announcement_date_visibility_option() {
		// Check the default is correct
		$this->assertEquals( $this->options['date-visibility'], '1' );
		// Test announcement time frame
		$this->options['date-visibility'] = '0';
		// Update the option with the new value
		update_option( TIMELINE_EXPRESS_OPTION, $this->options );
		// Get new options
		$options = timeline_express_get_options();
		// Assert the new value is correct
		$this->assertEquals( $options['date-visibility'], '0' );
	}

	/**
	 * Test the announcement read more visibility option
	 */
	public function test_announcement_read_more_visibility_option() {
		// Check the default is correct
		$this->assertEquals( $this->options['read-more-visibility'], '1' );
		// Test announcement time frame
		$this->options['read-more-visibility'] = '0';
		// Update the option with the new value
		update_option( TIMELINE_EXPRESS_OPTION, $this->options );
		// Get new options
		$options = timeline_express_get_options();
		// Assert the new value is correct
		$this->assertEquals( $options['read-more-visibility'], '0' );
	}

	/**
	 * Test the announcement default announcement icon option
	 */
	public function test_announcement_default_announcement_icon_option() {
		// Check the default is correct
		$this->assertEquals( $this->options['default-announcement-icon'], 'exclamation-triangle' );
		// Test announcement time frame
		$this->options['default-announcement-icon'] = 'thumbs-o-up';
		// Update the option with the new value
		update_option( TIMELINE_EXPRESS_OPTION, $this->options );
		// Get new options
		$options = timeline_express_get_options();
		// Assert the new value is correct
		$this->assertEquals( $options['default-announcement-icon'], 'thumbs-o-up' );
	}

	/**
	 * Test the announcement icon color option
	 */
	public function test_announcement_default_announcement_color_option() {
		// Check the default is correct
		$this->assertEquals( $this->options['default-announcement-color'], '#75CE66' );
		// Test announcement time frame
		$this->options['default-announcement-color'] = '#61618b';
		// Update the option with the new value
		update_option( TIMELINE_EXPRESS_OPTION, $this->options );
		// Get new options
		$options = timeline_express_get_options();
		// Assert the new value is correct
		$this->assertEquals( $options['default-announcement-color'], '#61618b' );
	}

	/**
	 * Test the announcement box shadow color option
	 */
	public function test_announcement_box_shadow_color_option() {
		// Check the default is correct
		$this->assertEquals( $this->options['announcement-box-shadow-color'], '#B9C5CD' );
		// Test announcement time frame
		$this->options['announcement-box-shadow-color'] = '#1bb976';
		// Update the option with the new value
		update_option( TIMELINE_EXPRESS_OPTION, $this->options );
		// Get new options
		$options = timeline_express_get_options();
		// Assert the new value is correct
		$this->assertEquals( $options['announcement-box-shadow-color'], '#1bb976' );
	}

	/**
	 * Test the announcement background line color option
	 */
	public function test_announcement_background_line_color_option() {
		// Check the default is correct
		$this->assertEquals( $this->options['announcement-background-line-color'], '#D7E4ED' );
		// Test announcement time frame
		$this->options['announcement-background-line-color'] = '#8f8bd6';
		// Update the option with the new value
		update_option( TIMELINE_EXPRESS_OPTION, $this->options );
		// Get new options
		$options = timeline_express_get_options();
		// Assert the new value is correct
		$this->assertEquals( $options['announcement-background-line-color'], '#8f8bd6' );
	}

	/**
	 * Test the announcement background color option
	 */
	public function test_announcement_background_color_option() {
		// Check the default is correct
		$this->assertEquals( $this->options['announcement-bg-color'], '#EFEFEF' );
		// Test announcement time frame
		$this->options['announcement-bg-color'] = '#8f8bd6';
		// Update the option with the new value
		update_option( TIMELINE_EXPRESS_OPTION, $this->options );
		// Get new options
		$options = timeline_express_get_options();
		// Assert the new value is correct
		$this->assertEquals( $options['announcement-bg-color'], '#8f8bd6' );
	}

	/**
	 * Test the no events message option
	 */
	public function test_no_events_message_option() {
		// Check the default is correct
		$this->assertEquals( $this->options['no-events-message'], 'No announcements found' );
		// Test announcement time frame
		$this->options['no-events-message'] = 'Attention, Attention! There are no announcements present.';
		// Update the option with the new value
		update_option( TIMELINE_EXPRESS_OPTION, $this->options );
		// Get new options
		$options = timeline_express_get_options();
		// Assert the new value is correct
		$this->assertEquals( $options['no-events-message'], 'Attention, Attention! There are no announcements present.' );
	}

	/**
	 * Test the no events message option
	 */
	public function test_announcement_appear_in_searches_option() {
		// Check the default is correct
		$this->assertEquals( $this->options['announcement-appear-in-searches'], 'true' );
		// Test announcement time frame
		$this->options['announcement-appear-in-searches'] = 'false';
		// Update the option with the new value
		update_option( TIMELINE_EXPRESS_OPTION, $this->options );
		// Get new options
		$options = timeline_express_get_options();
		// Assert the new value is correct
		$this->assertEquals( $options['announcement-appear-in-searches'], 'false' );
	}

	/**
	 * Test delete announcement posts on uninstallation option
	 */
	public function test_delete_announcement_posts_on_uninstallation_option() {
		// Check the default is correct
		$this->assertEquals( $this->options['delete-announcement-posts-on-uninstallation'], '0' );
		// Test announcement time frame
		$this->options['delete-announcement-posts-on-uninstallation'] = '1';
		// Update the option with the new value
		update_option( TIMELINE_EXPRESS_OPTION, $this->options );
		// Get new options
		$options = timeline_express_get_options();
		// Assert the new value is correct
		$this->assertEquals( $options['delete-announcement-posts-on-uninstallation'], '1' );
	}

	/**
	 * Test version option
	 */
	public function test_version_option() {
		// Check the default is correct
		$this->assertEquals( $this->options['version'], TIMELINE_EXPRESS_VERSION_CURRENT );
		// Test announcement time frame
		$this->options['version'] = (int) ( ( (int) TIMELINE_EXPRESS_VERSION_CURRENT ) + 1 );
		// Update the option with the new value
		update_option( TIMELINE_EXPRESS_OPTION, $this->options );
		// Get new options
		$options = timeline_express_get_options();
		// Assert the new value is correct
		$this->assertEquals( $options['version'], (int) ( ( (int) TIMELINE_EXPRESS_VERSION_CURRENT ) + 1 ) );
	}

	/**
	 * Test updating more than one option
	 */
	public function test_update_group_of_options() {
		// Assert our defaults are setup properly
		$this->assertEquals( $this->options['default-announcement-color'], '#75CE66' );
		$this->assertEquals( $this->options['date-visibility'], '1' );
		$this->assertEquals( $this->options['excerpt-trim-length'], '50' );
		$this->assertEquals( $this->options['announcement-display-order'], 'ASC' );

		// Setup new values
		$this->options['defualt-announcement-color'] = '#f9241e';
		$this->options['date-visibility'] = '0';
		$this->options['excerpt-trim-length'] = '420';
		$this->options['announcement-display-order'] = 'DESC';

		// Update the options with our new values
		update_option( TIMELINE_EXPRESS_OPTION, $this->options );

		// Get new options
		$options = timeline_express_get_options();

		// Check that the options updated correctly
		$this->assertEquals( $options['defualt-announcement-color'], '#f9241e' );
		$this->assertEquals( $options['date-visibility'], '0' );
		$this->assertEquals( $options['excerpt-trim-length'], '420' );
		$this->assertEquals( $options['announcement-display-order'], 'DESC' );
	}
}
