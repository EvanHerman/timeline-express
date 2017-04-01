<?php
/**
 * Addon Template - Admin Page
 *
 * @package Timeline Express
 *
 * @since   1.2
 */

if ( ! defined( 'ABSPATH' ) ) :

	exit;

endif;

if ( ! isset( $_GET['page'] ) || 'timeline-express-addons' !== $_GET['page']  ) :

	return;

endif;

/**
 * Build an array of add-ons
 *
 * @var array
 */
$addon_array = array(
	array(
		'name'          => esc_html__( 'Timeline Express - HTML Excerpts', 'timeline-express' ),
		'class'         => 'Timeline_Express_HTML_Excerpts',
		'description'   => esc_html__( 'Enable custom HTML excerpts and allow for your timeline excerpts to display audio, video and shortcodes. As one of the most visited documentation pages on the site, we decided to break this feature off into a free add-on, so you never have to touch your sites code.', 'timeline-express' ),
		'thumbnail_url' => 'https://www.wp-timelineexpress.com/wp-content/uploads/2016/09/html-excerpts-banner-150x150.jpg',
		'purchase_url'  => wp_nonce_url( self_admin_url( 'update.php?action=install-plugin&plugin=timeline-express-html-excerpt-add-on' ), 'install-plugin_timeline-express-html-excerpt-add-on' ),
		'popular'       => true,
		'free'          => true,
	),
	array(
		'name'          => esc_html__( 'Timeline Express - White Label Branding', 'timeline-express' ),
		'class'         => 'Timeline_Express_White_label',
		'description'   => esc_html__( 'Remove any and all references to our branding, Code Parrots. This add-on removes links, metaboxes, menu items and any association to Code Parrots so your clients won’t get confused with the mixed branding across the dashboard.', 'timeline-express' ),
		'thumbnail_url' => 'https://www.wp-timelineexpress.com/wp-content/uploads/2016/06/timeline-express-white-label-banner-150x150.jpg',
		'purchase_url'  => 'https://www.wp-timelineexpress.com/products/timeline-express-white-label-addon/',
	),
	array(
		'name'          => esc_html__( 'Timeline Express - Single Column', 'timeline-express' ),
		'class'         => 'Timeline_Express_Single_Column',
		'description'   => esc_html__( 'This add-on enables a new layout for your Timelines, by displaying them in a single column. A highly requested features that we’ve turned into a plug and play solution – so you, as the end user, don’t have to make any alterations to your code.', 'timeline-express' ),
		'thumbnail_url' => 'https://www.wp-timelineexpress.com/wp-content/uploads/2016/06/timeline-express-single-column-addon-banner-150x150.jpg',
		'purchase_url'  => wp_nonce_url( self_admin_url( 'update.php?action=install-plugin&plugin=timeline-express-single-column-add-on' ), 'install-plugin_timeline-express-single-column-add-on' ),
		'free'          => true,
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
		'name'          => esc_html__( 'Timeline Express - No Icons', 'timeline-express' ),
		'class'         => 'Timeline_Express_No_Icons',
		'description'   => esc_html__( 'Remove the icon selection on the announcement creation/edit screen, and remove the icons on the timeline on the front end of the site.', 'timeline-express' ),
		'thumbnail_url' => 'https://www.wp-timelineexpress.com/wp-content/uploads/edd/2016/12/timeline-express-no-icons-banner-new-150x150.jpg',
		'purchase_url'  => wp_nonce_url( self_admin_url( 'update.php?action=install-plugin&plugin=timeline-express-no-icons-add-on' ), 'install-plugin_timeline-express-no-icons-add-on' ),
		'free'          => true,
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

shuffle( $addon_array );

array_unshift( $addon_array, array(
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

	<p class="intro" style="max-width:800px;">
		<?php esc_html_e( "Extend the base Timeline Express functionality with our powerful add-ons. We're constantly looking to build out additional add-ons. If you have a great idea for a new add-on, get in contact with us!", 'timeline-express' ); ?>
	</p>

	<?php

	$x = 1;

	foreach ( $addon_array as $addon_data ) {

		if ( 1 === $x ) {

			?><div class="section group"><?php

		}

		$addon_data_array = timeline_express_build_addon_data( $addon_data );

		$addon_purchase_url = ( $addon_data_array['plugin_installed'] ) ? '#' : esc_url( $addon_data_array['purchase_url'] );

		?>

			<!-- Individual add-on containers -->
			<div class="timeline-express-addon-item col span_1_of_3 timeline-express-addon-status-upgrade<?php if ( isset( $addon_data['popular'] ) && $addon_data['popular'] ) { echo ' popular-addon'; } ?><?php if ( $addon_data_array['plugin_installed'] ) { echo ' timeline-express-addon-installed-container'; } ?>">

				<div class="timeline-express-addon-image">
					<img src="<?php echo esc_url( $addon_data_array['thumbnail_url'] ); ?>" />
					<span class="icons">
						<?php
						if ( isset( $addon_data_array['popular'] ) && $addon_data_array['popular'] ) {

							printf(
								'<div class="badge popular"><span class="dashicons dashicons-awards"></span>%s</div>',
								esc_html__( 'Popular', 'timeline-express' )
							);

						}

						if ( isset( $addon_data_array['free'] ) && $addon_data_array['free'] ) {

							printf(
								'<div class="badge free"><span class="dashicons dashicons-info"></span>%s</div>',
								esc_html__( 'Free', 'timeline-express' )
							);

						}
						?>
					</span>
				</div>

				<div class="timeline-express-addon-text">

					<h4><?php echo esc_html( $addon_data_array['name'] ); ?></h4>

					<p class="desc"><?php echo esc_html( $addon_data_array['description'] ); ?></p>

				</div>

				<div class="timeline-express-addon-action">

					<a href="<?php echo esc_attr( $addon_purchase_url ); ?>"<?php if ( $addon_data_array['external_url'] ) { echo ' target="_blank"'; } ?> class="<?php if ( $addon_data_array['plugin_installed'] ) { echo 'button-addon-installed'; } ?>">

						<?php echo esc_html( $addon_data_array['button_text'] ); ?>

					</a>

				</div>

			</div>

		<?php

		if ( 3 === $x ) {

			?></div><?php

			$x = 1;

			continue;

		}

		$x++;

	}

	?>

	<div style="clear:both"></div>

</div>

<?php
/**
 * Build the data array to use when displaying add-ons
 *
 * @since 1.2.8
 *
 * @return array
 */
function timeline_express_build_addon_data( $data ) {

	// Button Text
	$data['button_text']   = ( isset( $data['free'] ) && $data['free'] ) ? esc_html__( 'Download Now', 'timeline-express' ) : esc_html__( 'Buy Now', 'timeline-express' );

	// Setup thumbnail URL with fallback
	$data['thumbnail_url'] = ( isset( $data['thumbnail_url'] ) ) ? $data['thumbnail_url'] : 'https://www.wp-timelineexpress.com/wp-content/uploads/2016/11/timeline-express-150x150.png';

	// Check if this add-on is installed or not
	$data['plugin_installed'] = ( isset( $data['class'] ) && class_exists( $data['class'] ) ) ? true : false;

	if ( $data['plugin_installed'] ) {

		$data['button_text'] = esc_html__( 'Installed', 'timeline-express' );

	}

	// Use this to dictate target="_blank" or not
	$data['external_url'] = ( strpos( $data['purchase_url'], admin_url() ) !== false ) ? false : true;

	return $data;

}
