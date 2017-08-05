<?php
/**
 * Timeline Express :: Compatibility Class
 *
 * @author Code Parrots
 * @link http://www.codeparrots.com
 * @package Timeline_Express
 * @since 1.5.2
 */

class Timeline_Express_Compat {

	public function __construct() {

		add_action( 'init', array( $this, 'include_compat_files' ) );

	}

	/**
	 * Include our compatibility files.
	 *
	 * @since 1.5.2
	 */
	public function include_compat_files() {

		$whitelist = array(
			'qtranslate.php',
		);

		foreach ( $whitelist as $compat_file ) {

			if ( ! is_readable( TIMELINE_EXPRESS_PATH . "lib/compat/{$compat_file}" ) ) {

				continue;

			}

			include_once TIMELINE_EXPRESS_PATH . "lib/compat/{$compat_file}";

		}

	}

}

$timeline_express_compat = new Timeline_Express_Compat();
