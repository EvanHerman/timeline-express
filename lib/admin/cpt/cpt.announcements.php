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

$timeline_express_labels = array(
	'name'                => __( 'Timeline Express Announcements' , 'timeline-express' ),
	'singular_name'       => __( 'Announcement' , 'timeline-express' ), /* Menu item at the top New > Announcement */
	'menu_name'           => __( 'Timeline Express' , 'timeline-express' ), /* Menu name */
	'parent_item_colon'   => __( 'Timeline Express:' , 'timeline-express' ),
	'all_items'           => __( 'All Announcements' , 'timeline-express' ),
	'view_item'           => __( 'View Announcement' , 'timeline-express' ),
	'add_new_item'        => __( 'New Announcement' , 'timeline-express' ),
	'add_new'             => __( 'New Announcement' , 'timeline-express' ),
	'edit_item'           => __( 'Edit Announcement' , 'timeline-express' ),
	'update_item'         => __( 'Update Announcement' , 'timeline-express' ),
	'search_items'        => __( 'Search Announcements' , 'timeline-express' ),
	'not_found'           => __( 'No Timeline Express Announcements Found' , 'timeline-express' ),
	'not_found_in_trash'  => __( 'No Timeline Express Announcements in Trash' , 'timeline-express' ),
);
$timeline_express_rewrite = array(
	'slug'                => apply_filters( 'timeline-express-slug' , 'announcement' ),
	'with_front'          => false,
	'pages'               => true,
	'feeds'               => true,
);
$timeline_express_args = array(
	'label'               => 'timeline-express-announcement',
	'description'         => __( 'Post type for adding timeline express announcements to the site' , 'timeline-express' ),
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
register_post_type( 'te_announcements', $timeline_express_args );
/* End release cycle cpt */

/* Flush the re-write rules/permalinks - prevents 404 on initial activation */
$set = get_option( 'post_type_rules_flased_te-announcements', false );
if ( true !== $set ) {
	flush_rewrite_rules( false );
	update_option( 'post_type_rules_flased_te-announcements', true );
}
