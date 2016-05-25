<?php
/**
 * Welcome Page template
 * users are redirected here upon activation
 *
 * @package Timeline Express
 * @subpackage Timeline_Express_Addons
 * @since 1.2
 */

$selected = isset( $_GET['tab'] ) ? $_GET['tab'] : 'timeline-express-getting-started';
?>
<!-- Welcome Page Template Wrap -->
<div class="wrap about-wrap" style="min-height: 750px;">
	<h1><?php esc_attr_e( 'Welcome to Timeline Express', 'timeline-express' ); ?></h1>
	<div class="about-text">
		<?php esc_attr_e( "Thank you for choosing Timeline Express - the most beginner friendly, attractive and powerful WordPress Timeline plugin. Here's how to get started.", 'timeline-express' ); ?>
	</div>
	<div class="timeline-express-badge">
		<img src="<?php echo esc_attr__( TIMELINE_EXPRESS_URL . 'lib/admin/images/timeline-express-logo-128.png' ); ?>" title="Timeline Express" />
		<span class="version"><?php printf( esc_attr__( 'Version %s', 'timeline-express' ), esc_attr__( TIMELINE_EXPRESS_VERSION_CURRENT ) ); ?></span>
	</div>
	<h2 class="nav-tab-wrapper">
		<a class="nav-tab <?php echo 'timeline-express-getting-started' === $selected ? 'nav-tab-active' : ''; ?>" href="<?php echo esc_url( admin_url( add_query_arg( array( 'tab' => 'timeline-express-getting-started' ), 'admin.php?page=timeline-express-welcome' ) ) ); ?>">
			<?php esc_attr_e( 'Getting Started', 'timeline-express' ); ?>
		</a>
		<a class="nav-tab <?php echo 'timeline-express-addons' === $selected ? 'nav-tab-active' : ''; ?>" href="<?php echo esc_url( admin_url( add_query_arg( array( 'tab' => 'timeline-express-addons' ), 'admin.php?page=timeline-express-welcome' ) ) ); ?>">
			<?php esc_attr_e( 'Add-Ons', 'timeline-express' ); ?>
		</a>
		<a class="nav-tab <?php echo 'timeline-express-author' === $selected ? 'nav-tab-active' : ''; ?>" href="<?php echo esc_url( admin_url( add_query_arg( array( 'tab' => 'timeline-express-author' ), 'admin.php?page=timeline-express-welcome' ) ) ); ?>">
			<?php esc_attr_e( 'About Code Parrots', 'timeline-express' ); ?>
		</a>
	</h2>

	<p class="about-description">
		<?php
		if ( 'timeline-express-getting-started' === $selected ) {
			esc_attr_e( 'Use the tips below to get started using Timeline Express. You will be up and running in no time!', 'timeline-express' );
		} else if ( 'timeline-express-author' === $selected ) {
			esc_attr_e( "Code Parrots is a top tier WordPress plugin development shop, which builds powerful and highly customizable products for WordPress sites. We pride ourselves on our high quality of code and our unmatched level of support. As developers we've been building powerful WordPress products since 2012, and have provided some of the best solutions around.", 'timeline-express' );
		} else {
			esc_attr_e( "Extend the base Timeline Express functionality with our powerful add-ons. We're constantly looking to build out additional add-ons. If you have a great idea for a new add-on, get in contact with us!.", 'timeline-express' );
		}
		?>
	</p>

	<?php	if ( 'timeline-express-getting-started' === $selected ) { ?>

		<div class="feature-section two-col" style="padding-top:0;">
			<div class="col" style="width:100%;">
				<h3><?php esc_attr_e( 'Creating Your First Announcement', 'timeline-express' ); ?></h3>
				<p><?php printf( esc_attr__( 'Timeline Express makes it easy to create and display a beautiful animated timeline in WordPress. If you are new to Timeline Express you may want to read our knowledge base article, %s.', 'timeline-express' ), '<a href="https://www.wp-timelineexpress.com/documentation/creating-an-announcement/" target="_blank">How To Create Your First Announcement</a>' ); ?>
				<p><?php printf( esc_attr__( 'However, the process is so intuitive that you can jump right in by going to %s.', 'timeline-express' ), '<a href="' . esc_url( admin_url( 'post-new.php?post_type=te_announcements' ) ) . '">Timeline Express &#8594; New Announcement</a>' ); ?>
				<hr style="margin:2em 0;" />
				<h3><?php esc_attr_e( 'Tweak the Settings', 'timeline-express' ); ?></h3>
				<p><?php printf( esc_attr__( 'Head into the %s to tweak how the Timeline is going to appear on your site.', 'timeline-express' ), '<a href="' . esc_url( admin_url( 'edit.php?post_type=te_announcements&page=timeline-express-settings' ) ) . '">' . esc_attr__( 'Settings Page', 'timeline-express' ) . '</a>' ); ?>
			</div>
		</div>

		<hr />
		<div class="feature-section two-col">
			<div class="col">
				<h3><?php esc_attr_e( 'Feature Packed' ); ?></h3>
				<p><?php esc_attr_e( 'Timeline Express is both easy to use and extremely powerful. On top of the visible features, we have built in a ton of additional features under the hood - to allow beginners and seasoned developers to bring their timeline to new heights.', 'timeline-express' ); ?></p>
				<p><a href="https://www.wp-timelineexpress.com/features/" target="_blank" class="timeline-express-features-button button button-primary"><?php esc_attr_e( 'See all Features', 'timeline-express' ); ?></a></p>
			</div>
			<div class="col">
				<img src="<?php esc_attr_e( TIMELINE_EXPRESS_URL . 'lib/admin/images/flag-astronaut.png' ); ?>">
			</div>
		</div>

		<hr />
		<div class="feature-section two-col">
			<div class="col">
				<h3><?php esc_attr_e( 'Plugin Support & Documentation' ); ?></h3>
				<p><?php esc_attr_e( 'Got stuck on something? Run into an issue? Not to worry, our knowledgeable support staff is equipped to help resolve any issues you may encounter. Post an issue in the WordPress.org support forums, or take a peak at our support documentation.', 'timeline-express' ); ?></p>
				<p>
					<a href="https://wordpress.org/support/plugin/timeline-express" target="_blank" class="timeline-express-features-button button button-primary"><?php esc_attr_e( 'Support', 'timeline-express' ); ?></a>
					<a href="https://www.wp-timelineexpress.com" target="_blank" class="timeline-express-features-button button button-primary"><?php esc_attr_e( 'Documentation', 'timeline-express' ); ?></a>
				</p>
			</div>
			<div class="col">
				<img src="<?php esc_attr_e( TIMELINE_EXPRESS_URL . 'lib/admin/images/404-astronaut.png' ); ?>">
			</div>
		</div>

		<hr />
		<div class="feature-section two-col">
			<div class="col">
				<h3><?php esc_attr_e( 'Add-Ons' ); ?></h3>
				<p><?php esc_attr_e( "Timeline Express has the option to be extended with some of the dvanced add-ons that we've built out. The add-ons extend Timeline Express beyond what it can do out of the box, and allows for more advanced use cases - including date ranges between the year 1000-9999, ajax loading more announcements and more. If you're looking for additionality functionality, take a peak at our full list of add-ons.", 'timeline-express' ); ?></p>
				<p>
					<a href="https://www.wp-timelineexpress.com/add-ons/" target="_blank" class="timeline-express-features-button button button-primary"><?php esc_attr_e( 'View Add-Ons', 'timeline-express' ); ?></a>
				</p>
			</div>
			<div class="col">
				<img src="<?php esc_attr_e( TIMELINE_EXPRESS_URL . 'lib/admin/images/add-ons-astronaut.png' ); ?>">
			</div>
		</div>

		<hr />
		<div class="feature-section two-col">
			<div class="col">
				<h3><?php esc_attr_e( 'Powerful &amp; Flexible' ); ?></h3>
				<p><?php esc_attr_e( 'Out of the box, Timeline Express is both attractive and powerful. However, some projects may require an additional level of customization to fit the existing look and feel of the site. You can quickly and easily tweak the visual appearance of any element on the timeline using some CSS.', 'timeline-express' ); ?></p>
				<p><?php esc_attr_e( 'Users with even a little bit of knowledge customizing WordPress templates will feel right at home. In the latest release, users can now copy over any of the bundled templates and customize them as needed!.', 'timeline-express' ); ?></p>
				<p>
					<a href="https://www.wp-timelineexpress.com/?s=Customize&post_type=kbe_knowledgebase" target="_blank" class="timeline-express-features-button button button-primary"><?php esc_attr_e( 'View Customization Articles', 'timeline-express' ); ?></a>
				</p>
			</div>
			<div class="col">
				<img src="<?php esc_attr_e( TIMELINE_EXPRESS_URL . 'lib/admin/images/rating-astronaut.png' ); ?>">
			</div>
		</div>

	<?php } else if ( 'timeline-express-author' === $selected ) { ?>

		<div class="feature-section" style="padding-top:0;">
			<div class="col">

			</div>
		</div>

		<!-- link/logo -->
		<a href="http://www.codeparrots.com" target="_blank" style="position: absolute; right: 0; bottom: 0;">
			<img src="<?php esc_attr_e( TIMELINE_EXPRESS_URL . 'lib/admin/images/code-parrots-logo-dark.png' ); ?>" title="Code Parrots Logo" />
		</a>
	<?php } else { ?>
		<?php include_once( TIMELINE_EXPRESS_PATH . 'lib/classes/class.timeline-express-addons.php' ); ?>
	<?php } ?>
</div>
