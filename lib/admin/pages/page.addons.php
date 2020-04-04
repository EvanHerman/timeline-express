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

add_thickbox();
wp_enqueue_script( 'plugin-install' );

wp_enqueue_script( 'timeline-express-add-ons-js', TIMELINE_EXPRESS_URL . "lib/admin/js/min/timeline-express-add-ons{$suffix}.js", array( 'plugin-install' ), TIMELINE_EXPRESS_VERSION_CURRENT, true );

wp_localize_script(
	'timeline-express-add-ons-js',
	'te_installer_localize',
	array(
		'ajax_url'      => admin_url( 'admin-ajax.php' ),
		'admin_nonce'   => wp_create_nonce( 'timeline_express_add_on_install_nonce' ),
		'install_now'   => __( 'Are you sure you want to install this add-on?', 'timeline-express' ),
		'install_btn'   => __( 'Install' ), // core i18n
		'activate_btn'  => __( 'Activate' ), // core i18n
		'installed_btn' => __( 'Active', 'timeline-express' ),
	)
);

$all_plugins = get_plugins();

/**
 * Build arrays of add-ons
 */
$free_addons = array(
	array(
		'name'    => esc_html__( 'Timeline Express - HTML Excerpts', 'timeline-express' ),
		'slug'    => 'timeline-express-html-excerpt-add-on',
		'popular' => true,
	),
	array(
		'name' => esc_html__( 'Timeline Express - Single Column', 'timeline-express' ),
	),
	array(
		'name' => esc_html__( 'Timeline Express - No Icons', 'timeline-express' ),
	),
);

$premium_addons = array(
	array(
		'name'          => esc_html__( 'Timeline Express - White Label Branding', 'timeline-express' ),
		'class'         => 'Timeline_Express_White_label',
		'description'   => esc_html__( 'Remove any and all references to our branding, Code Parrots. This add-on removes links, metaboxes, menu items and any association to Code Parrots so your clients won’t get confused with the mixed branding across the dashboard.', 'timeline-express' ),
		'thumbnail_url' => 'https://www.wp-timelineexpress.com/wp-content/uploads/2016/06/timeline-express-white-label-banner-150x150.jpg',
		'purchase_url'  => 'https://www.wp-timelineexpress.com/products/timeline-express-white-label-addon/',
		'author'        => '<a href="http://www.codeparrots.com">Code Parrots</a>',
	),
	array(
		'name'          => esc_html__( 'Timeline Express - Post Types', 'timeline-express' ),
		'class'         => 'Timeline_Express_Post_Type',
		'description'   => esc_html__( 'Generate timelines using posts, pages or any other custom post type on your site with this add-on. Powerful, flexible and simple to use – now users can generate custom timelines in a beautiful timeline without altering any code.', 'timeline-express' ),
		'thumbnail_url' => 'https://www.wp-timelineexpress.com/wp-content/uploads/2016/05/timeline-express-post-types-banner-150x150.jpg',
		'purchase_url'  => 'https://www.wp-timelineexpress.com/products/timeline-express-post-types-add-on/',
		'popular'       => true,
		'author'        => '<a href="http://www.codeparrots.com">Code Parrots</a>',
	),
	array(
		'name'          => esc_html__( 'Timeline Express - Historical Dates', 'timeline-express' ),
		'class'         => 'Timeline_Express_Historical_Dates_Addon',
		'description'   => esc_html__( 'Due to a limitation with PHP, storing dates prior to 1970 has been a one of the limitations of Timeline Express. Quickly enable the ability to assign dates between the years 1000 to 9999 to all announcements.', 'timeline-express' ),
		'thumbnail_url' => 'https://www.wp-timelineexpress.com/wp-content/uploads/2016/05/timeline-express-historical-dates-banner-150x150.jpg',
		'purchase_url'  => 'https://www.wp-timelineexpress.com/products/timeline-express-historical-dates-add-on/',
		'popular'       => true,
		'author'        => '<a href="http://www.codeparrots.com">Code Parrots</a>',
	),
	array(
		'name'          => esc_html__( 'Timeline Express - AJAX Limits', 'timeline-express' ),
		'class'         => 'Timeline_Express_AJAX_Limits',
		'description'   => esc_html__( 'Limit your Timeline to a set number of announcements, and display a ‘Load More’ button beneath, allowing users to load more announcements onto the timeline. This prevents your pages from becoming unruly in length if you display many announcements.', 'timeline-express' ),
		'thumbnail_url' => 'https://www.wp-timelineexpress.com/wp-content/uploads/2016/05/ajax-limits-add-on-banner-1-150x150.jpg',
		'purchase_url'  => 'https://www.wp-timelineexpress.com/products/timeline-express-ajax-limits-add-on/',
		'popular'       => true,
		'author'        => '<a href="http://www.codeparrots.com">Code Parrots</a>',
	),
	array(
		'name'          => esc_html__( 'Timeline Express - Twitter Feed', 'timeline-express' ),
		'class'         => 'Timeline_Express_Twitter_Feed',
		'description'   => esc_html__( 'Display twitter feeds in a Timeline for users, search terms and by gelocation using our Twitter Feed Add-On. Twitter feeds can be set to live update, so every 30 seconds the feed is updated with new, fresh, tweets.', 'timeline-express' ),
		'thumbnail_url' => 'https://www.wp-timelineexpress.com/wp-content/uploads/2016/10/timeline-express-twitter-feeds-addon-banner-150x150.jpg',
		'purchase_url'  => 'https://www.wp-timelineexpress.com/products/timeline-express-twitter-feeds-add/',
		'author'        => '<a href="http://www.codeparrots.com">Code Parrots</a>',
	),
	array(
		'name'          => esc_html__( 'Timeline Express - Toolbox', 'timeline-express' ),
		'class'         => 'Timeline_Express_Toolbox',
		'description'   => esc_html__( 'Customize many aspects of Timeline Express (image size, date format, announcement slug etc.) without ever writing any code, using an admin UI.', 'timeline-express' ),
		'thumbnail_url' => 'https://www.wp-timelineexpress.com/wp-content/uploads/edd/2017/01/timeline-express-toolbox-add-on-banner-150x150.jpg',
		'purchase_url'  => 'https://www.wp-timelineexpress.com/products/timeline-express-toolbox-add/',
		'popular'       => true,
		'author'        => '<a href="http://www.codeparrots.com">Code Parrots</a>',
	),
	array(
		'name'          => esc_html__( 'Timeline Express - Popups', 'timeline-express' ),
		'class'         => 'Timeline_Express_Popups',
		'description'   => esc_html__( 'Display announcement content in an elegant popup, on the same page as your timeline, when a user clicks the "Read More" link.', 'timeline-express' ),
		'thumbnail_url' => 'https://www.wp-timelineexpress.com/wp-content/uploads/edd/2017/03/timeline-express-popups-banner-150x150.jpg',
		'purchase_url'  => 'https://www.wp-timelineexpress.com/products/timeline-express-popups-add-on/',
		'author'        => '<a href="http://www.codeparrots.com">Code Parrots</a>',
	),
);

