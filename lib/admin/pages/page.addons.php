<?php
/**
 * Addon Template - Admin Page
 *
 * @package Timeline Express
 *
 * @since   1.2
 */

if ( ! defined( 'ABSPATH' ) ) {

	exit;

}

if ( ! isset( $_GET['page'] ) || 'timeline-express-addons' !== $_GET['page'] ) {

	return;

}

$suffix = SCRIPT_DEBUG ? '' : '.min';

wp_enqueue_script( 'timeline-express-add-ons-js', TIMELINE_EXPRESS_URL . "lib/admin/js/min/timeline-express-add-ons{$suffix}.js", array( 'jquery' ), TIMELINE_EXPRESS_VERSION_CURRENT, true );

/**
 * Build arrays of add-ons
 */
$free_addons = array(
	array(
		'name'    => esc_html__( 'Timeline Express - HTML Excerpts', 'timeline-express' ),
		'popular' => true,
	),
	array(
		'name'    => esc_html__( 'Timeline Express - Single Column', 'timeline-express' ),
	),
	array(
		'name'    => esc_html__( 'Timeline Express - No Icons', 'timeline-express' ),
	),
);

$premium_addons = array(
	array(
		'name'          => esc_html__( 'Timeline Express - White Label Branding', 'timeline-express' ),
		'class'         => 'Timeline_Express_White_label',
		'description'   => esc_html__( 'Remove any and all references to our branding, Code Parrots. This add-on removes links, metaboxes, menu items and any association to Code Parrots so your clients won’t get confused with the mixed branding across the dashboard.', 'timeline-express' ),
		'thumbnail_url' => 'https://www.wp-timelineexpress.com/wp-content/uploads/2016/06/timeline-express-white-label-banner-150x150.jpg',
		'purchase_url'  => 'https://www.wp-timelineexpress.com/products/timeline-express-white-label-addon/',
	),
	array(
		'name'          => esc_html__( 'Timeline Express - Post Types', 'timeline-express' ),
		'class'         => 'Timeline_Express_Post_Type',
		'description'   => esc_html__( 'Generate timelines using posts, pages or any other custom post type on your site with this add-on. Powerful, flexible and simple to use – now users can generate custom timelines in a beautiful timeline without altering any code.', 'timeline-express' ),
		'thumbnail_url' => 'https://www.wp-timelineexpress.com/wp-content/uploads/2016/05/timeline-express-post-types-banner-150x150.jpg',
		'purchase_url'  => 'https://www.wp-timelineexpress.com/products/timeline-express-post-types-add-on/',
		'popular'       => true,
	),
	array(
		'name'          => esc_html__( 'Timeline Express - Historical Dates', 'timeline-express' ),
		'class'         => 'Timeline_Express_Historical_Dates_Addon',
		'description'   => esc_html__( 'Due to a limitation with PHP, storing dates prior to 1970 has been a one of the limitations of Timeline Express. Quickly enable the ability to assign dates between the years 1000 to 9999 to all announcements.', 'timeline-express' ),
		'thumbnail_url' => 'https://www.wp-timelineexpress.com/wp-content/uploads/2016/05/timeline-express-historical-dates-banner-150x150.jpg',
		'purchase_url'  => 'https://www.wp-timelineexpress.com/products/timeline-express-historical-dates-add-on/',
		'popular'       => true,
	),
	array(
		'name'          => esc_html__( 'Timeline Express - AJAX Limits', 'timeline-express' ),
		'class'         => 'Timeline_Express_AJAX_Limits',
		'description'   => esc_html__( 'Limit your Timeline to a set number of announcements, and display a ‘Load More’ button beneath, allowing users to load more announcements onto the timeline. This prevents your pages from becoming unruly in length if you display many announcements.', 'timeline-express' ),
		'thumbnail_url' => 'https://www.wp-timelineexpress.com/wp-content/uploads/2016/05/ajax-limits-add-on-banner-1-150x150.jpg',
		'purchase_url'  => 'https://www.wp-timelineexpress.com/products/timeline-express-ajax-limits-add-on/',
		'popular'       => true,
	),
	array(
		'name'          => esc_html__( 'Timeline Express - Twitter Feed', 'timeline-express' ),
		'class'         => 'Timeline_Express_Twitter_Feed',
		'description'   => esc_html__( 'Display twitter feeds in a Timeline for users, search terms and by gelocation using our Twitter Feed Add-On. Twitter feeds can be set to live update, so every 30 seconds the feed is updated with new, fresh, tweets.', 'timeline-express' ),
		'thumbnail_url' => 'https://www.wp-timelineexpress.com/wp-content/uploads/2016/10/timeline-express-twitter-feeds-addon-banner-150x150.jpg',
		'purchase_url'  => 'https://www.wp-timelineexpress.com/products/timeline-express-twitter-feeds-add/',
	),
	array(
		'name'          => esc_html__( 'Timeline Express - Toolbox', 'timeline-express' ),
		'class'         => 'Timeline_Express_Toolbox',
		'description'   => esc_html__( 'Customize many aspects of Timeline Express (image size, date format, announcement slug etc.) without ever writing any code, using an admin UI.', 'timeline-express' ),
		'thumbnail_url' => 'https://www.wp-timelineexpress.com/wp-content/uploads/edd/2017/01/timeline-express-toolbox-add-on-banner-150x150.jpg',
		'purchase_url'  => 'https://www.wp-timelineexpress.com/products/timeline-express-toolbox-add/',
		'popular'       => true,
	),
	array(
		'name'          => esc_html__( 'Timeline Express - Popups', 'timeline-express' ),
		'class'         => 'Timeline_Express_Popups',
		'description'   => esc_html__( 'Display announcement content in an elegant popup, on the same page as your timeline, when a user clicks the "Read More" link.', 'timeline-express' ),
		'thumbnail_url' => 'https://www.wp-timelineexpress.com/wp-content/uploads/edd/2017/03/timeline-express-popups-banner-150x150.jpg',
		'purchase_url'  => 'https://www.wp-timelineexpress.com/products/timeline-express-popups-add-on/',
	),
);

