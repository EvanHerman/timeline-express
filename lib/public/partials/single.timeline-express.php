<?php
/**
 * Timeline Express - Single Announcement Template
 * Note: This file can be customized by copying it to /wp-content/themes/theme_name/timeline-express/
 * @since 1.2.4
 */
get_header(); ?>

<section id="announcement-single-container" <?php timeline_express_container_classes( 'container single-timeline-express-announcement-container' ); ?>>
	<article id="post-<?php the_ID(); ?>" <?php post_class( 'single-post announcement announcement-' . the_ID() ); ?>>
		<?php
		if ( have_posts() ) {
			while ( have_posts() ) {
				the_post();
				/**
				 * Single Timeline Express Announcemnet Template
				 *
				 * @package Timeline Express
				 * @by CodeParrots
				 * @link http://www.codeparrots.com
				 */

				echo wp_kses_post( '<h1 class="entry-title">' . apply_filters( 'the_title', get_the_title() ) . '</h1>' );

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
				<strong class="timeline-express-single-page-announcement-date">
					<?php
						/* Action hook to display content before the single announcement date */
						do_action( 'timeline-express-single-before-date' );

						printf(
							esc_attr__( 'Announcement Date: %s', 'timeline-express' ),
							wp_kses_post( timeline_express_get_announcement_date( get_the_ID() ) )
						);

						/* Action hook to display content after the single announcement date */
						do_action( 'timeline-express-single-after-date' );
					?>
				</strong>

				<?php
				/* Action hook to display content before the single announcement content */
				do_action( 'timeline-express-single-before-content' );

				/* The announcement content */
				the_content();
			}
		}
		?>
	</article>

		<?php
		/* Timeline Express Announcement Sidebar */
		if ( is_active_sidebar( apply_filters( 'timeline-express-single-sidebar', 'timeline-express-announcement-sidebar' ) ) ) {
			?>
			<aside id="secondary" class="timeline-express-sidebar widget-area sidebar-widget-area" role="complementary">
			<?php
				dynamic_sidebar( apply_filters( 'timeline-express-single-sidebar', 'timeline-express-announcement-sidebar' ) );
			?>
			</aside>
			<?php
		}
		?>
</section>

<?php get_footer(); ?>
