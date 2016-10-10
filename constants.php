<?php
/**
 * Plugin Constats
 * define constants used throughout Timeline Express
 * By Code Parrots
 *
 * @link http://www.codeparrots.com
 *
 * @package Timeline Express
 * @since 1.2
 */

/**
 * Define the current version of Timeline Express
 */
if ( ! defined( 'TIMELINE_EXPRESS_VERSION_CURRENT' ) ) {

	define( 'TIMELINE_EXPRESS_VERSION_CURRENT', '1.2.9' );

}

/**
 * Define the path to Timeline Express
 */
if ( ! defined( 'TIMELINE_EXPRESS_PATH' ) ) {

	define( 'TIMELINE_EXPRESS_PATH', plugin_dir_path( __FILE__ ) );

}

/**
 * Define the URL of Timeline Express
 */
if ( ! defined( 'TIMELINE_EXPRESS_URL' ) ) {

	define( 'TIMELINE_EXPRESS_URL', plugins_url( 'timeline-express/' ) );

}

/**
 * Define the name of the option in the database
 */
if ( ! defined( 'TIMELINE_EXPRESS_OPTION' ) ) {

	define( 'TIMELINE_EXPRESS_OPTION', 'timeline_express_storage' );

}

/**
 * Define Support/Update endpoint URLs for our Add-ons
 */
if ( ! defined( 'EH_DEV_SHOP_URL' ) ) {

	define( 'EH_DEV_SHOP_URL', 'https://www.evan-herman.com' );

}

/**
 * Define the tracking project id
 */
if ( ! defined( 'TIMELINE_EXPRESS_TRACKING_PROJECT_ID' ) ) {

	define( 'TIMELINE_EXPRESS_TRACKING_PROJECT_ID', '57f9bc868db53dfda8a72f46' );

}

/**
 * Define the tracking write key
 */
if ( ! defined( 'TIMELINE_EXPRESS_TRACKING_WRITE_KEY' ) ) {

	define( 'TIMELINE_EXPRESS_TRACKING_WRITE_KEY', 'F53C50051F4C4932A67B568DF88E7C8025C60261F6B1FD4888F2A13C9649D1585FBB0D4FD3CD8C8EB860AB5847053A1196621A7CCB22D49C6ED6DF4CB383C823F0B3F8FF06519036C24E80B1D6CB7320899FEAF044C532A066BE9A11F10B1A4C' );

}
