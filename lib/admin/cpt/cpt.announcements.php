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
$announcement_slug = apply_filters( 'timeline_express_slug', apply_filters( 'timeline-express-slug', __( 'announcement', 'timeline-express' ) ) );

/**
 * Allow users to alter the timeline express menu text (singular items)
 * @since 1.2
 */
$announcement_singular_text = apply_filters( 'timeline_express_singular_name', esc_html__( 'Announcement', 'timeline-express' ) );

/**
 * Allow users to alter the timeline express menu text (plural items)
 * @since 1.2
 */
$announcement_plural_text = apply_filters( 'timeline_express_plural_name', esc_html__( 'Announcements', 'timeline-express' ) );

/**
 * Custom Post Type Label Array
 */
$timeline_express_labels = array(
	/* translators: %s: Announcement singular name eg: Announcement Name */
	'name'               => sprintf( esc_html( 'Timeline Express %s', 'timeline-express' ), $announcement_plural_text ),
	'singular_name'      => $announcement_singular_text, /* Menu item at the top New > Announcement */
	'menu_name'          => esc_html__( 'Timeline Express', 'timeline-express' ), /* Menu name */
	'parent_item_colon'  => esc_html__( 'Timeline Express:', 'timeline-express' ),
	/* translators: %s: Announcement plural name eg: All Announcements */
	'all_items'          => sprintf( esc_html( 'All %s', 'timeline-express' ), $announcement_plural_text ),
	/* translators: %s: Announcement singular name eg: View Announcement */
	'view_item'          => sprintf( esc_html( 'View %s', 'timeline-express' ), $announcement_singular_text ),
	/* translators: %s: Announcement singular name eg: New Announcement */
	'add_new_item'       => sprintf( esc_html( 'New %s', 'timeline-express' ), $announcement_singular_text ),
	/* translators: %s: Announcement singular name eg: New Announcement */
	'add_new'            => sprintf( esc_html( 'New %s', 'timeline-express' ), $announcement_singular_text ),
	/* translators: %s: Announcement singular name eg: Edit Announcement */
	'edit_item'          => sprintf( esc_html( 'Edit %s', 'timeline-express' ), $announcement_singular_text ),
	/* translators: %s: Announcement singular name eg: Update Announcement */
	'update_item'        => sprintf( esc_html( 'Update %s', 'timeline-express' ), $announcement_singular_text ),
	/* translators: %s: Announcement plural name eg: Search Announcements */
	'search_items'       => sprintf( esc_html( 'Search %s', 'timeline-express' ), $announcement_plural_text ),
	/* translators: %s: Announcement plural name eg: Search Announcements */
	'not_found'          => sprintf( esc_html( 'No Timeline Express %s Found', 'timeline-express' ), $announcement_plural_text ),
	/* translators: %s: Announcement plural name eg: Search Announcements */
	'not_found_in_trash' => sprintf( esc_html( 'No Timeline Express %s in Trash', 'timeline-express' ), $announcement_plural_text ),
);

/**
 * Custom post type rewrite rules
 */
$timeline_express_rewrite = array(
	'slug'       => $announcement_slug,
	'with_front' => false,
	'pages'      => true,
	'feeds'      => true,
);

/**
 * Custom post type arguments
 */
$timeline_express_args = array(
	'label'               => 'timeline-express-announcement',
	/* translators: %s: Announcement plural name eg: announcements */
	'description'         => sprintf( esc_html( 'Post type for adding timeline express %s to the site.', 'timeline-express' ), strtolower( $announcement_plural_text ) ),
	'labels'              => $timeline_express_labels,
	'supports'            => array( 'title', 'editor' ),
	'taxonomies'          => array(),
	'hierarchical'        => true,
	'public'              => isset( $timeline_express_options['read-more-visibility'] ) ? $timeline_express_options['read-more-visibility'] : true,
	'show_ui'             => true,
	'show_in_menu'        => true,
	'show_in_nav_menus'   => isset( $timeline_express_options['read-more-visibility'] ) ? $timeline_express_options['read-more-visibility'] : true,
	'show_in_admin_bar'   => true,
	'menu_position'       => 5,
	'menu_icon'           => TIMELINE_EXPRESS_URL . 'lib/admin/images/timeline-express-menu-icon.png',
	'can_export'          => true,
	'has_archive'         => isset( $timeline_express_options['read-more-visibility'] ) ? $timeline_express_options['read-more-visibility'] : true,
	'publicly_queryable'  => isset( $timeline_express_options['read-more-visibility'] ) ? $timeline_express_options['read-more-visibility'] : true,
	'exclude_from_search' => ( isset( $timeline_express_options['announcement-appear-in-searches'] ) && 'true' === $timeline_express_options['announcement-appear-in-searches'] ) ? true : false,
	'rewrite'             => $timeline_express_rewrite,
	'rest_base'           => $announcement_slug,
	'show_in_rest'        => 'WP_REST_Posts_Controller',
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