shuffle( $premium_addons );

array_unshift( $premium_addons, array(
	'name'          => esc_html__( 'Timeline Express Product Bundle', 'timeline-express' ),
	/* translators: Integer value for the number of add-ons in the add-on list. (eg: 6) */
	'description'   => sprintf( esc_html( "Get any and all %s of the Timeline Express add-ons, for one low price! Select a 5 or 10 site license, and receive all current and future add-ons for Timeline Express along with updates and priority product support. An amazing deal, don't miss it!", 'timeline-express' ), count( $addon_array ) ),
	'purchase_url'  => 'https://www.wp-timelineexpress.com/products/timeline-express-bundle/',
	'popular'       => true,
) );

?>

<div id="timeline-express-addons" class="wrap">

	<h1 class="page-title">
		<?php esc_html_e( 'Timeline Express Add-Ons', 'timeline-express' ); ?>
		<a href="https://www.wp-timelineexpress.com/add-ons/" target="_blank" class="view-all-addons button-primary">View All Add-Ons</a>
	</h1>

	<p class="intro">
		<?php esc_html_e( "Extend the base Timeline Express functionality with our powerful add-ons. We're constantly looking to build out additional add-ons. If you have a great idea for a new add-on, get in contact with us!", 'timeline-express' ); ?>
	</p>

	<hr />

	<h2 class="widefat"><?php esc_html_e( 'Free Add-Ons', 'timeline-express' ); ?></h2>

	<div id="the-list">

	<?php

	// Free Add-Ons
	require_once( ABSPATH . 'wp-admin/includes/plugin-install.php' );

	foreach ( $free_addons as $addon_data ) {

		$addon_data = timeline_express_build_addon_data( $addon_data, true );

		if ( ! $addon_data ) {

			continue;

		}

		timeline_express_render_addon( $addon_data, true );

	} // End foreach().

	?>

	</div>

	<hr />

	<h2 class="widefat"><?php esc_html_e( 'Premium Add-Ons', 'timeline-express' ); ?></h2>

	<div id="the-list">

	<?php

	// Premium Add-Ons
	foreach ( $premium_addons as $addon_data ) {

		$addon_data = timeline_express_build_addon_data( $addon_data );

		if ( ! $addon_data ) {

			continue;

		}

		timeline_express_render_addon( $addon_data );

	} // End foreach().

	?>

	</div>

	<div style="clear:both"></div>

</div>

<?php
/**
 * Build the data array to use when displaying add-ons
 *
 * @since  1.2.8
 *
 * @return array
 */
function timeline_express_build_addon_data( $data, $free = false ) {

	if ( $free ) {

		$slug = sanitize_title( $data['name'] . ' Add-On' );

		$api = (array) plugins_api( 'plugin_information',
			array(
				'slug'   => sanitize_file_name( $slug ),
				'fields' => array(
					'short_description' => true,
					'sections'          => false,
					'requires'          => false,
					'downloaded'        => true,
					'last_updated'      => false,
					'added'             => false,
					'tags'              => false,
					'compatibility'     => false,
					'homepage'          => false,
					'donate_link'       => false,
					'icons'             => true,
					'banners'           => true,
				),
			)
		);

		if ( is_wp_error( $api ) ) {

			return false;

		}

		$plugin_file = timeline_express_get_plugin_file( $slug );

		$data['button_class'] = is_plugin_active( $plugin_file ) ? 'button disabled' : 'installed button';
		$data['button_text']  = is_plugin_active( $plugin_file ) ? __( 'Activated', 'timeline-express' ) : __( 'Installed', 'timeline-express' );

		$data['description'] = $api['short_description'];

		// Setup thumbnail URL with fallback
		$data['thumbnail_url'] = isset( $api['icons']['1x'] ) ? $api['icons']['1x'] : 'https://www.wp-timelineexpress.com/wp-content/uploads/2016/11/timeline-express-150x150.png';

		return $data;

	} // End if().

	$installed = ( isset( $data['class'] ) && class_exists( $data['class'] ) );

	// Button Text
	$data['button_class'] = 'install button';
	$data['button_text']  = esc_html__( 'View Add-On', 'timeline-express' );

	// Setup thumbnail URL with fallback
	$data['thumbnail_url'] = ( isset( $data['thumbnail_url'] ) ) ? $data['thumbnail_url'] : 'https://www.wp-timelineexpress.com/wp-content/uploads/2016/11/timeline-express-150x150.png';

	// Use this to dictate target="_blank" or not
	$data['external_url'] = ( strpos( $data['purchase_url'], admin_url() ) !== false ) ? false : true;

	return $data;

}

