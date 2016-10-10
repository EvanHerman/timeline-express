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
		'name'          => __( 'Timeline HTML Excerpts', 'timeline-express-pro' ),
		'class'         => 'Timeline_Express_HTML_Excerpts',
		'description'   => __( 'Enable custom HTML excerpts and allow for your timeline excerpts to display audio, video and shortcodes. As one of the most visited documentation pages on the site, we decided to break this feature off into a free add-on, so you never have to touch your sites code.', 'timeline-express-pro' ),
		'thumbnail_url' => 'http://www.wp-timelineexpress.com/wp-content/uploads/2016/09/html-excerpts-banner-150x150.jpg',
		'purchase_url'  => wp_nonce_url( self_admin_url( 'update.php?action=install-plugin&plugin=timeline-express-html-excerpt-add-on' ), 'install-plugin_timeline-express-html-excerpt-add-on' ),
		'popular'       => true,
		'free'          => true,
	),
	array(
		'name'          => __( 'White Label Branding', 'timeline-express-pro' ),
		'class'         => 'Timeline_Express_White_label',
		'description'   => __( 'Remove any and all references to our branding, Code Parrots. This addon removes links, metaboxes, menu items and any association to Code Parrots so your clients won’t get confused with the mixed branding across the dashboard.', 'timeline-express-pro' ),
		'thumbnail_url' => 'http://www.wp-timelineexpress.com/wp-content/uploads/2016/06/timeline-express-white-label-banner-150x150.jpg',
		'purchase_url'  => 'https://www.evan-herman.com/wordpress-plugin/timeline-express-white-label-addon/',
	),
	array(
		'name'          => __( 'Single Column Timeline', 'timeline-express-pro' ),
		'class'         => 'Timeline_Express_Single_Column',
		'description'   => __( 'This add-on enables a new layout for your Timelines, by displaying them in a single column. A highly requested features that we’ve turned into a plug and play solution – so you, as the end user, don’t have to make any alterations to your code.', 'timeline-express-pro' ),
		'thumbnail_url' => 'http://www.wp-timelineexpress.com/wp-content/uploads/2016/06/timeline-express-single-column-addon-banner-150x150.jpg',
		'purchase_url'  => wp_nonce_url( self_admin_url( 'update.php?action=install-plugin&plugin=timeline-express-single-column-add-on' ), 'install-plugin_timeline-express-single-column-add-on' ),
		'free'          => true,
	),
	array(
		'name'          => __( 'Timeline Post Types', 'timeline-express-pro' ),
		'class'         => 'Timeline_Express_Post_Type',
		'description'   => __( 'Generate timelines using posts, pages or any other custom post type on your site with this add-on. Powerful, flexible and simple to use – now users can generate custom timelines in a beautiful timeline without altering any code.', 'timeline-express-pro' ),
		'thumbnail_url' => 'http://www.wp-timelineexpress.com/wp-content/uploads/2016/05/timeline-express-post-types-banner-150x150.jpg',
		'purchase_url'  => 'https://www.evan-herman.com/wordpress-plugin/timeline-express-post-types-add-on/',
		'popular'       => true,
	),
	array(
		'name'          => __( 'Historical Dates', 'timeline-express-pro' ),
		'class'         => 'Timeline_Express_Historical_Dates_Addon',
		'description'   => __( 'Due to a limitation with PHP, storing dates prior to 1970 has been a one of the limitations of Timeline Express. Quickly enable the ability to assign dates between the years 1000 to 9999 to all announcements.', 'timeline-express-pro' ),
		'thumbnail_url' => 'http://www.wp-timelineexpress.com/wp-content/uploads/2016/05/timeline-express-historical-dates-banner-150x150.jpg',
		'purchase_url'  => 'https://www.evan-herman.com/wordpress-plugin/timeline-express-historical-dates-add-on/',
		'popular'       => true,
	),
	array(
		'name'          => __( 'AJAX Limits Add-On', 'timeline-express-pro' ),
		'class'         => 'Timeline_Express_AJAX_Limits',
		'description'   => __( 'Limit your Timeline to a set number of announcements, and display a ‘Load More’ button beneath, allowing users to load more announcements onto the timeline. This prevents your pages from becoming unruly in length if you display many announcements.', 'timeline-express-pro' ),
		'thumbnail_url' => 'http://www.wp-timelineexpress.com/wp-content/uploads/2016/05/ajax-limits-add-on-banner-1-150x150.jpg',
		'purchase_url'  => 'https://www.evan-herman.com/wordpress-plugin/timeline-express-ajax-limits-add-on/',
		'popular'       => true,
	),
);

shuffle( $addon_array );

array_unshift( $addon_array, [
	'name'          => __( 'Timeline Express Product Bundle', 'timeline-express-pro' ),
	'description'   => sprintf( _x( "Get any and all %s of the Timeline Express add-ons, for one low price! Select a 5 or 10 site license, and receive all current and future add-ons for Timeline Express along with updates and priority product support. An amazing deal, don't miss it!", 'Integer value for the number of add-ons in the add-on list. (eg: 6)', 'timeline-express-pro' ), count( $addon_array ) ),
	'purchase_url'  => 'https://www.evan-herman.com/wordpress-plugin/timeline-express-bundle/',
	'popular'       => true,
] );

?>
<div id="timeline-express-addons" class="wrap">

	<h1 class="page-title">
		<?php esc_html_e( 'Timeline Express Add-Ons', 'timeline-express-pro' ); ?>
	</h1>

	<p class="intro" style="max-width:800px;">
		<?php esc_html_e( "Extend the base Timeline Express functionality with our powerful add-ons. We're constantly looking to build out additional add-ons. If you have a great idea for a new add-on, get in contact with us!", 'timeline-express-pro' ); ?>
	</p>

	<?php

	foreach ( $addon_array as $addon_data ) :

		$addon_data_array = timeline_express_build_addon_data( $addon_data );

		$addon_purchase_url = ( $addon_data_array['plugin_installed'] ) ? '#/' : esc_url( $addon_data_array['purchase_url'] );

		?>

			<!-- Individual add-on containers -->
			<div class="timeline-express-addon-item timeline-express-addon-status-upgrade<?php if ( isset( $addon_data['popular'] ) && $addon_data['popular'] ) { echo ' popular-addon'; } ?><?php if ( $addon_data_array['plugin_installed'] ) { echo ' timeline-express-addon-installed-container'; } ?>">

				<div class="timeline-express-addon-image">
					<img src="<?php echo esc_url( $addon_data_array['thumbnail_url'] ); ?>" />
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

	endforeach;

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
	$data['button_text']   = ( isset( $data['free'] ) && $data['free'] ) ? __( 'Download Now', 'timeline-express-pro' ) : __( 'Buy Now', 'timeline-express-pro' );

	// Setup thumbnail URL with fallback
	$data['thumbnail_url'] = ( isset( $data['thumbnail_url'] ) ) ? $data['thumbnail_url'] : 'https://www.evan-herman.com/wp-content/uploads/edd/2014/12/timeline-express-150x150.png';

	// Check if this add-on is installed or not
	$data['plugin_installed'] = ( isset( $data['class'] ) && class_exists( $data['class'] ) ) ? true : false;

	if ( $data['plugin_installed'] ) {

		$data['button_text'] = __( 'Add-On Installed', 'timeline-express-pro' );

	}

	// Use this to dictate target="_blank" or not
	$data['external_url'] = ( strpos( $data['purchase_url'], admin_url() ) !== false ) ? false : true;

	return $data;

}
