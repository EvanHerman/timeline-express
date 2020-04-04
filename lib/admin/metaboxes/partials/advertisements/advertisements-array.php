<?php
/**
 * Advertisements Array
 *
 * @since 1.3.1
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {

	exit;

}

$installation_url = wp_nonce_url( self_admin_url( 'update.php?action=install-plugin&plugin=timeline-express-html-excerpt-add-on' ), 'install-plugin_timeline-express-html-excerpt-add-on' );

return array(
	array(
		'title'   => __( 'AJAX Load More Add-On', 'timeline-express' ),
		'image'   => TIMELINE_EXPRESS_URL . 'lib/admin/images/advertisement/ajax-load-more-ad.jpg',
		'content' => null,
		'url'     => 'https://www.wp-timelineexpress.com/add-ons/?utm_source=plugin&utm_medium=banner&utm_campaign=freeplugin',
	),
	array(
		'title'      => __( 'Halloween Discount', 'timeline-express' ),
		'image'      => TIMELINE_EXPRESS_URL . 'lib/admin/images/advertisement/halloween-discount-ad.jpg',
		'start_date' => strtotime( '10/10/' . gmdate( 'Y' ) ),
		'end_date'   => strtotime( '10/31/' . gmdate( 'Y' ) ),
		'content'    => null,
		'url'        => 'http://wp-timelineexpress.com/pricing/?discount=halloween25&utm_source=plugin&utm_medium=banner&utm_campaign=freeplugin',
	),
	array(
		'title'   => __( 'Historical Dates Add-On', 'timeline-express' ),
		'image'   => TIMELINE_EXPRESS_URL . 'lib/admin/images/advertisement/historical-dates-ad.jpg',
		'content' => null,
		'url'     => 'https://www.wp-timelineexpress.com/add-ons/?utm_source=plugin&utm_medium=banner&utm_campaign=freeplugin',
	),
	array(
		'title'   => __( 'HTML Excerpts Add-On', 'timeline-express' ),
		'image'   => TIMELINE_EXPRESS_URL . 'lib/admin/images/advertisement/html-excerpts-ad.jpg',
		'content' => null,
		'url'     => $installation_url,
	),
	array(
		'title'   => __( 'Post Types Add-On', 'timeline-express' ),
		'image'   => TIMELINE_EXPRESS_URL . 'lib/admin/images/advertisement/post-types-ad.jpg',
		'content' => null,
		'url'     => 'https://www.evan-herman.com/wordpress-plugin/timeline-express-post-types-add-on/?utm_source=plugin&utm_medium=banner&utm_campaign=freeplugin',
	),
	array(
		'title'   => __( 'Timeline Express Bundle', 'timeline-express' ),
		'image'   => TIMELINE_EXPRESS_URL . 'lib/admin/images/advertisement/product-bundle-ad.jpg',
		'content' => null,
		'url'     => 'https://www.evan-herman.com/wordpress-plugin/timeline-express-bundle/?utm_source=plugin&utm_medium=banner&utm_campaign=freeplugin',
	),
);
