<?php
/**
 #_________________________________________________ PLUGIN
 Plugin Name: Timeline Express
 Plugin URI: http://www.evan-herman.com
 Description: Create a beautiful vertical, CSS3 animated and responsive timeline in minutes flat without writing code.
 Version: 1.2
 Author: Evan Herman
 Author URI: http://www.evan-herman.com
 License: GPL2
 #_________________________________________________ LICENSE
 Copyright 2012-14 Evan Herman (email : evan.m.herman@gmail.com)

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
	load_plugin_textdomain( 'timeline-express', false, dirname( plugin_basename( __FILE__ ) ) . '/lib/languages' );
}
add_action( 'init', 'timeline_express_text_domain_init' );

/* Activation Hooks */

// register_activation_hook( __FILE__ ,		array( $timeline_express_base, 'activate' ) );

/* Include Class Files */

/* Main timeline express class file */
require_once plugin_dir_path( __FILE__ ) . 'lib/classes/class.timeline-express.php';
/* Initialize the plugin's base class */
$timeline_express_base = new TimelineExpressBase();

/* Ajax functions */
// require_once TIMELINE_EXPRESS_PATH.'lib/lib.ajax.php';

/* Activation Hooks */
// register_activation_hook( __FILE__ ,		array( $timeline_express_base, 'activate' ) );
// register_deactivation_hook( __FILE__ ,	array( $timeline_express_base, 'deactivate' ) );

/* Daily Cron Job to check license */
// register_activation_hook( __FILE__ , array( $timeline_express_base, 'schedule_timeline_express_support_cron' ) );
