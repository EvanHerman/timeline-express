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

	/**
	 * MyClass Class Doc Comment
	 *
	 * @category Class
	 * @package  MyClass
	 * @author    A NOther
	 * @license  http://www.gnu.org/copyleft/gpl.html GNU General Public License
	 * @link     http://www.hashbangcode.com/
	 */
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
			/* Generate our admin menus */
			add_action( 'admin_menu' , array( $this, 'timeline_express_admin_menus' ) );
			/* Sanitize and store our options when they are saved */
			add_action( 'admin_init', array( $this, 'timeline_express_save_options' ) );
			/* Custom admin notices for Timeline Express */
			add_action( 'admin_notices', array( $this, 'timeline_express_admin_notices' ) );
			/* Add our TinyMCE button that generates our shortcode for the user */
			add_action( 'admin_head', array( $this, 'timeline_express_add_tinymce' ) );
			/* Define our [timeline-express] shortcode, so it's usable on the frontend */
			add_shortcode( 'timeline-express', array( $this, 'process_timeline_express_shortcode' ) );
			/** Filter the single announcement content. */
			add_filter( 'the_content', array( $this, 'timeline_express_single_page_content' ) );
			/** Enqueue single announcement template styles */
			add_action( 'wp_enqueue_scripts', array( $this, 'timeline_express_single_template_styles' ) );
			/*
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
			 *
			 * @since 1.2
			 */
			 add_action( 'admin_enqueue_scripts' , array( $this, 'add_timeline_express_admin_scripts_and_styles' ) );
		}

		/**
		 * Plugin activation function
		 *
		 * @package  TimelineExpressBase
		 */
		public function activate() {
				update_option( 'timeline_express_do_activation_redirect', true );
		}

		/**
		 * Generate administrative menus
		 *
		 * @package  TimelineExpressBase
		 */
		public function timeline_express_admin_menus() {
			/* Settings Page */
			add_submenu_page(
				'edit.php?post_type=te_announcements',
				__( 'Timeline Express Settings','timeline-express' ),
				__( 'Settings', 'timeline-express' ),
				'manage_options',
				'timeline-express-settings',
				array( $this, 'timeline_express_options_page' )
			);
			/* Welcome Page */
			add_submenu_page('options.php',
				__( 'Timeline Express Welcome', 'timeline-express' ),
				__( 'Timeline Express Welcome', 'timeline-express' ),
				'manage_options',
				'timeline-express-welcome',
				array( $this, 'timeline_express_welcome_page' )
			);
		}

		/**
		 * Sanitize and save our options to the database
		 *
		 * @package  TimelineExpressBase
		 */
		public function timeline_express_save_options() {
			if ( isset( $_POST['save-timeline-express-options'] ) && 'true' === $_POST['save-timeline-express-options'] ) {
				/* Retreive our default options to update */
				$timeline_express_options = timeline_express_get_options();
				$timeline_express_options['announcement-time-frame'] = sanitize_text_field( $_POST['announcement-time-frame'] );
				$timeline_express_options['announcement-display-order'] = sanitize_text_field( $_POST['announcement-display-order'] );
				$timeline_express_options['excerpt-trim-length'] = (int) sanitize_text_field( $_POST['excerpt-trim-length'] );
				$timeline_express_options['excerpt-random-length'] = (int) ( isset( $_POST['excerpt-random-length'] ) ) ? 1 : 0;
				$timeline_express_options['date-visibility'] = sanitize_text_field( $_POST['date-visibility'] );
				$timeline_express_options['read-more-visibility'] = sanitize_text_field( $_POST['read-more-visibility'] );
				$timeline_express_options['default-announcement-icon'] = sanitize_text_field( $_POST['default-announcement-icon'] );
				$timeline_express_options['default-announcement-color'] = sanitize_text_field( $_POST['default-announcement-color'] );
				$timeline_express_options['announcement-bg-color'] = sanitize_text_field( $_POST['announcement-bg-color'] );
				$timeline_express_options['announcement-box-shadow-color'] = sanitize_text_field( $_POST['announcement-box-shadow-color'] );
				$timeline_express_options['announcement-background-line-color'] = sanitize_text_field( $_POST['announcement-background-line-color'] );
				$timeline_express_options['no-events-message'] = sanitize_text_field( $_POST['no-events-message'] );
				$timeline_express_options['announcement-appear-in-searches'] = sanitize_text_field( $_POST['announcement-appear-in-searches'] );
				update_option( TIMELINE_EXPRESS_OPTION, $timeline_express_options );
				wp_redirect( esc_url_raw( add_query_arg( array( 'settings-updated' => true ), admin_url( 'edit.php?post_type=te_announcements&page=timeline-express-settings' ) ) ) );
				exit;
			}
		}

		/**
		 * Display admin notices in certain locations
		 *
		 * @package  TimelineExpressBase
		 */
		public function timeline_express_admin_notices() {
			if ( isset( $_GET['settings-updated'] ) && true == $_GET['settings-updated'] ) {
				?>
				<div class="notice notice-success">
					<p><?php esc_attr_e( 'Timeline Express Settings Updated', 'timeline-express' ); ?></p>
				</div>
				<?php
			}
		}

		/**
		 * Add our tinyMCE button, and scripts to the WP_Editor() instance
		 *
		 * @package  TimelineExpressBase
		 */
		public function timeline_express_add_tinymce() {
			global $typenow;
			/* Only on Post Type: Post and Page */
			if ( ! in_array( $typenow, apply_filters( 'timeline-express-tinymce-post-types', array( 'page', 'post' ) ), true ) ) {
				return;
			}
			add_filter( 'mce_external_plugins', array( $this, 'timeline_express_add_tinymce_plugin' ) );
			add_filter( 'mce_buttons', array( $this, 'timeline_express_add_tinymce_button' ) );
		}

		/**
		 * Define and process [timeline-express] shortcode
		 *
		 * @param array $atts array of shortcode attributes.
		 * @package  TimelineExpressBase
		 */
		public function process_timeline_express_shortcode( $atts ) {
			include TIMELINE_EXPRESS_PATH . 'lib/classes/class.timeline-express-initialize.php';
			$timeline_express = new Timeline_Express_Initialize( $atts );
			return $timeline_express->generate_timeline_express( timeline_express_get_options(), $atts );
		}

		/**
		 * Filter the content, and load our template in it's place.
		 *
		 * @param array $the_content The page content to filter.
		 * @return page template.
		 */
		public function timeline_express_single_page_content( $the_content ) {
			global $post;
			if ( is_single() && 'te_announcements' === $post->post_type ) {
				ob_start();
				/* Include helper functions */
				include_once TIMELINE_EXPRESS_PATH . 'lib/helpers.php';
				/**
				 * Check if a file exists locally (theme root), and load it.
				 * Users can create a directory (timeline-express), and copy over the announcement template into the theme root.
				 *
				 * @since 1.2
				 */
				if ( file_exists( get_template_directory() . '/timeline-express/single.timeline-express.php' ) ) {
					include( get_template_directory() . '/timeline-express/single.timeline-express.php' );
				} else {
					include( TIMELINE_EXPRESS_PATH . 'lib/public/partials/single.timeline-express.php' );
				}
				/* Return the output buffering */
				$the_content = ob_get_clean();
			}
			return $the_content;
		}
		/**
		 * Enqueue styles on single announcement templates.
		 *
		 * @return null
		 */
		public function timeline_express_single_template_styles() {
			global $post;
			if ( is_single() && 'te_announcements' === $post->post_type ) {
				wp_enqueue_style( 'single-timeline-express-styles', TIMELINE_EXPRESS_URL . 'lib/public/css/min/timeline-express-single-page.min.css', array(), 'all' );
			}
			return;
		}
		/**
		 * Add our tinyMCE plugin to the tinyMCE WordPress instance
		 *
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
		 *
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
		 *
		 * @since 1.2
		 * @package included in TimelineExpressBase->timeline_express_admin_menus()
		 */
		function timeline_express_options_page() {
			require_once TIMELINE_EXPRESS_PATH . 'lib/admin/pages/page.options.php';
		}

		/**
		 * Inclue our welcome page
		 *
		 * @since 1.2
		 * @package included in TimelineExpressBase->timeline_express_admin_menus()
		 */
		function timeline_express_welcome_page() {
			require_once TIMELINE_EXPRESS_PATH . 'lib/admin/pages/page.welcome.php';
		}

		/**
		 * Register Announcement Custom Post Type
		 * Register Announcement Custom Post Type Columns
		 *
		 * @since 1.2
		 */
		public function timeline_express_generate_announcement_post_type() {
			$timeline_express_options = timeline_express_get_options();
			include_once TIMELINE_EXPRESS_PATH . 'lib/admin/cpt/cpt.announcements.php';
			include_once TIMELINE_EXPRESS_PATH . 'lib/admin/cpt/timeline-express-admin-columns.php';
		}

		/**
		 * Conditionally enqueue our scripts and styles on the dashboard, where needed.
		 *
		 * @since 1.2
		 */
		public function add_timeline_express_admin_scripts_and_styles() {
			$screen = get_current_screen();
			$load_styles_on_pages = array( 'te_announcements_page_timeline-express-settings', 'admin_page_timeline-express-welcome' );
			if ( in_array( $screen->base, $load_styles_on_pages, true ) || 'te_announcements' === $screen->post_type ) {
				/* Register Styles */
				wp_enqueue_style( 'timeline-express-css-base', TIMELINE_EXPRESS_URL . 'lib/admin/css/min/timeline-express-settings.min.css' , array(), TIMELINE_EXPRESS_VERSION_CURRENT, 'all' );
				/* Enqueue font awesome icons, defined in helpers.php */
				timeline_express_enqueue_font_awesome();

				/*
				 * Enqueue bootstrap select/styles
				 * Note: Minified .js file includes -
				 * admin/js/bootstrap-select.js
				 * admin/js/script.options-color-picker-custom.js
				 */
				wp_enqueue_script( 'timeline-express-admin-js', TIMELINE_EXPRESS_URL . 'lib/admin/js/min/timeline-express-admin.min.js', array( 'jquery' ), TIMELINE_EXPRESS_VERSION_CURRENT, true );
				wp_enqueue_script( 'bootstrap-min', '//netdna.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js' );
				wp_enqueue_style( 'bootstrap-select-style',  TIMELINE_EXPRESS_URL . 'lib/admin/css/min/bootstrap-select.min.css' );
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
