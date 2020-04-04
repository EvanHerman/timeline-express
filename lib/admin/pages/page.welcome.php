<?php
/**
 * Welcome Page template
 * users are redirected here upon activation
 *
 * @package    Timeline Express
 *
 * @since      1.2
 */


// If accessed directly, exit;
if ( ! defined( 'ABSPATH' ) ) :

	exit;

endif;

$selected = isset( $_GET['tab'] ) ? $_GET['tab'] : 'timeline-express-getting-started';
?>

<!-- Welcome Page Template Wrap -->
<div class="wrap timeline-express-about-wrap about-wrap">

	<div id="timeline-express-header">

		<div class="timeline-express-badge">
			<img src="<?php echo esc_url( TIMELINE_EXPRESS_URL . 'lib/admin/images/timeline-express-logo-128.png' ); ?>" title="Timeline Express" />
		</div>

		<h1>
			<?php
				/* translators: Integer value, representing the plugin version number. */
				printf( esc_html( 'Welcome to Timeline Express v%s', 'timeline-express' ), esc_html( TIMELINE_EXPRESS_VERSION_CURRENT ) );
			?>
		</h1>

		<div class="about-text">
			<?php esc_html_e( "Thank you for choosing Timeline Express - the most beginner friendly, attractive and powerful WordPress Timeline plugin. Here's how to get started.", 'timeline-express' ); ?>
		</div>

	</div>

	<!-- Tabs -->
	<h2 class="nav-tab-wrapper">
		<a class="nav-tab <?php echo 'timeline-express-getting-started' === $selected ? 'nav-tab-active' : ''; ?>" href="<?php echo esc_url(
			admin_url(
				add_query_arg(
					array(
						'tab' => 'timeline-express-getting-started',
					),
					'admin.php?page=timeline-express-welcome'
				)
			)
		); ?>">
			<?php esc_html_e( 'Getting Started', 'timeline-express' ); ?>
		</a>
		<a class="nav-tab <?php echo 'timeline-express-author' === $selected ? 'nav-tab-active' : ''; ?>" href="<?php echo esc_url(
			admin_url(
				add_query_arg(
					array(
						'tab' => 'timeline-express-author',
					),
					'admin.php?page=timeline-express-welcome'
				)
			)
		); ?>">
			<?php esc_html_e( 'About Code Parrots', 'timeline-express' ); ?>
		</a>
	</h2>
	<!-- End Tabs -->

	<p class="about-description">
		<?php
		if ( 'timeline-express-getting-started' === $selected ) {

			esc_html_e( 'Use the tips below to get started using Timeline Express. You will be up and running in no time!', 'timeline-express' );

		}
		?>
	</p>

	<?php	if ( 'timeline-express-getting-started' === $selected ) { ?>

		<div class="changelog">

			<h3><?php esc_html_e( 'Creating Your First Announcement', 'timeline-express' ); ?></h3>

			<div class="feature-section">

				<div class="feature-section-media">
					<img src="<?php echo esc_url( TIMELINE_EXPRESS_URL . 'lib/admin/images/create-new-announcement.png' ); ?>" title="Timeline Express" />
				</div>

				<div class="feature-section-content">

					<p>
						<?php
							/* translators: Anchor tag linking back to the Timeline Express documentation. */
							printf( esc_html( 'Timeline Express makes it easy to create and display a beautiful and animated timeline in WordPress. Feel free to read our support article, %s.', 'timeline-express' ), '<a href="https://www.wp-timelineexpress.com/documentation/creating-an-announcement/" target="_blank">How To Create Your First Announcement</a>' );
						?>
					</p>

					<p>
						<?php
							/* translators: Anchor tag linking to create a new announcement. */
							printf( esc_html( 'The process is so intuitive that you can jump right in by going to %s.', 'timeline-express' ), '<a href="' . esc_url( admin_url( 'post-new.php?post_type=te_announcements' ) ) . '">' . esc_html__( 'Timeline Express &#8594; New Announcement', 'timeine-express-pro' ) . '</a>' );
						?>
					</p>

					<h4><?php esc_html_e( 'Announcement Images', 'timeline-express' ); ?></h4>

					<p><?php esc_html_e( 'Adding images to your announcements is as easy as adding images to standard posts in WordPress. When you add images to your announcements, they will appear both on the timeline and on the single announcement templates.', 'timeline-express' ); ?></p>

				</div>

			</div>

		</div>

		<div class="changelog">

			<h3><?php esc_html_e( 'Setup Timeline Express', 'easy-digital-downloads' ); ?></h3>

			<div class="feature-section">

				<div class="feature-section-media">
					<img src="<?php echo esc_url( TIMELINE_EXPRESS_URL . 'lib/admin/images/timeline-express-settings.png' ); ?>" title="<?php esc_attr_e( 'Timeline Express Settings Page', 'timeline-express' ); ?>" />
				</div>

				<div class="feature-section-content">

					<p>
						<?php
							/* translators: Anchor tag linking back to the Timeline Express settings page. */
							printf( esc_html( 'Head into the %s to tweak how the Timeline is going to function and display on your site. You can tweak the visual appearance of the timeline, and the order and time period from which announcements should disdplay.', 'timeline-express' ), '<a href="' . esc_url( admin_url( 'edit.php?post_type=te_announcements&page=timeline-express-settings' ) ) . '">' . esc_attr__( 'Settings Page', 'timeline-express' ) . '</a>' );
						?>
					</p>

						<p>
						<?php
							/* translators: HTML markup (strong tags) surrounding the words "Pro Tip" */
							printf( esc_html( "%s: If you ever notice something doesn't look correct or function properly on the timeline, double check that your settings are correct.", 'timeline-express' ), '<strong>' . esc_html__( 'Pro Tip', 'timeline-express' ) . '</strong>' );
						?>
					</p>

				</div>

			</div>

		</div>

		<div class="changelog">

			<h3><?php esc_html_e( 'Powerful &amp; Flexible', 'timeline-express' ); ?></h3>

			<div class="feature-section">

				<div class="feature-section-media">
					<img src="<?php echo esc_url( TIMELINE_EXPRESS_URL . 'lib/admin/images/rating-astronaut.png' ); ?>">
				</div>

				<div class="feature-section-content">

					<p><?php esc_html_e( 'Out of the box, Timeline Express is both attractive and powerful. However, some projects require an additional level of customization to fit the existing look and feel of the site.', 'timeline-express' ); ?></p>

					<p><?php esc_html_e( 'Users with even a little bit of knowledge customizing WordPress templates will feel right at home. In the latest release, users can now copy over any of the bundled templates and customize them as needed!.', 'timeline-express' ); ?></p>

					<p>
						<a href="https://www.wp-timelineexpress.com/?s=Customize&post_type=kbe_knowledgebase" target="_blank" class="timeline-express-features-button button button-primary">
							<?php esc_html_e( 'View Customization Articles', 'timeline-express' ); ?>
						</a>
					</p>

				</div>

			</div>

		</div>

		<div class="changelog">

			<h3><?php esc_html_e( 'Feature Packed', 'timeline-express' ); ?></h3>

			<div class="feature-section">

				<div class="feature-section-media">
					<img src="<?php echo esc_url( TIMELINE_EXPRESS_URL . 'lib/admin/images/flag-astronaut.png' ); ?>">
				</div>

				<div class="feature-section-content">

					<p><?php esc_html_e( 'Timeline Express is the number one rated Timline plugin for WordPress, and for good reason!', 'timeline-express' ); ?></p>

					<p><?php esc_html_e( 'It is both easy to use and extremely powerful. On top of the visible features, we have a ton of additional features built in under the hood - to allow beginners and seasoned developers to bring their timeline to new heights.', 'timeline-express' ); ?></p>

					<p><?php esc_html_e( 'If you need something custom, take a look at the developer documentation. If you need help beyond that, you can always reach out to our support staff!', 'timeline-express' ); ?></p>

					<p>
						<a href="https://www.wp-timelineexpress.com/features/" target="_blank" class="timeline-express-features-button button button-primary">
							<?php esc_html_e( 'See all Features', 'timeline-express' ); ?>
						</a>
					</p>

				</div>

			</div>

		</div>

		<div class="changelog">

			<h3><?php esc_html_e( 'Plugin Support & Documentation', 'timeline-express' ); ?></h3>

			<div class="feature-section">

				<div class="feature-section-media">
					<img src="<?php echo esc_url( TIMELINE_EXPRESS_URL . 'lib/admin/images/404-astronaut.png' ); ?>">
				</div>

				<div class="feature-section-content">

					<h3><?php esc_html_e( 'Plugin Support & Documentation' ); ?></h3>

					<p><?php esc_html_e( 'Got stuck on something? Run into an issue? Not to worry, our knowledgeable support staff is equipped to help resolve any issues you may encounter.', 'timeline-express' ); ?></p>

					<p>
						<a href="<?php echo esc_url( admin_url() . '/edit.php?post_type=te_announcements&page=timeline-express-license' ); ?>" class="timeline-express-features-button button button-primary">
							<?php esc_html_e( 'Support', 'timeline-express' ); ?>
						</a>
						<a href="https://www.wp-timelineexpress.com/documentation/" target="_blank" class="timeline-express-features-button button button-primary">
							<?php esc_html_e( 'Documentation', 'timeline-express' ); ?>
						</a>
					</p>

				</div>

			</div>

		</div>

		<div class="changelog">

			<h3><?php esc_html_e( 'Add-Ons', 'timeline-express' ); ?></h3>

			<div class="feature-section">

				<div class="feature-section-media">
					<img src="<?php echo esc_url( TIMELINE_EXPRESS_URL . 'lib/admin/images/add-ons-astronaut.png' ); ?>">
				</div>

				<div class="feature-section-content">

					<p><?php esc_html_e( "We have built out both free and premium add-ons for Timeline Express. Our add-ons extend Timeline Express beyond what it can do out of the box, and enable advanced features such as - enabling HTML in announcement excerpts, allowing for date ranges between the year 1000-9999 to be used, loading more announcements on your timeline via ajax and more. If you're looking for additionality functionality, take a peak at our full list of add-ons.", 'timeline-express' ); ?></p>

					<p>
						<a href="https://www.wp-timelineexpress.com/?s=Customize&post_type=kbe_knowledgebase" target="_blank" class="timeline-express-features-button button button-primary">
							<?php esc_html_e( 'View Customization Articles', 'timeline-express' ); ?>
						</a>
					</p>

				</div>

			</div>

		</div>

	<?php } else { ?>

		<div class="changelog">

			<h3><?php esc_html_e( 'About Code Parrots', 'timeline-express' ); ?></h3>

			<div class="feature-section">

				<div class="feature-section-media">
					<!-- link/logo -->
					<a href="http://www.codeparrots.com" target="_blank">
						<img src="<?php echo esc_url( TIMELINE_EXPRESS_URL . 'lib/admin/images/code-parrots-logo-dark.png' ); ?>" title="Code Parrots Logo" />
					</a>
				</div>

				<div class="feature-section-content">

					<p><?php esc_html_e( "Coming together in 2015, Code Parrots is a fanatical WordPress plugin development shop. We pride ourselves on our high quality of code and our unmatched level of support. As developers we've been building powerful WordPress products since 2012, and have provided some of the best solutions around.", 'timeline-express' ); ?></p>

					<p><?php esc_html_e( "When you purchase a product from Code Parrots, you know you're getting a great product built on solid code with a knowledgable team that stands behind it's products.", 'timeline-express' ); ?></p>

				</div>

			</div>

		</div>

	<?php }// End if().
	?>
</div>
