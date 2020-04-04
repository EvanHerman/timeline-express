<?php
/**
#_________________________________________________ PLUGIN
Plugin Name: Timeline Express
Plugin URI: https://www.wp-timelineexpress.com
Description: Create a beautiful vertical, CSS3 animated and responsive timeline in minutes flat without writing code.
Version: 1.8.1
Author: Code Parrots
Text Domain: timeline-express
Author URI: http://www.codeparrots.com
License: GPL2
#_________________________________________________ LICENSE
Copyright 2012-16 Code Parrots (email : codeparrots@gmail.com)

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License, version 2, as
published by the Free Software Foundation.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
#_________________________________________________ CONSTANTS
 *
 * @link http://www.codeparrots.com
 *
 * @package Timeline Express
 * @since 1.0.0
 **/

/* Include project constants */
include_once plugin_dir_path( __FILE__ ) . 'constants.php';

/**
 * Localization
 * Include our textdomain and translation files
 **/
function timeline_express_text_domain_init() {

	load_plugin_textdomain( 'timeline-express', false, dirname( plugin_basename( __FILE__ ) ) . '/i18n' );

}
add_action( 'init', 'timeline_express_text_domain_init' );

/* Main Timeline Express class file */
require_once plugin_dir_path( __FILE__ ) . 'lib/classes/class-timeline-express.php';

/* Initialize the base class */
$timeline_express_base = new TimelineExpressBase();

/* Activation Hook */
register_activation_hook(
	__FILE__,
	array(
		$timeline_express_base,
		'timeline_express_activate',
	)
);

/* Deactivation Hook */
register_deactivation_hook(
	__FILE__,
	array(
		$timeline_express_base,
		'timeline_express_deactivate',
	)
);
