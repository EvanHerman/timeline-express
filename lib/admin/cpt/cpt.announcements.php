<?php
/**
 * Register our Announcement Custom Post Type
 * used to easily manage the announcements on the site
 *
 * @author Code Parrots
 *
 * @link http://www.codeparrots.com
 *
 * @package Timeline Express
 *
 * @since 1.2
 */

// store our options for use here
$timeline_express_options = timeline_express_get_options();

/**
 * Wrapped in apply_filters() twice, for legacy support.
 * Allow users to alter the timeline express slug.
 *
 * Legacy Filter: timeline-express-slug @since 1.1.3
 * New Filter: timeline_express_slug @since 1.2
 */
$announcement_slug = apply_filters( 'timeline_express_slug', apply_filters( 'timeline-express-slug', 'announcement' ) );

/**
 * Allow users to alter the timeline express menu text (singular items)
 * @since 1.2
 */
$announcement_singular_text = apply_filters( 'timeline_express_singular_name', __( 'Announcement', 'timeline-express' ) );

/**
 * Allow users to alter the timeline express menu text (plural items)
 * @since 1.2
 */
$announcement_plural_text = apply_filters( 'timeline_express_plural_name', __( 'Announcements', 'timeline-express' ) );

/**
 * Custom Post Type Label Array
 */
$timeline_express_labels = array(
	'name'                => sprintf( _x( 'Timeline Express %s', 'Announcement plural name eg: Timeline Express Announcements', 'timeline-express' ), $announcement_plural_text ),
	'singular_name'       => $announcement_singular_text, /* Menu item at the top New > Announcement */
	'menu_name'           => __( 'Timeline Express', 'timeline-express' ), /* Menu name */
	'parent_item_colon'   => __( 'Timeline Express:', 'timeline-express' ),
	'all_items'           => sprintf( _x( 'All %s', 'Announcement plural name eg: All Announcements', 'timeline-express' ), $announcement_plural_text ),
	'view_item'           => sprintf( _x( 'View %s', 'Announcement singular name eg: View Announcement', 'timeline-express' ), $announcement_singular_text ),
	'add_new_item'        => sprintf( _x( 'New %s', 'Announcement singular name eg: New Announcement', 'timeline-express' ), $announcement_singular_text ),
	'add_new'             => sprintf( _x( 'New %s', 'Announcement singular name eg: New Announcement', 'timeline-express' ), $announcement_singular_text ),
	'edit_item'           => sprintf( _x( 'Edit %s', 'Announcement singular name eg: Edit Announcement', 'timeline-express' ), $announcement_singular_text ),
	'update_item'         => sprintf( _x( 'Update %s', 'Announcement singular name eg: Update Announcement', 'timeline-express' ), $announcement_singular_text ),
	'search_items'        => sprintf( _x( 'Search %s', 'Announcement plural name eg: Search Announcements', 'timeline-express' ), $announcement_plural_text ),
	'not_found'           => sprintf( _x( 'No Timeline Express %s Found', 'Announcement plural name eg: No Timeline Express Announcements Found', 'timeline-express' ), $announcement_plural_text ),
	'not_found_in_trash'  => sprintf( _x( 'No Timeline Express %s in Trash', 'Announcement plural name eg: No Timeline Express Announcements in Trash', 'timeline-express' ), $announcement_plural_text ),
);

/**
 * Custom post type rewrite rules
 */
$timeline_express_rewrite = array(
	'slug'                => $announcement_slug,
	'with_front'          => false,
	'pages'               => true,
	'feeds'               => true,
);

/**
 * Custom post type arguments
 */
$timeline_express_args = array(
	'label'               => 'timeline-express-announcement',
	'description'         => sprintf( _x( 'Post type for adding timeline express %s to the site.', 'Announcement plural name eg: Post type for adding timeline express announcements to the site', 'timeline-express' ), strtolower( $announcement_plural_text ) ),
	'labels'              => $timeline_express_labels,
	'supports'            => array( 'title', 'editor' ),
	'taxonomies'          => array(),
	'hierarchical'        => true,
	'public'              => true,
	'show_ui'             => true,
	'show_in_menu'        => true,
	'show_in_nav_menus'   => true,
	'show_in_admin_bar'   => true,
	'menu_position'       => 5,
	'menu_icon'           => TIMELINE_EXPRESS_URL . 'lib/admin/images/timeline-express-menu-icon.png',
	'can_export'          => true,
	'has_archive'         => true,
	'publicly_queryable'	=> true,
	'exclude_from_search'	=> ( isset( $timeline_express_options['announcement-appear-in-searches'] ) && 'true' === $timeline_express_options['announcement-appear-in-searches'] ) ? true : false,
	'rewrite'             => $timeline_express_rewrite,
	'capability_type'     => 'page',
);

/**
 * Register the announcement post type.
 */
register_post_type( 'te_announcements', $timeline_express_args );

/* Flush the re-write rules/permalinks - prevents 404 on initial plugin activation */
$set = get_option( 'post_type_rules_flushed_te-announcements', false );

/**
 * If the re-write rules are not set, flush them and update the option
 * Prevents re-write rules being flushed every page load
 *
 * @since 1.2.8.5
 *
 * @link https://github.com/EvanHerman/timeline-express/pull/24
 */
if ( ! $set ) {
	flush_rewrite_rules( false );
	update_option( 'post_type_rules_flushed_te-announcements', true );
}
