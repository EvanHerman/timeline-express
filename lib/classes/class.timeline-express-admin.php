<?php
/**
 * Timeline Express :: Admin Class
 *
 * @author Code Parrots
 *
 * @link http://www.codeparrots.com
 *
 * @package Timeline_Express
 *
 * @since 1.2
 */
class TimelineExpressAdmin {
	/**
	 * Main constructor
	 */
	public function __construct() {

		// Only offer user tracking if the PHP version is equal to 5.4.0 (or later)
		if ( version_compare( PHP_VERSION, '5.4.0' ) >= 0 ) {

			/* Include the usage tracking file */
			require_once  TIMELINE_EXPRESS_PATH . 'lib/classes/usage-tracking/wp-plugin-usage-tracker.php';

			$tracker = new WP_Plugin_Usage_Tracker();

			$tracker->init();

		}

		// Include our 2 weeks notice/rating request class
		require_once  TIMELINE_EXPRESS_PATH . 'lib/classes/class.timeline-express-2-week-notice.php';

		$two_week_notice = new Timeline_Express_Two_Weeks_Notice();

		$two_week_notice->init();

		/* Generate our announcements custom post type */
		add_action( 'init', array( $this, 'timeline_express_generate_announcement_post_type' ) );

		/* Move all "advanced" metaboxes above the default editor */
		add_action( 'edit_form_after_title', array( $this, 'timeline_express_rearrange_metaboxes' ), 999 );

		/* Generate our admin menus */
		add_action( 'admin_menu', array( $this, 'timeline_express_admin_menus' ) );

		/* Register our settings, and the default values */
		add_action( 'admin_init', array( $this, 'timeline_express_register_settings' ) );

		/* Custom admin notices for Timeline Express */
		add_action( 'admin_notices', array( $this, 'timeline_express_admin_notices' ) );

		/* Add our TinyMCE button that generates our shortcode for the user */
		add_action( 'admin_head', array( $this, 'timeline_express_add_tinymce' ) );

		/* Custom plugin action links */
		add_filter( 'plugin_action_links', array( $this, 'timeline_express_action_links' ), 10, 2 );

		/* Reset the transient anytime an announcement gets updated/published */
		add_action( 'save_post', array( $this, 'timeline_express_reset_transients' ) );

		/**
		 * Include CMB2 - Metabox Framework
		 * @resource https://github.com/WebDevStudios/CMB2
		 */
		if ( file_exists( TIMELINE_EXPRESS_PATH . 'lib/admin/CMB2/init.php' ) ) {

			/* Include the bootstrap file */
			require_once  TIMELINE_EXPRESS_PATH . 'lib/admin/CMB2/init.php';

			/* Initiate the metaboxes - timeline_express_announcement_metaboxes() defined in helpers.php */
			add_action( 'cmb2_init', 'timeline_express_announcement_metaboxes' );

		}

		/**
		 * Admin scripts and styles enqueue
		 * @since 1.2
		 */

		add_action( 'admin_enqueue_scripts', array( $this, 'add_timeline_express_admin_scripts_and_styles' ) );

	}

	/**
	 * Register Announcement Custom Post Type
	 * Register Announcement Custom Post Type Columns
	 * @since 1.2
	 */
	public function timeline_express_generate_announcement_post_type() {

		include_once TIMELINE_EXPRESS_PATH . 'lib/admin/cpt/cpt.announcements.php';

		include_once TIMELINE_EXPRESS_PATH . 'lib/admin/cpt/timeline-express-admin-columns.php';

	}

	/**
	 * Re-arrange the metbaoxes on our announcements custom post type.
	 *
	 * @return null
	 *
	 * @since 1.2
	 */
	public function timeline_express_rearrange_metaboxes() {

		global $post, $wp_meta_boxes;

		// When the post type is not set, or it is and it's not an announcement, abort
		if ( ! isset( $post->post_type ) || 'te_announcements' !== $post->post_type ) {

			return;

		}

		/* Re-arrange our metaboxes */
		do_meta_boxes( get_current_screen(), 'advanced', $post );

		unset( $wp_meta_boxes[ get_post_type( $post ) ]['advanced'] );

	}

	/**
	 * Generate administrative menus
	 *
	 * @since  1.2
	 */
	public function timeline_express_admin_menus() {

		/* Filter caps, for who can view this menu item */
		$menu_cap = apply_filters( 'timeline_express_menu_cap', 'manage_options' );

		/* Settings Page */
		add_submenu_page(
			'edit.php?post_type=te_announcements',
			__( 'Timeline Express Settings', 'timeline-express' ),
			__( 'Settings', 'timeline-express' ),
			$menu_cap,
			'timeline-express-settings',
			array( $this, 'timeline_express_options_page' )
		);

		/* Addon Page */
		add_submenu_page(
			'edit.php?post_type=te_announcements',
			__( 'Timeline Express Add-Ons', 'timeline-express' ),
			'<span style="color:#F7A933">' . esc_html__( 'Add-Ons', 'timeline-express' ) . '<span>',
			$menu_cap,
			'timeline-express-addons',
			array( $this, 'timeline_express_addons_page' )
		);

		/* Welcome Page */
		add_submenu_page(
			'edit.php?post_type=te_announcements',
			__( 'Timeline Express Welcome', 'timeline-express' ),
			__( 'Welcome', 'timeline-express' ),
			$menu_cap,
			'timeline-express-welcome',
			array( $this, 'timeline_express_welcome_page' )
		);

	}

