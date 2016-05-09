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
	echo '<a href="' . esc_url( $addon_url ) . '" class="advertisment-link" target="_blank" title="' . esc_attr( $addon_title ) . '"><img src="' . esc_url( $addon_image ) . '" style="max-width:100%;width:100%;" /></a>';
}
