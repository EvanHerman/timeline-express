<?php
/**
 * Test submodules exist.
 *
 * @package Timeline Express
 * @since 1.5.0
 */

class Submodule_Tests extends WP_UnitTestCase {

	public function setUp() {

		parent::setUp();

	}

	public function test_cmb2_submodule() {

		$root = dirname( dirname( __FILE__ ) );

		$cmb2 = $root . '/lib/admin/CMB2';

		$this->assertTrue( file_exists( $cmb2 ), "The {$cmb2} directory does not exist." );
		$this->assertTrue( is_dir( $cmb2 ), "{$cmb2} is not a directory." );

		$this->assertFalse( $this->is_dir_empty( $cmb2 ), "{$cmb2} is empty." );

	}

	/**
	 * Check if a directory is empty.
	 *
	 * @param  string  $dir Path to a directory.
	 *
	 * @return boolean      Return true if empty, false
	 */
	private function is_dir_empty( $dir ) {

		return ( count( glob( "$dir/*" ) ) === 0 );

	}

}
