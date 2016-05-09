<?php
/**
 * Test class to test out that our helper functions return proper values.
 *
 * @package Timeline Express
 * @since 1.2
 */
class TE_Helper_Tests extends WP_UnitTestCase {

	/* Helper function to create an announcement for our test cases */
	public function test_create_announcement( $color = '#FF6347', $icon = 'fa-bluetooth-b', $date = false, $image = '', $image_id = '' ) {
		$announcement_id = wp_insert_post( array(
			'post_type' => 'te_announcements',
			'post_title' => 'Test Announcement',
			'post_content' => 'This is some test content for our announcement.',
		) );

		// setup the date parameter
		$date = ( $date ) ? strtotime( $date ) : strtotime( 'now' );

		 // Setup test meta
		$exp_values = array(
			'announcement_color' => $color,
			'announcement_icon' => $icon,
			'announcement_date' => $date,
			'announcement_image' => $image,
			'announcement_image_id' => $image_id,
		);

		// Upload a test image to our announcement
		$filename = ( __DIR__ . '/test-images/test-image-1.png' );
		$contents = file_get_contents( $filename );
		$upload = wp_upload_bits( basename( $filename ), null, $contents );
		$this->assertTrue( empty( $upload['error'] ) );

		$type = '';
		if ( ! empty( $upload['type'] ) ) {
			 $type = $upload['type'];
		} else {
			$mime = wp_check_filetype( $upload['file'] );
			if ( $mime ) {
				$type = $mime['type'];
			}
		}
		$attachment = array(
			'post_title' => basename( $upload['file'] ),
			'post_content' => '',
			'post_type' => 'attachment',
			'post_parent' => $announcement_id,
			'post_mime_type' => $type,
			'guid' => $upload['url'],
		);

		// Save the data to our announcement
		$id = wp_insert_attachment( $attachment, $upload['file'], $announcement_id );
		wp_update_attachment_metadata( $id, wp_generate_attachment_metadata( $id, $upload['file'] ) );

		 // Update the test meta
		foreach ( $exp_values as $meta_name => $meta_value ) {
			// update the announcement image id
			if ( 'announcement_image_id' === $meta_name ) {
				$meta_value = (int) $id;
			}
			// update the announcemen URL
			if ( 'announcement_image' === $meta_name ) {
				$meta_value = esc_url( $attachment['guid'] );
			}
			update_post_meta( $announcement_id, $meta_name, $meta_value );
		}
		// return the announcement id to use for testing
		$this->assertGreaterThan( 0, $announcement_id );
		// return the announcement id to use in other tests.
		return (int) $announcement_id;
	}

	/**
	 * Test our options array is not empty
	 * @return null
	 */
	public function test_timeline_express_get_options() {
		$options = timeline_express_get_options();
		// test that our options is not empty
		$this->assertNotEmpty( $options );
		// Check that each option is set
		foreach ( $options as $option ) {
			$this->assertNotEmpty( $options );
		}
	}

	/**
	 * Test that our included files actually exist
	 */
	public function test_included_files_exist() {
		// Timeline Express initialization class
		$this->assertFileExists( TIMELINE_EXPRESS_PATH . 'lib/classes/class.timeline-express-initialize.php' );
		// Timeline Express container template
		$this->assertFileExists( TIMELINE_EXPRESS_PATH . 'lib/public/partials/timeline-express-container.php' );
		// Announcement metabox file
		$this->assertFileExists( TIMELINE_EXPRESS_PATH . 'lib/admin/metaboxes/metaboxes.announcements.php' );
		// Custom date timestamp file
		$this->assertFileExists( TIMELINE_EXPRESS_PATH . 'lib/admin/metaboxes/partials/time-stamp-custom.php' );
		// Advertisment metabox file
		$this->assertFileExists( TIMELINE_EXPRESS_PATH . 'lib/admin/metaboxes/partials/advertisment-metabox.php' );
		// Help & Documentation metabox file
		$this->assertFileExists( TIMELINE_EXPRESS_PATH . 'lib/admin/metaboxes/partials/help-docs-metabox.php' );
		// Local copy of Font Awesome
		$this->assertFileExists( TIMELINE_EXPRESS_PATH . 'lib/icons/css/font-awesome.min.css' );
		/**
		 * Admin Styles
		 */
		// bootstrap-select.min.css (used to create our icon dropdown)
		$this->assertFileExists( TIMELINE_EXPRESS_PATH . 'lib/admin/css/min/bootstrap-select.min.css' );
		// Timeline Express admin styles
		$this->assertFileExists( TIMELINE_EXPRESS_PATH . 'lib/admin/css/min/timeline-express-admin.min.css' );
		/**
		 * Admin Scripts
		 */
		// Timeline Express admin script
		$this->assertFileExists( TIMELINE_EXPRESS_PATH . 'lib/admin/js/min/timeline-express-admin.min.js' );
		// Timeline Express TinyMCE button script
		$this->assertFileExists( TIMELINE_EXPRESS_PATH . 'lib/admin/js/min/timeline-express-tinymce.min.js' );
		/**
		 * Public Styles
		 */
		// Timeline Express public styles
		$this->assertFileExists( TIMELINE_EXPRESS_PATH . 'lib/public/css/min/timeline-express.min.css' );
		/**
		 * Public Scripts
		 */
		// Timeline Express public script
		$this->assertFileExists( TIMELINE_EXPRESS_PATH . 'lib/public/js/min/timeline-express.min.js' );
	}

