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
class Timeline_Express_Admin {
	/**
	 * Main constructor
	 */
	public function __construct() {

		include_once( TIMELINE_EXPRESS_PATH . 'lib/classes/class-timeline-express-2-week-notice.php' );

		new Timeline_Express_Two_Weeks_Notice();

		include_once( TIMELINE_EXPRESS_PATH . 'lib/classes/class-timeline-express-blocks.php' );

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

		/* Add our announcement met adata to the REST API */
		add_action( 'rest_api_init', array( $this, 'timeline_express_rest_api' ) );

		/* Flush the transients when the button is pressed */
		add_action( 'admin_init', array( $this, 'timeline_express_flush_cache' ) );

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

		add_action( 'wp_ajax_timeline_express_add_on_installer', array( $this, 'timeline_express_add_on_installer' ) ); // Install add-on
		add_action( 'wp_ajax_timeline_express_add_on_activation', array( $this, 'timeline_express_add_on_activation' ) ); // Activate add-on

		add_action( 'wp_ajax_timeline_express_toggle_cache', array( $this, 'toggle_cache' ) );

		add_filter( 'use_block_editor_for_post_type', array( $this, 'disable_block_editor' ), 10, 2 );

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
			esc_html__( 'Timeline Express Settings', 'timeline-express' ),
			esc_html__( 'Settings', 'timeline-express' ),
			$menu_cap,
			'timeline-express-settings',
			array( $this, 'timeline_express_options_page' )
		);

		/* Addon Page */
		add_submenu_page(
			'edit.php?post_type=te_announcements',
			esc_html__( 'Timeline Express Add-Ons', 'timeline-express' ),
			'<span style="color:#F7A933">' . esc_html__( 'Add-Ons', 'timeline-express' ) . '<span>',
			$menu_cap,
			'timeline-express-addons',
			array( $this, 'timeline_express_addons_page' )
		);

