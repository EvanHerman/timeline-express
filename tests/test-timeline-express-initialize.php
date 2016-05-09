<?php
/**
 * Test class to test out that our filters all work properly.
 *
 * @package Timeline Express
 * @since 1.2
 */

class TE_Init_Tests extends WP_UnitTestCase {

	// Setup the init class
	private $init_class, $options;

	/**
	 * Constructor, include the class to test.
	 */
	public function setUp() {
		parent::setUp();
		// include the helpers class, so we can quickly create announcements for testing
		$te_helper_tests = new TE_Helper_Tests;
		$this->announcement_id = $te_helper_tests->test_create_announcement( '#c332d5', 'fa-cutlery', '05/18/2002' );
		// Include the parent class so we can use it
		include_once( TIMELINE_EXPRESS_PATH . 'lib/classes/class.timeline-express-initialize.php' );
		$this->init_class = new Timeline_Express_Initialize( array() );
		// Setup options
		$this->options = timeline_express_get_options();
	}

	public function tearDown() {
		parent::tearDown();
	}

	/**
	 * Test that the announcement icon returns what we expect.
	 * @return string The font awsome class to use as the icon.
	 */
	public function test_get_announcement_icon() {
		$announcement_icon = timeline_express_get_announcement_icon( $this->announcement_id );
		$this->assertEquals( 'fa-cutlery', $announcement_icon );
	}

	/**
	 * Test that the announcement icon color returns what we expect (hex).
	 * @return string The hex value to use as the icon background.
	 */
	public function test_get_announcement_icon_color() {
		$announcement_icon_color = timeline_express_get_announcement_icon_color( $this->announcement_id );
		$this->assertEquals( '#c332d5', $announcement_icon_color );
	}

	/**
	 * Test that the announcement date returns what we expect.
	 * @return int The UNIX time stamp of the date to use.
	 */
	public function test_get_announcement_date() {
		$announcement_date = timeline_express_get_announcement_date( $this->announcement_id );
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
		// Ensure compare sign returns properly when 'Past' events is set
		$compare_sign = $this->init_class->timeline_express_compare_sign( '0', 1 );
		$this->assertEquals( '>=', $compare_sign );
		// Ensure compare sign returns properly when 'All(Past+Future)' events is set
		$compare_sign = $this->init_class->timeline_express_compare_sign( '1', 1 );
		$this->assertEquals( '', $compare_sign );
		// Ensure compare sign returns properly when 'Future' events is set
		$compare_sign = $this->init_class->timeline_express_compare_sign( '2', 1 );
		$this->assertEquals( '<', $compare_sign );
	}

	/**
	 * Test that the announcement query args returns what we expect.
	 * @return array Query arguments to use on the front end queries.
	 */
	public function test_get_timeline_express_query_args() {
		$compare_signs = array( '>=', '', '<' );
		$sort_order = array( 'ASC', 'DESC' );
		$mock_shortcode_atts = array(
			'limit' => -1,
			'display' => 'all',
			'order' => 'ASC',
		);
		foreach ( $compare_signs as $compare_sign ) {
			foreach ( $sort_order as $sort ) {
				$query_args = $this->init_class->timeline_express_query_args( $compare_sign, $sort, $mock_shortcode_atts );
				if ( '' === $compare_sign ) {
					// Setup expected args for compare sign === ''
					$announcement_args = array(
						'post_type' => 'te_announcements',
						'meta_key'   => 'announcement_date',
						'orderby'    => 'meta_value_num',
						'order'      => $sort,
						'posts_per_page' => $mock_shortcode_atts['limit'],
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
						'posts_per_page' => $mock_shortcode_atts['limit'],
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

	/**
	 * Test that our HTML comment returns properly
	 * @return string HTMl helper comment generated below the timeline.
	 */
	public function test_timeline_express_html_comment() {
		$assumed_block = 'Timeline Express Free v' . TIMELINE_EXPRESS_VERSION_CURRENT . ' | Site: http://www.wp-timelineexpress.com | Author: CodeParrots - http://www.codeparrots.com';
		$html_block = $this->init_class->timeline_express_about_comment();
		$this->assertEquals( $assumed_block, $html_block );
	}

	/**
	 * Test that our inline styles are printing
	 */
	public function test_timeline_express_print_inline_styles() {
		// store some options
		$content_bg_color = $this->options['announcement-bg-color'];
		$bg_line_color = $this->options['announcement-background-line-color'];
		$box_shadow_color = $this->options['announcement-box-shadow-color'];
		// print the inline styles
		$this->init_class->timeline_express_print_inline_styles( $this->options );
		// get the loaded styles
		global $wp_styles;
		$inline_styles = $wp_styles->registered['timeline-express-base']->extra['after'][0];
		// assert the return values contain what we expect
		$this->assertContains( 'border-left-color: ' . $content_bg_color . ';', $inline_styles );
		$this->assertContains( '-moz-box-shadow: 0 3px 0 ' . $box_shadow_color . ';', $inline_styles );
		$this->assertContains( 'background: ' . $bg_line_color . ';', $inline_styles );
	}
}
