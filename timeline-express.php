<?php
/*
#_________________________________________________ PLUGIN
Plugin Name: Timeline Express
Plugin URI: http://www.evan-herman.com
Description: Create a beautiful vertical, CSS3 animated and responsive timeline in minutes flat without writing code.
Version: 1.0.2
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
if(!defined('TIMELINE_EXPRESS_DEBUG'))						define('TIMELINE_EXPRESS_DEBUG',		         false);
if(!defined('TIMELINE_EXPRESS_VERSION_CURRENT'))				define('TIMELINE_EXPRESS_VERSION_CURRENT',	'1.0.2');
if(!defined('TIMELINE_EXPRESS_REQ_PHP'))						define('TIMELINE_EXPRESS_REQ_PHP',			'5.0');
if(!defined('TIMELINE_EXPRESS_AUTHOR'))						define('TIMELINE_EXPRESS_AUTHOR',				'Evan Herman');
if(!defined('TIMELINE_EXPRESS_SITE'))							define('TIMELINE_EXPRESS_SITE',				site_url().'/');
if(!defined('TIMELINE_EXPRESS_PREFIX'))						define('TIMELINE_EXPRESS_PREFIX',				'timeline_express_');
if(!defined('TIMELINE_EXPRESS_PATH'))							define('TIMELINE_EXPRESS_PATH',				ABSPATH.'wp-content/plugins/timeline-express/');
if(!defined('TIMELINE_EXPRESS_URL'))							define('TIMELINE_EXPRESS_URL',				plugins_url('timeline-express/'));
if(!defined('TIMELINE_EXPRESS_URL_WP'))						define('TIMELINE_EXPRESS_URL_WP',				get_bloginfo('url'));
if(!defined('TIMELINE_EXPRESS_URL_WP_ADM'))					define('TIMELINE_EXPRESS_URL_WP_ADM',			TIMELINE_EXPRESS_URL_WP.'/wp-admin/');

/** Database Tables **/
if(!defined('TIMELINE_EXPRESS_OPTION'))						define('TIMELINE_EXPRESS_OPTION',				TIMELINE_EXPRESS_PREFIX.'storage');

// Conditional check for SSL enabled site
if(!defined('TIMELINE_EXPRESS_URL_WP_AJAX')) {
   if ( is_ssl() ) {
		define('TIMELINE_EXPRESS_URL_WP_AJAX', admin_url('admin-ajax.php', 'https'));
	} else {
		define('TIMELINE_EXPRESS_URL_WP_AJAX', admin_url('admin-ajax.php', 'http'));
	}
}
if(!defined('TIMELINE_EXPRESS_URL_CURRENT'))					define('TIMELINE_EXPRESS_URL_CURRENT',		$_SERVER['REQUEST_URI']);


/** Localization **/
// include translated files
function timeline_express_text_domain_init() {
	load_plugin_textdomain('timeline-express', false, dirname(plugin_basename(__FILE__)) . '/languages'); 
}
add_action('init', 'timeline_express_text_domain_init');

/** Initial Configuration **/
if(TIMELINE_EXPRESS_DEBUG) error_reporting(E_ALL ^ E_NOTICE);

/** Include Required Plugin Files **/
// main boilerplate class file
require_once TIMELINE_EXPRESS_PATH.'classes/class.timeline-express.php';
// ajax functions
require_once TIMELINE_EXPRESS_PATH.'lib/lib.ajax.php';

/** Initialize the plugin's base class **/
$timelineExpressBase	= new timelineExpressBase();

/** Activation Hooks **/
register_activation_hook(__FILE__,		array(&$timelineExpressBase, 'activate'));
register_deactivation_hook(__FILE__,	array(&$timelineExpressBase, 'deactivate'));
register_uninstall_hook(__FILE__,		array('timelineExpressBase', 'uninstall'));