		/* Welcome Page */
		add_submenu_page(
			'edit.php?post_type=te_announcements',
			esc_html__( 'Timeline Express Welcome', 'timeline-express' ),
			esc_html__( 'Welcome', 'timeline-express' ),
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
		require_once TIMELINE_EXPRESS_PATH . 'lib/classes/class-timeline-express-addons.php';

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

		$settings_updated = filter_input( INPUT_GET, 'settings-updated', FILTER_SANITIZE_STRING );

		// When the settings were not updated, or it isn't set to true, abort
		if ( $settings_updated && 'true' === $settings_updated ) {

			?>

			<div class="notice notice-success">

				<p>
					<span class="dashicons dashicons-yes"></span> <?php esc_html_e( 'Timeline Express settings saved successfully!', 'timeline-express' ); ?>
				</p>

			</div>

			<?php

		}

		$cache_flushed = filter_input( INPUT_GET, 'cache_flushed', FILTER_SANITIZE_STRING );

		// When the settings were not updated, or it isn't set to true, abort
		if ( $cache_flushed && 'true' === $cache_flushed ) {

			?>

			<div class="notice notice-success">

				<p>
					<span class="dashicons dashicons-yes"></span> <?php esc_html_e( 'Timeline Express cache flushed.', 'timeline-express' ); ?>
				</p>

			</div>

			<?php

		}

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
		.menu-icon-te_announcements .wp-menu-image img {
			padding: 6px 0 0 !important;
			width: 20px;
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
		if ( ! in_array( get_post_type( $post_id ), array( 'te_announcements', 'post', 'page' ), true ) ) {

			return;

		}

		// When a revision, abort
		if ( wp_is_post_revision( $post_id ) ) {

			return;

		}

		// If post or page, delete single transient
		if ( in_array( get_post_type( $post_id ), array( 'post', 'page' ), true ) ) {

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
	 * Process the cache flush button press.
	 *
	 * @since 1.6.1
	 */
	public function timeline_express_flush_cache() {

		$nonce = filter_input( INPUT_GET, '_wpnonce', FILTER_SANITIZE_STRING );

		if ( ! $nonce || ! wp_verify_nonce( $nonce, 'flush_cache' ) ) {

			return;

		}

		delete_timeline_express_transients();

		wp_safe_redirect( admin_url( 'edit.php?post_type=te_announcements&page=timeline-express-settings&cache_flushed=true' ), 200 );

		exit;

	}

	/**
	 * Expose our announcement meta data to the REST API
	 *
	 * @since 1.3.6
	 */
	public function timeline_express_rest_api() {

		if ( ! function_exists( 'register_rest_field' ) ) {

			return;

		}

		register_rest_field(
			'te_announcements',
			'announcement_date',
			array(
				'get_callback' => array( $this, 'get_announcement_date' ),
				'schema'       => null,
			)
		);

		register_rest_field(
			'te_announcements',
			'announcement_image',
			array(
				'get_callback' => array( $this, 'get_announcement_image' ),
				'schema'       => null,
			)
		);

	}

	/**
	 * Return the announcement date to the REST API
	 *
	 * @param  object $object     The field object.
	 * @param  string $field_name The name of the field.
	 * @param  string $request    The request type.
	 *
	 * @since 1.3.6
	 *
	 * @return string
	 */
	function get_announcement_date( $object, $field_name, $request ) {

		return sprintf(
			/* translators: Announcement date format */
			apply_filters( 'timeline_express_announcement_date_text', __( 'Announcement Date: %s', 'timeline-express' ) ),
			wp_kses_post( timeline_express_get_announcement_date( $object['id'] ) )
		);

	}

	/**
	 * Return the announcement date to the REST API
	 *
	 * @param  object $object     The field object.
	 * @param  string $field_name The name of the field.
	 * @param  string $request    The request type.
	 *
	 * @since 1.3.6
	 *
	 * @return string
	 */
	function get_announcement_image( $object, $field_name, $request ) {

		$image_id = get_post_meta( $object['id'], 'announcement_image_id', true );

		if ( ! $image_id ) {

			return false;

		}

		$image_url = get_post_meta( $object['id'], 'announcement_image', true );

		/**
		 * Filter the announcement image data in the REST response.
		 *
		 * @var array
		 */
		return (array) apply_filters(
			'timeline_express_popups_addon_announcement_image',
			array(
				'iframe' => false,
				'url'    => $image_url ? esc_url( $image_url ) : false,
			),
			$image_id
		);

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

				?>
				<style>.cmb-type-te-bootstrap-dropdown{ display: none !important; }</style><?php

			}

			$rtl = is_rtl() ? '-rtl' : '';

			/* Register Styles */
			wp_enqueue_style( 'timeline-express-css-base', TIMELINE_EXPRESS_URL . "lib/admin/css/min/timeline-express-admin{$rtl}.min.css", array(), TIMELINE_EXPRESS_VERSION_CURRENT, 'all' );

			/* Enqueue font awesome icons, defined in helpers.php */
			timeline_express_enqueue_font_awesome();

			/*
			 * Enqueue bootstrap select/styles
			 * Note: Minified .js file includes
			 * lib/admin/js/timeline-express-settings.js
			 * admin/js/bootstrap-select.js
			 * admin/js/script.options-color-picker-custom.js
			 */
			wp_enqueue_script( 'timeline-express-admin-js', TIMELINE_EXPRESS_URL . 'lib/admin/js/min/timeline-express-admin.min.js', array( 'jquery' ), TIMELINE_EXPRESS_VERSION_CURRENT, true );

			wp_localize_script(
				'timeline-express-admin-js',
				'timelineExpressSettings',
				array(
					'siwtchLabels' => array(
						'default'     => array(
							'enabled'  => __( 'Enabled.', 'timeline-express' ),
							'disabled' => __( 'Disabled.', 'timeline-express' ),
						),
						'toggleCache' => array(
							'enabled'  => __( 'Cache is enabled.', 'timeline-express' ),
							'disabled' => __( 'Cache is disabled.', 'timeline-express' ),
						),
					),
				)
			);

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

	/**
	 * cnkt_plugin_installer
	 * An Ajax method for installing plugin.
	 *
	 * @return $json
	 *
	 * @since 1.0
	*/
	public function timeline_express_add_on_installer() {

		if ( ! current_user_can( 'install_plugins' ) ) {

			wp_die( __( 'Sorry, you are not allowed to install plugins on this site.', 'timeline-express' ) );

		}

		// Check our nonce, if they don't match then bounce!
		if ( ! wp_verify_nonce( filter_input( INPUT_POST, 'nonce', FILTER_SANITIZE_STRING ), 'timeline_express_add_on_install_nonce' ) ) {

			wp_die( __( 'Error - unable to verify nonce, please try again.', 'timeline-express' ) );

		}

		$plugin = filter_input( INPUT_POST, 'plugin', FILTER_SANITIZE_STRING );

		if ( ! $plugin ) {

			wp_send_json_error();

		}

		// Include required libs for installation
		require_once( ABSPATH . 'wp-admin/includes/plugin-install.php' );
		require_once( ABSPATH . 'wp-admin/includes/class-wp-upgrader.php' );
		require_once( ABSPATH . 'wp-admin/includes/class-wp-ajax-upgrader-skin.php' );
		require_once( ABSPATH . 'wp-admin/includes/class-plugin-upgrader.php' );

		// Get Plugin Info
		$api = plugins_api(
			'plugin_information',
			array(
				'slug'   => $plugin,
				'fields' => array(
					'short_description' => false,
					'sections'          => false,
					'requires'          => false,
					'rating'            => false,
					'ratings'           => false,
					'downloaded'        => false,
					'last_updated'      => false,
					'added'             => false,
					'tags'              => false,
					'compatibility'     => false,
					'homepage'          => false,
					'donate_link'       => false,
				),
			)
		);

		$skin     = new WP_Ajax_Upgrader_Skin();
		$upgrader = new Plugin_Upgrader( $skin );

		$upgrader->install( $api->download_link );

		$status = $api->name ? 'success' : 'failed';
		$msg    = $api->name ? sprintf(
			'%s successfully installed.',
			esc_html( $api->name )
		) : sprintf(
			'There was an error installing %s.',
			esc_html( $api->name )
		);

		$json = array(
			'status' => $status,
			'msg'    => $msg,
		);

		wp_send_json( $json );

	}

	/**
	 * cnkt_plugin_activation
	 * Activate plugin via Ajax.
	 *
	 * @return $json
	 *
	 * @since 1.0
	*/
	public function timeline_express_add_on_activation() {

		if ( ! current_user_can( 'install_plugins' ) ) {

			wp_die( __( 'Sorry, you are not allowed to activate plugins on this site.', 'timeline-express' ) );

		}

		// Check our nonce, if they don't match then bounce!
		if ( ! wp_verify_nonce( filter_input( INPUT_POST, 'nonce', FILTER_SANITIZE_STRING ), 'timeline_express_add_on_install_nonce' ) ) {

			wp_die( __( 'Error - unable to verify nonce, please try again.', 'timeline-express' ) );

		}

		// Include required libs for activation
		require_once( ABSPATH . 'wp-admin/includes/plugin-install.php' );
		require_once( ABSPATH . 'wp-admin/includes/class-wp-upgrader.php' );
		require_once( ABSPATH . 'wp-admin/includes/class-plugin-upgrader.php' );

		$plugin  = filter_input( INPUT_POST, 'plugin', FILTER_SANITIZE_STRING );
		$premium = filter_input( INPUT_POST, 'premium', FILTER_SANITIZE_NUMBER_INT );

		if ( $premium ) {

			if ( is_wp_error( activate_plugin( $plugin . '/' . $plugin . '.php' ) ) ) {

				wp_send_json_error(
					array(
						'status' => 'error',
						'msg'    => sprintf(
							/* translators: The name of the plugin. */
							__( 'Failed to activate %s.', 'timeline-express' ),
							esc_html( $plugin )
						),
					)
				);

			}

			wp_send_json(
				array(
					'status' => 'success',
					'msg'    => sprintf(
						/* translators: The name of the plugin. */
						__( '%s successfully activated.', 'timeline-express' ),
						esc_html( $plugin )
					),
				)
			);

		}

		// Get Plugin Info
		$api = plugins_api(
			'plugin_information',
			array(
				'slug'   => $plugin,
				'fields' => array(
					'short_description' => false,
					'sections'          => false,
					'requires'          => false,
					'rating'            => false,
					'ratings'           => false,
					'downloaded'        => false,
					'last_updated'      => false,
					'added'             => false,
					'tags'              => false,
					'compatibility'     => false,
					'homepage'          => false,
					'donate_link'       => false,
				),
			)
		);

		if ( $api->name ) {

			$main_plugin_file = $api->slug . '/' . $api->slug . '.php';

			if ( 'timeline-express-html-excerpt-add-on' === $api->slug ) {

				$main_plugin_file = 'timeline-express-html-excerpt-add-on/timeline-express-html-excerpts-add-on.php';

			}

			if ( $main_plugin_file ) {

				activate_plugin( $main_plugin_file );

				$status = 'success';
				$msg    = sprintf(
					/* translators: The name of the plugin. */
					__( '%s successfully activated.', 'timeline-express' ),
					esc_html( $api->name )
				);

			} // @codingStandardsIgnoreLine

		} else {

			$status = 'failed';
			$msg    = sprintf(
				/* translators: The name of the plugin. */
				__( 'There was an error activating %s.', 'timeline-express' ),
				esc_html( $api->name )
			);

		}

		$json = array(
			'status' => $status,
			'msg'    => $msg,
		);

		wp_send_json( $json );

	}

	/**
	 * Toggle the cache state via AJAX request.
	 * Note: Fires when the switch in the 'Flush Cached Data' checkbox is toggled.
	 *
	 * @return null
	 */
	public function toggle_cache() {

		$cache_enabled = filter_input( INPUT_POST, 'cacheEnabled', FILTER_SANITIZE_STRING );
		$cache_enabled = ( 'true' === $cache_enabled ) ? 1 : 0;

		update_option( 'timeline_express_cache_enabled', $cache_enabled );

		wp_send_json_success( $cache_enabled );

	}

	/**
	 * Disable the block editor for Announcement post types.
	 *
	 * @param  boolean $is_enabled Whether or not the block editor is enabled.
	 * @param  string  $post_type  Post type name.
	 *
	 * @since 1.7.4
	 *
	 * @return boolean False to disable the block editor
	 */
	public function disable_block_editor( $is_enabled, $post_type ) {

		if ( 'te_announcements' !== $post_type ) {

			return $is_enabled;

		}

		return false;

	}

}

$timeline_express_admin = new Timeline_Express_Admin();
