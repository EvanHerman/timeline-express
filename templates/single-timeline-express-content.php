<?php
/**
 * Content markup for single announcement templates
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

/* Action hook to display content before the single announcement image */
do_action( 'timeline-express-single-before-image' );

/**
 * Render the announcement image.
 *
 * @param int    $post_id    The announcement (post) ID whos image you want to retreive.
 * @param string $image_size Name of the image size you want to retreive. Possible: timeline-express, full, large, medium, thumbnail.
 */
echo wp_kses_post( timeline_express_get_announcement_image( get_the_ID(), 'full' ) );

/* Action hook to display content after the single announcement image */
do_action( 'timeline-express-single-after-image' );
?>

<!-- Render the announcement date -->
<p class="timeline-express-single-page-announcement-date">

	<?php
		/* Action hook to display content before the single announcement date */
		do_action( 'timeline-express-single-before-date' );

		printf(
			/* translators: The announcement date */
			apply_filters( 'timeline_express_announcement_date_text', __( 'Announcement Date: %s', 'timeline-express' ) ),
			wp_kses_post( timeline_express_get_announcement_date( get_the_ID() ) )
		);

		/* Action hook to display content after the single announcement date */
		do_action( 'timeline-express-single-after-date' );
		?>

</p>

<?php
	/* Action hook to display content before the single announcement content */
	do_action( 'timeline-express-single-before-content' );

	the_content();

	/* Action hook to display content before the single announcement content */
	do_action( 'timeline-express-single-after-content' );
?>
