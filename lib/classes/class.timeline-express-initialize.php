<?php
/**
 * Timeline Express Initialization class
 *
 * @category Timeline_Express_Initialize
 * @package  TimelineExpressBase
 * @author    CodeParrots
 * @license  GPLv2
 * @link     http://www.codeparrots.com
 */

/**
 * Initialize Timeline Express.
 */
class Timeline_Express_Initialize {
	/**
	 * Main class constructor
	 *
	 * @param array $atts Shortcode attributes passed in from class.timeline-express.php.
	 */
	public function __construct( $atts ) {
		/* Parse the shortcode attributes */
		$atts = shortcode_atts( array(), $atts, 'timeline-express' );

		/**
		 * Enqueue our scripts & styles
		 * 1) jquery-masonry for laying out the announcements
		 * 2) Timeline Express Base Scripts to initialize the timeline.
		 * 3) do_action( 'timeline-express-scripts' ) for additional plugins to hook into.
		 */
		/* Scripts */
		wp_enqueue_script( 'jquery-masonry' );
		wp_enqueue_script( 'timeline-express-js-base' , TIMELINE_EXPRESS_URL . 'lib/public/js/min/script.timeline-express.min.js' , array( 'jquery-masonry' ) );
		do_action( 'timeline-express-scripts' );

		/**
		 * Styles
		 * 1) Font Awesome for timeline icons
		 * 2) Timeline Express Base Styles to layout the timeline properly
		 * 3) do_action( 'timeline-express-styles' ); for additional plugins to hook into.
		 */
		timeline_express_enqueue_font_awesome();
		wp_enqueue_style( 'timeline-express-base', TIMELINE_EXPRESS_URL . 'lib/public/css/min/timeline-express.min.css' , array( 'font-awesome' ) , 'all' );
		do_action( 'timeline-express-styles' );

		/** Print our Timeline Express styles */
		add_action( 'wp_enqueue_scripts', array( $this, self::timeline_express_print_inline_styles( timeline_express_get_options() ) ) );
	}

	/**
	 * Generate our timeline containers etc.
	 *
	 * @param array $timeline_express_options Array of timeline express settings, to be used in the timeline.
	 * @param array $atts Array of shortcode attributes, passed in above.
	 * @return mixed HTML content of our timeline used to render on the frontend.
	 */
	public function generate_timeline_express( $timeline_express_options, $atts ) {
		ob_start();

		global $post;

		$compare_sign = self::timeline_express_compare_sign( $timeline_express_options['announcement-time-frame'] );
		$announcement_args = self::timeline_express_query_args( $compare_sign, $timeline_express_options['announcement-display-order'] );
		$announcement_query = new WP_Query( apply_filters( 'timeline_express_announcement_query_args', $announcement_args, $post, $atts ) );

		if ( $announcement_query->have_posts() ) {
			?>
			<section id="cd-timeline" class="cd-container">
			<?php
			while ( $announcement_query->have_posts() ) {
				$announcement = $announcement_query->the_post();
				self::generate_timeline_express_container( get_post( get_the_ID() ), $timeline_express_options );
			}
			?>
			</section>
			<?php
		}

		/* Generate About Text */
		echo '<!-- ' . esc_html( self::timeline_express_about_content() ) . ' -->';

		$shortcode = ob_get_contents();
		ob_end_clean();
		return $shortcode;
	}