// Sort addons by name
usort( $premium_addons, 'compare_addon_names' );

array_unshift(
	$premium_addons,
	array(
		'name'         => esc_html__( 'Timeline Express - Product Bundle', 'timeline-express' ),
		/* translators: Integer value for the number of add-ons in the add-on list. (eg: 6) */
		'description'  => sprintf( esc_html( "Get all %s of the Timeline Express add-ons for one low price! Select a 5 or 10 site license, and receive all current and future add-ons for Timeline Express along with updates and priority product support. An amazing deal, don't miss it!", 'timeline-express' ), count( $premium_addons ) ),
		'purchase_url' => 'https://www.wp-timelineexpress.com/products/timeline-express-bundle/',
		'popular'      => true,
		'author'       => '<a href="http://www.codeparrots.com">Code Parrots</a>',
	)
);

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

	<p class="description"><?php esc_html_e( 'Download and install any of our free Timeline Express add-ons from the WordPress.org plugin directory.', 'timeline-express' ); ?></p>

	<div class="the-list">

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

	<p class="description"><?php esc_html_e( 'Premium add-ons bring enhanced features to the Timeline Express base plugin. Browse through some of our premium add-ons below.', 'timeline-express' ); ?></p>

	<div class="the-list">

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

	$all_plugins = get_plugins();

	$slug        = isset( $data['slug'] ) ? $data['slug'] : sanitize_title( $data['name'] . ' Add-On' );
	$plugin_file = $slug . '/' . $slug . '.php';

	if ( $free ) {

		$api = (array) plugins_api(
			'plugin_information',
			array(
				'slug'   => sanitize_file_name( $slug ),
				'fields' => array(
					'short_description' => true,
					'sections'          => false,
					'requires'          => true,
					'downloaded'        => true,
					'active_installs'   => true,
					'last_updated'      => true,
					'added'             => false,
					'tags'              => false,
					'compatibility'     => false,
					'homepage'          => false,
					'donate_link'       => false,
					'icons'             => true,
					'banners'           => false,
				),
			)
		);

		if ( is_wp_error( $api ) ) {

			return false;

		}

		if ( 'timeline-express-html-excerpt-add-on' === $slug ) {

			$plugin_file = 'timeline-express-html-excerpt-add-on/timeline-express-html-excerpts-add-on.php';

		}

		$plugin_installed = array_key_exists( $plugin_file, $all_plugins );

		$data['button_class'] = $plugin_installed ? ( is_plugin_active( $plugin_file ) ? 'button disabled' : 'activate button button-primary' ) : 'install button';
		$data['button_text']  = $plugin_installed ? ( is_plugin_active( $plugin_file ) ? __( 'Active', 'timeline-express' ) : __( 'Activate', 'timeline-express' ) ) : __( 'Install' );

		$data['description'] = $api['short_description'];

		// Setup thumbnail URL with fallback
		$data['thumbnail_url'] = isset( $api['icons']['1x'] ) ? $api['icons']['1x'] : 'https://www.wp-timelineexpress.com/wp-content/uploads/2016/11/timeline-express-150x150.png';

		$data['api_data'] = $api;

		return $data;

	} // End if().

	$installed = array_key_exists( $plugin_file, $all_plugins );
	$active    = ( isset( $data['class'] ) && class_exists( $data['class'] ) );

	// Button Text
	$data['button_class'] = $installed ? ( $active ? 'button disabled premium' : 'activate button button-primary premium' ) : 'install button premium';
	$data['button_text']  = $installed ? ( $active ? __( 'Active', 'timeline-express' ) : __( 'Activate', 'timeline-express' ) ) : __( 'View Add-On', 'timeline-express' );

	// Setup thumbnail URL with fallback
	$data['thumbnail_url'] = ( isset( $data['thumbnail_url'] ) ) ? $data['thumbnail_url'] : 'https://www.wp-timelineexpress.com/wp-content/uploads/2016/11/timeline-express-150x150.png';

	// Use this to dictate target="_blank" or not
	$data['external_url'] = isset( $data['purchase_url'] ) ? true : false;

	return $data;

}