	/**
	 * Test the saving of a date on the announcement page
	 * @return null
	 */
	public function test_announcement_date_sanitization() {
		/**
		 * Test saving our font awesome icon on the announcement page
		 *
		 * @param string current date in the database.
		 * @param string new date to save.
		 */
		$sanitize_us_date = cmb2_sanitize_te_date_time_stamp_custom_callback( null, '04/04/1989' );
		// ensure our icon was saved properly
		$this->assertEquals( strtotime( '04/04/1989' ), $sanitize_us_date );
	}

	/**
	 * Test the saving of an icon on the announcement page
	 * @return null
	 */
	public function test_font_awesome_dropdown_sanitization() {
		/**
		 * Test saving our font awesome icon on the announcement page
		 *
		 * @param string current icon in the database.
		 * @param string new icon to save.
		 */
		$sanitize_icon = cmb2_validate_te_bootstrap_dropdown_callback( 'bluetooth-b', 'plus' );
		// ensure our icon was saved properly
		$this->assertEquals( 'fa-plus', $sanitize_icon );
	}

	/**
	 * Testing that get_announcement_image() returns what we need
	 */
	public function test_timeline_express_get_announcement_image() {
		// instantiate a new class
		$helper_functions_test_class = new TE_Helper_Tests;
		// create some test announcements
		$announcement_id = $helper_functions_test_class->test_create_announcement();
		// store the announcement id
		$announcement_image_id = get_post_meta( $announcement_id, 'announcement_image_id', true );
		// if the announcement id exists, continue
		if ( $announcement_image_id ) {
			// store the announcement image to check
			$announcement_image = wp_get_attachment_image(
				$announcement_image_id,
				'full', /* Legacy filter name - maintain formatting */
				false,
				array(
					'title' => 'test',
					'class' => 'announcement-banner-image',
				)
			);
			$this->assertNotEmpty( $announcement_image );
		}
	}

	/**
	 * Testing that timeline_express_get_announcement_date() returns what we expect
	 */
	public function test_timeline_express_get_announcement_date() {
		// Re-instantiate this class
		$helper_functions_test_class = new TE_Helper_Tests;
		// Create some test announcements, passing in some defaults.
		$announcement_id = $helper_functions_test_class->test_create_announcement( '#FF6347', 'fa-plus', '04/04/1989' );
		// Grab the announcement date
		$announcement_date = timeline_express_get_announcement_date( $announcement_id );
		$comparison_date = date_i18n( get_option( 'date_format' ), strtotime( '04/04/1989' ) );
		// $announcement_date = get_post_meta( $announcement_id, 'announcement_date', true );
		$this->assertEquals( $announcement_date, $comparison_date );
	}

	/**
	 * Testing that timeline_express_get_announcement_content() returns what we expect
	 */
	public function test_timeline_express_get_announcement_content() {
		// Re-instantiate this class
		$helper_functions_test_class = new TE_Helper_Tests;
		// Create some test announcements, passing in some defaults.
		$announcement_id = $helper_functions_test_class->test_create_announcement();
		// Grab the announcement date
		$announcement_content = trim( timeline_express_get_announcement_content( $announcement_id ) );
		// $announcement_date = get_post_meta( $announcement_id, 'announcement_date', true );
		$this->assertEquals( $announcement_content, '<p>This is some test content for our announcement.</p>' );
	}
}
