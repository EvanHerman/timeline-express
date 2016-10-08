<?php
/**
 * AJAX Load More Advertisment
 *
 * @since 1.2.9
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {

	exit;

}

return [
	'title'   => __( 'AJAX Load More Add-On', 'timeline-express' ),
	'image'   => TIMELINE_EXPRESS_URL . 'lib/admin/images/advertisement/ajax-load-more-ad.jpg',
	'content' => null,
	'url'     => 'https://www.wp-timelineexpress.com/add-ons/?utm_source=plugin&utm_medium=banner&utm_campaign=freeplugin',
];
