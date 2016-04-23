<?php
/**
 * Timeline Express Support Metabox template
 *
 * @package Timeline Express
 * @since 1.2
 */
$addon_title = get_transient( 'timeline_express_ad_title' );
$addon_image = get_transient( 'timeline_express_ad_image' );
$addon_content = get_transient( 'timeline_express_ad_content' );
$addon_url = get_transient( 'timeline_express_ad_url' );

/* Check for our transient, and conteinue - else abort */
if ( false !== get_transient( 'timeline_express_ad_rss_feed' ) ) {
	echo '<img src="' . esc_url( $addon_image ) . '" style="max-width:100%;" />';
	echo '<p class="description" style="margin:8px 0 0 0;">' . wp_kses_post( $addon_content ) . '</p>';
	echo '<a href="' . esc_url( $addon_url ) . '" target="_blank" class="button button-primary">' . esc_attr__( 'View Addon', 'timeline-express' ) . '</a>';
}
