<?php
/**
 * Timeline Express Options Page
 *
 * @package Timeline Express
 *
 * @since 1.2
 */

// Get & Store the current options from the database.
$current_options = timeline_express_get_options();

// Setup the options for our WYSIWYG editors for the optin messages.
$additional_editor_parameters = array(
	'textarea_name'    => 'timeline_express_storage[no-events-message]',
	'teeny'            => true,
	'textarea_rows'    => 15,
	'tabindex'         => 1,
	'drag_drop_upload' => true,
);

$active_tab = ( filter_has_var( INPUT_GET, 'tab' ) ) ? filter_input( INPUT_GET, 'tab', FILTER_SANITIZE_STRING ) : 'base';

$add_ons = get_option( 'timeline_express_installed_add_ons', array() );

$active_add_ons_class = ( ! empty( $add_ons ) ) ? ' add-ons-active' : '';

// Setup the labels
$timeline_express_singular_name = apply_filters( 'timeline_express_singular_name', __( 'Announcement', 'timeline-express' ) );
$timeline_express_plural_name   = apply_filters( 'timeline_express_plural_name', __( 'Announcements', 'timeline-express' ) );
?>

<!-- Page Title -->
<div class="wrap">
	<div id="poststuff">
		<div id="post-body" class="metabox-holder columns-1">
			<!-- main content -->
			<div id="post-body-content">
				<div class="meta-box-sortables ui-sortable">
					<div class="postbox timeline-express-settings-header" style="margin-bottom:0;">
						<div class="inside settings-header">

							<?php timeline_express_generate_options_header( $active_tab ); ?>

						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="wrap">

	<div id="poststuff">

		<div id="post-body" class="metabox-holder columns-2">

			<!-- main content -->
			<div id="post-body-content">

				<div class="meta-box-sortables ui-sortable">

					<?php timeline_express_generate_options_tabs( $active_tab ); ?>

					<div class="postbox">

						<div class="inside">

							<?php

							if ( 'base' !== $active_tab ) {

								do_action( 'timeline_express_add_on_options_page', $active_tab );

							} else {

								?>

								<form method="post" action="options.php" name="timeline-express-form" id="timeline-express-form">

									<?php
									/* Do the settings fields */
									settings_fields( 'timeline-express-settings' );

									do_settings_sections( 'timeline-express-settings' );

									/* Nonce security check :) */
									wp_nonce_field( 'timeline_express_save_settings', 'timeline_express_settings_nonce' );
									?>

									<table class="form-table timeline-express-form">
										<tbody>

											<!-- Select Time Frame -->
											<tr valign="top">
												<th scope="row">
													<label for="timeline_express_storage[announcement-time-frame]">
														<?php esc_html_e( 'Time Frame', 'timeline-express' ); ?>
													</label>
												</th>
												<td>
													<select name="timeline_express_storage[announcement-time-frame]" id="announcement-time-frame" class="regular-text" />
														<option value="0" <?php selected( $current_options['announcement-time-frame'], '0' ); ?>>
															<?php esc_html_e( 'Future', 'timeline-express' ); ?>
														</option>
														<option value="1" <?php selected( $current_options['announcement-time-frame'], '1' ); ?>>
															<?php esc_html_e( 'All (Past & Future)', 'timeline-express' ); ?>
														</option>
														<option value="2" <?php selected( $current_options['announcement-time-frame'], '2' ); ?>>
															<?php esc_html_e( 'Past', 'timeline-express' ); ?>
														</option>
													</select>
													<p class="description">
														<?php
															/* translators: Timeline Express plural name (eg: announcements) */
															printf( esc_html( 'Select the time frame to query %s from.', 'timeline-express' ), strtolower( $timeline_express_plural_name ) );
														?>
													</p>
												</td>
											</tr>

											<!-- Display Order -->
											<tr valign="top">
												<th scope="row">
													<label for="timeline_express_storage[announcement-display-order]">
														<?php esc_html_e( 'Display Order', 'timeline-express' ); ?>
													</label>
												</th>
												<td>
													<select name="timeline_express_storage[announcement-display-order]" id="announcement-display-order" class="regular-text" />
														<option value="ASC"<?php echo ( 'ASC' === $current_options['announcement-display-order'] ? ' selected' : '' ); ?>>
															<?php esc_html_e( 'Ascending', 'timeline-express' ); ?>
														</option>
														<option value="DESC"<?php echo ( 'DESC' === $current_options['announcement-display-order'] ? ' selected' : '' ); ?>>
															<?php esc_html_e( 'Descending', 'timeline-express' ); ?>
														</option>
													</select>
													<p class="description">
														<?php
															/* translators: Timeline Express plural name (eg: announcements) */
															printf( esc_html( 'Select the order you would like the %s to display.', 'Timeline Express plural name (eg: announcements)', 'timeline-express' ), strtolower( $timeline_express_plural_name ) );
														?>
													</p>
													<p class="description">
														<code>
															<?php
																/* translators: Timeline Express singular name (eg: announcement) */
																printf( esc_html( 'Ascending: Chronological order by %s date.', 'timeline-express' ), strtolower( $timeline_express_singular_name ) );
															?>
														</code>
														<br />
														<code>
															<?php
																/* translators: Timeline Express singular name (eg: announcement) */
																printf( esc_html( 'Descending: Reverse chronological order by %s date.', 'timeline-express' ), strtolower( $timeline_express_singular_name ) );
															?>
														</code>
													</p>
												</td>
											</tr>

											<!-- Excerpt Trim Length -->
											<tr valign="top">
												<th scope="row">
													<label for="timeline_express_storage[excerpt-trim-length]">
														<?php
															/* translators: Timeline Express singular name (eg: Announcement) */
															printf( esc_html( '%s Excerpt Length', 'timeline-express' ), $timeline_express_singular_name );
														?>
													</label>
												</th>
												<td>
													<input <?php if ( isset( $current_options['excerpt-random-length'] ) && '1' === $current_options['excerpt-random-length'] ) { ?> style="display:none;" <?php } ?> type="number" name="timeline_express_storage[excerpt-trim-length]" min="25" value="<?php echo esc_attr( (int) $current_options['excerpt-trim-length'] ); ?>">
													<label for="excerpt-random-length">
														<input type="checkbox" id="excerpt-random-length" name="timeline_express_storage[excerpt-random-length]" onclick="changeRandomTrimLengthCheckbox();" value="1" <?php checked( $current_options['excerpt-random-length'], '1' ); ?> <?php if ( '0' === $current_options['excerpt-random-length'] ) { ?> style="margin-left:.5em;" <?php } ?>>
														<span id="random-lenth-text-container"<?php if ( '0' === $current_options['excerpt-random-length'] ) { ?> class="random-length-text" <?php } ?>>
															<?php esc_html_e( 'random length', 'timeline-express' ); ?>
														</span>
													</label>
													<p class="description">
														<?php
															/* translators: Timeline Express singular name (eg: announcement) */
															printf( esc_html( 'Set the length of the excerpt for each %s.', 'timeline-express' ), strtolower( $timeline_express_singular_name ) );
														?>
													</p>
													<p class="description">
														<code><?php esc_html_e( 'Minimum Length: 25; 50 = 50 character excerpt length.', 'timeline-express' ); ?></code>
													</p>
												</td>
											</tr>

											<!-- Toggle Date Visibility -->
											<tr valign="top">
												<th scope="row">
													<label for="timeline_express_storage[date-visibility]">
														<?php esc_html_e( 'Date Visibility', 'timeline-express' ); ?>
													</label>
												</th>
												<td>
													<select name="timeline_express_storage[date-visibility]" id="timeline_express_storage[date-visibility]" class="regular-text" />
														<option value="1" <?php selected( $current_options['date-visibility'], '1' ); ?>>
															<?php esc_html_e( 'Visible', 'timeline-express' ); ?>
														</option>
														<option value="0" <?php selected( $current_options['date-visibility'], '0' ); ?>>
															<?php esc_html_e( 'Hidden', 'timeline-express' ); ?>
														</option>
													</select>
													<p class="description">
														<?php
															/* translators: Timeline Express singular name (eg: announcement) */
															printf( esc_html( 'Toggle the visibility of the date for the %s.', 'timeline-express' ), strtolower( $timeline_express_singular_name ) );
														?>
													</p>
												</td>
											</tr>

											<!-- Toggle Read Visibility More -->
											<tr valign="top">
												<th scope="row">
													<label for="timeline_express_storage[read-more-visibility]">
													<?php esc_html_e( 'Read More Visibility', 'timeline-express' ); ?>
													</label>
												</th>
												<td>
													<select name="timeline_express_storage[read-more-visibility]" id="read-more-visibility" class="regular-text" />
														<option value="1" <?php selected( $current_options['read-more-visibility'], '1' ); ?>>
															<?php esc_html_e( 'Visible', 'timeline-express' ); ?>
														</option>
														<option value="0" <?php selected( $current_options['read-more-visibility'], '0' ); ?>>
															<?php esc_html_e( 'Hidden', 'timeline-express' ); ?>
														</option>
													</select>
													<p class="description">
														<?php
															/* translators: Timeline Express singular name (eg: announcement) */
															printf( esc_html( 'Toggle the visibility of the read more button. Hide to prevent users from viewing the full %s.', 'timeline-express' ), strtolower( $timeline_express_singular_name ) );
														?>
													</p>
												</td>
											</tr>

											<!-- Default Announcement Icon -->
											<tr valign="top">
												<th scope="row">
													<label for="timeline_express_storage[default-announcement-icon]">
														<?php esc_html_e( 'Default Icon', 'timeline-express' ); ?>
													</label>
												</th>
												<td>
													<?php
														/* Display our dropdown, pass in the ID, and empty desc */
														timeline_express_build_bootstrap_icon_dropdown(
															array(
																'id' => 'timeline_express_storage[default-announcement-icon]',
																'desc' => '',
															),
															'fa-' . esc_attr( $current_options['default-announcement-icon'] )
														);
													?>
													<p class="description">
														<?php
															/* translators: Timeline Express plural name (eg: announcements) */
															printf( esc_html( 'Select the font-awesome icon that you would like to use as a default icon for new %s.', 'timeline-express' ), strtolower( $timeline_express_plural_name ) );
														?>
														<a href="http://fortawesome.github.io/Font-Awesome/cheatsheet/" target="_blank" style="font-size:12px;font-style:em;">
															<?php esc_html_e( 'cheat sheet', 'timeline-express' ); ?>
														</a>
													</p>
												</td>
											</tr>

											<!-- Default Announcement Color -->
											<tr valign="top">
												<th scope="row">
													<label for="timeline_express_storage[default-announcement-color]">
														<?php
															/* translators: Timeline Express singular name (eg: announcement) */
															printf( esc_html( 'Default %s Color', 'timeline-express' ), $timeline_express_singular_name );
														?>
													</label>
												</th>
												<td>
													<input name="timeline_express_storage[default-announcement-color]" type="text" id="default-announcement-color" value="<?php echo esc_attr( $current_options['default-announcement-color'] ); ?>" class="regular-text color-picker-field" />
													<p class="description">
														<?php
															/* translators: Timeline Express plural name (eg: announcements) */
															printf( esc_html( 'Set the default color for all new %s.', 'timeline-express' ), strtolower( $timeline_express_plural_name ) );
														?>
													</p>
													<p clss="description">
														<code>
															<?php
																/* translators: Timeline Express singular name (eg: announcement) */
																printf( esc_html( 'Note: You can override this setting within each %s.', 'timeline-express' ), strtolower( $timeline_express_singular_name ) );
															?>
														</code>
													</p>
												</td>
											</tr>

											<!-- Single Announcement Container Background -->
											<tr valign="top">
												<th scope="row">
													<label for="timeline_express_storage[announcement-bg-color]">
														<?php
															/* translators: Timeline Express singular name (eg: announcement) */
															printf( esc_html( '%s Container Background Color', 'timeline-express' ), $timeline_express_singular_name );
														?>
													</label>
												</th>
												<td>
													<input type="text" name="timeline_express_storage[announcement-bg-color]" class="color-picker-field" value="<?php echo esc_attr( $current_options['announcement-bg-color'] ); ?>" />
													<p class="description">
														<?php
															/* translators: Timeline Express singular name (eg: announcement) */
															printf( esc_html( 'Set the background color of the %s container on the timeline.', 'timeline-express' ), strtolower( $timeline_express_singular_name ) );
														?>
													</p>
												</td>
											</tr>

											<!-- Single Announcement Box Shadow Color -->
											<tr valign="top">
												<th scope="row">
													<label for="timeline_express_storage[announcement-box-shadow-color]">
														<?php
															/* translators: Timeline Express singular name (eg: announcement) */
															printf( esc_html( '%s Shadow Color', 'timeline-express' ), $timeline_express_singular_name );
														?>
													</label>
												</th>
												<td>
													<input type="text" name="timeline_express_storage[announcement-box-shadow-color]" class="color-picker-field" value="<?php echo esc_attr( $current_options['announcement-box-shadow-color'] ); ?>" />
													<p class="description">
														<?php
															/* translators: Timeline Express singular name (eg: announcement) */
															printf( esc_html( 'Set the shadow color for the %s container on the timeline.', 'timeline-express' ), strtolower( $timeline_express_singular_name ) );
														?>
													</p>
												</td>
											</tr>

											<!-- Background Line Color -->
											<tr valign="top">
												<th scope="row">
													<label for="timeline_express_storage[announcement-background-line-color]">
														<?php esc_html_e( 'Timeline Background Line Color', 'timeline-express' ); ?>
													</label>
												</th>
												<td>
													<input type="text" name="timeline_express_storage[announcement-background-line-color]" class="color-picker-field" value="<?php echo esc_attr( $current_options['announcement-background-line-color'] ); ?>" />
													<p class="description">
														<?php esc_html_e( 'Select the color of the line in the background of the timeline.', 'timeline-express' ); ?>
													</p>
												</td>
											</tr>

											<!-- No Announcements Message -->
											<tr valign="top">
												<th scope="row">
													<label for="timeline_express_storage[no-events-message]">
														<?php
															/* translators: Timeline Express plural name (eg: announcements) */
															printf( esc_html( 'No %s Message', 'timeline-express' ), $timeline_express_plural_name );
														?>
													</label>
												</th>
												<td>
													<?php

													wp_editor(
														stripslashes( $current_options['no-events-message'] ),
														'no-events-message',
														$additional_editor_parameters
													);

													?>
													<p class="description">
														<?php
															/* translators: Timeline Express plural name (eg: announcements) */
															printf( esc_html( 'Set the message that will display when no %s are found.', 'timeline-express' ), strtolower( $timeline_express_plural_name ) );
														?>
													</p>
												</td>
											</tr>

											<!-- Publicly Query Timeline Announcements Checkbox -->
											<tr valign="top">
												<th scope="row">
													<label for="timeline_express_storage[delete-announcement-posts-on-uninstallation]">
														<?php
															/* translators: Timeline Express plural name (eg: announcements) */
															printf( esc_html( 'Exclude %s from Site Searches', 'timeline-express' ), $timeline_express_plural_name );
														?>
													</label>
												</th>
												<td>
													<select name="timeline_express_storage[announcement-appear-in-searches]" id="announcement-appear-in-searches" class="regular-text" />
														<option value="true" <?php selected( $current_options['announcement-appear-in-searches'], 'true' ); ?>>
															<?php esc_html_e( 'True', 'timeline-express' ); ?>
														</option>
														<option value="false" <?php selected( $current_options['announcement-appear-in-searches'], 'false' ); ?>>
															<?php esc_html_e( 'False', 'timeline-express' ); ?>
														</option>
													</select>
													<p class="description">
														<?php
															/* translators: Timeline Express plural name (eg: announcements) */
															printf( esc_html( 'Set to true to exclude %1$s from site searches. False will include %1$s in site searches.', 'timeline-express' ), strtolower( $timeline_express_plural_name ) );
														?>
													</p>
												</td>
											</tr>

											<!-- Disable Timeline Animation -->
											<tr valign="top">
												<th scope="row">
													<label for="timeline_express_storage[disable-animation]">
														<?php esc_html_e( 'Disable Timeline Animations', 'timeline-express' ); ?>
													</label>
												</th>
												<td>
													<input type="checkbox" name="timeline_express_storage[disable-animation]" <?php if ( isset( $current_options['disable-animation'] ) ) { checked( $current_options['disable-animation'], '1' ); } ?> value="1" />
													<p class="description">
														<?php esc_html_e( 'Check this option off to disable the timeline animations while scrolling.', 'timeline-express' ); ?>
													</p>
												</td>
											</tr>

											<!-- Delete Announcements On Uninstall Checkbox -->
											<tr valign="top">
												<th scope="row">
													<label for="timeline_express_storage[delete-announcement-posts-on-uninstallation]">
														<?php
															/* translators: Timeline Express plural name (eg: announcements) */
															printf( esc_html( 'Delete %s On Uninstall', 'timeline-express' ), $timeline_express_plural_name );
														?>
													</label>
												</th>
												<td>
													<input type="checkbox" name="timeline_express_storage[delete-announcement-posts-on-uninstallation]" onclick="toggleDeleteCheckClass();" <?php checked( $current_options['delete-announcement-posts-on-uninstallation'], '1' ); ?> value="1" />
													<span class="delete-yes"></span>
													<p class="description">
														<?php
															/* translators: Timeline Express plural name (eg: announcements) */
															printf( esc_html( 'Check this option to delete all %1$s from the database on plugin uninstall. This can not be undone. If you want to back them up, it is recommended you %2$s before uninstalling.', 'timeline-express' ), strtolower( $timeline_express_plural_name ), '<a href="' . admin_url( 'export.php' ) . '">' . sprintf( esc_html__( 'export your %s', 'timeline-express' ), strtolower( $timeline_express_plural_name ) ) . '</a>' );
														?>
													</p>
												</td>
											</tr>

											<!-- Submit Button -->
											<tr>
												<td></td>
												<td>
													<br />
													<input type="hidden" name="save-timeline-express-options" value="true" />
													<input type="submit" name="submit" id="submit" class="button-primary" value="<?php esc_attr_e( 'Save Settings', 'timeline-express' ); ?>">
												</td>
											</tr>

										</tbody>
									</table>

								</form>

							<?php } // End if().
							?>

						</div>
						<!-- .inside -->

					</div>
					<!-- .postbox -->

				</div>
				<!-- .meta-box-sortables .ui-sortable -->

			</div>
			<!-- post-body-content -->

			<!-- sidebar -->
			<div id="postbox-container-1" class="postbox-container te-sidebar<?php echo esc_attr( $active_add_ons_class ); ?>">

				<div class="meta-box-sortables">

					<!-- Timeline Express Logo Metabox -->
					<div class="postbox">
						<div class="inside" style="padding:0;">
							<a href="https://www.wp-timelineexpress.com" target="_blank" style="display:block;">
								<img src="<?php echo esc_url( TIMELINE_EXPRESS_URL . 'lib/admin/images/timeline-express-logo-128.png' ); ?>" style="display:block;margin:0 auto;" title="Timeline Express" />
							</a>
						</div>
						<!-- .inside -->
					</div>
					<!-- Timeline Express Logo metabox -->

					<!-- CodeParrots Metabox -->
					<div class="postbox">
						<div class="inside">
							<a href="https://www.codeparrots.com" target="_blank" style="display:block;">
								<img src="<?php echo esc_url( TIMELINE_EXPRESS_URL . 'lib/admin/images/code-parrots-logo-dark.png' ); ?>" title="Code Parrots" style="max-width:100%;" />
							</a>
						</div>
						<!-- .inside -->
					</div>
					<!-- codeparrots metabox -->

					<!-- Rating -->
					<div class="postbox" style="text-align:center;">
						<h2>
							<span>
								<?php esc_html_e( 'Support Timeline Express', 'timeline-express' ); ?>
							</span>
						</h2>

						<div class="inside">

								<p style="margin-bottom:0;"><?php esc_html_e( 'Leave A Review', 'timeline-express' ); ?></p>

								<!-- Stars -->
								<div class="dashicons dashicons-star-filled"></div>
								<div class="dashicons dashicons-star-filled"></div>
								<div class="dashicons dashicons-star-filled"></div>
								<div class="dashicons dashicons-star-filled"></div>
								<div class="dashicons dashicons-star-filled"></div>

								<p style="margin-bottom:0;"><?php esc_html_e( 'Tweet About It', 'timeline-express' ); ?></p>

								<a href="https://twitter.com/share" class="twitter-share-button" data-url="https://www.wp-timelineexpress.com" data-text="I am using the Timeline Express #WordPress plugin on my site!" data-via="CodeParrots" data-size="large">Tweet</a>
								<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+'://platform.twitter.com/widgets.js';fjs.parentNode.insertBefore(js,fjs);}}(document, 'script', 'twitter-wjs');</script>

						</div>
						<!-- .inside -->
					</div>
					<!-- codeparrots metabox -->

					<!-- Documentation Metabox -->
					<div class="postbox">
						<h2 style="text-align:center;">
							<span>
								<?php esc_html_e( 'Help & Documentation', 'timeline-express' ); ?>
							</span>
						</h2>

						<div class="inside">
							<p><?php esc_html_e(
								'If you need help, or run into any issues, you can reach out for support in the WordPress.org support forums. Additionally, please see our documentation for tutorials, frequent issues and how-tos.',
								'timeline-express'
							); ?></p>
							<a href="https://wordpress.org/support/plugin/timeline-express" target="_blank" class="button-secondary">
								<?php esc_html_e( 'Support Forums', 'timeline-express' ); ?>
							</a>
							<a href="https://www.wp-timelineexpress.com/documentation/" target="_blank" class="button-secondary">
								<?php esc_html_e( 'Documentation', 'timeline-express' ); ?>
							</a>
						</div>
						<!-- .inside -->
					</div>
					<!-- .postbox -->

					<!-- Toggle built-in caching -->
					<div class="postbox">
						<h2 style="text-align:center;">
							<span>
								<?php esc_html_e( 'Toggle Built-in Caching', 'timeline-express' ); ?>
							</span>
						</h2>

						<div class="inside">
							<p><?php esc_html_e(
								'Timeline Express has a number of caching mechanisms built into the plugin to lessen the impact on load times of your site. When disabled, all cached data will be ignored and fresh data will be retreived on each new page load.',
								'timeline-express'
							); ?></p>

							<?php

							$cache_enabled       = get_option( 'timeline_express_cache_enabled', 1 );
							$cache_enabled_label = $cache_enabled ? __( 'Cache is enabled.', 'timeline-express-pro' ) : __( 'Cache is disabled.', 'timeline-express-pro' );
							$checked_attr        = $cache_enabled ? 'checked' : '';

							?>

							<div class="toggle-cache">
								<div class="pretty p-switch p-fill">
									<input class="timeline-express-toggle-cache" type="checkbox" <?php echo esc_attr( $checked_attr ); ?> />
									<div class="state">
										<label><?php echo esc_html( $cache_enabled_label ); ?></label>
									</div>
								</div>
							</div>

						</div>
					</div>
					<!-- /toggle built-in caching -->

					<!-- Documentation Metabox -->
					<div class="postbox">
						<h2 style="text-align:center;">
							<span>
								<?php esc_html_e( 'Flush Cached Data', 'timeline-express' ); ?>
							</span>
						</h2>

						<div class="inside">
							<p><?php esc_html_e(
								'Flush all cached Timeline Express data. This will reset any cached data so your timelines will update on the front of site. If you notice your timelines are not up to date, try clearing the cache below.',
								'timeline-express'
							); ?></p>

							<?php
							global $wpdb;

							// Query the database for all transients with the text 'timeline-express-query'
							$results = $wpdb->get_results(
								$wpdb->prepare(
									"SELECT * from `{$wpdb->prefix}options` WHERE option_name LIKE %s;", '%' . $wpdb->esc_like( 'timeline-express-query' ) . '%' // @codingStandardsIgnoreLine
								)
							);

							$class = '';

							if ( ! $results || empty( $results ) ) {

								$class = 'disabled';

							}

							printf(
								'<a href="%s" class="button button-secondary %s widefat" style="text-align: center;" name="">%s</a>',
								wp_nonce_url( admin_url( 'edit.php?post_type=te_announcements&page=timeline-express-settings' ), 'flush_cache' ),
								esc_attr( $class ),
								esc_html__( 'Flush Cache', 'timeline-express' )
							);

							?>

						</div>
						<!-- .inside -->
					</div>
					<!-- .postbox -->

				</div>
				<!-- .meta-box-sortables -->

			</div>
			<!-- #postbox-container-1 .postbox-container -->

		</div>
		<!-- #post-body .metabox-holder .columns-2 -->

		<br class="clear">
	</div>
	<!-- #poststuff -->

</div> <!-- .wrap -->
