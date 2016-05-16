<?php
/**
 * Timeline Express :: Admin Class
 * By Code Parrots
 * @link http://www.codeparrots.com
 *
 * @package WordPress
 * @subpackage Component
 * @since 1.2
 **/
class TimelineExpressPublic {
	/**
	 * Main constructor
	 */
	public function __construct() {
		/* Include the Timeline Express Init class */
		include TIMELINE_EXPRESS_PATH . 'lib/classes/class.timeline-express-initialize.php';
		/* Define our [timeline-express] shortcode, so it's usable on the frontend */
		add_shortcode( 'timeline-express', array( $this, 'process_timeline_express_shortcode' ) );
		/* load a custom page template (override the default) */
		// add_filter( 'single_template', array( $this, 'timeline_express_announcement_single_page_template' ) );
		/* Load custom template */
		add_filter( 'template_include', array( $this, 'timeline_express_announcement_single_page_template' ) );
		/* Enqueue single announcement template styles */
		add_action( 'wp_enqueue_scripts', array( $this, 'timeline_express_single_template_styles' ) );
		/* Add appropriate container class for sidebar/no-sidebar styles */
		add_filter( 'timeline-express-single-container-class', array( $this, 'timeline_express_single_container_classes' ) );
	}

	/**
	 * Define and process [timeline-express] shortcode
	 *
	 * @param array $atts array of shortcode attributes.
	 * @since  1.0
	 */
	public function process_timeline_express_shortcode( $atts ) {
		$options = timeline_express_get_options();
		/* Parse the shortcode attributes */
		$atts = shortcode_atts( array(
			'limit' => -1,
			'order' => $options['announcement-display-order'],
			'display' => $options['announcement-time-frame'],
		), $atts, 'timeline-express' );
		$timeline_express_init = new Timeline_Express_Initialize();
		return $timeline_express_init->generate_timeline_express( $options, $atts );
	}

	/**
	 * Decide what template file to use to display single announcements.
	 * 	First checks for a directory in the theme root /timeline-express/single-te_announcements.php,
	 *  Next it checks for a single.php template in the theme root
	 *  Next it checksf or a page.php template in the theme root
	 *  If all else fails, it will use the default template defined by WordPress.
	 * @param  string 	$page_template 	  The page template name to be used for single announcements.
	 * @return string                  		The page template to be used for the single announcements.
	 * @since 1.2
	 */
	public function timeline_express_announcement_single_page_template( $template ) {
		global $post;
		if ( ! isset( $post->post_type ) || 'te_announcements' !== $post->post_type ) {
			return $template;
		}
		/* If custom template file exists */
		if ( file_exists( get_stylesheet_directory() . '/timeline-express/single-announcement-template.php' ) ) {
			$template = get_stylesheet_directory() . '/timeline-express/single-announcement-template.php';
		} else {
			/* If single.php exists */
			$template = TIMELINE_EXPRESS_PATH . 'lib/public/partials/single.timeline-express.php';
		}
		/**
		 * Return our template, passed through filters
		 * Legacy Support, 2 filters
		 */
		return apply_filters( 'timeline_express_single_page_template', apply_filters( 'timeline-express-single-page-template', $template ) );
	}

	/**
	 * Enqueue styles on single announcement templates.
	 * @return null
	 * @since 1.2
	 */
	public function timeline_express_single_template_styles() {
		global $post;
		// When this is not a single post, or it is but is not an announcement
		if ( ! is_single() || 'te_announcements' !== $post->post_type ) {
			return;
		}
		wp_enqueue_style( 'single-timeline-express-styles', TIMELINE_EXPRESS_URL . 'lib/public/css/min/timeline-express.min.css', array(), 'all' );
	} /* Final Function */
}
$timeline_express_public = new TimelineExpressPublic();