/*
* get_plugin_file
* A method to get the main plugin file.
*
*
* @param  $plugin_slug    String - The slug of the plugin
* @return $plugin_file
*
* @since 1.0
*/
function timeline_express_get_plugin_file( $plugin_slug ) {

	require_once( ABSPATH . '/wp-admin/includes/plugin.php' ); // Load plugin lib

	$plugins = get_plugins();

	foreach ( $plugins as $plugin_file => $plugin_info ) {

		// Get the basename of the plugin e.g. [askismet]/askismet.php
		$slug = dirname( plugin_basename( $plugin_file ) );

		if ( ! $slug || $slug !== $plugin_slug ) {

			continue;

		}

		return $plugin_file; // If $slug = $plugin_name

	}

	return null;

}

/**
 * Render the Timeline Express add-on container
 *
 * @param  array $addon Add-On data array.
 *
 * @return mixed        Markup for the addon container.
 */
function timeline_express_render_addon( $addon, $free = false ) {

	?>

	<div class="plugin-card plugin-card-<?php echo sanitize_title( $addon['name'] ); ?>">
		<div class="plugin-card-top">

			<div class="name column-name">
				<h3><?php timeline_express_get_addon_info_url( $addon, $free ) ?></h3>
			</div>

			<div class="action-links">

				<ul class="plugin-action-buttons">

					<li>
						<a class="<?php echo esc_attr( $addon['button_class'] ); ?>" data-slug="<?php echo sanitize_title( $addon['name'] ); ?>" href="http://timeline-express-i18n.dev/wp-admin/update.php?action=install-plugin&amp;plugin=wp-super-cache&amp;_wpnonce=2ed6719395" aria-label="<?php echo sprintf( __( 'Install %s now', 'timeline-express' ), $addon['name'] ); ?>" data-name="<?php echo esc_attr( $addon['name'] ); ?>">
							<?php echo esc_html( $addon['button_text'] ); ?>
						</a>
					</li>

					<?php if ( $free ) { ?>
						<li>
							<a href="http://timeline-express-i18n.dev/wp-admin/plugin-install.php?tab=plugin-information&amp;plugin=wp-super-cache&amp;TB_iframe=true&amp;width=772&amp;height=515" class="thickbox open-plugin-details-modal" aria-label="More information about <?php echo esc_attr( $addon['name'] ); ?> 1.4.9" data-title="<?php echo esc_attr( $addon['name'] ); ?>">
								<?php esc_html( 'More Details' ); // core i18n ?>
							</a>
						</li>
					<?php } ?>

				</ul>

			</div>

			<div class="desc column-description">
				<p><?php echo esc_html( $addon['description'] ); ?></p>
				<p class="authors">
					<cite>By <a href="https://www.codeparrots.com/">Code Parrots</a></cite>
				</p>
			</div>
		</div>
		<div class="plugin-card-bottom">
			<div class="vers column-rating">
				<div class="star-rating">
					<span class="screen-reader-text">4.5 rating based on 1,206 ratings</span>
					<div class="star star-full" aria-hidden="true"></div>
					<div class="star star-full" aria-hidden="true"></div>
					<div class="star star-full" aria-hidden="true"></div>
					<div class="star star-full" aria-hidden="true"></div>
					<div class="star star-half" aria-hidden="true"></div>
				</div>
				<span class="num-ratings" aria-hidden="true">(1,206)</span>
			</div>
			<div class="column-updated">
				<strong>Last Updated:</strong>
				3 months ago
			</div>
			<div class="column-downloaded">
				1+ Million Active Installs
			</div>
			<div class="column-compatibility">
				<span class="compatibility-compatible">
					<strong>Compatible</strong> with your version of WordPress
				</span>
			</div>
		</div>
	</div>

	<?php

}

function timeline_express_get_addon_info_url( $addon, $free = false ) {

	if ( $free ) {

		$plugin_info_url = add_query_arg( array(
			'tab'       => 'plugin-information',
			'TB_iframe' => true,
			'width'     => '772',
			'height'    => '515',
			'plugin'    => urlencode( $addon['name'] ),
		), admin_url() );

		?>

		<a href="<?php echo esc_url( $plugin_info_url ); ?>" class="thickbox open-plugin-details-modal">
			<?php echo esc_html( $addon['name'] ); ?>
			<img src='<?php echo esc_url( $addon['thumbnail_url'] ); ?>' class='plugin-icon' alt=''>
		</a>

		<?php

		return;

	}

	?>

	<?php echo esc_html( $addon['name'] ); ?>
	<img src='<?php echo esc_url( $addon['thumbnail_url'] ); ?>' class='plugin-icon' alt=''>

	<?php

}
