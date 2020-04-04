<?php
/**
 * Timeline Express :: Initialization Class
 *
 * @author Code Parrots
 *
 * @link http://www.codeparrots.com
 *
 * @package Timeline_Express
 *
 * @since 1.2
 */
class Timeline_Express_Initialize {

	public function __construct() {

		// retreive & store our options
		$options = timeline_express_get_options();

		// check if the animation is disabled or not
		$animation_disabled = ( isset( $options['disable-animation'] ) && $options['disable-animation'] ) ? true : false;

		/**
		 * Enqueue our scripts & styles
		 * 1) Timeline Express Base Scripts to initialize the timeline.
		 * 2) do_action( 'timeline-express-scripts' ) for additional plugins to hook into.
		 */
		/* Scripts */
		wp_enqueue_script( 'timeline-express-js-base', TIMELINE_EXPRESS_URL . 'lib/public/js/min/timeline-express.min.js', array( 'jquery' ) );

		/* pass the disabled state to our script */
		wp_localize_script(
			'timeline-express-js-base',
			'timeline_express_data',
			array(
				'animation_disabled' => $animation_disabled,
			)
		);

		do_action( 'timeline-express-scripts' );

		$rtl = is_rtl() ? '-rtl' : '';

		/**
		 * Styles
		 * 1) Font Awesome for timeline icons
		 * 2) Timeline Express Base Styles to layout the timeline properly
		 * 3) do_action( 'timeline-express-styles' ); for additional plugins to hook into.
		 */
		timeline_express_enqueue_font_awesome();

		wp_enqueue_style( 'timeline-express-base', TIMELINE_EXPRESS_URL . "lib/public/css/min/timeline-express{$rtl}.min.css", array( 'font-awesome' ), TIMELINE_EXPRESS_VERSION_CURRENT );

		do_action( 'timeline-express-styles' );

		/** Print our Timeline Express styles */
		add_action( 'wp_enqueue_scripts', array( $this, self::timeline_express_print_inline_styles( $options ) ) );

		/* Add Custom Classes to the announcment container */
		add_filter( 'timeline-express-announcement-container-class', array( $this, 'timeline_express_announcement_container_classes' ), 10, 2 );

		add_filter( 'timeline_express_disable_cache', array( $this, 'disable_cache' ) );

	}

	/**
	 * Generate our timeline containers etc.
	 *
	 * @param  array  $timeline_express_options Array of timeline express settings, to be used in the timeline.
	 * @param  array  $atts Array of shortcode attributes, passed in above.
	 *
	 * @return string HTML content of our timeline used to render on the frontend.
	 */
	public function generate_timeline_express( $timeline_express_options, $atts ) {

		ob_start();

		global $post;

		/**
		 * Used to count the number of times a shortcode is used on a page
		 * This helps us store transients appropriately
		 * @var integer
		 */
		static $shortcode_count = 1;

		/* Setup the compare sign */
		$compare_sign = self::timeline_express_compare_sign( $atts['display'] );

		/* Setup the 'shortcode_iteration' variable for our transient */
		$shortcode_iteration = ( $shortcode_count > 1 ) ? '-' . $shortcode_count : '';

		/* Setup the transient suffix */
		$transient_suffix = ( isset( $post->ID ) ? $post->ID : '' ) . $shortcode_iteration;

		/**
		 * Filter the transient name for this page
		 *
		 * @param integer|string $post->ID            Post ID if found, else empy string
		 * @param integer        $shortcode_iteration The timeline number being displayed (1, 2, 3 etc.)
		 *
		 * @var string Filtered Timeline Express transient name
		 *
		 * @since 2.2.6
		 */
		$transient_name = (string) apply_filters( 'timeline_express_transient_name', $transient_suffix, ( isset( $post->ID ) ? $post->ID : '' ), $shortcode_iteration );

		$announcement_query = get_transient( 'timeline-express-query-' . $transient_name );

		/**
		 * Allow users to bypass the Timeline caching
		 *
		 * @var boolean
		 */
		$disable_cache = (bool) apply_filters( 'timeline_express_disable_cache', false );

		/**
		 * Check if our transient is present, and use that
		 * if not, re-run our query and setup the transient
		 * @since 1.2
		 */
		if ( false === $announcement_query || $disable_cache || WP_DEBUG ) {

			/* Setup the announcement args */
			$announcement_args = apply_filters( 'timeline_express_announcement_query_args', self::timeline_express_query_args( $compare_sign, $atts['order'], $atts ), $post, $atts );

			/* Run the query to retreive our announcements */
			$announcement_query = new WP_Query( $announcement_args );

			/* Setup our transient, and store it for a full day - before running again */
			set_transient( 'timeline-express-query-' . ( isset( $post->ID ) ? $post->ID : '' ) . $shortcode_iteration, $announcement_query, 24 * HOUR_IN_SECONDS );

		}

		$announcement_query = apply_filters( 'timeline_express_announcement_query', $announcement_query );

		/* Loop over announcements, if found */
		if ( $announcement_query->have_posts() ) {
			?>
			<section id="cd-timeline" class="cd-container timeline-express">

			<?php
			while ( $announcement_query->have_posts() ) {

				$announcement_query->the_post();

				get_timeline_express_template( 'timeline-container' );

				// reset the post data
				wp_reset_postdata();

			}
			?>

			</section>

			<?php

			// Action hook after timeline
			do_action( 'timeline-express-after-timeline', $atts, self::timeline_express_query_args( $compare_sign, $atts['order'], $atts ), $announcement_query );

		} else {

			/* Display the 'no events' message, setup in our options. */
			?>
				<h3 class="timeline-express-no-announcements-found">

					<?php echo apply_filters( 'timeline_express_no_announcements_found_message', esc_textarea( $timeline_express_options['no-events-message'] ) ); ?>

				</h3>
			<?php

		}// End if().

		/* Generate About Text */
		echo '<!-- ' . esc_html( self::timeline_express_about_comment() ) . ' -->';

		$shortcode = ob_get_contents();

		$shortcode_count++; // increment out shortcode counter

		ob_end_clean();

		return $shortcode;

	}

