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

	define( 'TIMELINE_EXPRESS_VERSION_CURRENT', '1.8.1' );

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
if ( ! defined( 'TIMELINE_EXPRESS_SITE_URL' ) ) {

	define( 'TIMELINE_EXPRESS_SITE_URL', 'https://www.wp-timelineexpress.com' );

}

/**
 * Define Timeline Express blocks path
 */
if ( ! defined( 'TIMELINE_EXPRESS_BLOCKS_PATH' ) ) {

	define( 'TIMELINE_EXPRESS_BLOCKS_PATH', plugin_dir_path( __FILE__ ) . '/lib/admin/blocks/' );

}
