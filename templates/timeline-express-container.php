<?php
/**
 * Timeline Express Container Markup
 *
 * @package Timeline Express
 * @since 1.2
 */

/* Store the global $post object */
global $post;

/* Retreive Timeline Express Options */
$timeline_express_options = timeline_express_get_options();
/* Setup the custom icon, if being used */
$custom_icon_html = apply_filters( 'timeline_express_custom_icon_html', apply_filters( 'timeline-express-custom-icon-html', '', $post, $timeline_express_options ), $post->ID, $timeline_express_options );
?>

<div class="cd-timeline-block">

	<?php
	/* Generate the Custom Icon. */
	if ( ! empty( $custom_icon_html ) ) {
		esc_html_e( $custom_icon_html );
	} else {
		/* If read more visibility is set to true, wrap the icon in a link. */
		if ( 0 !== $timeline_express_options['read-more-visibility'] ) {
			?>
			<a class="cd-timeline-icon-link" href="<?php esc_attr_e( get_the_permalink( $post->ID ) ); ?>">
				<div class="cd-timeline-img cd-picture" style="background:'<?php esc_attr_e( timeline_express_get_announcement_icon_color( $post->ID ) ); ?>;">
				<span class="fa <?php esc_attr_e( timeline_express_get_announcement_icon( $post->ID ) ); ?>" title="<?php esc_attr_e( get_the_title( $post->ID ) ); ?>"></span>
				</div> <!-- cd-timeline-img -->
			</a>
			<?php
		} else {
			/* Else, no link around the icon. */
			?>
			<div class="cd-timeline-img cd-picture" style="background:<?php esc_attr_e( timeline_express_get_announcement_icon_color( $post->ID ) ); ?>;">';
				<span class="fa <?php esc_attr_e( timeline_express_get_announcement_icon( $post->ID ) ); ?>" title="<?php esc_attr_e( get_the_title( $post->ID ) ); ?>"></span>';
			</div>
			<?php
		}
	}
	?>

	<!-- Timeline Content -->
	<div class="cd-timeline-content">

		<?php
		/* Action hook to display content at the top of the announcement container */
		do_action( 'timeline-express-container-top' );
		?>

		<!-- Announcement Title -->
		<span class="cd-timeline-title-container">

			<?php
			/* Action hook to display content before the announcement title on the timeline */
			do_action( 'timeline-express-before-title' );
			?>

			<h2 class="cd-timeline-item-title">
				<?php the_title();?>
			</h2>

			<?php
			/* Action hook to display content after the announcement title on the timeline */
			do_action( 'timeline-express-after-title' );

			/* Generate the announcement date. */
			if ( 1 === (int) $timeline_express_options['date-visibility'] ) {
				?>
				<span class="timeline-date">
					<?php
					/* Action hook to display content before the announcement date on the timeline */
					do_action( 'timeline-express-before-date' );

					esc_attr_e( timeline_express_get_announcement_date( $post->ID ) );

					/* Action hook to display content after the announcement date on the timeline */
					do_action( 'timeline-express-after-date' );
					?>
				</span>
				<?php
			}
			?>
		</span>
		<!-- End Announcement Title -->

		<?php
		/* Action hook to display content before the announcement image on the timeline */
		do_action( 'timeline-express-before-image' );

		/* Generate the announcement image. */
		esc_attr_e( timeline_express_get_announcement_image( $post->ID ) );

		/* Action hook to display content after the announcement image on the timeline */
		do_action( 'timeline-express-after-image' );
		?>

		<!-- Announcement Excerpt -->
		<span class="the-excerpt">
			<?php
			/* Action hook to display content before the announcement excerpt on the timeline */
			do_action( 'timeline-express-before-excerpt' );

			/* Generate the announcement excerpt. */
			esc_attr_e( timeline_express_get_announcement_excerpt( $post->ID ) );

			/* Action hook to display content after the announcement excerpt on the timeline */
			do_action( 'timeline-express-after-excerpt' );
			?>
		</span>
		<!-- End Announcement Excerpt -->

		<?php
		/* Action hook to display content at the bottom of the announcement container */
		do_action( 'timeline-express-container-bottom' );
		?>

	</div>
	<!-- End Timeline Content -->
</div>
<!-- End Timeline Block -->