/**
 * Render the Timeline Express add-on container
 *
 * @param  array $addon Add-On data array.
 *
 * @return mixed        Markup for the addon container.
 */
function timeline_express_render_addon( $addon, $free = false ) {

	/**
	 * Allowed tags for the byline - borrowed from WordPress core.
	 *
	 * @reference https://github.com/WordPress/WordPress/blob/b83a62217e1e3925e65fe643831fc649df55fb65/wp-admin/includes/class-wp-plugin-install-list-table.php#L394-L399
	 *
	 * @var array
	 */
	$plugins_allowedtags = array(
		'a'       => array(
			'href'   => array(),
			'title'  => array(),
			'target' => array(),
		),
		'abbr'    => array(
			'title' => array(),
		),
		'acronym' => array(
			'title' => array(),
		),
		'code'    => array(),
		'pre'     => array(),
		'em'      => array(),
		'strong'  => array(),
		'ul'      => array(),
		'ol'      => array(),
		'li'      => array(),
		'p'       => array(),
		'br'      => array(),
	);

	$link   = isset( $addon['purchase_url'] ) ? $addon['purchase_url'] : '#';
	$target = isset( $addon['external_url'] ) ? 'target="_blank"' : '';

	?>

	<div class="plugin-card plugin-card-<?php echo sanitize_title( $addon['name'] ); ?>">
		<div class="plugin-card-top">

			<div class="name column-name">
				<h3><?php timeline_express_get_addon_info_url( $addon, $free ); ?></h3>
			</div>

			<div class="action-links">

				<ul class="plugin-action-buttons">

					<li>
						<a class="<?php echo esc_attr( $addon['button_class'] ); ?>" <?php echo esc_attr( $target ); ?> data-slug="<?php echo sanitize_title( isset( $addon['slug'] ) ? $addon['slug'] : $addon['name'] . '-add-on' ); ?>" href="<?php echo esc_url( $link ); ?>" aria-label="<?php printf( /* translators: The name of the plugin. */ __( 'Install %s now', 'timeline-express' ), $addon['name'] ); ?>" data-name="<?php echo esc_attr( $addon['name'] ); ?>">
							<?php echo esc_html( $addon['button_text'] ); ?>
						</a>
					</li>

				</ul>

			</div>

			<div class="desc column-description">
				<p><?php echo esc_html( $addon['description'] ); ?></p>
				<p class="authors">
				<?php

				$author = wp_kses( ( $free ? $addon['api_data']['author'] : $addon['author'] ), $plugins_allowedtags );

				if ( ! empty( $author ) ) {

					print( ' <cite>' . /* translators: The author name wrapped in <a> tags. */ sprintf(
						__( 'By %s' ),
						$author
					) . '</cite>' );

				}

				?>
				</p>
			</div>
		</div>

		<?php
		if ( $free ) {

			timeline_express_addon_details( $addon );

		}
		?>

	</div>

	<?php

}

