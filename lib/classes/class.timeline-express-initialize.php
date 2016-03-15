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

		$compare_sign = self::timeline_express_compare_sign( $timeline_express_options['announcement-time-frame'] );
		$announcement_args = self::timeline_express_query_args( $compare_sign, $timeline_express_options['announcement-display-order'] );

		global $post;

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
		$shortcode = ob_get_contents();
		ob_end_clean();
		return $shortcode;
	}

	/**
	 * Generate the timeline express container
	 *
	 * @param object $announcement The announcement (post) object.
	 * @param array $timeline_express_options The timeline express settings array.
	 */
	private function generate_timeline_express_container( $announcement, $timeline_express_options ) {
		$container_styles = array();
		$container_styles['background'] = ( '' === $timeline_express_options['announcement-bg-color'] ) ? 'background: transparent;' : 'background: ' . $timeline_express_options['announcement-bg-color'] . ';';
		/* Crossbrowser compliant */
		$container_styles['shadow'] = ( '' === $timeline_express_options['announcement-box-shadow-color'] ) ? 'box-shadow: 0 3px 0 transparent;' : 'box-shadow: 0 3px 0 ' . $timeline_express_options['announcement-box-shadow-color'] . ';';
		$container_styles['shadow'] .= ( '' === $timeline_express_options['announcement-box-shadow-color'] ) ? '-webkit-box-shadow: 0 3px 0 transparent;' : '-webkit-box-shadow: 0 3px 0 ' . $timeline_express_options['announcement-box-shadow-color'] . ';';
		$container_styles['shadow'] .= ( '' === $timeline_express_options['announcement-box-shadow-color'] ) ? '-moz-box-shadow: 0 3px 0 transparent;' : '-moz-box-shadow: 0 3px 0 ' . $timeline_express_options['announcement-box-shadow-color'] . ';';
		?>
		<div class="cd-timeline-block">
			<?php
			/* Generate the icon container */
			echo self::get_announcement_icon( $announcement );
			?>
			<div class="cd-timeline-content" style="<?php esc_attr_e( implode(' ', $container_styles ) ); ?>">
				<!-- title -->
				<span class="cd-timeline-title-container">
					<h2 class="cd-timeline-item-title">
						<?php the_title();?>
					</h2>
					<?php
					/* Generate the announcement date */
					echo self::get_announcement_date( $timeline_express_options['date-visibility'], $announcement );
					echo self::get_announcement_image( $announcement );
					?>
					<span class="the-excerpt">
						<?php
						echo self::get_announcement_excerpt( $timeline_express_options['excerpt-random-length'], $timeline_express_options['excerpt-trim-length'], $timeline_express_options['read-more-visibility'], $announcement );
						?>
					</span>
				</span>
			</div>
		</div>
		<?php
	}

	/**
	 * Get the announcement icon to use
	 *
	 * @param object $post The announcement post object.
	 * @return the icon to be used for this announcement.
	 */
	private function get_announcement_icon( $post ) {
		$timeline_express_options = timeline_express_get_options();
		$custom_icon_html = apply_filters( 'timeline-express-custom-icon-html', '', $post, $timeline_express_options );
		if ( ! empty( $custom_icon_html ) ) {
			return $custom_icon_html;
		} else {
			$icon = ''; /* Start clean */
			if ( 0 !== $timeline_express_options['read-more-visibility'] ) {
				$icon .= '<a class="cd-timeline-icon-link" href="' . get_the_permalink( $post->ID ) . '">';
					$icon .= '<div class="cd-timeline-img cd-picture" style="background:' . get_post_meta( $post->ID , 'announcement_color' , true ). ';">';
						$icon .= '<span class="fa ' . get_post_meta( $post->ID , 'announcement_icon' , true ) . '" title="' . get_the_title( $post->ID ) . '"></span>';
					$icon .= '</div> <!-- cd-timeline-img -->';
				$icon .= '</a>';
			} else {
				$icon .= '<div class="cd-timeline-img cd-picture" style="background:' . get_post_meta( $post->ID , 'announcement_color' , true ) . ';">';
					$icon .= '<span class="fa ' . get_post_meta( $post->ID , 'announcement_icon' , true ) . '" title="' . get_the_title( $post->ID ) . '"></span>';
				$icon .= '</div> <!-- cd-timeline-img -->';
			}
			return $icon;
		}
	}

	/**
	 * Get the announcement date
	 *
	 * @param integer $date_visibility Setting option to decide if date should be visible or not.
	 * @param object  $post The announcement post object.
	 * @return the icon to be used for this announcement.
	 */
	private function get_announcement_date( $date_visibility, $post ) {
		$date_container = null;
		if ( 1 === (int) $date_visibility ) {
			/* Now localized, for international date formats based on the 'date_format' option */
			$date_container = '<span class="timeline-date">';
				$date_container .= esc_attr_e( apply_filters( 'timeline_express_frontend_date_filter', date_i18n( apply_filters( 'timeline_express_custom_date_format' , get_option( 'date_format' ) ) , get_post_meta( $post->ID, 'announcement_date', true ) ), get_post_meta( $post->ID, 'announcement_date', true ) ) );
			$date_container .= '</span>';
		}
		return $date_container;
	}

	/**
	 * Get the announcement image to use
	 *
	 * @param object $post The announcement post object.
	 * @return the announcement image to be used.
	 */
	private function get_announcement_image( $post ) {
		return wp_get_attachment_image(
			get_post_meta( $post->ID, 'announcement_image_id', true ),
			apply_filters( 'timeline-express-announcement-img-size', 'timeline-express' ),
			false,
			array(
				'alt' => '',
				'class' => 'announcement-banner-image',
			)
		);
	}

	/**
	 * Get the announcement image to use
	 *
	 * @param bool    random_length Dictates whether a random string length should be used.
	 * @param integer $excerpt_length the length of the excerpt to be used.
	 * @param object  $read_more_visibility Whether or not the read more link should be visible.
	 * @param object  $post The announcement post object.
	 * @return the excerpt to be used for this announcement.
	 */
	private function get_announcement_excerpt( $random_length, $excerpt_length, $read_more_visiblity, $post ) {
		$post_id = (int) $post->ID;
		/* Remove the default excerpt behavior from announcements */
		add_filter('excerpt_more', function( $post_id ) {
				return '';
		});
		/* If read more is visible, add a read more link */
		if ( '1' === $read_more_visiblity ) {
			/* Setup the read more button */
			add_filter('excerpt_more', function( $post_id ) {
					return '... <a class="moretag" class="' . implode( ' ', apply_filters( 'timeline-express-read-more-class', array( 'cd-read-more' ) ) ) . '" href="'. get_permalink( $post_id ) . '"> ' . __( 'Read more' , 'timeline-express' ) . '</a>';
			});
		}
		/* Setup the excerpt length */
		if ( 1 === $random_length ) {
			return self::generate_random_excerpt_length( $post->ID );
		} else {
			add_filter( 'excerpt_length', function( $excerpt_length ) {
				return $excerpt_length;
			});
			return the_excerpt( get_the_content( $post->ID ) );
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
				'posts_per_page' => -1,
			);
		} else { /* Else the compare sign is set */
			$announcement_args = array(
				'post_type' => 'te_announcements',
				'meta_key'   => 'announcement_date',
				'orderby'    => 'meta_value_num',
				'order'      => $display_order,
				'posts_per_page' => -1,
				'meta_query' => array(
					array(
						'key'     => 'announcement_date',
						'value'   => strtotime( current_time( 'm/d/Y' ) ),
						'type' => 'NUMERIC',
						'compare' => $compare_sign,
					),
				),
			);
			return apply_filters( 'timeline_express_frontend_query_args', $announcement_args );
		}

	} /* Last Function */
}
