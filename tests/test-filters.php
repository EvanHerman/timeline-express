<?php

class TE_Filter_Tests extends WP_UnitTestCase {

	/**
	 * Test that our font awesome version filter works properly
	 * @return bool PHP Unit test assertion.
	 */
	function test_font_awesome_version_filter() {
		$font_awesome_version = apply_filters( 'timeline_express_font_awesome_version', '4.5.0' );
		$this->assertEquals( '4.4.0', $font_awesome_version );
	}

	/**
	 * Test that our menu capabilities filter works properly
	 * @return bool PHP Unit test assertion.
	 */
	function test_timeline_express_menu_capability() {
		$menu_cap = apply_filters( 'timeline_express_menu_cap', 'manage_options' );
		$this->assertEquals( 'read', $menu_cap );
	}
}


/**
 * Test that our font awesome version number filter works properly
 * Filter: timeline_express_font_awesome_version
 *
 * @param int $version_number Initial font awesome version number pre-filter.
 * @return int Font awesome version number
 */
function filter_font_awesome_version_number( $version_numer ) {
	return '4.4.0';
}
add_action( 'timeline_express_font_awesome_version', 'filter_font_awesome_version_number' );

/**
 * Test that our menu capabilities work properly
 * Filter: timeline_express_menu_cap
 *
 * @param int $cap Default capability for users to manage announcements.
 * @return int Font awesome version number
 */
function filter_timeline_express_menu_capabilities( $cap ) {
	return 'read';
}
add_action( 'timeline_express_menu_cap', 'filter_timeline_express_menu_capabilities' );
