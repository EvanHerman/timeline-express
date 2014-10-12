<?php
/**
 * The template for displaying single announcements 
 * from Timeline Express
 *
 * This page template requires Timeline Express to be installed
 */

get_header(); 

global $timelineExpressBase;

$timelineExpressBase->addStyles_frontend();

?>

	<div id="primary" class="site-content">
		<div id="content" role="main">

			<?php while ( have_posts() ) : the_post(); ?>
				
				<?php get_template_part( 'content', 'page' ); ?>
			
			<?php endwhile; // end of the loop. ?>

		</div><!-- #content -->
	</div><!-- #primary -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>