	/**
	 * Print the inlien styles for Timeline Express.
	 * These styles load the proper colors for Timeline Express containerss and background line.
	 *
	 * @param array $timeline_express_options Timeline Express options array.
	 * @since 1.2
	 */
	private function timeline_express_print_inline_styles( $timeline_express_options ) {

		$content_background = ( '' === $timeline_express_options['announcement-bg-color'] ) ? 'transparent' : $timeline_express_options['announcement-bg-color'];
		$content_shadow = ( '' === $timeline_express_options['announcement-box-shadow-color'] ) ? '0 3px 0 transparent' : '0 3px 0 ' . $timeline_express_options['announcement-box-shadow-color'];
		$background_line_color = ( '' === $timeline_express_options['announcement-background-line-color'] ) ? 'transparent' : $timeline_express_options['announcement-background-line-color'];
		$timeline_express_styles = "
		.cd-timeline-block:nth-child(odd) .cd-timeline-content::before {
			border-left-color: {$content_background};
		}
		.cd-timeline-block:nth-child(even) .cd-timeline-content::before {
			border-right-color: {$content_background};
		}
		#cd-timeline::before {
			background: {$background_line_color};
		}
		#cd-timeline .cd-timeline-content {
			background: {$content_background};
			-webkit-box-shadow: {$content_shadow};
			-moz-box-shadow: {$content_shadow};
			box-shadow: {$content_shadow};
		}
		@media only screen and (max-width: 821px) {
				.cd-timeline-content::before {
					border-left-color: transparent;
					border-right-color: {$content_background};
				}
				.cd-timeline-block:nth-child(odd) .cd-timeline-content::before {
					border-left-color: transparent;
				}
		}
		";
		wp_add_inline_style( 'timeline-express-base', $timeline_express_styles );
	}

	/**
	 * Generate the timeline express container
	 *
	 * @param object $announcement The announcement (post) object.
	 * @param array  $timeline_express_options The timeline express settings array.
	 */
	private function generate_timeline_express_container( $announcement, $timeline_express_options ) {
		/**
		 * Check if a file exists locally (theme root), and load it.
		 * Users can create a directory (timeline-express), and copy over the announcement template into the theme root.
		 *
		 * @since 1.2
		 */
		if ( file_exists( get_template_directory() . '/timeline-express/timeline-express-container.php' ) ) {
			include( get_template_directory() . '/timeline-express/timeline-express-container.php' );
		} else {
			include( TIMELINE_EXPRESS_PATH . 'lib/public/partials/timeline-express-container.php' );
		}
	}

	/**
	 * Get the announcement icon to use.
	 *
	 * @param object $post_id The announcement post ID.
	 * @return the icon to be used for this announcement.
	 */
	private function get_announcement_icon( $post_id ) {
		return get_post_meta( $post_id, 'announcement_icon', true );
	}

	/**
	 * Get the announcement icon color to use.
	 *
	 * @param object $post_id The announcement post ID.
	 * @return the icon color to be used for this announcement.
	 */
	private function get_announcement_icon_color( $post_id ) {
		return get_post_meta( $post_id, 'announcement_color', true );
	}

	/**
	 * Get the announcement date
	 *
	 * @param object $post_id The announcement post ID.
	 * @return string the date to be used for this announcement.
	 */
	public static function get_announcement_date( $post_id ) {
		return esc_attr_e( apply_filters( 'timeline_express_frontend_date_filter', date_i18n( apply_filters( 'timeline_express_custom_date_format', get_option( 'date_format' ) ), get_post_meta( $post_id, 'announcement_date', true ) ), get_post_meta( $post_id, 'announcement_date', true ) ) );
	}

	/**
	 * Get the announcement image to use
	 *
	 * @param object $post_id The announcement post object.
	 * @param string $image_size (optional) Image size to use when displaying announcement images.
	 */
	public static function get_announcement_image( $post_id, $image_size = 'timeline-express' ) {
		echo wp_get_attachment_image(
			get_post_meta( $post_id, 'announcement_image_id', true ),
			apply_filters( 'timeline-express-announcement-img-size', $image_size ),
			false,
			array(
				'title' => esc_attr__( get_the_title() ),
				'class' => 'announcement-banner-image',
			)
		);
	}

	/**
	 * Get the announcement image to use
	 *
	 * @param bool    $random_length Dictates whether a random string length should be used.
	 * @param integer $excerpt_length the length of the excerpt to be used.
	 * @param object  $read_more_visiblity Whether or not the read more link should be visible.
	 * @param object  $post_id The announcement post ID.
	 * @return the excerpt to be used for this announcement.
	 */
	private function get_announcement_excerpt( $random_length, $excerpt_length, $read_more_visiblity, $post_id ) {
		/* Remove the default excerpt behavior from announcements */
		add_filter( 'excerpt_more', function( $post_id ) {
				return '';
		});
		/* If read more is visible, add a read more link */
		if ( '1' === $read_more_visiblity ) {
			/* Setup the read more button */
			add_filter( 'excerpt_more', function( $post_id ) {
					return '... <a class="' . esc_attr__( apply_filters( 'timeline-express-read-more-class', 'timeline-express-read-more-link' ) ) . '" href="'. esc_attr__( esc_url( get_permalink( $post_id ) ) ) . '"> ' . esc_attr__( apply_filters( 'timeline-express-read-more-text', __( 'Read more' , 'timeline-express' ) ) ) . '</a>';
			});
		}
		/* Setup the excerpt length */
		if ( 1 === $random_length ) {
			return self::generate_random_excerpt_length( $post_id );
		} else {
			add_filter( 'excerpt_length', function( $excerpt_length ) {
				return $excerpt_length;
			});
			return the_excerpt( get_the_content( $post_id ) );
		}
	}

	/**
	 * Generate a random excerpt length for the announcement.
	 *
	 * @param object $announcement_id The announcement ID, to use in queries.
	 * @return the excerpt to be used for this announcement.
	 */
	private function generate_random_excerpt_length( $announcement_id ) {
		add_filter( 'excerpt_length', function() {
			$random_length = (int) rand( apply_filters( 'timeline-express-random-excerpt-min', 50 ), apply_filters( 'timeline-express-random-excerpt-max', 150 ) );
			return (int) $random_length;
		});
		return the_excerpt( get_the_content( $announcement_id ) );
	}

	/**
	 * Decide what compare sign should be used in the query arguments
	 *
	 * @param string $time_frame The time frame, defined on our settings page (possible values: 0, 1, 2).
	 * @return string $compare_sign Return the compare sign to be used.
	 */
	private function timeline_express_compare_sign( $time_frame ) {
		switch ( $time_frame ) {
			default:
			case '0':
				$compare_sign = '>=';
			break;

			case '1':
				$compare_sign = '';
			break;

			case '2':
				$compare_sign = '<';
			break;
		}
		return $compare_sign;
	}

	/**
	 * Setup the Timeline Express query
	 *
	 * @param string $compare_sign Compare sign to be used in the query arguments. Dictates the query to be used.
	 * @param string $display_order The display order set in the timeline express settings array.
	 * @return array $query_args Array of query arguments to be used.
	 */
	private function timeline_express_query_args( $compare_sign, $display_order ) {
		/* Set up the announcement arguments */
		if ( '' === $compare_sign ) {
			$announcement_args = array(
				'post_type' => 'te_announcements',
				'meta_key'   => 'announcement_date',
				'orderby'    => 'meta_value_num',
				'order'      => $display_order,
				'no_found_rows' => true,
				'posts_per_page' => 50,
			);
		} else { /* Else the compare sign is set */
			$announcement_args = array(
				'post_type' => 'te_announcements',
				'meta_key'   => 'announcement_date',
				'orderby'    => 'meta_value_num',
				'order'      => $display_order,
				'no_found_rows' => true,
				'posts_per_page' => 50,
				'meta_query' => array(
					array(
						'key'     => 'announcement_date',
						'value'   => strtotime( current_time( 'm/d/Y' ) ),
						'type' => 'NUMERIC',
						'compare' => $compare_sign,
					),
				),
			);
		}
		return apply_filters( 'timeline_express_frontend_query_args', $announcement_args );
	}

	/**
	 * Generate about text, to aid in debugging.
	 *
	 * @return string We're returning a comment block for the frontend.
	 */
	private function timeline_express_about_content() {
		ob_start();
		echo 'Timeline Express Free v' . esc_attr__( TIMELINE_EXPRESS_VERSION_CURRENT );
		echo ' | Site: http://www.wp-timelineexpress.com';
		echo ' | Author: CodeParrots - http://www.codeparrots.com';
		return ob_get_clean();
	} /* Last Function */
}
