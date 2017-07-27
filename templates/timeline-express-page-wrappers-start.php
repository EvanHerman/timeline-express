<?php
/**
 * Content wrappers beginngs
 *
 * This template can be overridden by copying it to yourtheme/level-playing-field/global/timeline-express-page-wrappers-start.php.
 *
 * @author Code Parrots
 *
 * @link http://www.codeparrots.com
 *
 * @package Timeline Express
 *
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {

	exit; // Exit if accessed directly

}

$template = get_option( 'template' );

switch ( $template ) {

	case 'twentyeleven' :
		echo '<div id="primary"><div id="content" role="main" class="twentyeleven">';

		break;

	case 'twentytwelve' :
		echo '<div id="primary" class="site-content"><div id="content" role="main" class="twentytwelve">';

		break;

	case 'twentythirteen' :
		echo '<div id="primary" class="site-content"><div id="content" role="main" class="entry-content twentythirteen">';

		break;

	case 'twentyfourteen' :
		echo '<div id="primary" class="content-area"><div id="content" role="main" class="site-content twentyfourteen"><div class="tfwc entry-content">';

		break;

	case 'twentyfifteen' :
		add_action( 'timeline_express_before_announcement_content', 'timeline_express_twenty_fifteen_top_container' );
		add_action( 'timeline_express_after_announcement_content', 'timeline_express_twenty_fifteen_bottom_container' );

		echo '<div id="primary" role="main" class="content-area twentyfifteen"><div id="main" class="site-main t15wc">';

		break;

	case 'twentysixteen' :
		echo '<div id="primary" class="content-area twentysixteen"><main id="main" class="site-main" role="main">';

		break;

	case 'twentyseventeen' :
		echo '<div class="wrap"><div id="primary" class="content-area"><main id="main" class="site-main" role="main">';

		break;

	default:
		/**
		 * @action timeline_express_page_wrapper_start
		 *
		 * Hook in to use custom page wrappers
		 */
		do_action( 'timeline_express_page_wrapper_start' );

		echo '<div id="container"><div id="content" role="main">';

		break;

}// End switch().

/**
 * Twenty Fifteen Helper
 */
function timeline_express_twenty_fifteen_top_container() {

	echo '<div class="entry-content">';

}

/**
 * Twenty Fifteen Helper
 */
function timeline_express_twenty_fifteen_bottom_container() {

	echo '</div>';

}
