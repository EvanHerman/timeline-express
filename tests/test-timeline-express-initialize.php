<?php
/**
 * Test class to test out that our filters all work properly.
 *
 * @package Timeline Express
 * @since 1.2
 */
class TE_Init_Tests extends WP_UnitTestCase {
	/**
	 * Constructor, include the class to test.
	 */
	public function __construct() {
		// include the helpers class, so we can quickly create announcements for testing
		$te_helper_tests = new TE_Helper_Tests;
		$this->announcement_id = $te_helper_tests->test_create_announcement( '#c332d5', 'fa-cutlery', '05/18/2002' );
		// Include our initializatio class
	}

	/**
	 * Test that the announcement icon returns what we expect.
	 * @return string The font awsome class to use as the icon.
	 */
	public function test_get_announcement_icon() {
		$init_class = new Timeline_Express_Initialize( array() );
		$announcement_icon = $init_class->get_announcement_icon( $this->announcement_id );
		$this->assertEquals( 'fa-cutlery', $announcement_icon );
	}

	/**
	 * Test that the announcement icon color returns what we expect (hex).
	 * @return string The hex value to use as the icon background.
	 */
	public function test_get_announcement_icon_color() {
		$init_class = new Timeline_Express_Initialize( array() );
		$announcement_icon_color = $init_class->get_announcement_icon_color( $this->announcement_id );
		$this->assertEquals( '#c332d5', $announcement_icon_color );
	}

	/**
	 * Test that the announcement date returns what we expect.
	 * @return int The UNIX time stamp of the date to use.
	 */
	public function test_get_announcement_date() {
		$init_class = new Timeline_Express_Initialize( array() );
		$announcement_date = $init_class->get_announcement_date( $this->announcement_id );
		$this->assertEquals( date_i18n( get_option( 'date_format' ), strtotime( '05/18/2002' ) ), $announcement_date );
	}

	/**
	 * @group ignore
	 *
	 * Test that the announcement date returns what we expect.
	 * @return int The UNIX time stamp of the date to use.
	public function test_get_announcement_excerpt() {
		$init_class = new Timeline_Express_Initialize( array() );
		$announcement_excerpt = $init_class->get_announcement_excerpt( null, '200', '0', $this->announcement_id );
		$this->assertEquals( 'test', $announcement_excerpt );
	}
	*/

	/**
	 * Test that the announcement date returns what we expect.
	 * @return int The UNIX time stamp of the date to use.
	 */
	public function test_get_timeline_express_compare_sign() {
		$init_class = new Timeline_Express_Initialize( array() );
		// Ensure compare sign returns properly when 'Past' events is set
		$compare_sign = $init_class->timeline_express_compare_sign( '0', 1 );
		$this->assertEquals( '>=', $compare_sign );
		// Ensure compare sign returns properly when 'All(Past+Future)' events is set
		$compare_sign = $init_class->timeline_express_compare_sign( '1', 1 );
		$this->assertEquals( '', $compare_sign );
		// Ensure compare sign returns properly when 'Future' events is set
		$compare_sign = $init_class->timeline_express_compare_sign( '2', 1 );
		$this->assertEquals( '<', $compare_sign );
	}

	/**
	 * Test that the announcement query args returns what we expect.
	 * @return array Query arguments to use on the front end queries.
	 */
	public function test_get_timeline_express_query_args() {
		$init_class = new Timeline_Express_Initialize( array() );
		$compare_signs = array( '>=', '', '<' );
		$sort_order = array( 'ASC', 'DESC' );
		foreach ( $compare_signs as $compare_sign ) {
			foreach ( $sort_order as $sort ) {
				$query_args = $init_class->timeline_express_query_args( $compare_sign, $sort );
				if ( '' === $compare_sign ) {
					// Setup expected args for compare sign === ''
					$announcement_args = array(
						'post_type' => 'te_announcements',
						'meta_key'   => 'announcement_date',
						'orderby'    => 'meta_value_num',
						'order'      => $sort,
						'no_found_rows' => true,
						'posts_per_page' => 50,
					);
					// Ensure compare sign returns properly when 'Past' events is set
					$this->assertEquals( $announcement_args, $query_args );
				} else {
					// Setup expected args for compare sign !== ''
					$announcement_args = array(
						'post_type' => 'te_announcements',
						'meta_key'   => 'announcement_date',
						'orderby'    => 'meta_value_num',
						'order'      => $sort,
						'no_found_rows' => true,
						'posts_per_page' => 50,
						'meta_query' => array(
							array(
								'key'     => 'announcement_date',
								'value'   => strtotime( current_time( 'm/d/Y' ) ),
								'type' => 'NUMERIC',
								'compare' => $compare_sign,
							),
						),
					);
					// Ensure compare sign returns properly when 'Past' events is set
					$this->assertEquals( $announcement_args, $query_args );
				}
			}
		}
	}
}
