<?php
/**
 * Test class to test out that our custom post type, and associated meta are working.
 *
 * @package Timeline Express
 * @since 1.2
 */
class TE_CPT_Meta_Tests extends WP_UnitTestCase {
	/**
	 * Test out our custom post types & meta
	 *
	 * @since 1.2
	 */
	public function test_announcement_post_type() {
		$announcement_id = wp_insert_post( array(
			'post_type' => 'te_announcements',
			'post_title' => 'Test Announcement',
			'post_content' => 'This is some test content for our announcement.',
		) );

		$this->assertTrue( is_int( $announcement_id ) && $announcement_id > 0 );

		$announcement_post = get_post( $announcement_id );

		// ensure we have a WP_Post instance
		$this->assertTrue( $announcement_post instanceof WP_Post );

		// ensure our updated post title is correct
		$this->assertEquals( 'Test Announcement', $announcement_post->post_title );

		// ensure our updated post content is correct
		$this->assertEquals( 'This is some test content for our announcement.', $announcement_post->post_content );

		// ensure our new post is the correct post type
		$this->assertEquals( 'te_announcements', $announcement_post->post_type );

		// Setup test meta
		$exp_values = array(
			'announcement_color' => '#FF6347',
			'announcement_icon' => 'fa-bluetooth-b',
			'announcement_date' => strtotime( 'now' ),
			'announcement_image' => 'http://www.test.com',
		);

		// Update the test meta
		foreach ( $exp_values as $meta_name => $meta_value ) {
			update_post_meta( $announcement_id, $meta_name, $meta_value );
		}

		// ensure our post meta was stored properly
		$this->assertEquals( '#FF6347', get_post_meta( $announcement_id, 'announcement_color', true ) );
		$this->assertEquals( 'fa-bluetooth-b', get_post_meta( $announcement_id, 'announcement_icon', true ) );
		$this->assertLessThanOrEqual( strtotime( 'now' ), get_post_meta( $announcement_id, 'announcement_date', true ) );
		$this->assertEquals( 'http://www.test.com', get_post_meta( $announcement_id, 'announcement_image', true ) );

	}
}