	/**
	 * Inclue our options page
	 *
	 * @since 1.2
	 */
	public function timeline_express_options_page() {

		require_once TIMELINE_EXPRESS_PATH . 'lib/admin/pages/page.options.php';

	}

	/**
	 * Inclue our welcome page
	 *
	 * @since 1.2
	 */
	public function timeline_express_welcome_page() {

		require_once TIMELINE_EXPRESS_PATH . 'lib/admin/pages/page.welcome.php';

	}

	/**
	 * Inclue our addons page
	 *
	 * @since 1.2
	 */
	public function timeline_express_addons_page() {

		/* Include the addons class */
		require_once TIMELINE_EXPRESS_PATH . 'lib/classes/class.timeline-express-addons.php';

	}

	/**
	 * Register the Timeline Express settings
	 *
	 * @since  1.2
	 */
	public function timeline_express_register_settings() {

		global $timeline_express_base;

		register_setting( 'timeline-express-settings', 'timeline_express_storage', array( $timeline_express_base, 'timeline_express_save_options' ) );

		/* Plugin redirect */
		$timeline_express_base->timeline_express_activate_redirect();

	}

	/**
	 * Display admin notices in certain locations
	 *
	 * @since  1.2
	 */
	public function timeline_express_admin_notices() {

		$screen = get_current_screen();

		// When the screen base is not set or it is and it doesn't equal our settings base, abort
		if ( ! isset( $screen ) || ! isset( $screen->base ) || 'te_announcements_page_timeline-express-settings' !== $screen->base ) {

			return;

		}

		// store the current URL
		$current_url = admin_url( add_query_arg( null, null ) );

		$split_url = wp_parse_args( $current_url );

		// When the settings were not updated, or it isn't set to true, abort
		if ( ! isset( $split_url['settings-updated'] ) || 'true' !== $split_url['settings-updated'] ) {

			return;

		}

		?>
		<div class="notice notice-success">

			<p>
				<span class="dashicons dashicons-yes"></span> <?php esc_html_e( 'Timeline Express settings saved successfully!', 'timeline-express' ); ?>
			</p>

		</div>

		<?php
	}

	/**
	 * Add our tinyMCE button, and scripts to the WP_Editor() instance
	 *
	 * @since  1.0
	 */
	public function timeline_express_add_tinymce() {

		/* Hide the 'Welcome' menu item from Timeline Express */
		?>

		<style>
		#menu-posts-te_announcements .wp-submenu a[href="edit.php?post_type=te_announcements&page=timeline-express-welcome"] {
			display: none !important;
		}
		</style>

		<?php

		global $typenow;

		/* Only on Post Type: Post and Page */
		if ( ! in_array( $typenow, apply_filters( 'timeline_express_tinymce_post_types', array( 'page', 'post' ) ), true ) ) {

			return;

		}

		add_filter( 'mce_external_plugins', array( $this, 'timeline_express_add_tinymce_plugin' ) );