/**
 * Build the addon info details URL.
 *
 * @since  1.4.4
 *
 * @return array
 */
function timeline_express_get_addon_info_url( $addon, $free = false ) {

	if ( $free ) {

		$plugin_info_url = add_query_arg(
			array(
				'tab'       => 'plugin-information',
				'plugin'    => sanitize_title( isset( $addon['slug'] ) ? $addon['slug'] : $addon['name'] . '-add-on' ),
				'TB_iframe' => 'true',
				'width'     => '600',
				'height'    => '550',
			),
			admin_url( 'plugin-install.php' )
		);

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

/**
 * Sort our addons by name.
 *
 * @since  1.4.4
 *
 * @param  array   $a Addon data array.
 * @param  array   $b Addon data array.
 *
 * @return boolean
 */
function compare_addon_names( $a, $b ) {

	return strcmp( $a['name'], $b['name'] );

}

function timeline_express_addon_details( $data ) {

	?>

	<div class="plugin-card-bottom">
		<div class="vers column-rating">
			<div class="star-rating">
				<span class="screen-reader-text">

					<?php
					sprintf(
						/* translators: 1. Plugin rating (eg: 4.5) 2. Rating count (eg: 100) */
						esc_html__( '%1$s rating based on %2$s ratings', 'timeline-express' ),
						(int) $data['api_data']['rating'],
						(int) $data['api_data']['num_ratings']
					);
					?>

				</span>

					<?php

					wp_star_rating(
						array(
							'rating' => $data['api_data']['rating'],
							'type'   => 'percent',
							'number' => $data['api_data']['num_ratings'],
						)
					);

					?>

			</div>
			<span class="num-ratings" aria-hidden="true">(<?php echo esc_html( number_format_i18n( (int) $data['api_data']['num_ratings'] ) ); ?>)</span>
		</div>
		<div class="column-updated">
			<strong><?php esc_html__( 'Last Updated:' ); ?></strong>
			<?php
			printf(
				/* translators: The last time this plugin was updated (eg: 1 week). */
				__( '%s ago' ),
				human_time_diff( strtotime( $data['api_data']['last_updated'] ) )
			);
			?>
		</div>
		<div class="column-downloaded">
			<?php

			if ( $data['api_data']['active_installs'] >= 1000000 ) {

				$active_installs_text = /* translators: Active plugin installs */ _x( '1+ Million', 'Active plugin installs' ); // core i18n

			} elseif ( 0 === $data['api_data']['active_installs'] ) {

				$active_installs_text = /* translators: Active plugin installs */ _x( 'Less Than 10', 'Active plugin installs' ); // core i18n

			} else {

				$active_installs_text = number_format_i18n( $data['api_data']['active_installs'] ) . '+';

			}

			printf(
				/* translators: Number of active installs (eg: 10,000). Note: Can be a string or an integer. */
				__( '%s Active Installs' ),
				$active_installs_text
			);

			?>
		</div>
		<div class="column-compatibility">
			<?php
			$wp_version = get_bloginfo( 'version' );

			if ( ! empty( $data['api_data']['tested'] ) && version_compare( substr( $wp_version, 0, strlen( $data['api_data']['tested'] ) ), $data['api_data']['tested'], '>' ) ) {

				echo '<span class="compatibility-untested">' . __( 'Untested with your version of WordPress' ) . '</span>';

			} elseif ( ! empty( $data['api_data']['requires'] ) && version_compare( substr( $wp_version, 0, strlen( $data['api_data']['requires'] ) ), $data['api_data']['requires'], '<' ) ) {

				echo '<span class="compatibility-incompatible">' . __( '<strong>Incompatible</strong> with your version of WordPress' ) . '</span>';

			} else {

				echo '<span class="compatibility-compatible">' . __( '<strong>Compatible</strong> with your version of WordPress' ) . '</span>';

			}
			?>
		</div>
	</div>

	<?php

}
