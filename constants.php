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

	define( 'TIMELINE_EXPRESS_VERSION_CURRENT', '1.6.0' );

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
 * Define the tracking project ID
 *
 * @since 1.3
 */
if ( ! defined( 'TIMELINE_EXPRESS_TRACKING_PROJECT_ID' ) ) {

	define( 'TIMELINE_EXPRESS_TRACKING_PROJECT_ID', '57fc20538db53dfda8a731c9' );

}

/**
 * Define the tracking write key
 *
 * @since 1.3
 */
if ( ! defined( 'TIMELINE_EXPRESS_TRACKING_WRITE_KEY' ) ) {

	define( 'TIMELINE_EXPRESS_TRACKING_WRITE_KEY', 'F0775BBAE5037EE4BB7F31A2AE70DD57F121F47C334D6A1E5D66866F2C9101615DE7A9702151A8CB2FE83C89DFE94DD5F24257D62FD4EB1C3ECD793D6C8263BD8CB1C95C0837BBBC946150BB8A8514215C961E4B31A9A90A4A680279F5C35840' );

}
