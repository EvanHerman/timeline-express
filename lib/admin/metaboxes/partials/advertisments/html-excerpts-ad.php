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

$installation_url = wp_nonce_url( self_admin_url( 'update.php?action=install-plugin&plugin=timeline-express-html-excerpt-add-on' ), 'install-plugin_timeline-express-html-excerpt-add-on' );

return [
	'title'   => __( 'HTML Excerpts Add-On', 'timeline-express' ),
	'image'   => TIMELINE_EXPRESS_URL . 'lib/admin/images/advertisement/html-excerpts-ad.jpg',
	'content' => null,
	'url'     => $installation_url,
];
