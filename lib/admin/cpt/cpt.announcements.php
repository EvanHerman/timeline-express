<?php
/**
 * Register our Announcement Custom Post Type
 * used to easily manage the announcements on the site
 * By Code Parrots
 *
 * @link http://www.codeparrots.com
 *
 * @package WordPress
 * @subpackage Component
 * @since 1.2
 */

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
	'name'                => sprintf( __( 'Timeline Express %s', 'timeline-express' ), $announcement_plural_text ),
	'singular_name'       => $announcement_singular_text, /* Menu item at the top New > Announcement */
	'menu_name'           => __( 'Timeline Express', 'timeline-express' ), /* Menu name */
	'parent_item_colon'   => __( 'Timeline Express:', 'timeline-express' ),
	'all_items'           => sprintf( __( 'All %s', 'timeline-express' ), $announcement_plural_text ),
	'view_item'           => sprintf( __( 'View %s', 'timeline-express' ), $announcement_singular_text ),
	'add_new_item'        => sprintf( __( 'New %s', 'timeline-express' ), $announcement_singular_text ),
	'add_new'             => sprintf( __( 'New %s', 'timeline-express' ), $announcement_singular_text ),
	'edit_item'           => sprintf( __( 'Edit %s', 'timeline-express' ), $announcement_singular_text ),
	'update_item'         => sprintf( __( 'Update %s', 'timeline-express' ), $announcement_singular_text ),
	'search_items'        => sprintf( __( 'Search %s', 'timeline-express' ), $announcement_plural_text ),
	'not_found'           => sprintf( __( 'No Timeline Express %s Found', 'timeline-express' ), $announcement_plural_text ),
	'not_found_in_trash'  => sprintf( __( 'No Timeline Express %s in Trash', 'timeline-express' ), $announcement_plural_text ),
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
	'description'         => sprintf( __( 'Post type for adding timeline express %s to the site', 'timeline-express' ), strtolower( $announcement_plural_text ) ),
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
	'menu_icon'						=> TIMELINE_EXPRESS_URL . 'lib/admin/images/timeline-express-menu-icon.png',
	'can_export'          => true,
	'has_archive'         => true,
	'exclude_from_search' => $timeline_express_options['announcement-appear-in-searches'], /* Toggled via setitngs page - @since v1.1.5.8 */
	'publicly_queryable'  => true,
	'rewrite'             => $timeline_express_rewrite,
	'capability_type'     => 'page',
);

/**
 * Register the announcement post type.
 */
register_post_type( 'te_announcements', $timeline_express_args );
/* End release cycle cpt */

/* Flush the re-write rules/permalinks - prevents 404 on initial plugin activation */
$set = get_option( 'post_type_rules_flased_te-announcements', false );
if ( true !== $set ) {
	flush_rewrite_rules( false );
	update_option( 'post_type_rules_flased_te-announcements', true );
}
