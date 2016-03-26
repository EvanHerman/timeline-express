<?php
/**
 * Welcome Page template
 * users are redirected here upon activation
 *
 * @package Timeline Express
 * @subpackage Timeline_Express_Addons
 * @since 1.2
 */

$selected = isset( $_GET['page'] ) ? $_GET['page'] : 'timeline-express-getting-started';
?>
<!-- Welcome Page Template Wrap -->
<div class="wrap about-wrap">
	<h1><?php esc_attr_e( 'Welcome to Timeline Express', 'timeline-express' ); ?></h1>
	<div class="about-text">
		<?php esc_attr_e( "Thank you for choosing Timeline Express - the most beginner friendly, attractive and powerful WordPress Timeline plugin. Here's how to get started.", 'timeline-express' ); ?>
	</div>
	<div class="timeline-express-badge">
		<img src="<?php echo esc_attr__( TIMELINE_EXPRESS_URL . 'lib/admin/images/timeline-express-logo-128.png' ); ?>" title="Timeline Express" />
		<span class="version"><?php printf( esc_attr__( 'Version %s', 'timeline-express' ), esc_attr__( TIMELINE_EXPRESS_VERSION_CURRENT ) ); ?></span>
	</div>
	<h2 class="nav-tab-wrapper">
		<a class="nav-tab <?php echo 'timeline-express-getting-started' === $selected ? 'nav-tab-active' : ''; ?>" href="<?php echo esc_url( admin_url( add_query_arg( array( 'page' => 'timeline-express-getting-started' ), 'index.php' ) ) ); ?>">
			<?php esc_attr_e( 'Getting Started', 'timeline-express' ); ?>
		</a>
	</h2>

	<p class="about-description">
		<?php esc_attr_e( 'Use the tips below to get started using timeline-express. You will be up and running in no time.', 'timeline-express' ); ?>
	</p>

	<div class="feature-section two-col">
		<div class="col">
			<h3><?php esc_attr_e( 'Creating Your First Announcement', 'timeline-express' ); ?></h3>
			<p><?php printf( __( 'Timeline Express makes it easy to create and display a beautiful and animated timeline in WordPress. Feel free to read our how to <a href="%s" target="_blank">create your first announcement</a>.', 'timeline-express' ), 'http://www.wp-timelineexpress.com/documentation/creating-an-announcement/' ); ?>
			<p><?php printf( __( 'The process is so intuitive that you can jump right in by going to <a href="%s">Timeline Express > New Announcement</a>.', 'timeline-express' ), esc_url( admin_url( 'admin.php?page=timeline-express-builder' ) ) ); ?>
		</div>
		<div class="col">
			<div class="feature-video">
				<img src="<?php esc_attr_e( TIMELINE_EXPRESS_URL . 'lib/admin/images/timeline-express-logo-128.png' ); ?>">
			</div>
		</div>
	</div>

	<div class="feature-section two-col">
		<div class="col">
			<h3><?php esc_attr_e( 'See all Timeline Express Has to Offer' ); ?></h3>
			<p><?php esc_attr_e( 'Timeline Express is both easy to use and extremely powerful. On top of the visible features, we have built in a ton of additional features under the hood.', 'timeline-express' ); ?></p>
			<p><a href="http://wp-timelineexpress.com" target="_blank" class="timeline-express-features-button button button-primary"><?php esc_attr_e( 'See all Features', 'timeline-express' ); ?></a></p>
		</div>
		<div class="col">
			<img src="<?php esc_attr_e( TIMELINE_EXPRESS_URL . 'lib/admin/images/timeline-express-logo-128.png' ); ?>">
		</div>
	</div>

</div>