		add_filter( 'mce_buttons', array( $this, 'timeline_express_add_tinymce_button' ) );

	}

	/**
	 * Add our tinyMCE plugin to the tinyMCE WordPress instance
	 *
	 * @param  array   $plugin_array Array of default tinyMCE plugins.
	 *
	 * @return tinyMCE $plugin array
	 *
	 * @since  1.0
	 */
	public function timeline_express_add_tinymce_plugin( $plugin_array ) {

		$plugin_array['timeline_express'] = plugins_url( 'timeline-express/lib/admin/js/min/timeline-express-tinymce.min.js' );

		return $plugin_array;

	}

	/**
	 * Add our tinyMCE plugin to the tinyMCE WordPress instance
	 *
	 * @param array $buttons Array of default tinyMCE buttons.
	 *
	 * @return tinyMCE buttons array
	 *
	 * @since  1.0
	 */
	public function timeline_express_add_tinymce_button( $buttons ) {

		array_push( $buttons, 'timeline_express_shortcode_button' );

		return $buttons;

	}

	/**
	 * Generate custom plugin action links
	 *
	 * @param  array $links  array of links to display for our plugin.
	 * @param  string $file  The file name of the current iteration.
	 *
	 * @return array         New array of links to display.
	 *
	 * @since 1.2
	 */
	public function timeline_express_action_links( $links, $file ) {

		if ( 'timeline-express/timeline-express.php' !== $file ) {

			return $links;

		}

		/* Remove the edit button */

		unset( $links['edit'] );

		$links[] = '<a href="' . admin_url( 'edit.php?post_type=te_announcements&page=timeline-express-settings' ) . '">' . esc_html__( 'Settings', 'timeline-express' ) . '</a>';

		$links[] = '<a href="' . admin_url( 'edit.php?post_type=te_announcements&page=timeline-express-addons' ) . '">' . esc_html__( 'Add-Ons', 'timeline-express' ) . '</a>';

		$links[] = '<a href="https://www.wp-timelineexpress.com/documentation/" target="_blank">' . esc_html__( 'Documentation', 'timeline-express' ) . '</a>';

		return $links;

	}

	/**
	 * Whenever an announcement is updated/published reset the 'timeline-express-query' transient
	 *
	 * @since 1.2
	 */
	public function timeline_express_reset_transients( $post_id ) {

		// When not an announcement, post or page abort
		if ( ! in_array( get_post_type( $post_id ), array( 'te_announcements', 'post', 'page' ) ) ) {

			return;

		}

		// When a revision, abort
		if ( wp_is_post_revision( $post_id ) ) {

			return;

		}

		// If post or page, delete single transient
		if ( in_array( get_post_type( $post_id ), array( 'post', 'page' ) ) ) {

			$page_obj = get_page( $post_id );

			// if the content contains our shortcode, delete the transient set for this page
			if ( ! empty( $page_obj->post_content ) && strpos( '[timeline-express', $page_obj->post_content ) >= 0 ) {

				delete_timeline_express_transients( $post_id );

			}

			return;

		}

		// delete all transients
		delete_timeline_express_transients();

	}

	/**
	 * Conditionally enqueue our scripts and styles on the dashboard, where needed.
	 *
	 * @since 1.2
	 */
	public function add_timeline_express_admin_scripts_and_styles() {

		$screen = get_current_screen();

		$load_styles_on_pages = array( 'te_announcements_page_timeline-express-settings', 'te_announcements_page_timeline-express-welcome' );

		if ( in_array( $screen->base, $load_styles_on_pages, true ) || 'te_announcements' === $screen->post_type ) {

			// If the years are being used, hide the icon selector

			if ( defined( 'TIMELINE_EXPRESS_YEAR_ICONS' ) && TIMELINE_EXPRESS_YEAR_ICONS ) {

				?><style>.cmb-type-te-bootstrap-dropdown{ display: none !important; }</style><?php

			}

			$rtl = is_rtl() ? '-rtl' : '';

			/* Register Styles */
			wp_enqueue_style( 'timeline-express-css-base', TIMELINE_EXPRESS_URL . "lib/admin/css/min/timeline-express-admin{$rtl}.min.css", array(), TIMELINE_EXPRESS_VERSION_CURRENT, 'all' );

			/* Enqueue font awesome icons, defined in helpers.php */
			timeline_express_enqueue_font_awesome();

			/*
			 * Enqueue bootstrap select/styles
			 * Note: Minified .js file includes -
			 * admin/js/bootstrap-select.js
			 * admin/js/script.options-color-picker-custom.js
			 */
			wp_enqueue_script( 'timeline-express-admin-js', TIMELINE_EXPRESS_URL . 'lib/admin/js/min/timeline-express-admin.min.js', array( 'jquery' ), TIMELINE_EXPRESS_VERSION_CURRENT, true );
			wp_enqueue_script( 'bootstrap-min', TIMELINE_EXPRESS_URL . 'lib/admin/js/min/bootstrap.min.js' );
			wp_enqueue_style( 'bootstrap-select-style', TIMELINE_EXPRESS_URL . 'lib/admin/css/min/bootstrap-select.min.css' );

		}

		if ( in_array( $screen->base, array( 'te_announcements_page_timeline-express-settings' ), true ) || 'te_announcements' === $screen->post_type ) {

			/* Add the color picker css file */
			wp_enqueue_style( 'wp-color-picker' );
			wp_enqueue_script( 'wp-color-picker' );

			/* Enqueue jQuery UI for our bootstrap icon dropdown */
			wp_enqueue_script( 'jquery-ui-dialog' );
			wp_enqueue_style( 'wp-jquery-ui-dialog' );

			/* Enqueue custom color picker file */
			wp_enqueue_script( 'timeline-express-admin-js', TIMELINE_EXPRESS_URL . 'lib/admin/js/min/timeline-express-admin.min.js', array( 'jquery' ), TIMELINE_EXPRESS_VERSION_CURRENT, true );

		}

	} /* Final Function */

}

$timeline_express_admin = new TimelineExpressAdmin();
