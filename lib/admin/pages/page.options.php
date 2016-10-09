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
	'textarea_name' => 'timeline_express_storage[no-events-message]',
	'teeny' => true,
	'textarea_rows' => 15,
	'tabindex' => 1,
	'drag_drop_upload' => true,
);
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
							<h1 id="timeline-express-page-header">
								<?php esc_html_e( 'Timeline Express Settings', 'timeline-express' ); ?>
							</h1>
							<p class="description">
								<?php esc_html_e( 'Alter your timeline settings here. You can adjust some of the visual settings as well as the display order, below.', 'timeline-express' ); ?>
							</p>
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

					<div class="postbox">
						<div class="inside">

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
													<option value="0"<?php echo ( '0' === $current_options['announcement-time-frame'] ? ' selected' : ''); ?>>
														<?php esc_html_e( 'Future Events', 'timeline-express' ); ?>
													</option>
													<option value="1"<?php echo ( '1' === $current_options['announcement-time-frame'] ? ' selected' : ''); ?>>
														<?php esc_html_e( 'All Events (past+future)', 'timeline-express' ); ?>
													</option>
													<option value="2"<?php echo ( '2' === $current_options['announcement-time-frame'] ? ' selected' : ''); ?>>
														<?php esc_html_e( 'Past Events','timeline-express' ); ?>
													</option>
												</select>
												<p class="description">
													<?php esc_html_e( 'Select the time frame to query events from.', 'timeline-express' ); ?>
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
													<?php esc_html_e( 'Select the order you would like the announcements to display. Ascending : Chronological order by announcement date. Descending : Reverse chronological order by announcement date.', 'timeline-express' ); ?>
												</p>
											</td>
										</tr>

										<!-- Excerpt Trim Length -->
										<tr valign="top">
											<th scope="row">
												<label for="timeline_express_storage[excerpt-trim-length]">
													<?php esc_html_e( 'Announcement Excerpt Length', 'timeline-express' ); ?>
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
													<?php esc_html_e( 'Set the length of the excerpt for each announcement. ( min=25; 50 = 50 characters )', 'timeline-express' ); ?>
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
													<?php esc_html_e( 'Toggle the visibility of the date next to the icon.', 'timeline-express' ); ?>
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
													<option value="1" <?php selected( $current_options['read-more-visibility'] , '1' ); ?>>
														<?php esc_html_e( 'Visible', 'timeline-express' ); ?>
													</option>
													<option value="0" <?php selected( $current_options['read-more-visibility'] , '0' ); ?>>
														<?php esc_html_e( 'Hidden', 'timeline-express' ); ?>
													</option>
												</select>
												<p class="description">
													<?php esc_html_e( 'Toggle the visibility of the read more button. Hide to prevent users from viewing the full announcement.', 'timeline-express' ); ?>
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
													<?php esc_html_e( 'Select the font-awesome icon that you would like to use as a default icon for new announcements.', 'timeline-express' ); ?>
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
													<?php esc_html_e( 'Default Announcement Color', 'timeline-express' ); ?>
												</label>
											</th>
											<td>
												<input name="timeline_express_storage[default-announcement-color]" type="text" id="default-announcement-color" value="<?php echo esc_attr( $current_options['default-announcement-color'] ); ?>" class="regular-text color-picker-field" />
												<p class="description">
													<?php esc_html_e( 'Select the default color for all new events. Note : this setting can be overwritten', 'timeline-express' ); ?>
												</p>
											</td>
										</tr>

										<!-- Single Announcement Container Background -->
										<tr valign="top">
											<th scope="row">
												<label for="timeline_express_storage[announcement-bg-color]">
													<?php esc_html_e( 'Announcement Container Background', 'timeline-express' ); ?>
												</label>
											</th>
											<td>
												<input type="text" name="timeline_express_storage[announcement-bg-color]" class="color-picker-field" value="<?php echo esc_attr( $current_options['announcement-bg-color'] ); ?>" />
												<p class="description">
													<?php esc_html_e( 'Select the background color of the announcement container.', 'timeline-express' ); ?>
												</p>
											</td>
										</tr>

										<!-- Single Announcement Box Shadow Color -->
										<tr valign="top">
											<th scope="row">
												<label for="timeline_express_storage[announcement-box-shadow-color]">
													<?php esc_html_e( 'Announcement Shadow Color', 'timeline-express' ); ?>
												</label>
											</th>
											<td>
												<input type="text" name="timeline_express_storage[announcement-box-shadow-color]" class="color-picker-field" value="<?php echo esc_attr( $current_options['announcement-box-shadow-color'] ); ?>" />
												<p class="description">
													<?php esc_html_e( 'Select the shadow color for the announcement container.', 'timeline-express' ); ?>
												</p>
											</td>
										</tr>

										<!-- Background Line Color -->
										<tr valign="top">
											<th scope="row">
												<label for="timeline_express_storage[announcement-background-line-color]">
													<?php esc_html_e( 'Background Line Color', 'timeline-express' ); ?>
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
													<?php esc_html_e( 'No Announcements Message', 'timeline-express' ); ?>
												</label>
											</th>
											<td>
												<?php wp_editor(
													stripslashes( $current_options['no-events-message'] ),
													'no-events-message',
													$additional_editor_parameters
												); ?>
												<p class="description">
													<?php esc_html_e( 'This is the message that will display when no announcements are found.', 'timeline-express' ); ?>
												</p>
											</td>
										</tr>

										<!-- Publicly Query Timeline Announcements Checkbox -->
										<tr valign="top">
											<th scope="row">
												<label for="timeline_express_storage[delete-announcement-posts-on-uninstallation]">
													<?php esc_html_e( 'Exclude Announcements from Site Searches', 'timeline-express' ); ?>
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
													<?php esc_html_e( 'Set to true to exclude announcements from all site searches. False will include announcements in site searches.', 'timeline-express' ); ?>
												</p>
											</td>
										</tr>

										<!-- Disable Timeline Animation -->
										<tr valign="top">
											<th scope="row">
												<label for="timeline_express_storage[disable-animation]">
													<?php esc_html_e( 'Disable Timeline Animations?', 'timeline-express' ); ?>
												</label>
											</th>
											<td>
												<input type="checkbox" name="timeline_express_storage[disable-animation]" <?php if ( isset( $current_options['disable-animation'] ) ) { checked( $current_options['disable-animation'] , '1' ); } ?> value="1" />
												<p class="description">
													<?php esc_html_e( 'Check this option off to disable the timeline animations while scrolling.', 'timeline-express' ); ?>
												</p>
											</td>
										</tr>

										<!-- Delete Announcements On Uninstall Checkbox -->
										<tr valign="top">
											<th scope="row">
												<label for="timeline_express_storage[delete-announcement-posts-on-uninstallation]">
													<?php esc_html_e( 'Delete Announcements On Uninstall?', 'timeline-express' ); ?>
												</label>
											</th>
											<td>
												<input type="checkbox" name="timeline_express_storage[delete-announcement-posts-on-uninstallation]" onclick="toggleDeleteCheckClass();" <?php checked( $current_options['delete-announcement-posts-on-uninstallation'] , '1' ); ?> value="1" />
												<span class="<?php if ( '0' === $current_options['delete-announcement-posts-on-uninstallation'] ) { ?> delete-no <?php } else { ?> delete-yes <?php } ?>" onclick="toggle_delete_checkbox();"></span>
												<p class="description">
													<?php esc_html_e( 'Check this option to delete all announcement posts from the data base on plugin uninstallation. this can not be undone, once they are deleted they are gone forever. If you want to back them up, it is recommended you export your announcements before uninstalling.', 'timeline-express' ); ?>
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
						</div>
						<!-- .inside -->

					</div>
					<!-- .postbox -->

				</div>
				<!-- .meta-box-sortables .ui-sortable -->

			</div>
			<!-- post-body-content -->

			<!-- sidebar -->
			<div id="postbox-container-1" class="postbox-container">

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
