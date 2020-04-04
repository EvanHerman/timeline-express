<?php
/**
 * The template for displaying all single announcements via Timeline Express
 *
 * To customize this template, copy it into a directory 'timeline-express' in your theme root
 * For full instructions, see https://www.wp-timelineexpress.com
 *
 * @author Code Parrots
 *
 * @link http://www.codeparrots.com
 *
 * @package Timeline Express
 *
 * @since 1.2.5
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {

	exit;

}

get_header();

/**
 * @action timeline_express_before_main_content
 *
 * @hooked timeline_express_generate_content_wrapper_start - 10 (outputs opening divs for the content)
 *
 * @since 1.2.8.5
 */
do_action( 'timeline_express_before_main_content' );
?>

<article itemscope itemtype="" id="announcement-<?php the_ID(); ?>" <?php post_class(); ?>>

	<?php

	do_action( 'timeline_express_before_announcement_content' );

	// Start the loop.
	while ( have_posts() ) : the_post();

		?>
		<header class="entry-header">
			<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
		</header><!-- .entry-header -->

		<?php
			// Include the single post content template.
			get_timeline_express_template( 'single-announcement' );

			// End of the loop.
			endwhile;

			do_action( 'timeline_express_after_announcement_content' );
	?>

</article><!-- .content-area -->

<?php
/**
 * @action timeline_express_after_main_content
 *
 * @hooked timeline_express_generate_page_wrapper_end - 10 (outputs closing divs for the content)
 *
 * @since 1.2.8.5
 */
do_action( 'timeline_express_after_main_content' );

/**
 * @action  timeline_express_sidebar
 *
 * @hooked timeline_express_generate_sidebar - 10
 *
 * @since 1.2.8.5
 */
do_action( 'timeline_express_sidebar' );

get_footer();
?>
