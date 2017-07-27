<?php
/**
 * Content wrapper endings
 *
 * This template can be overridden by copying it to yourtheme/timeline-express/timeline-express-page-wrappers-end.php.
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
		echo '</div>';

		get_sidebar( 'shop' );

		echo '</div>';

		break;

	case 'twentytwelve' :
		echo '</div></div>';

		break;

	case 'twentythirteen' :
		echo '</div></div>';

		break;

	case 'twentyfourteen' :
		echo '</div></div></div>';

		get_sidebar( 'content' );

		break;

	case 'twentyfifteen' :
		echo '</div></div>';

		break;

	case 'twentysixteen' :
		echo '</main></div>';

		break;

	case 'twentyseventeen' :
		echo '</main></div></div>';

		break;

	default:
		/**
		 * @action timeline_express_page_wrapper_end
		 *
		 * Hook in to use custom page wrappers
		 */
		do_action( 'timeline_express_page_wrapper_end' );

		echo '</div></div>';

		break;

}// End switch().
