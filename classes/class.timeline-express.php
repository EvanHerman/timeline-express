<?php
// Timeline Express :: Base Class 
// By Evan Herman
// http://www.Evan-Herman.com
/***************************************/
if(!class_exists("timelineExpressBase"))
	{
  class timelineExpressBase
		{
		
			/**
			 *	Variables
			 */
			public	$sessName = 'timeline_express_session';
			public	$timeline_express_optionVal = false;

			/**
			 *	Construct
			 */
			public function __construct() {
					timelineExpressBase::initialize();
				}

			/**
			 *	Destruct
			 */
			public function __destruct() {
					unset($this);
				}

			/**
			 *	ACTIONS
			 *	These are called when the plugin is initialized/deactivated/uninstalled
			 */
			public function activate() {				
					// redirect the user on plugin activation
					// to the timeline express welcome page
					add_option('timeline_express_do_activation_redirect', true);
					$this->addMissingOptions();
				}

			public function deactivate() {
					// clear our re-write rules on deactivate
					delete_option('post_type_rules_flased_te-announcements');
					wp_clear_scheduled_hook( 'timeline_express_support_license_check' );
				}

			public function uninstall() {
					// get+store our options
					$options = get_option(TIMELINE_EXPRESS_OPTION);
					$delete_cpt_option = $options['delete-announcement-posts-on-uninstallation'];
					// Step #1
						// check if the user wants to remove all announcemnts
						// and do so, if set
					if ( $delete_cpt_option == '1' ) {	
							// delete all created announcement posts on uninstallation
							global $wpdb; // Must have this or else! 
							// set the posts table
							$posts_table = $wpdb->posts;
							// query for our cpt
							$wpdb->query("DELETE FROM " . $posts_table . " WHERE post_type = 'te_announcements'"); 
						}
					// Step #2
						// delete options on plugin uninstall
						// after we check the 'delete-announcement-posts-on-uninstallation' setting
							delete_option( TIMELINE_EXPRESS_OPTION );	
							delete_option( 'timeline_express_license_status' );
							delete_option( 'timeline_express_license_key' );
				}

			/***** INITIAL SETUP
			 ****************************************************************************************************/
			public function initialize() {

					// If it's not already set up, initialize our plugin session
					if( session_id() == '' ) @session_start();
					
					if( !is_array( @$_SESSION[$this->sessName] ) ) {
						$_SESSION[$this->sessName]	= array();
					 }
						
					// Register a new custom image size
					add_image_size( 'timeline-express', '350' , '120', true );
						
					// Add the CSS/JS files - Dashboard
					add_action( 'admin_enqueue_scripts' , array( &$this , 'addStyles' ) );
					add_action( 'admin_enqueue_scripts' , array( &$this , 'addScripts' ) );
													
					// redirect on activation
					add_action( 'admin_init' , array( &$this , 'timeline_express_plugin_activation_redirect' ) );
				
					// Setup the administration menus
					add_action( 'admin_menu' , array( &$this , 'addAdministrationMenu' ) );
					
					// Make sure the option exists				
					if( !$this->timeline_express_optionVal ) {
						$this->getTimelineOptionValue();
					}
					
					// Setup shortcodes
					$this->timeline_express_createShortcodes();
					
					// Do any update tasks if needed
					$this->timeline_express_runUpdateCheck();

					// Move all "advanced" metaboxes above the default editor
					add_action('edit_form_after_title', array( &$this , 'timeline_express_rearrange_metaboxes' ) , 999 );
					
					// initialize the Metabox class
					add_action( 'init', array( &$this, 'timeline_express_initialize_cmb_meta_boxes' ) , 9998 );
					// Announcement CPT
					add_action( 'init', array( &$this , 'timeline_express_generate_announcement_post_type' ), 999 );
					// change announcement CPT title
					add_filter( 'enter_title_here', array( &$this , 'change_default_announcement_title' ) );	
					// enqueue announcement metaboxes
					add_filter( 'cmb_meta_boxes', array( &$this , 'cmb_timeline_announcement_metaboxes' ), 9999 );
					// add custom columns to the timeline express announcement cpt
					add_filter('manage_edit-te_announcements_columns', array( &$this, 'add_new_timeline_express_columns' ) );
					// generate the content for each column
					add_action('manage_te_announcements_posts_custom_column', array( &$this, 'manage_timeline_express_column_content' ), 10, 2);
					// make our columns sortable
					add_filter( 'manage_edit-te_announcements_sortable_columns', array( &$this ,  'make_sortable_timeline_express_column' ) );
					// custom sort function
					add_action( 'pre_get_posts', array( &$this , 'te_announcements_pre_get_posts' ) , 1 );
					// custom sort orderby 'announcement_date'
					add_filter( 'request', array( &$this , 'announcement_date_column_orderby' ) );
					// register custom image size for the edit page
					add_image_size( 'timeline-express-thumbnail', 150, 60, true );
					// register custom image size for the single announcement page
					add_image_size( 'timeline-express-announcement-header', 750, 155, false );
					// load our custom post type single template (to override the default)
					add_filter( 'single_template', array( &$this , 'get_single_page_timeline_express_announcement_template' ) );
					// content filter, to add our announcement image up above before the content
					add_filter( 'the_content', array( &$this , 'timeline_express_single_page_filter_the_content' ) );
					// append a donate button the 'views' section of the edit.php page for te_announcements only
					add_filter( 'views_edit-te_announcements' , array( &$this , 'append_donate_button_on_edit_page' ) );
					// add a tinymce button that generates our shortcode for the user
					add_action( 'admin_head', array( &$this , 'timeline_express_add_tinymce' ) );
					// filter to keep our plugin auto updated :) , we want all users on the most recent version (the best we can) new @v1.0.8					
					add_filter( 'auto_update_plugin', array( &$this , 'include_timeline_express_in_auto_updates' ), 10, 2 );					
					// register timeline express license setting
					add_action('admin_init', array( &$this , 'timeline_express_register_settings' ) );
					// Remote activation function
					add_action('admin_init', array( &$this , 'timeline_express_activate_license' ) );
					// Remove deactivation function 
					add_action('admin_init', array( &$this , 'timeline_express_deactivate_license' ) );
					// Cross check the validity of our supportl icense , twice a day
					add_action('timeline_express_support_license_check', array( &$this , 'crosscheck_support_license' ) );
					// render new custom timeline express date time
					add_action( 'cmb_render_te_date_time_stamp_custom', array($this,'cmb_render_te_date_time_stamp_custom'), 10, 2 );
					// render new custom timeline express about metabox
					add_action( 'cmb_render_te_about_metabox', array($this,'cmb_render_te_about_metabox'), 10, 2 );
					// custom vlaidation for our new custom field
					 //Validate new metabox type
					add_filter( 'cmb_validate_te_date_time_stamp_custom', array( $this, 'cmb_validate_te_date_time_stamp_custom' ) , 10, 2 );
					// render new custom timeline express about metabox
					add_action( 'cmb_render_te_bootstrap_dropdown', array( $this, 'cmb_render_te_bootstrap_dropdown' ), 10, 2 );
					// validate the new custom timeline express about metabox
					add_filter( 'cmb_validate_te_bootstrap_dropdown', array( $this, 'cmb_validate_te_bootstrap_dropdown' ) , 10, 2);
				}
			
			function addMissingOptions() {
				// store the option temporarily
				$this->timeline_express_optionVal = get_option( TIMELINE_EXPRESS_OPTION );
				// add new option announcement-appear-in-searches 
				// ( toggle display of announcements in searches )
				// @since v1.1.5.8
				if( !isset( $this->timeline_express_optionVal['announcement-appear-in-searches'] ) ) {
					$this->timeline_express_optionVal['announcement-appear-in-searches'] = 'true';
				}
				// update the options -> breaks previous users settings....
				// update_option( TIMELINE_EXPRESS_OPTION , $this->timeline_express_optionVal );
			}
			
			/*
			* cmb_render_te_date_time_stamp_custom()
			* render our custom date time stamp field (allows for a default to be set)
			* since @v1.1.5
			*/
			function cmb_render_te_date_time_stamp_custom( $field, $meta ) {
					?>
					<style>
						#ui-datepicker-div { z-index: 99999 !important; }
						#wpbody-content { overflow: hidden !important; }
						.cmb_id_announcement_image td .cmb_upload_button { height: 32px !important; }
					</style>
					<?php
					if( $meta && isset( $meta ) ){
						echo '<input class="cmb_text_small cmb_datepicker" type="text" name="', $field['id'], '" id="', $field['id'], '" value="', '' !== $meta ? date( 'm/d/Y' , $meta ) : $field['default'], '" />';
						echo '<p class="cmb_metabox_description">'.$field['desc'].'</p>';
					} else{
						echo '<input class="cmb_text_small cmb_datepicker" type="text" name="', $field['id'], '" id="', $field['id'], '" value="' . date('m/d/Y' ) .'" />';
						echo '<p class="cmb_metabox_description">'.$field['desc'].'</p>';
					}				
				}

			/*
			* cmb_validate_te_date_time_stamp_custom()
			* save our custom date time stamp
			* since @v1.1.5
			*/
			function cmb_validate_te_date_time_stamp_custom( $value, $new ) {
					if( isset( $new ) && $new != '' ){
						return strtotime( $new );
					}
					return '-1';
				}
			
			
			 /*
			* cmb_render_te_about_metabox()
			* render the data contained in our custom about metabox
			* since @v1.1.5
			*/
			function cmb_render_te_about_metabox( $field, $meta ) {
					require_once TIMELINE_EXPRESS_PATH . 'lib/about-metabox-template.php';
				}
			
			 /*
			* cmb_render_te_bootstrap_dropdown()
			* render the custom bootstrap dropdown
			* since @v1.1.5.7
			*/
			function cmb_render_te_bootstrap_dropdown( $field, $meta ) {
					// pass in the field object and meta data
					$this->timeline_express_build_bootstrap_dropdown( $field, $meta );
				}
			
			/*
			* cmb_validate_te_date_time_stamp_custom()
			* save our custom date time stamp
			* since @v1.1.5
			*/
			function cmb_validate_te_bootstrap_dropdown( $value, $new ) {
					if( isset( $new ) && $new != '' ){
						return 'fa-'.trim($new);
					}
					return '-1';
				}	
				
			/*
			* schedule_timeline_express_support_cron()
			* Setup our twice daily transient, to cross check the API key ( if set )
			* since @v1.1.4
			*/
			public function schedule_timeline_express_support_cron() {
					wp_schedule_event( current_time( 'timestamp' ), 'twicedaily', 'timeline_express_support_license_check');
				}
				
			/*
			* crosscheck_support_license()
			* API Request to cross check the license, and update the option based on the result
			* since @v1.1.4
			*/
			public function crosscheck_support_license() {
					// only run if the user has a valid license installed
					if ( get_option( 'timeline_express_license_status' ) !== false && get_option( 'timeline_express_license_status' ) == 'valid' ) {
						// api parameters, cross checking the license
							$api_params = array( 
								'edd_action' => 'check_license', 
								'license' => trim( get_option( 'timeline_express_license_key' ) ), 
								'item_name' => urlencode( EH_DEV_SHOP_SUPPORT_PRODUCT_NAME ), // the name of our product
								'url' => home_url()
							);
							// Call the custom API.
							$response = wp_remote_get( add_query_arg( $api_params, EH_DEV_SHOP_URL ), array( 'timeout' => 15, 'sslverify' => false ) );
							
							// decode the license data
							$license_data = json_decode( wp_remote_retrieve_body( $response ) );
							// check license status
							if ( $license_data->license != 'valid' ) {
								update_option( 'timeline_express_license_status', $license_data->license );
								update_option( 'timeline_express_license_data', $license_data );
							}
					}	
				}
			
			/*
			* timeline_express_activate_license()
			* Remote Support License Activation
			* since @v1.1.4
			*/
			public function timeline_express_activate_license() {
						
					// listen for our activate button to be clicked
					if( isset( $_POST['timeline_express_license_activate'] ) ) {
											
						// run a quick security check 
						if( ! check_admin_referer( 'timeline_express_nonce', 'timeline_express_nonce' ) ) 	
							return; // get out if we didn't click the Activate button

						// retrieve the license from the database
						$license = trim( get_option( 'timeline_express_license_key' ) );
							
						// data to send in our API request
						$api_params = array( 
							'edd_action'=> 'activate_license', 
							'license' 	=> $license, 
							'item_name' => urlencode( EH_DEV_SHOP_SUPPORT_PRODUCT_NAME ), // the name of our product
							'url'       => home_url()
						);
						
						// Call the custom API.
						$response = wp_remote_get( add_query_arg( $api_params, EH_DEV_SHOP_URL ), array( 'timeout' => 15, 'sslverify' => false ) );

						// make sure the response came back okay
						if ( is_wp_error( $response ) )
							return false;

						// decode the license data
						$license_data = json_decode( wp_remote_retrieve_body( $response ) );
						
						// $license_data->license returns "valid" or "invalid"
						update_option( 'timeline_express_license_status', $license_data->license );
						update_option( 'timeline_express_license_data', $license_data );

					}
				} // end remote activation
		

			/*
			* timeline_express_deactivate_license()
			* Remote Support License De-activation
			* since @v1.1.4
			*/
			public function timeline_express_deactivate_license() {

					// listen for our activate button to be clicked
					if( isset( $_POST['timeline_express_license_deactivate'] ) ) {

						// run a quick security check 
						if( ! check_admin_referer( 'timeline_express_nonce', 'timeline_express_nonce' ) ) 	
							return; // get out if we didn't click the Activate button

						// retrieve the license from the database
						$license = trim( get_option( 'timeline_express_license_key' ) );
							

						// data to send in our API request
						$api_params = array( 
							'edd_action'=> 'deactivate_license', 
							'license' 	=> $license, 
							'item_name' => urlencode( EH_DEV_SHOP_SUPPORT_PRODUCT_NAME ), // the name of our product
							'url'       => home_url()
						);
						
						// Call the custom API.
						$response = wp_remote_get( add_query_arg( $api_params, EH_DEV_SHOP_URL ), array( 'timeout' => 15, 'sslverify' => false ) );

						// make sure the response came back okay
						if ( is_wp_error( $response ) )
							return false;

						// decode the license data
						$license_data = json_decode( wp_remote_retrieve_body( $response ) );
						
						// $license_data->license returns either "deactivated" or "failed"
						if( $license_data->license == 'deactivated' )
							delete_option( 'timeline_express_license_status' );

					}
				} // end remove deactivation
				
				
			/*
			* timeline_express_register_settings()
			* Register a setting for support license users
			* since @v1.1.4
			*/
			function timeline_express_register_settings() {
					// creates our settings in the options table
					register_setting('timeline_express_license', 'timeline_express_license_key', array( &$this , 'timeline_express_sanitize_license' ) );
				}
			
			
			/*
			* timeline_express_sanitize_license()
			* save license key function
			* since @v1.1.4
			*/
			function timeline_express_sanitize_license( $new ) {
					$old = get_option( 'timeline_express_license_key' );
					if( $old && $old != $new ) {
						delete_option( 'timeline_express_license_status' ); // new license has been entered, so must reactivate
					}
					return $new;
				}	
			
			/* 
			*	include_timeline_express_in_auto_updates();
			*
			*	Keep this plugin automatically updated!
			*	new since @v1.0.8
			*/
			function include_timeline_express_in_auto_updates( $update, $item ) {
				return ( in_array( $item->slug, array(
					'timeline-express',
				) ) );
			}
			
			// move the metaboxes around on the announcement creation page
			public function timeline_express_rearrange_metaboxes() {
				global $post, $wp_meta_boxes;
				do_meta_boxes(get_current_screen(), 'advanced', $post);
				unset($wp_meta_boxes[get_post_type($post)]['advanced']);
			}
			
			// enqueue metabox for the announcement cpt
			public function timeline_express_initialize_cmb_meta_boxes() {
				if ( ! class_exists( 'cmb_Meta_Box' ) ){
					require_once( TIMELINE_EXPRESS_PATH . 'lib/cmb_metaboxes/init.php' );
				}
			}	
				
			// Register Announcement Custom Post Type
			public function timeline_express_generate_announcement_post_type() {
					
					$this->timeline_express_optionVal = get_option( TIMELINE_EXPRESS_OPTION );
					if( isset( $this->timeline_express_optionVal['announcement-appear-in-searches'] ) ) {
						$announcements_public = $this->timeline_express_optionVal['announcement-appear-in-searches'];
					} else {
						$announcements_public = 'true';
					}
					
					// toggle public search visibility of the announcements
					// @since v1.1.5.8
					if( $announcements_public == 'false' ) {
						$announcements_public = false;
					} else {
						$announcements_public = true;
					}
					
					// Register our Announcement Custom Post Type
						// used to easily manage the announcements on the site
					$timeline_express_labels = array(
						'name'                => __( 'Timeline Express Announcements' , 'timeline-express' ),
						'singular_name'       =>  __( 'Announcement' , 'timeline-express' ), // menu item at the top New > Announcement
						'menu_name'           =>  __( 'Timeline Express' , 'timeline-express' ), // menu name
						'parent_item_colon'   =>  __( 'Timeline Express:' , 'timeline-express' ),
						'all_items'           =>  __( 'All Announcements' , 'timeline-express' ),
						'view_item'           =>  __( 'View Announcement' , 'timeline-express' ),
						'add_new_item'        =>  __( 'New Announcement' , 'timeline-express' ),
						'add_new'             =>  __( 'New Announcement' , 'timeline-express' ),
						'edit_item'           =>  __( 'Edit Announcement' , 'timeline-express' ),
						'update_item'         =>  __( 'Update Announcement' , 'timeline-express' ),
						'search_items'        =>  __( 'Search Announcements' , 'timeline-express' ),
						'not_found'           =>  __( 'No Timeline Express Announcements Found' , 'timeline-express' ),
						'not_found_in_trash'  =>  __( 'No Timeline Express Announcements in Trash' , 'timeline-express' ),
					);
					$timeline_express_rewrite = array(
						'slug'                =>  apply_filters( 'timeline-express-slug' , 'announcement' ),
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
						'menu_icon' 			=> TIMELINE_EXPRESS_URL . '/images/timeline-express-menu-icon.png',
						'can_export'          => true,
						'has_archive'         => true,
						'exclude_from_search' =>  $announcements_public, // toggled via setitngs page - @since v1.1.5.8,
						'publicly_queryable'  => true,
						'rewrite'             => $timeline_express_rewrite,
						'capability_type'     => 'page',
					);
					register_post_type( 'te_announcements', $timeline_express_args );
					// end release cycle cpt

					// flush the re-write/permalinks
					$set = get_option('post_type_rules_flased_te-announcements');
					if ($set !== true){
						   flush_rewrite_rules(false);
						   update_option('post_type_rules_flased_te-announcements',true);
						}
					
				}
				// end announcement CPT creation


			/**
			 * Define the metabox and field configurations.
			 *
			 * @param  array $meta_boxes
			 * @return array
			 */
			public function cmb_timeline_announcement_metaboxes( array $meta_boxes ) {
	
					// Start with an underscore to hide fields from custom fields list
					$prefix = 'announcement_';
					
					// setup an empty field type for users to customize
					$custom_field = array();
					
					// set up our array of fields
					$field_array = array(
						array(
								'name' => __( 'Announcement Color', 'timeline-express' ),
								'desc' => __( 'select the color for this announcement.', 'timeline-express' ),
								'id'   => $prefix . 'color',
								'type' => 'colorpicker',
								'default'  => $this->timeline_express_optionVal['default-announcement-color'],
								// 'repeatable' => true,
								// 'on_front' => false, // Optionally designate a field to wp-admin only
							),
							array(
								'name' => __( 'Announcement Icon', 'timeline-express' ),
								'desc' => __( 'select an icon from the drop down above. This is used for the icon associated with the announcement.', 'timeline-express' ),
								'id'   => $prefix . 'icon',
								'type' => 'te_bootstrap_dropdown',
								'default' => 'fa-'.str_replace( 'fa-' , '' , $this->timeline_express_optionVal['default-announcement-icon'] ),
								// 'repeatable' => true,
								// 'on_front' => false, // Optionally designate a field to wp-admin only
							),
							array(
								'name' => __( 'Announcement Date', 'timeline-express' ),
								'desc' => __( 'enter the date of the announcement. the announcements will appear in chronological order according to this date. ', 'timeline-express' ),
								'id'   => $prefix . 'date',
								'type' => 'te_date_time_stamp_custom',
								'default' => strtotime( date( 'm/d/Y' ) ), 
								// 'repeatable' => true,
								// 'on_front' => false, // Optionally designate a field to wp-admin only
							),
							array(
								'name' => __( 'Announcement Image', 'timeline-express' ),
								'desc' => __( 'select a banner image for this announcement (optional). (recommended 650px wide or larger)  ', 'timeline-express' ),
								'id'   => $prefix . 'image',
								'type' => 'file',
								// 'repeatable' => true,
								// 'on_front' => false, // Optionally designate a field to wp-admin only
							),
					);
					
					//Filter here is to allow extra fields to be added
					// loop to add fields to our array
					$custom_fields = apply_filters( 'timeline_express_custom_fields', $custom_field );
					$i = 0;
					// first, check if any custom fields are defined...
					if( !empty( $custom_fields ) ) {
						foreach( $custom_fields as $user_defined_field ) {
							if( $custom_fields[$i]['name'] != '' ) {
								$field_array[] = $custom_fields[$i];
							}
							$i++;
						}
					}
					
					$meta_boxes['announcement_info'] = array(
						'id'         => 'announcement_info',
						'title'      => __( 'Announcement Info.', 'timeline-express' ),
						'pages'      => array( 'te_announcements', ), // Post type
						'context'    => 'advanced',
						'priority'   => 'high',
						'show_names' => true, // Show field names on the left
						// 'cmb_styles' => true, // Enqueue the CMB stylesheet on the frontend
						'fields'     => $field_array
					);
					
					$meta_boxes['about_the_author'] = array(
						'id'         => 'about_the_author',
						'title'      => __( 'About', 'timeline-express' ),
						'pages'      => array( 'te_announcements', ), // Post type
						'context'    => 'side',
						'priority'   => 'low',
						'show_names' => false, // Show field names on the left
						// 'cmb_styles' => true, // Enqueue the CMB stylesheet on the frontend
						'fields'     => array(
							array(
								 'name' => __( '', 'timeline-express' ),
								 'desc' => __( '', 'timeline-express' ),
								 'id'   => $prefix . 'about',
								// 'type' => 'custom_about_the_author_callback',
								 'type' => 'te_about_metabox',
							),
						),
					);
						
					// Add other metaboxes as needed
					return $meta_boxes;
			
				}
				// End metabox definitions	
				
			/* Change Testimonial Title */
			public function change_default_announcement_title( $title ){
					$screen = get_current_screen();
					if  ( 'te_announcements' == $screen->post_type ) {
						$title = __( 'Enter Announcement Title' , 'timeline-express' );
					}
					return $title;
				}		
			
			/* Add Custom Columns to Announcement page */
			public function add_new_timeline_express_columns($timeline_express_columns) {
					$timeline_express_announcement_columns['cb'] = '<input type="checkbox" />';
					$timeline_express_announcement_columns['title'] = _x('Announcement Name', 'timeline-express');
					$timeline_express_announcement_columns['color'] = _x('Color', 'timeline-express');
					$timeline_express_announcement_columns['icon'] = _x('Icon', 'timeline-express');
					$timeline_express_announcement_columns['announcement_date'] = _x('Announcement Date', 'timeline-express');
					$timeline_express_announcement_columns['image'] = _x('Image', 'timeline-express');
					$timeline_express_announcement_columns['past_announcement'] = _x('Announcement Past?', 'timeline-express');
					return $timeline_express_announcement_columns;
				}
		
			/* Generate the content for our columns */
			public function manage_timeline_express_column_content($column_name, $id) {
					
					switch ($column_name) {
					
						case 'color':
								$announcement_color = get_post_meta( $id , 'announcement_color' , true );
								echo '<span class="announcement_color_box" style="background-color:' . $announcement_color . ';" title="' . $announcement_color . '"></span>';
							break;
					 
						case 'icon':
								$announcement_icon = get_post_meta( $id , 'announcement_icon' , true );
								echo '<span class="fa ' . $announcement_icon . ' edit-announcement-icon" title="' . $announcement_icon . '"></span>';
							break;
							
						case 'announcement_date':
								$announcment_date = get_post_meta( $id , 'announcement_date' , true );
								echo date( 'l, F jS, Y' , $announcment_date );
							break;
						
						case 'image':
								global $wpdb;
								$announcement_image = get_post_meta( $id , 'announcement_image' , true );								
								if ( $announcement_image != '' ) {
									$announcement_image_id = $wpdb->get_col($wpdb->prepare("SELECT ID FROM $wpdb->posts WHERE guid='%s';", $announcement_image )); 
									$announcement_image_thumbnail = wp_get_attachment_image_src( $announcement_image_id[0] , 'timeline-express-thumbnail' );
									echo '<img src="' . esc_url( $announcement_image_thumbnail[0] ) . '">';
								} else {
									echo '<span class="no-image-used-text"><em>n/a</em></span>'; // blank spot for spacing
								}	
							break;
							
						case 'past_announcement':
								$announcment_date = get_post_meta( $id , 'announcement_date' , true );
								$todays_date = strtotime( date( 'm/d/Y' ) );

									if ( $announcment_date < $todays_date ) {
										echo '<div class="dashicon-past-announcement dashicons dashicons-backup" title="announcement has past..."></div>';
									}
									
							break;

						default:
							break;
						
					} // end switch
				}   
			
			// Make sortable columns function
			public function make_sortable_timeline_express_column( $columns ) {
					$columns['announcement_date'] = 'announcement_date';
					return $columns;
				}
			
			// Custom Column Sorting
			function te_announcements_pre_get_posts( $query ) {
				   /**
					* We only want our code to run in the main WP query
					* AND if an orderby query variable is designated.
					*/
				   if ( $query->is_main_query() && ( $orderby = $query->get( 'orderby' ) ) ) {

					  switch( $orderby ) {

						 // If we're ordering by 'announcement_date'
						 case 'announcement_date':
							// set our query's meta_key, which is used for custom fields
							$query->set( 'meta_key', 'announcement_date' );
							$query->set( 'orderby', 'meta_value_num' );
							break;

					  }

				   }

				}
			
			function announcement_date_column_orderby( $vars ) {
				if ( isset( $vars['orderby'] ) && 'announcement_date' == $vars['orderby'] ) {
					$vars = array_merge( $vars, array(
						'meta_key' => 'announcement_date',
						'orderby' => 'meta_value_num'
					) );
				}
				return $vars;
			}
			
			// register our shortcodes
			public function timeline_express_createShortcodes() {
					add_shortcode('timeline-express', array(&$this, 'processShortcode'));
				}
			
			// Create and store our initial plugin options	
			public function getTimelineOptionValue() {
					$timeline_express_defaultVals	= array(
						'version'	=> TIMELINE_EXPRESS_VERSION_CURRENT,
						'timeline-title' => "Timeline Express",
						'timeline-title-alignment' => "left",
						'timeline-title-size' => "h1",
						'default-announcement-color' => '#75CE66',
						'excerpt-trim-length' => '250',
						'excerpt-random-length' => '0',
						'read-more-visibility'	=> '1',
						'date-visibility'	=> '1',
						'default-announcement-icon' => "fa-exclamation-triangle",
						'announcement-time-frame' => "0",
						'announcement-display-order' => 'ASC',
						'no-events-message' => "No announcements found",
						'announcement-bg-color' => "#EFEFEF",
						'announcement-box-shadow-color' => "#B9C5CD",
						'announcement-background-line-color' => '#D7E4ED',
						'delete-announcement-posts-on-uninstallation' => '0'
					);
					$ov	= get_option( TIMELINE_EXPRESS_OPTION , $timeline_express_defaultVals );
					$this->timeline_express_optionVal	= $ov;
					return $ov;
				}

			// Update check
			// compare stored version to current version	
			private function timeline_express_runUpdateCheck() {
					if( !isset( $this->timeline_express_optionVal['version'] ) || $this->timeline_express_optionVal['version'] < TIMELINE_EXPRESS_VERSION_CURRENT ) {
						$this->runUpdateTasks();
					}
				}


			/***** FUNCTIONS
			 ****************************************************************************************************/
			 
			 /* TinyMCE Button Functions */
			 
				// register our button for the custom post type
				 public function timeline_express_add_tinymce() {
						global $typenow;
						// only on Post Type: post and page
						if( ! in_array( $typenow, array( 'page' , 'post' ) ) )
							return;
						add_filter( 'mce_external_plugins', array( &$this , 'timeline_express_add_tinymce_plugin' ) );
						add_filter( 'mce_buttons', array( &$this , 'timeline_express_add_tinymce_button' ) );
					 }
				 
				 // inlcude the js for tinymce
				public function timeline_express_add_tinymce_plugin( $plugin_array ) {
						$plugin_array['timeline_express'] = plugins_url( 'timeline-express/js/timeline-express-button-script.js' );
						// Print all plugin js path
						// var_dump( $plugin_array );
						return $plugin_array;
					}
					
				// Add the button key for address via JS
				function timeline_express_add_tinymce_button( $buttons ) {
						array_push( $buttons, 'timeline_express_shortcode_button' );
						// Print all buttons
						// var_dump( $buttons );
						return $buttons;
					}
				// end tinymce button functions
			 
			 
			 // append donation button to list table
			public function append_donate_button_on_edit_page( $views ) {
					$current_user_object = wp_get_current_user();
					$current_user_name = $current_user_object->user_firstname;
					$current_user_name .= ' ' . $current_user_object->user_lastname;
					$views[] .= '<a href="http://www.evan-herman.com/contact/?contact-name=' . $current_user_name . '&contact-reason=I want to make a donation for all your hard work" target="_blank"><i class="fa fa-paypal" style="color:#253b80;"></i> Donate</a>';
					return $views;
				}
			 
			 // load a custom template file for single announcements
			 // when this is copied to the theme root, users can override
			 // and customize the template file
			 function get_single_page_timeline_express_announcement_template($single_template) {
					global $post;
					// check if the user has created a copy localy
					// if so , we'll use it
					if ( file_exists( get_template_directory() . '/timeline-express/single-timeline-express-announcement.php' ) ) {
						if ($post->post_type == 'te_announcements') {
							  $single_template = get_template_directory() . '/single-timeline-express-announcement.php';
						 }
						return $single_template;
					} else { // load the defualt one from the plugin
						if ($post->post_type == 'te_announcements') {
							  $single_template = TIMELINE_EXPRESS_PATH . 'lib/single-announcement-template/single-timeline-express-announcement.php';
						 }
						return $single_template;
					}
					
				}
					
			// Filter the content and append our custom image
			function timeline_express_single_page_filter_the_content( $content ) {
						global $post;
						if ( is_single() && $post->post_type == 'te_announcements') {
							global $wpdb;
							// grab the attached image
							$announcement_image = get_post_meta( $post->ID , 'announcement_image' , true );
							$announcement_date = get_post_meta( $post->ID , 'announcement_date' , true );
							$referer = $_SERVER['HTTP_REFERER'];
							if ( $announcement_image != '' ) {
								$announcement_image_id = $wpdb->get_col($wpdb->prepare("SELECT ID FROM $wpdb->posts WHERE guid='%s';", esc_url( $announcement_image) ) ); 
								$custom_content  = '';								
								if ( $announcement_image_id ) {
									$announcement_header_image = wp_get_attachment_image_src( $announcement_image_id[0] , 'timeline-express-announcement-header');
									$custom_content .= '<img class="announcement-banner-image" src="' . esc_url ( $announcement_header_image[0] ) . '" alt="' . get_the_title( $post->ID ) . '">';
								}
								$custom_content .= '<strong class="timeline-express-single-page-announcement-date">' . __( 'Announcement Date' , 'timeline-express' ) . ' : ' . date( 'M j , Y' , $announcement_date ) . '</strong>';
								$custom_content .= $content;
								if ( $referer != '' ) {	
									$custom_content .= '<a href="' . $referer . '" class="return-to-timeline"><i class="fa fa-chevron-left"></i> ' . __( 'Back' , 'timeline-express' ) . '</a>';
								}
								return $custom_content;
							} else {	
								$custom_content = '<strong class="timeline-express-single-page-announcement-date">' . __( 'Announcement Date' , 'timeline-express' ) . ' : ' . date( 'M j , Y' , $announcement_date ) . '</strong>';
								$custom_content .= $content;
								if ( $referer != '' ) {	
									$custom_content .= '<a href="' . $referer . '" class="return-to-timeline"><i class="fa fa-chevron-left"></i> ' . __( 'Back' , 'timeline-express' ) . '</a>';
								}
								return $custom_content;
							}
						} else {
							return $content;
						} 
					}			

				
			/***** CONFIGURATION
			 ****************************************************************************************************/
			// Update our plugin options
			// Runs when the user updates the settings page with new values 
			public function updateOptions( $p ) {
					if( !empty( $p['form_data'] ) ) {
							parse_str($p['form_data'], $fd);
								$this->timeline_express_optionVal['timeline-title'] = stripslashes( $fd['timeline-title'] );
								$this->timeline_express_optionVal['timeline-title-alignment'] =  $fd['timeline-title-alignment'];
								$this->timeline_express_optionVal['timeline-title-size'] =  $fd['timeline-title-size'];
								$this->timeline_express_optionVal['default-announcement-color']	= $fd['default-announcement-color'];
								$this->timeline_express_optionVal['excerpt-trim-length']	= $fd['excerpt-trim-length'];
								$this->timeline_express_optionVal['excerpt-random-length']	= isset( $fd['excerpt-random-length'] ) ? '1' : '0';
								$this->timeline_express_optionVal['read-more-visibility']	= $fd['read-more-visibility'];
								$this->timeline_express_optionVal['date-visibility']	= $fd['date-visibility'];
								$this->timeline_express_optionVal['default-announcement-icon']	= $fd['default-announcement-icon'];
								$this->timeline_express_optionVal['announcement-time-frame']	= $fd['announcement-time-frame'];
								$this->timeline_express_optionVal['announcement-display-order']	= $fd['announcement-display-order'];
								$this->timeline_express_optionVal['no-events-message']	= stripslashes( $fd['no-events-message'] );
								$this->timeline_express_optionVal['announcement-bg-color']	= stripslashes( $fd['announcement-bg-color'] );
								$this->timeline_express_optionVal['announcement-box-shadow-color']	= $fd['announcement-box-shadow-color'];
								$this->timeline_express_optionVal['announcement-background-line-color']	= $fd['announcement-background-line-color'];
								$this->timeline_express_optionVal['delete-announcement-posts-on-uninstallation'] = isset( $fd['delete-announcement-posts-on-uninstallation'] ) ? '1' : '0';
								$this->timeline_express_optionVal['announcement-appear-in-searches'] = $fd['announcement-appear-in-searches'];
							return update_option( TIMELINE_EXPRESS_OPTION, $this->timeline_express_optionVal );		
						}
					return false;
				}
				
			// Update the version number	
			public function updateVersion( $k ) {
					$this->timeline_express_optionVal['version']	= $k; 
					return update_option(TIMELINE_EXPRESS_OPTION, $this->timeline_express_optionVal);
				}

			/***** SCRIPTS/STYLES
			 ****************************************************************************************************/
			 
			 // add styles to the dashboard
			public function addStyles() {
					
					$screen = get_current_screen();
					$print_styles_on_screen_array = array( 'te_announcements_page_timeline-express-settings' , 'admin_page_timeline-express-welcome' , 'te_announcements_page_timeline-express-support' );

					if ( in_array( $screen->base , $print_styles_on_screen_array ) || $screen->post_type == 'te_announcements' ) {
						// Register Styles
						wp_enqueue_style( 'timeline-express-css-base', TIMELINE_EXPRESS_URL . 'css/timeline-express-settings.min.css' , array(), '1.0.0', 'all');	
						// enqueue font awesome for use in column display
						wp_enqueue_style( 'prefix-font-awesome' , '//netdna.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css' , array() , '4.3.0' );					
					}
							
				}
				
			// add scripts to the admin side
			public function addScripts() {
					$screen = get_current_screen();
					global $post;
					if ( in_array( $screen->base , array('te_announcements_page_timeline-express-settings') ) || $screen->post_type == 'te_announcements' ) {					
						// enqueue the admin scripts here
						// Add the color picker css file       
							// used to select colors on the settings page
						wp_enqueue_style( 'wp-color-picker' );
						wp_enqueue_script( 'wp-color-picker' );
						
						wp_enqueue_script( 'jquery-ui-dialog' );
						wp_enqueue_style( "wp-jquery-ui-dialog" );
						
						// enqueue custom color picker files
						wp_enqueue_script( 'options-color-picker-custom' , TIMELINE_EXPRESS_URL . 'js/script.options-color-picker-custom.js' , array( 'jquery' , 'wp-color-picker' ) , '' , true );
					}
				}
				
			// redirect the user to the settings page on initial activation
			function timeline_express_plugin_activation_redirect() {
					if ( get_option( 'timeline_express_do_activation_redirect' , false ) ) {
						delete_option( 'timeline_express_do_activation_redirect' );
						// redirect to settings page
						wp_redirect( admin_url( '/admin.php?page=timeline-express-welcome' ) );
					}
				}

			// enqueue scripts on the frontend
			public function addScripts_frontend() {
					// Everything else
					// load our scripts in the dashboard
					wp_enqueue_script( 'timeline-express-js-base' , TIMELINE_EXPRESS_URL . 'js/script.timeline-express.min.js' , array( 'jquery' ) );
					// masonry for layout
					wp_enqueue_script( 'jquery-masonry' );
				}

			// add styles to the front end
			public function addStyles_frontend() {
					// Enqueue Styles
					wp_enqueue_style( 'timeline-express-base', TIMELINE_EXPRESS_URL . 'css/timeline-express.min.css' , array() , '' , 'all' );
					// enqueue font awesome for use in the timeline
					wp_enqueue_style( 'prefix-font-awesome' , '//netdna.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css' , array() , '4.2.0' );
				}

			/***** SHORTCODE
			 ****************************************************************************************************/
			 // Function to process the shortcode provided by the plugin
			 // $p is the data associated with the shortcode (ie: form id and submit button text)
			public function processShortcode( $p ) {
				// enqueue our scripts + styles
				$this->addScripts_frontend();
				$this->addStyles_frontend();
				
					// start the object buffer
					ob_start();
					
					// store the element wrap
					$title_wrap = $this->timeline_express_optionVal['timeline-title-size'];
					$title_alignment = $this->timeline_express_optionVal['timeline-title-alignment'];
					
						// get and store the color options
						$content_background = $this->timeline_express_optionVal['announcement-bg-color'];
						$content_shadow = $this->timeline_express_optionVal['announcement-box-shadow-color'];
						$background_line_color = $this->timeline_express_optionVal['announcement-background-line-color'];
						$display_order = $this->timeline_express_optionVal['announcement-display-order'];
												
						// set the current date, with our offset
						$offset = get_option('gmt_offset');					
						$current_date = strtotime( 'today ' . $offset );
						
						// decide how to compare our $current_date to $announcement_start_date meta
						$compare = $this->timeline_express_optionVal['announcement-time-frame'];
										
							switch( $compare ) {
								case '0':
									$compare_sign = '>=';
								break;
										
								case '1':
									$compare_sign = '';
								break;
										
								case '2':
									$compare_sign = '<';
								break;
							}
										
							// if the announcement setting
							// is set to All Announcements
							// let's query them all
							if ( $compare_sign == '' ) {
								// set up the announcement arguments
								$announcement_args = array(
									'post_type' => 'te_announcements',
									'meta_key'   => 'announcement_date',
									'orderby'    => 'meta_value_num',
									'order'      => $display_order,
									'posts_per_page' => -1
								);
							} else { 
								// else we only want to query what we
								// have specified
								$announcement_args = array(
									'post_type' => 'te_announcements',
									'meta_key'   => 'announcement_date',
									'orderby'    => 'meta_value_num',
									'order'      => $display_order,
									'posts_per_page' => -1,
									'meta_query' => array(
										array(
											'key'     => 'announcement_date',
											'value'   => $current_date,
											'type' => 'NUMERIC',
											'compare' => $compare_sign
										),
									),
								);
							}
							// end setting up query args
										
							$announcement_query = new WP_Query( $announcement_args );
							
							// print_r($announcement_args);
																
							if ( $announcement_query->have_posts() ) {
								?>
								<!-- style the arrow that points at the icon -->
								<style>
									.cd-timeline-title {
										display: block;
										text-align: <?php echo $title_alignment; ?>;
									}
									.cd-timeline-block:nth-child(odd) .cd-timeline-content::before {
										border-left-color: <?php if ( $content_background == '' ) { echo 'transparent'; } else { echo $content_background . '!important'; } ?>;
									}	
									.cd-timeline-block:nth-child(even) .cd-timeline-content::before {
										border-right-color: <?php if ( $content_shadow == '' ) { echo 'transparent'; } else { echo $content_background. '!important'; } ?>;
									}
									#cd-timeline::before {
										background: <?php if ( $background_line_color == '' ) { echo 'transparent'; } else { echo $background_line_color. '!important'; } ?>;
									}
									@media only screen and (max-width: 821px) {
										  .cd-timeline-content::before {
												border-left-color: transparent;
												border-right-color: <?php if ( $content_background == '' ) { echo 'transparent'; } else { echo $content_background. '!important'; } ?>;
										  }
										  .cd-timeline-block:nth-child(odd) .cd-timeline-content::before {
											border-left-color: transparent !important;
										  }
									}
								</style>
										
								<<?php echo $title_wrap; ?> class="cd-timeline-title"><?php if ( $this->timeline_express_optionVal['timeline-title'] != '' ) { echo apply_filters( 'the_title' , $this->timeline_express_optionVal['timeline-title'] ); } ?></<?php echo $title_wrap; ?>>
								<section id="cd-timeline" class="cd-container"><?php
									
								while( $announcement_query->have_posts() ) {
									$announcement_query->the_post();
									global $post;
									$announcement_image = esc_url( get_post_meta( $post->ID , 'announcement_image' , true ) );	
									$button_classes = 'cd-read-more btn btn-primary ';
										?>
											<div class="cd-timeline-block">
												<!-- icon -->
												<?php if ( $this->timeline_express_optionVal['read-more-visibility'] != 0 ) { ?>
													<a class="cd-timeline-icon-link" href="<?php echo get_the_permalink( $post->ID ); ?>">
														<div class="cd-timeline-img cd-picture" style="background:<?php echo get_post_meta( $post->ID , 'announcement_color' , true ); ?>;">
															<span class="fa <?php echo get_post_meta( $post->ID , 'announcement_icon' , true ); ?>" title="<?php echo get_the_title( $post->ID ); ?>"></span>
														</div> <!-- cd-timeline-img -->
													</a>
												<?php } else { ?>
													<div class="cd-timeline-img cd-picture" style="background:<?php echo get_post_meta( $post->ID , 'announcement_color' , true ); ?>;">
														<span class="fa <?php echo get_post_meta( $post->ID , 'announcement_icon' , true ); ?>" title="<?php echo get_the_title( $post->ID ); ?>"></span>
													</div> <!-- cd-timeline-img -->
												<?php } ?>
												<!-- content/date/etc. -->
												<div class="cd-timeline-content" style="background:<?php if ( $content_background == '' ) { echo 'transparent'; } else { echo $content_background; } ?>;box-shadow: 0 3px 0 <?php if ( $content_shadow == '' ) { echo 'transparent'; } else { echo $content_shadow; } ?>;">
													<!-- title -->
													<span class="cd-timeline-title-container"><h2 class="cd-timeline-item-title"><?php the_title();?></h2><?php if ( $this->timeline_express_optionVal['date-visibility'] == 1 ) { ?>
														<!-- release date -->
														<!-- now localized, for international date formats based on the 'date_format' option -->
														<span class="timeline-date"><?php echo date_i18n( apply_filters( 'timeline_express_custom_date_format' , get_option( 'date_format' ) ) , get_post_meta( $post->ID , 'announcement_date' , true ) ); ?></span>
													<?php } ?></span>
													<?php
													// display our image, if it exists
													if ( $announcement_image != '' ) { 
														$attachment_id = $this->timeline_express_get_image_id( $announcement_image ); 
														$timeline_announcement_image = wp_get_attachment_image_src( $attachment_id, apply_filters( 'timeline-express-announcement-img-size' , 'timeline-express' ) );
														echo '<img src="' . $timeline_announcement_image[0] . '" alt="Announcement Image" class="announcement-banner-image" >';
													}											
													// excerpt random length
													if( $this->timeline_express_optionVal['excerpt-random-length'] == 1 ) {
														// lets trim it at some random value, 
														// to switch it up a bit
															$random_number = array(  );
															$random_selection = array_rand( $random_number );
															$trim_array = array( "50" , "52" , "55" , "60" , "66" , "70" , "75" , "82", "45", "40", "48" , "58", "78" , "100" , "80" , "93" , "35" , "25" , "120" , "99" , "85" , "82" );
															$random_trim = array_rand( $trim_array );
															// if the user wants to hide read more,
															// we should remove the elipses
															if ( $this->timeline_express_optionVal['read-more-visibility'] == 0 ) {
																$elipses = '';
															} else {
																$elipses =  __( '...' , 'timeline-express' ) ;
															}
															// set up the readmore button
															if ( $this->timeline_express_optionVal['read-more-visibility'] == 0 ) {
																$elipses = '';
																$read_more_button = '';
															} else {
																$elipses =  __( '...' , 'timeline-express' );
																$read_more_button = '<a href="' . get_the_permalink() . '" class="' . apply_filters( "timeline-express-read-more-class" , $button_classes ) . '">' . __( 'Read more' , 'timeline-express' ) . '</a>';
															}
														?>
														<span class="the-excerpt">
															<?php echo apply_filters( 'the_content' , $this->timeline_express_custom_truncate( get_the_content() , $trim_array[$random_trim] , $elipses , false, true ) ); ?>
														</span>
														<?php
													} else {
														$trim_length = $this->timeline_express_optionVal['excerpt-trim-length'];
														if ( $this->timeline_express_optionVal['read-more-visibility'] == 0 ) {
															$elipses = '';
															$read_more_button = '';
														} else {
															$elipses = __( '...' , 'timeline-express' );
															$read_more_button = '<a href="' . get_the_permalink() . '" class="' . apply_filters( "timeline-express-read-more-class" , $button_classes ) . '">' . __( 'Read more' , 'timeline-express' ) . '</a>';
														}
													?>
														<span class="the-excerpt">
															<?php // echo apply_filters( 'the_content' , $this->te_wp_trim_words_retain_formatting( get_the_content() , $trim_length , $elipses ) ); ?>
															<?php echo apply_filters( 'the_content' , $this->timeline_express_custom_truncate( get_the_content() , $trim_length , $elipses , false, true ) ); ?>
														</span>
													<?php
													}
													?>
													<!-- readmore link -->
													<?php echo $read_more_button; ?>
												</div> <!-- cd-timeline-content -->
															
											</div> <!-- cd-timeline-block -->
										<?php									
								}
							
							?></section><!-- Timeline Express by Evan Herman - http://www.Evan-Herman.com --><?php
								wp_reset_query();
								
							} else {
							?>
								<h2><?php echo $this->timeline_express_optionVal['no-events-message']; ?></h2>
							<?php			
							}		
					$shortcode = ob_get_contents();
					ob_end_clean();
					return $shortcode;
				}
				
				/*
				*	Re-Write of the custom excerpt function
				*	- trims at the set char. count (inside of timeline express settings)
				*	- counts by character not by word
				*	@since v1.1.5.6
				*/
				public function timeline_express_custom_truncate( $text, $length = 100, $ending = '&hellip;', $exact = false, $considerHtml = true ) {
					if ($considerHtml) {
					
						// if the plain text is shorter than the maximum length, return the whole text
						if (strlen(utf8_decode(preg_replace( array( '/<.*?>/', '/\n/', '/&[0-9a-z]{2,8};|&#[0-9]{1,7};|&#x[0-9a-f]{1,6};/i' ), array( '', '', ' ' ), $text))) <= $length) {
							return $text;
						}
				 
						// splits all html-tags to scanable lines
						preg_match_all('/(<.+?>)?([^<>]*)/s', $text, $lines, PREG_SET_ORDER);
				 
							$total_length = ( $ending === '&hellip;' ) ? 2 : strlen( utf8_decode($ending) );
							$open_tags = array();
							$truncate = '';
				 
						foreach ($lines as $line_matchings) {
							// if there is any html-tag in this line, handle it and add it (uncounted) to the output
							if (!empty($line_matchings[1])) {
								// if it's an "empty element" with or without xhtml-conform closing slash (f.e. <br/>)
								if (preg_match('/^<(\s*.+?\/\s*|\s*(img|br|input|hr|area|base|basefont|col|frame|isindex|link|meta|param)(\s.+?)?)>$/is', $line_matchings[1])) {
									// do nothing
								// if tag is a closing tag (f.e. </b>)
								} else if (preg_match('/^<\s*\/([^\s]+?)\s*>$/s', $line_matchings[1], $tag_matchings)) {
									// delete tag from $open_tags list
									$pos = array_search($tag_matchings[1], $open_tags);
									if ($pos !== false) {
										unset($open_tags[$pos]);
									}
								// if tag is an opening tag (f.e. <b>)
								} else if (preg_match('/^<\s*([^\s>!]+).*?>$/s', $line_matchings[1], $tag_matchings)) {
									// add tag to the beginning of $open_tags list
									array_unshift($open_tags, strtolower($tag_matchings[1]));
								}
								// add html-tag to $truncate'd text
								$truncate .= $line_matchings[1];
							}
				 
							// calculate the length of the plain text part of the line; handle entities as one character
							$content_length = strlen(utf8_decode(preg_replace('/&[0-9a-z]{2,8};|&#[0-9]{1,7};|&#x[0-9a-f]{1,6};/i', ' ', $line_matchings[2])));
							if ($total_length+$content_length> $length) {
								// the number of characters which are left
								$left = $length - $total_length;
								$entities_length = 0;
								// search for html entities
								if (preg_match_all('/&[0-9a-z]{2,8};|&#[0-9]{1,7};|&#x[0-9a-f]{1,6};/i', $line_matchings[2], $entities, PREG_OFFSET_CAPTURE)) {
									// calculate the real length of all entities in the legal range
									foreach ($entities[0] as $entity) {
										if ($entity[1]+1-$entities_length <= $left) {
											$left--;
											$entities_length += strlen(utf8_decode($entity[0]));
										} else {
											// no more characters left
											break;
										}
									}
								}
								$truncate .= substr($line_matchings[2], 0, $left+$entities_length);
								// maximum lenght is reached, so get off the loop
								break;
							} else {
								$truncate .= $line_matchings[2];
								$total_length += $content_length;
							}
				 
							// if the maximum length is reached, get off the loop
							if($total_length >= $length) {
								break;
							}
						}
					} else {
						if (strlen(utf8_decode($text)) <= $length) {
							return $text;
						} else {
							$truncate = substr($text, 0, $length - strlen(utf8_decode($ending)));
						}
					}
				 
					// if the words shouldn't be cut in the middle...
					if (!$exact) {
						// ...search the last occurance of a space...
						$spacepos = strrpos($truncate, ' ');
						if (isset($spacepos)) {
							// ...and cut the text in this position
							$truncate = substr($truncate, 0, $spacepos);
						}
					}
				 
					// add the defined ending to the text
					$truncate .= $ending;
				 
					if($considerHtml) {
						// close all unclosed html-tags
						foreach ($open_tags as $tag) {
							$truncate .= '</' . $tag . '>';
						}
					}
				 
					return $truncate;
				 
				}
				
				// retrieves the attachment ID from the file URL
				public function timeline_express_get_image_id($image_url) {
						global $wpdb;
						$attachment = $wpdb->get_col($wpdb->prepare("SELECT ID FROM $wpdb->posts WHERE guid='%s';", $image_url )); 
							return $attachment[0]; 
					}

					
				// Build a dropdown for our bootstrap icons
				// @since v1.1.5.7
				public function timeline_express_build_bootstrap_dropdown( $field, $meta ) {
						
						// get the icons out of the css file
						$response = wp_remote_get( 'http://netdna.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.css' );
						
						if( is_wp_error( $response ) ) {
							wp_die( $resposne->get_error_message() , $response->title , array( 'back_link' => true ) );
						}

						// splot the response body, and store the icon classes in a variable
						$split_dat_response = explode( 'icons */' , $response['body'] );
						
						// empty array for icon array
						$bootstrap_icon_array = array();
						
						// replace the unecessary stuff
						$data = str_replace( ';' , '' , str_replace( ':before' , '' , str_replace( '}' , '' , str_replace( 'content' , '' , str_replace( '{' , '' , $split_dat_response[1] ) ) ) ) );
						$icon_data = explode( '.fa-' , $data );
						$i = 1;
								
						foreach( array_slice($icon_data,1) as $key => $value) {
							$split_icon = explode( ':' , $value );
							if( isset( $split_icon[1] ) ) {
								$bootstrap_icon_array[] = array( trim( 'fa-' . $split_icon[0] ) => trim( $split_icon[0] ) );
							}
							$i++;
						}
							
						$flat_bootstrap_icon_array = array();
						foreach($bootstrap_icon_array as $array) {
							foreach($array as $k=>$v) {
							   $flat_bootstrap_icon_array[$k] = $v;
							}
						}
						
						wp_enqueue_script( 'bootstrap-select' , TIMELINE_EXPRESS_URL . 'js/bootstrap-select.js' , array( 'jquery' ) , 'all' );
						wp_enqueue_script( 'bootstrap-min' , 'http://netdna.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js' );
						wp_enqueue_style('bootstrap-select-style' ,  TIMELINE_EXPRESS_URL . 'css/bootstrap-select.min.css' );
						?>	
						<script>
						jQuery( document ).ready( function() {
							jQuery('.selectpicker').selectpicker({
								style: 'btn-info',
								size: 6
							});
						});
						</script>
						<style>
							.dropdown-toggle { background: transparent !important; border: 1px solid rgb(201, 201, 201) !important; } 
							.dropdown-toggle .caret { border-top-color: #333 !important; }
							.ui-datepicker-prev:hover, .ui-datepicker-next:hover { cursor: pointer; }
						</style> 
						
						<!-- start the font awesome icon select -->
						<select class="selectpicker" name="<?php echo $field['id']; ?>" id="<?php echo $field['id']; ?>">
							
							<?php
								/* sort the bootstrap icons alphabetically */
								sort( $flat_bootstrap_icon_array );
								foreach( $flat_bootstrap_icon_array as $icon ) {
							?>
							
							<option class="fa" data-icon="fa-<?php echo $icon; ?>" <?php selected( 'fa-'.$icon , $meta ); ?>><?php echo $icon; ?></option>
							
							<?php
								}
							?>
							
						</select>
						<!-- end select -->
						
						<?php
						echo '<p class="cmb_metabox_description">'.$field['desc'].'</p>';
					}	
					
			/***** ADMINISTRATION MENUS
			 ****************************************************************************************************/
			public function addAdministrationMenu() {
					// Sub Items
						// Settings Page
						add_submenu_page('edit.php?post_type=te_announcements', __('Timeline Express Settings','timeline-express'), __('Settings','timeline-express'), 'manage_options', 'timeline-express-settings', array(&$this, 'generateOptionsPage'));
						// Welcome Page
						add_submenu_page('options.php', __('Timeline Express Welcome','timeline-express'), __('Timeline Express Welcome','timeline-express'), 'manage_options', 'timeline-express-welcome', array(&$this, 'generateWelcomePage'));
						// Support Page
						add_submenu_page('edit.php?post_type=te_announcements', __('Support','timeline-express'), __('Support','timeline-express'), 'manage_options', 'timeline-express-support', array(&$this, 'generateSupportPage'));
				}


			/***** ADMINISTRATION PAGES
			 ****************************************************************************************************/
			public function generateOptionsPage() {
					require_once TIMELINE_EXPRESS_PATH . 'pages/options.php'; // include our options page
				}
			public function generateAboutPage() {
					require_once TIMELINE_EXPRESS_PATH . 'pages/about.php'; // include our about page
				}	
			public function generateWelcomePage() {	
					require_once TIMELINE_EXPRESS_PATH . 'pages/welcome.php'; // include our welcome page
				}	
			public function generateSupportPage() {	
					require_once TIMELINE_EXPRESS_PATH . 'pages/support.php'; // include our welcome page
				}		

				
			/***** FORM DATA
			 ****************************************************************************************************/
			public function resetPluginSettings() {
					// reset the plugin settings back to defaults
					$this->timeline_express_optionVal['version']	= TIMELINE_EXPRESS_VERSION_CURRENT;
					$this->timeline_express_optionVal['timeline-title'] = "Timeline Express";
					$this->timeline_express_optionVal['timeline-title-alignment'] = "left";
					$this->timeline_express_optionVal['timeline-title-size'] = "h1";
					$this->timeline_express_optionVal['default-announcement-color'] = '#75CE66';
					$this->timeline_express_optionVal['excerpt-trim-length'] = '250';
					$this->timeline_express_optionVal['excerpt-random-length'] = '0';
					$this->timeline_express_optionVal['read-more-visibility']	= '1';
					$this->timeline_express_optionVal['date-visibility']	= '1';
					$this->timeline_express_optionVal['default-announcement-icon'] = "fa-exclamation-triangle";
					$this->timeline_express_optionVal['announcement-time-frame'] = "0";
					$this->timeline_express_optionVal['announcement-display-order'] = "ASC";
					$this->timeline_express_optionVal['no-events-message'] = "No announcements found";
					$this->timeline_express_optionVal['announcement-bg-color'] = "#EFEFEF";
					$this->timeline_express_optionVal['announcement-box-shadow-color'] = "#B9C5CD";	
					$this->timeline_express_optionVal['announcement-background-line-color'] = '#D7E4ED';
					$this->timeline_express_optionVal['delete-announcement-posts-on-uninstallation'] = '0';
					$this->timeline_express_optionVal['announcement-appear-in-searches'] = 'true';
					return update_option( TIMELINE_EXPRESS_OPTION, $this->timeline_express_optionVal );	
				}
			 


			/***** UPDATES
			 ****************************************************************************************************/
			public function runUpdateTasks() {
					$currentVersion	= ( !isset( $this->timeline_express_optionVal['version'] ) || empty( $this->timeline_express_optionVal['version'] ) ? '1.0.0' : $this->timeline_express_optionVal['version'] );
					$latestVersion	= TIMELINE_EXPRESS_VERSION_CURRENT;
					if( $currentVersion < $latestVersion )
						{	
						$updateFunction	= 'runUpdateTasks_'.str_replace('.', '_', $currentVersion);
						if( !method_exists( $this, $updateFunction ) ) return false;
						else
							{
							if( call_user_func( array( &$this , $updateFunction ) ) )
								{
								update_option( TIMELINE_EXPRESS_OPTION, TIMELINE_EXPRESS_VERSION_CURRENT );
								$this->runUpdateTasks();
								}
							}
						}
					else return false;
				}
				
			/**
			 * Update function to add missing options etc.
			 * runUpdateTasks_(old version number)
			 * remember to update version number here
			 * and add any missing options!
			 *
			 * 1.0.1 => 1.0.2
			*/
			private function runUpdateTasks_1_0_1() {
					$this->timeline_express_optionVal['announcement-display-order'] = 'ASC';
					$this->timeline_express_optionVal['version'] = '1.0.2';
				}
				
			private function runUpdateTasks_1_0_2() {
					$this->timeline_express_optionVal['announcement-display-order'] = isset( $this->timeline_express_optionVal['announcement-display-order'] ) ? $this->timeline_express_optionVal['announcement-display-order'] : 'ASC'; // check if the user this setting previously set up
					$this->timeline_express_optionVal['version'] = '1.0.3';
				}
			
			
		} // end class timelineExpressBase
	} // end if class exists check
	

/**************************************
// enjoy the plugin :)
// Author : Evan Herman
// Contact : http://www.Evan-Herman.com/contact/
**************************************/
?>