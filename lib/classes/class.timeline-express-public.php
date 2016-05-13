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
		add_filter( 'single_template', array( $this, 'timeline_express_announcement_single_page_template' ) );
		/* Filter the single announcement content. */
		add_action( 'loop_start', array( $this, 'condition_to_timeline_content' ) );
		/* Enqueue single announcement template styles */
		add_action( 'wp_enqueue_scripts', array( $this, 'timeline_express_single_template_styles' ) );
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
	public function timeline_express_announcement_single_page_template( $single_template ) {
		global $post;
		if ( ! isset( $post->post_type ) && 'te_announcements' !== $post->post_type ) {
			return $single_template;
		}
		/* If custom template file exists */
		if ( file_exists( get_stylesheet_directory() . '/timeline-express/single-announcement-template.php' ) ) {
			$single_template = get_stylesheet_directory() . '/timeline-express/single-announcement-template.php';
		} else if ( file_exists( get_stylesheet_directory() . 'single.php' ) ) {
			/* If single.php exists */
			$single_template = get_stylesheet_directory() . 'single.php';
		} else if ( file_exists( get_stylesheet_directory() . 'page.php' ) ) {
			/* If page.php exists */
			$single_template = get_stylesheet_directory() . 'page.php';
		}
		/**
		 * Return our template, passed through filters
		 * Legacy Support, 2 filters
		 */
		return apply_filters( 'timeline_express_single_page_template', apply_filters( 'timeline-express-single-page-template', $single_template ) );
	}

	/**
	 * Conditional to check which page is being displayed
	 * - This allows for the proper template
	 * - This fixes single templates loading in place of the timeline-container template
	 * 	 when the timeline is displayed inside of a post.
	 * @param  $query $query Query object used as the conditional.
	 * @return null  				 Filter to use when displaying the content.
	 * @since 1.2.3
	 */
	public function condition_to_timeline_content( $query ) {
		global $wp_query;
		if( $query === $wp_query ) {
			add_filter( 'the_content', array( $this, 'timeline_express_single_page_content' ), 10, 2 );
		} else {
			remove_filter('the_content', array( $this, 'timeline_express_single_page_content' ), 10, 2 );
		}
	}

	/**
	 * Filter the content, and load our template in it's place.
	 * @param array  $the_content The page content to filter.
	 * @return array The single page content to display for this announcement.
	 * @since  1.0
	 */
	public function timeline_express_single_page_content( $the_content ) {
		global $post;
		$post_id = ( isset( $post->ID ) ) ? $post->ID : '';
		// When this is not a single post, or it is and it isn't an announcement, abort
		if ( ! is_single() || 'te_announcements' !== $post->post_type ) {
			return $the_content;
		}
		ob_start();
		/* Store the announcement content from the WYSIWYG editor */
		$announcement_content = $the_content;
		/* Include the single template */
		get_timeline_express_template( 'single-announcement' );
		/* Return the output buffering */
		$the_content = ob_get_clean();
		/* Return announcement meta & append the announcement content */
		return apply_filters( 'timeline_express_single_content', $the_content . $announcement_content, $post_id );
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
