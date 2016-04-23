<?php
/**
 * Timeline Express :: Base Class
 * By Code Parrots
 *
 * @link http://www.codeparrots.com
 *
 * @package WordPress
 * @subpackage Component
 * @since 1.2
 **/

if ( ! class_exists( 'TimelineExpressBase' ) ) {

	class TimelineExpressBase {
		/**
		 * Main constructor
		 */
		public function __construct() {
			/* Include helper functions */
			include_once TIMELINE_EXPRESS_PATH . 'lib/helpers.php';
			/* Register our custom timeline express image size (350px x 120px) */
			add_image_size( 'timeline-express', '350', '120', true );
			/* Regiser our custom timeline express thumbnail image size (200px x 120px) - Used in the admin table */
			add_image_size( 'timeline-express-thumbnail', '200', '120', true );
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
			/* Define our [timeline-express] shortcode, so it's usable on the frontend */
			add_shortcode( 'timeline-express', array( $this, 'process_timeline_express_shortcode' ) );
			/* load our custom post type single template (override the default) */
			add_filter( 'single_template', array( $this, 'timeline_express_single_announcement_template' ) );
			/* Filter the single announcement content. */
			add_filter( 'the_content', array( $this, 'timeline_express_single_page_content' ) );
			/* Enqueue single announcement template styles */
			add_action( 'wp_enqueue_scripts', array( $this, 'timeline_express_single_template_styles' ) );
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
		 * Plugin activation function
		 */
		public function timeline_express_activate() {
			/* Setup the plugin activation redirect */
			update_option( 'timeline_express_do_activation_redirect', true );
		}

		/**
		 * Plugin deactivation function
		 */
		public function timeline_express_deactivate() {
			/* Clear the re-write rules, so on next activation we can re-flush them */
			delete_option( 'post_type_rules_flushed_te-announcements' );
		}

		/**
		 * Plugin deactivation function
		 */
		public function timeline_express_activate_redirect() {
			/* User can disable the activation redirect, if it gets annoying */
			if ( defined( 'TIMELINE_EXPRESS_DISABLED_ACTIVATION_REDIRECT' ) ) {
				return;
			}
			if ( get_option( 'timeline_express_do_activation_redirect', false ) ) {
				delete_option( 'timeline_express_do_activation_redirect' );
				// Check if this is an update or first install
				$announcement_count = wp_count_posts( 'te_announcements' );
				if ( ! isset( $announcement_count ) || 0 === $announcement_count->publish ) {
					/* Redirect to the welcome page -  Initial install */
					wp_safe_redirect( admin_url( 'admin.php?page=timeline-express-welcome' ) );
				} else {
					/* Redirect to the welcome page (whats new tab)-  Update install */
					wp_safe_redirect( admin_url( 'admin.php?page=timeline-express-welcome&tab=whats-new' ) );
				}
			}
		}

		/**
		 * Generate administrative menus
		 * @package  TimelineExpressBase
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
				__( 'Timeline Express Addons', 'timeline-express' ),
				'<span style="color:#F7A933">' . __( 'Addons', 'timeline-express' ) . '<span>',
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
		 * Register the Timeline Express settings
		 * @package  TimelineExpressBase
		 */
		public function timeline_express_register_settings() {
			register_setting( 'timeline-express-settings', 'timeline_express_storage', array( $this, 'timeline_express_save_options' ) );
			/* Plugin redirect */
			self::timeline_express_activate_redirect();
		}

		/**
		 * Sanitize and save our options to the database
		 * @package  TimelineExpressBase
		 * @param array $options Options array to update.
		 */
		public function timeline_express_save_options( $options ) {
			// When the nonce is not set, abort
			if ( ! isset( $_POST['timeline_express_settings_nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['timeline_express_settings_nonce'] ) ), 'timeline_express_save_settings' ) ) {
				wp_die( esc_attr__( 'Sorry, the nonce security check did not pass. Please go back to the settings page, refresh the page and try to save your settings again.', 'timeline-express' ), __( 'Failed Nonce Security Check', 'timeline-express' ), array(
					'response' => 500,
					'back_link' => true,
					'text_direction' => ( is_rtl() ) ? 'rtl' : 'ltr',
				) );
			}
			/* Retreive our default options to update */
			$timeline_express_options = timeline_express_get_options();
			/* Update our options */
			$timeline_express_options['announcement-time-frame'] = sanitize_text_field( $options['announcement-time-frame'] );
			$timeline_express_options['announcement-display-order'] = sanitize_text_field( $options['announcement-display-order'] );
			$timeline_express_options['excerpt-trim-length'] = (int) sanitize_text_field( $options['excerpt-trim-length'] );
			$timeline_express_options['excerpt-random-length'] = (int) ( isset( $options['excerpt-random-length'] ) ) ? 1 : 0;
			$timeline_express_options['date-visibility'] = sanitize_text_field( $options['date-visibility'] );
			$timeline_express_options['read-more-visibility'] = sanitize_text_field( $options['read-more-visibility'] );
			$timeline_express_options['default-announcement-icon'] = sanitize_text_field( $options['default-announcement-icon'] );
			$timeline_express_options['default-announcement-color'] = sanitize_text_field( $options['default-announcement-color'] );
			$timeline_express_options['announcement-bg-color'] = sanitize_text_field( $options['announcement-bg-color'] );
			$timeline_express_options['announcement-box-shadow-color'] = sanitize_text_field( $options['announcement-box-shadow-color'] );
			$timeline_express_options['announcement-background-line-color'] = sanitize_text_field( $options['announcement-background-line-color'] );
			$timeline_express_options['no-events-message'] = sanitize_text_field( $options['no-events-message'] );
			$timeline_express_options['announcement-appear-in-searches'] = sanitize_text_field( $options['announcement-appear-in-searches'] );
			$timeline_express_options['delete-announcement-posts-on-uninstallation'] = (int) ( isset( $options['delete-announcement-posts-on-uninstallation'] ) ) ? 1 : 0;
			$timeline_express_options['disable-animation'] = (int) ( isset( $options['disable-animation'] ) ) ? 1 : 0;
			/* Delete the transient, to refresh the frontend timeline (display order, excerpt length etc.) */
			delete_transient( 'timeline-express-query' );
			return $timeline_express_options;
		}

		/**
		 * Display admin notices in certain locations
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
				<p><span class="dashicons dashicons-yes"></span> <?php esc_attr_e( 'Timeline Express settings saved successfully!', 'timeline-express' ); ?></p>
			</div>
			<?php
		}

		/**
		 * Add our tinyMCE button, and scripts to the WP_Editor() instance
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
		 * Define and process [timeline-express] shortcode
		 *
		 * @param array $atts array of shortcode attributes.
		 * @since  1.0
		 */
		public function process_timeline_express_shortcode( $atts ) {
			include TIMELINE_EXPRESS_PATH . 'lib/classes/class.timeline-express-initialize.php';
			$timeline_express = new Timeline_Express_Initialize( $atts );
			return $timeline_express->generate_timeline_express( timeline_express_get_options(), $atts );
		}

		/**
		 * Filter the content, and load our template in it's place.
		 * @param array  $the_content The page content to filter.
		 * @return array The single page content to display for this announcement.
		 * @since  1.0
		 */
		public function timeline_express_single_page_content( $the_content ) {
			global $post;
			$post_id = ( isset( $post->ID ) ) ? $post->ID : '';
			// When this is not a single post, or it is and it isn't an announcement, abort
			if ( ! is_single() || 'te_announcements' !== $post->post_type ) {
				return $the_content;
			}
			ob_start();
			/* Store the announcement content from the WYSIWYG editor */
			$announcement_content = $the_content;
			/* Include helper functions */
			include_once TIMELINE_EXPRESS_PATH . 'lib/helpers.php';
			/* Include the single template */
			get_timeline_express_template( 'single-announcement' );
			/* Return the output buffering */
			$the_content = ob_get_clean();
			/* Return announcement meta & append the announcement content */
			return apply_filters( 'timeline_express_single_content', $the_content . $announcement_content, $post_id );
		}

		/**
		 * Decide what template file to use to display single announcements.
		 * 	First checks for a directory in the theme root /timeline-express/single-te_announcements.php,
		 *  Next it checks for a single.php template in the theme root
		 *  Next it checksf or a page.php template in the theme root
		 *  If all else fails, it will use the default template defined by WordPress.
		 * @param  string $single_template The page template name to be used for single announcements.
		 * @return string                  The page template to be used for the single announcements.
		 * @since 1.2
		 */
		public function timeline_express_single_announcement_template( $single_template ) {
			global $post;
			if ( ! isset( $post->post_type ) && 'te_announcements' !== $post->post_type ) {
				return $single_template;
			}
			/* If custom template file exists */
			if ( file_exists( get_template_directory() . '/timeline-express/single-te_announcements.php' ) ) {
				$single_template = get_template_directory() . '/timeline-express/single-te_announcements.php';
			} else if ( file_exists( get_template_directory() . 'single.php' ) ) {
				/* If single.php exists */
				$single_template = get_template_directory() . 'single.php';
			} else if ( file_exists( get_template_directory() . 'page.php' ) ) {
				/* If page.php exists */
				$single_template = get_template_directory() . 'page.php';
			}
			/**
			 * Return our template, passed through filters
			 * Legacy Support, 2 filters
			 */
			return apply_filters( 'timeline_express_single_page_template', apply_filters( 'timeline-express-single-page-template', $single_template ) );
		}
		/**
		 * Enqueue styles on single announcement templates.
		 * @return null
		 * @since 1.2
		 */
		public function timeline_express_single_template_styles() {
			global $post;
			// When this is not a single post, or it is but is not an announcement
			if ( ! is_single() || 'te_announcements' !== $post->post_type ) {
				return;
			}
			wp_enqueue_style( 'single-timeline-express-styles', TIMELINE_EXPRESS_URL . 'lib/public/css/min/timeline-express.min.css', array(), 'all' );
		}

		/**
		 * Custom plugin action links.
		 * @param  array $links  array of links to display for our plugin.
		 * @param  string $file  The file name of the current iteration.
		 * @return array         New array of links to display.
		 * @since 1.2
		 */
		public function timeline_express_action_links( $links, $file ) {
			if ( 'timeline-express/timeline-express.php' !== $file ) {
				return $links;
			}
			/* Remove the edit button */
			unset( $links['edit'] );
			$links[] = '<a href="' . admin_url( 'edit.php?post_type=te_announcements&page=timeline-express-settings' ) . '">' . esc_attr__( 'Settings', 'timeline-express' ) . '</a>';
			$links[] = '<a href="' . admin_url( 'edit.php?post_type=te_announcements&page=timeline-express-addons' ) . '">' . esc_attr__( 'Addons', 'timeline-express' ) . '</a>';
			$links[] = '<a href="http://www.wp-timelineexpress.com/knowledgebase_category/timeline-express/" target="_blank">' . esc_attr__( 'Documentation', 'timeline-express' ) . '</a>';
			return $links;
		}

		/**
		 * Whenever an announcement is updated/published reset the 'timeline-express-query' transient
		 * @since 1.2
		 */
		public function timeline_express_reset_transients( $post_id ) {
			// When not an announcement post, abort
			if ( 'te_announcements' !== get_post_type( $post_id ) ) {
				return;
			}
			// When a revision, abort
			if ( wp_is_post_revision( $post_id ) ) {
				return;
			}
			// Clear our transient
			delete_transient( 'timeline-express-query' );
		}

		/**
		 * Add our tinyMCE plugin to the tinyMCE WordPress instance
		 * @package  TimelineExpressBase
		 * @param array $plugin_array Array of default tinyMCE plugins.
		 * @return tinyMCE plugin array
		 */
		public function timeline_express_add_tinymce_plugin( $plugin_array ) {
			$plugin_array['timeline_express'] = plugins_url( 'timeline-express/lib/admin/js/min/timeline-express-tinymce.min.js' );
			return $plugin_array;
		}

		/**
		 * Add our tinyMCE plugin to the tinyMCE WordPress instance
		 * @package  TimelineExpressBase
		 * @param array $buttons Array of default tinyMCE buttons.
		 * @return tinyMCE buttons array
		 */
		public function timeline_express_add_tinymce_button( $buttons ) {
			array_push( $buttons, 'timeline_express_shortcode_button' );
			return $buttons;
		}

		/**
		 * Inclue our options page
		 * @since 1.2
		 * @package included in TimelineExpressBase->timeline_express_admin_menus()
		 */
		public function timeline_express_options_page() {
			require_once TIMELINE_EXPRESS_PATH . 'lib/admin/pages/page.options.php';
		}

		/**
		 * Inclue our welcome page
		 * @since 1.2
		 * @package included in TimelineExpressBase->timeline_express_admin_menus()
		 */
		public function timeline_express_welcome_page() {
			require_once TIMELINE_EXPRESS_PATH . 'lib/admin/pages/page.welcome.php';
		}

		/**
		 * Inclue our addons page
		 * @since 1.2
		 * @package included in TimelineExpressBase->timeline_express_admin_menus()
		 */
		public function timeline_express_addons_page() {
			/* Include the addons class */
			require_once TIMELINE_EXPRESS_PATH . 'lib/classes/class.timeline-express-addons.php';
		}

		/**
		 * Re-arrange the metbaoxes on our announcements custom post type.
		 * @since 1.0
		 * @return null
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
		 * Register Announcement Custom Post Type
		 * Register Announcement Custom Post Type Columns
		 * @since 1.2
		 */
		public function timeline_express_generate_announcement_post_type() {
			include_once TIMELINE_EXPRESS_PATH . 'lib/admin/cpt/cpt.announcements.php';
			include_once TIMELINE_EXPRESS_PATH . 'lib/admin/cpt/timeline-express-admin-columns.php';
		}

		/**
		 * Conditionally enqueue our scripts and styles on the dashboard, where needed.
		 * @since 1.2
		 */
		public function add_timeline_express_admin_scripts_and_styles() {
			$screen = get_current_screen();
			$load_styles_on_pages = array( 'te_announcements_page_timeline-express-settings', 'te_announcements_page_timeline-express-welcome' );
			if ( in_array( $screen->base, $load_styles_on_pages, true ) || 'te_announcements' === $screen->post_type ) {
				/* Register Styles */
				wp_enqueue_style( 'timeline-express-css-base', TIMELINE_EXPRESS_URL . 'lib/admin/css/min/timeline-express-admin.min.css', array(), TIMELINE_EXPRESS_VERSION_CURRENT, 'all' );
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
}
