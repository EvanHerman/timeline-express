<?php
/**
 * Single Timeline Express Announcemnet Template
 *
 * @package Timeline Express
 * @by CodeParrots
 * @link http://www.codeparrots.com
 */

/**
 * Render the announcement image.
 *
 * @param int    $post_id    The announcement (post) ID whos image you want to retreive.
 * @param string $image_size Name of the image size you want to retreive. Possible: timeline-express, full, large, medium, thumbnail.
 */
esc_attr_e( timeline_express_get_announcement_image( get_the_ID(), 'full' ) );
?>

<!-- Render the announcement date -->
<strong class="timeline-express-single-page-announcement-date">
	<?php
		esc_attr_e( __( 'Announcement Date:' , 'timeline-express' ) . ' ' );
		esc_attr_e( timeline_express_get_announcement_date( get_the_ID() ) );
	?>
</strong>

<!-- Render the announcement content (Note: Currently does not properly pass through the_content() filter.) -->
<div class="timeline-express-single-page-content">
	<?php	esc_attr_e( get_the_content( get_the_ID() ) ); ?>
</div>
