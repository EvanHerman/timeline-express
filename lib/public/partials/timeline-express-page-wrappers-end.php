<?php
/**
 * Content wrapper endings
 *
 * This template can be overridden by copying it to yourtheme/timeline-express/timeline-express-page-wrappers-end.php.
 *
 * @version     1.0.0
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

	default :
		echo '</div></div>';
		break;
}
