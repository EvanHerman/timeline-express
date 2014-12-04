<?php
/**
 * The template for displaying single announcements 
 * from Timeline Express
 *
 * This page template requires Timeline Express to be installed
 */

	// enqueue styles to make the single page look a bit better
	wp_enqueue_style( 'timeline-express-single-page', TIMELINE_EXPRESS_URL . 'css/timeline-express-single-page.css' , array() , '' , 'all' );
 
	// check for a single.php template file first...
	// timeline_express_custom_template filter
	// to allow users to specify their own template files ( if they want to use different ones )
	if ( locate_template( apply_filters( 'timeline_express_custom_template' , 'single.php' ) ) ) {
		include( TEMPLATEPATH . '/' . apply_filters( 'timeline_express_custom_template' , 'single.php' ) );
	} else {

			// build our own template :(
			get_header(); 

			global $timelineExpressBase;

			$timelineExpressBase->addStyles_frontend();

			?>

				<div id="primary" class="site-content">
					<div id="content" role="main">

						<?php while ( have_posts() ) : the_post(); ?>
							
							<?php 				
								// check if the theme has a content-page.php template file
								if ( locate_template( 'content-page.php' ) ) {
									get_template_part( 'content', 'page' ); 
								} else {
									the_content();
								}
							?>
						
						<?php endwhile; // end of the loop. ?>

					</div><!-- #content -->
				</div><!-- #primary -->

			<?php get_sidebar(); ?>

			<?php get_footer(); 
					
	}
?>