<?php
/**
 * Q-translate compatibility.
 * @source https://wordpress.org/plugins/qtranslate-x/
 * @reference https://wordpress.org/support/topic/multilang-issue/
 *
 * @since NEXT
 */

/**
 * Clear Timeline Express cache on qtranslate pages.
 * Delete the cache when qtranslate is used to translate Timeline Express.
 *
 * @since NEXT
 */
function timeline_express_qtranslate_bust_cache() {

	global $post;

	if ( ! isset( $post->ID ) || false === get_transient( "timeline-express-query-{$post->ID}" ) ) {

		return;

	}

	delete_transient( "timeline-express-query-{$post->ID}" );

}
add_action( 'qtranslate_head_add_css', 'timeline_express_qtranslate_bust_cache' );
