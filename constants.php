<?php
/**
 * Plugin Constats
 * define constants used throughout Timeline Express
 * By Code Parrots
 *
 * @link http://www.codeparrots.com
 *
 * @package WordPress
 * @subpackage Component
 * @since 1.2
 */

/** Configuration **/
if ( ! defined( 'TIMELINE_EXPRESS_VERSION_CURRENT' ) ) {
	define( 'TIMELINE_EXPRESS_VERSION_CURRENT',	'1.2' );
}

if ( ! defined( 'TIMELINE_EXPRESS_PATH' ) ) {
	define( 'TIMELINE_EXPRESS_PATH', plugin_dir_path( __FILE__ ) );
}

if ( ! defined( 'TIMELINE_EXPRESS_URL' ) ) {
	define( 'TIMELINE_EXPRESS_URL', plugins_url( 'timeline-express/' ) );
}

/* Define Support Constants */
if ( ! defined( 'EH_DEV_SHOP_URL' ) ) {
	define( 'EH_DEV_SHOP_URL', 'https://www.evan-herman.com' );
}

if ( ! defined( 'EH_DEV_SHOP_SUPPORT_PRODUCT_NAME' ) ) {
	define( 'EH_DEV_SHOP_SUPPORT_PRODUCT_NAME', 'timeline-express' );
}

/** Database Tables **/
if ( ! defined( 'TIMELINE_EXPRESS_OPTION' ) ) {
	define( 'TIMELINE_EXPRESS_OPTION', 'timeline_express_storage' );
}
