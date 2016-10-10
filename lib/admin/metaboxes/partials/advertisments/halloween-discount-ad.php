<?php
/**
 * Historical Dates Advertisment
 *
 * @since 1.2.9
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {

	exit;

}

return [
	'title'      => __( 'Halloween Discount', 'timeline-express' ),
	'image'      => TIMELINE_EXPRESS_URL . 'lib/admin/images/advertisement/halloween-discount-ad.jpg',
	'start_date' => strtotime( '10/10/' . date( 'Y' ) ),
	'end_date'   => strtotime( '10/31/' . date( 'Y' ) ),  
	'content'    => null,
	'url'        => 'http://wp-timelineexpress.com/pricing/?discount=halloween25&utm_source=plugin&utm_medium=banner&utm_campaign=freeplugin',
];