	/**
	 * Print the inlien styles for Timeline Express.
	 * These styles load the proper colors for Timeline Express containerss and background line.
	 *
	 * @param array $timeline_express_options Timeline Express options array.
	 *
	 * @since 1.2
	 */
	public function timeline_express_print_inline_styles( $timeline_express_options ) {

		$content_background = ( '' === $timeline_express_options['announcement-bg-color'] ) ? 'transparent' : $timeline_express_options['announcement-bg-color'];

		$content_shadow = ( '' === $timeline_express_options['announcement-box-shadow-color'] ) ? '0 3px 0 transparent' : '0 3px 0 ' . $timeline_express_options['announcement-box-shadow-color'];

		$background_line_color = ( '' === $timeline_express_options['announcement-background-line-color'] ) ? 'transparent' : $timeline_express_options['announcement-background-line-color'];

		$timeline_express_styles = "
		#cd-timeline::before {
			background: {$background_line_color};
		}
		#cd-timeline .cd-timeline-content {
			background: {$content_background};
			-webkit-box-shadow: {$content_shadow};
			-moz-box-shadow: {$content_shadow};
			box-shadow: {$content_shadow};
		}
		";

		if ( ! is_rtl() ) {

			$timeline_express_styles .= ".cd-timeline-block:nth-child(odd) .cd-timeline-content::before {
				border-left-color: {$content_background};
			}
			.cd-timeline-block:nth-child(even) .cd-timeline-content::before {
				border-right-color: {$content_background};
			}
			@media only screen and (max-width: 821px) {
				.cd-timeline-content::before {
					border-left-color: transparent;
					border-right-color: {$content_background};
				}
				.cd-timeline-block:nth-child(odd) .cd-timeline-content::before {
					border-left-color: transparent;
				}
			}";

		}

		if ( is_rtl() ) {

			$timeline_express_styles .= "@media only screen and (max-width: 821px) {
				.cd-timeline-content::before {
					border-right-color: transparent;
					border-left-color: {$content_background};
				}
				.cd-timeline-block:nth-child(odd) .cd-timeline-content::before {
					border-right-color: transparent;
					border-left-color: {$content_background};
				}
			}";

		}

		wp_add_inline_style( 'timeline-express-base', $timeline_express_styles );

	}

	/**
	 * Decide what compare sign should be used in the query arguments
	 *
	 * @param  string  $time_frame    The time frame, defined on our settings page (possible values: 0, 1, 2).
	 *
	 * @return string  $compare_sign  Return the compare sign to be used.
	 */
	public function timeline_express_compare_sign( $time_frame ) {

		switch ( strtolower( $time_frame ) ) {

			default:
			case 'future':
			case '0':
				$compare_sign = '>=';
				break;

			case 'all':
			case '1':
				$compare_sign = '';
				break;

			case 'past':
			case '2':
				$compare_sign = '<';
				break;

		}

		return apply_filters( 'timeline_express_compare_sign', $compare_sign, get_the_ID() );

	}

	/**
	 * Setup the Timeline Express query
	 *
	 * @param  string  $compare_sign Compare sign to be used in the query arguments. Dictates the query to be used.
	 * @param  string  $display_order The display order set in the timeline express settings array.
	 *
	 * @return array   $query_args Array of query arguments to be used.
	 */
	public function timeline_express_query_args( $compare_sign, $display_order, $shortcode_attributes ) {

		/* Set up the announcement arguments */
		$announcement_args = array(
			'post_type'      => 'te_announcements',
			'meta_key'       => 'announcement_date',
			'orderby'        => 'meta_value_num',
			'order'          => $display_order,
			'posts_per_page' => $shortcode_attributes['limit'],
		);

		// If the compare sign equals ''
		if ( '' !== $compare_sign ) {

			$announcement_args['meta_query'] = array(
				array(
					'key'     => 'announcement_date',
					'value'   => strtotime( current_time( 'm/d/Y' ) ),
					'type'    => 'NUMERIC',
					'compare' => $compare_sign,
				),
			);

		}

		/**
		 * Fitlered on line 85
		 * filter name: timeline_express_announcement_query_args
		 */
		return $announcement_args;

	}

	/**
	 * Generate about text, to aid in debugging.
	 *
	 * @return  string  We're returning a comment block for the frontend.
	 */
	public function timeline_express_about_comment() {

		ob_start();

		echo 'Timeline Express Free v' . esc_attr( TIMELINE_EXPRESS_VERSION_CURRENT );
		echo ' | Site: https://www.wp-timelineexpress.com';
		echo ' | Author: CodeParrots - http://www.codeparrots.com';

		return apply_filters( 'timeline_express_html_comment', ob_get_clean() );

	}

	/**
	 * Append additional classes to our container based on the announcement meta
	 *
	 * @param  string    $class             Initial class to add to our container (cd-container)
	 * @param  integer   $announcement_id   The announcement ID to retreive meta from
	 *
	 * @return string                       Imploded array of new classes to append to our container.
	 */
	public function timeline_express_announcement_container_classes( $class, $announcement_id ) {

		$container_classes = array( $class );

		$announcement_obj = get_post( $announcement_id );

		// Setup the date
		$announcement_date = ( get_post_meta( $announcement_id, 'announcement_date', true ) ) ? get_post_meta( $announcement_id, 'announcement_date', true ) : strtotime( $announcement_obj->post_date_gmt );

		// append the month
		$container_classes[] = strtolower( date_i18n( 'F', $announcement_date ) );

		// append the day
		$container_classes[] = date_i18n( 'd', $announcement_date );

		// append the year
		$container_classes[] = date_i18n( 'Y', $announcement_date );

		// if the announcement has no announcement image
		if ( ! get_post_meta( $announcement_id, 'announcement_image_id', true ) ) {

			$container_classes[] = 'announcement-no-image';

		}

		// append the post ID
		$container_classes[] = 'announcement-' . $announcement_id;

		// append the custom classes if enabled
		if ( defined( 'TIMELINE_EXPRESS_CONTAINER_CLASSES' ) && TIMELINE_EXPRESS_CONTAINER_CLASSES ) {

			$container_classes[] = esc_textarea( get_post_meta( $announcement_id, 'announcement_container_classes', true ) );

		}

		if ( defined( 'TIMELINE_EXPRESS_YEAR_ICONS' ) && TIMELINE_EXPRESS_YEAR_ICONS ) {

			$container_classes[] = 'year-icon';

		}

		// return the array
		return implode( ' ', $container_classes );

	}

	/**
	 * Disable the cache when the option is set to 0
	 *
	 * @since 2.2.5
	 *
	 * @return boolean True when cache is disabled, else false.
	 */
	public function disable_cache() {

		return ( '0' === get_option( 'timeline_express_cache_enabled', 1 ) );

	}
}
