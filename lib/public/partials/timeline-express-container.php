<?php
/**
 * Timeline Express Container Markup
 *
 * @author Code Parrots
 *
 * @link http://www.codeparrots.com
 *
 * @package Timeline Express
 *
 * @since 1.2
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {

	exit;

}

/* Store the global $post object */
global $post;

/* Retreive Timeline Express Options */
$timeline_express_options = timeline_express_get_options();
?>

<div class="<?php echo esc_attr( apply_filters( 'timeline-express-announcement-container-class', 'cd-timeline-block', $post->ID ) ); ?>">

	<?php
	/* Generate the Icon */
	echo wp_kses_post( timeline_express_get_announcement_icon_markup( $post->ID ) );
	?>

	<!-- Timeline Content -->
	<div class="cd-timeline-content">

		<?php
		/* Action hook to display content at the top of the announcement container */
		do_action( 'timeline-express-container-top' );
		?>

		<!-- Announcement Title -->
		<div class="cd-timeline-title-container">

			<?php
			/* Action hook to display content before the announcement title on the timeline */
			do_action( 'timeline-express-before-title' );
			?>

			<h2 class="cd-timeline-item-title">
				<?php the_title(); ?>
			</h2>

			<?php
			/* Action hook to display content after the announcement title on the timeline */
			do_action( 'timeline-express-after-title' );

			/* Generate the announcement date. */
			if ( 1 === (int) $timeline_express_options['date-visibility'] ) {
				?>
				<p class="timeline-date">
					<?php
					/* Action hook to display content before the announcement date on the timeline */
					do_action( 'timeline-express-before-date' );

					echo wp_kses_post( timeline_express_get_announcement_date( $post->ID ) );

					/* Action hook to display content after the announcement date on the timeline */
					do_action( 'timeline-express-after-date' );
					?>
				</p>
				<?php
			}
			?>
		</div>
		<!-- End Announcement Title -->

		<?php
		/* Action hook to display content before the announcement image on the timeline */
		do_action( 'timeline-express-before-image' );

		/* Generate the announcement image. */
		echo wp_kses_post( timeline_express_get_announcement_image( $post->ID ) );

		/* Action hook to display content after the announcement image on the timeline */
		do_action( 'timeline-express-after-image' );
		?>

		<!-- Announcement Excerpt -->
		<div class="the-excerpt">
			<?php
			/* Action hook to display content before the announcement excerpt on the timeline */
			do_action( 'timeline-express-before-excerpt' );

			/* Generate the announcement excerpt. */
			echo wp_kses_post( timeline_express_get_announcement_excerpt( $post->ID ) );

			/* Action hook to display content after the announcement excerpt on the timeline */
			do_action( 'timeline-express-after-excerpt' );
			?>
		</div>
		<!-- End Announcement Excerpt -->

		<?php
		/* Action hook to display content at the bottom of the announcement container */
		do_action( 'timeline-express-container-bottom' );
		?>

	</div>
	<!-- End Timeline Content -->

</div>
<!-- End Timeline Block -->
