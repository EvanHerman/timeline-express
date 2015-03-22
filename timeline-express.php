<?php
/*
#_________________________________________________ PLUGIN
Plugin Name: Timeline Express
Plugin URI: http://www.evan-herman.com
Description: Create a beautiful vertical, CSS3 animated and responsive timeline in minutes flat without writing code.
Version: 1.1.6.4
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

/** Configuration **/
if(!defined('TIMELINE_EXPRESS_VERSION_CURRENT'))				define('TIMELINE_EXPRESS_VERSION_CURRENT',	'1.1.6.4');
if(!defined('TIMELINE_EXPRESS_PATH'))							define('TIMELINE_EXPRESS_PATH',				plugin_dir_path( __FILE__ ));
if(!defined('TIMELINE_EXPRESS_URL'))							define('TIMELINE_EXPRESS_URL',				plugins_url('timeline-express/'));
if(!defined('TIMELINE_EXPRESS_URL_WP'))						define('TIMELINE_EXPRESS_URL_WP',				get_bloginfo('url'));
if(!defined('TIMELINE_EXPRESS_URL_WP_ADM'))					define('TIMELINE_EXPRESS_URL_WP_ADM',			TIMELINE_EXPRESS_URL_WP.'/wp-admin/');

/* Define Support Constants */
if(!defined('EH_DEV_SHOP_URL')) define( 'EH_DEV_SHOP_URL', 'http://www.evan-herman.com' );
if(!defined('EH_DEV_SHOP_SUPPORT_PRODUCT_NAME')) define( 'EH_DEV_SHOP_SUPPORT_PRODUCT_NAME', 'timeline-express' ); 		

/** Database Tables **/
if(!defined('TIMELINE_EXPRESS_OPTION'))						define('TIMELINE_EXPRESS_OPTION', 'timeline_express_storage');

// Conditional check for SSL enabled site
if(!defined('TIMELINE_EXPRESS_URL_WP_AJAX')) {
   if ( is_ssl() ) {
		define('TIMELINE_EXPRESS_URL_WP_AJAX', admin_url('admin-ajax.php', 'https'));
	} else {
		define('TIMELINE_EXPRESS_URL_WP_AJAX', admin_url('admin-ajax.php', 'http'));
	}
}

/** Localization **/
// include translated files
function timeline_express_text_domain_init() {
	load_plugin_textdomain('timeline-express', false, dirname(plugin_basename(__FILE__)) . '/languages'); 
}
add_action('init', 'timeline_express_text_domain_init');

/** Include Required Plugin Files **/
// main timeline express class file
require_once TIMELINE_EXPRESS_PATH.'classes/class.timeline-express.php';
// ajax functions
require_once TIMELINE_EXPRESS_PATH.'lib/lib.ajax.php';

/** Initialize the plugin's base class **/
$timelineExpressBase = new timelineExpressBase();

/** Activation Hooks **/
register_activation_hook( __FILE__ ,		array( &$timelineExpressBase, 'activate') );
register_deactivation_hook( __FILE__ ,	array( &$timelineExpressBase, 'deactivate') );
// register_uninstall_hook( __FILE__ ,		array( &$timelineExpressBase, 'uninstall') );

/* Daily Cron Job to check license */
register_activation_hook( __FILE__ , array( &$timelineExpressBase , 'schedule_timeline_express_support_cron' ) );