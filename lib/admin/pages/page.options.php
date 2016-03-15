<?php
/**
 * Options Page
 *
 * @package WordPress
 * @since 1.2
 */

// Getting our variables to pass into our donation link.
$current_user_object = wp_get_current_user();
if ( isset( $current_user_object->user_firstname ) && '' !== $current_user_object->user_firstname ) {
	$current_user_name = $current_user_object->user_firstname;
	$current_user_name .= ' ' . $current_user_object->user_lastname;
} else {
	$current_user_name = '';
	$current_user_name .= '';
}

// Get & Store the current options from the database.
$current_options = timeline_express_get_options();

	// Setup the options for our WYSIWYG editors for the optin messages.
	$no_event_messages_parameters = array(
		'teeny' => true,
		'textarea_rows' => 15,
		'tabindex' => 1,
		'textarea_name' => 'no-events-message',
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
								<?php esc_attr_e( 'Timeline Express Settings','timeline-express' ); ?>
							</h1>
							<p style="margin-top:0;font-weight:200;" class="description">
								<?php esc_attr_e( 'Alter your timeline settings here. You can adjust some of the visual settings as well as the display order, below.' , 'timeline-express' ); ?>
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

							<form method="post" name="timeline-express-form" id="timeline-express-form">
								<table class="form-table timeline-express-form">
									<tbody>

										<!-- Select Time Frame -->
										<tr valign="top">
											<th scope="row"><label for="announcement-time-frame"><?php _e('Time Frame','timeline-express'); ?></label></th>
											<td>
												<select name="announcement-time-frame" id="announcement-time-frame" class="regular-text" />
													<option value="0"<?php echo ($current_options['announcement-time-frame'] === '0' ? ' selected' : ''); ?>><?php _e('Future Events','timeline-express'); ?></option>
													<option value="1"<?php echo ($current_options['announcement-time-frame'] === '1' ? ' selected' : ''); ?>><?php _e('All Events (past+future)','timeline-express'); ?></option>
													<option value="2"<?php echo ($current_options['announcement-time-frame'] === '2' ? ' selected' : ''); ?>><?php _e('Past Events','timeline-express'); ?></option>
												</select>
												<p class="description">
													<?php _e('Select the time frame to query events from.','timeline-express'); ?>
												</p>
											</td>
										</tr>

										<!-- Display Order -->
										<tr valign="top">
											<th scope="row"><label for="announcement-display-order"><?php _e('Display Order','timeline-express'); ?></label></th>
											<td>
												<select name="announcement-display-order" id="announcement-display-order" class="regular-text" />
													<option value="ASC"<?php echo ($current_options['announcement-display-order'] === 'ASC' ? ' selected' : ''); ?>><?php _e('Ascending','timeline-express'); ?></option>
													<option value="DESC"<?php echo ($current_options['announcement-display-order'] === 'DESC' ? ' selected' : ''); ?>><?php _e('Descending','timeline-express'); ?></option>
												</select>
												<p class="description">
													<?php _e('Select the order you would like the announcements to display. Ascending : Chronological order by announcement date. Descending : Reverse chronological order by announcement date.','timeline-express'); ?>
												</p>
											</td>
										</tr>

										<!-- Excerpt Trim Length -->
										<tr valign="top">
											<th scope="row"><label for="excerpt-trim-length"><?php _e('Announcement Excerpt Length','timeline-express'); ?></label></th>
											<td>
												<input <?php if( $current_options['excerpt-random-length'] == '1' ) { ?> style="display:none;" <?php } ?> type="number" name="excerpt-trim-length" min="25" value="<?php echo $current_options['excerpt-trim-length']; ?>">
												<label for="excerpt-random-length">
													<input type="checkbox" id="excerpt-random-length" name="excerpt-random-length" onclick="changeRandomTrimLengthCheckbox();" value="1" <?php checked( $current_options['excerpt-random-length'], '1' ); ?> <?php if( $current_options['excerpt-random-length'] == '0' ) { ?> style="margin-left:.5em;" <?php } ?>>
													<span id="random-lenth-text-container"<?php if( $current_options['excerpt-random-length'] == '0' ) { ?> class="random-length-text" <?php } ?>>
														<?php _e( 'random length', 'timeline-express' ); ?>
													</span>
												</label>
												<p class="description">
													<?php _e('Set the length of the excerpt for each announcement. ( min=25; 50 = 50 characters )','timeline-express'); ?>
												</p>
											</td>
										</tr>

										<!-- Toggle Date Visibility -->
										<tr valign="top">
											<th scope="row"><label for="date-visibility"><?php _e('Date Visibility','timeline-express'); ?></label></th>
											<td>
												<select name="date-visibility" id="date-visibility" class="regular-text" />
													<option value="1"<?php echo ($current_options['date-visibility'] === '1' ? ' selected' : ''); ?>><?php _e('Visible','timeline-express'); ?></option>
													<option value="0"<?php echo ($current_options['date-visibility'] === '0' ? ' selected' : ''); ?>><?php _e('Hidden','timeline-express'); ?></option>
												</select>
												<p class="description">
													<?php _e('Toggle the visibility of the date next to the icon.','timeline-express'); ?>
												</p>
											</td>
										</tr>

										<!-- Toggle Read Visibility More -->
										<tr valign="top">
											<th scope="row"><label for="read-more-visibility"><?php _e('Read More Visibility','timeline-express'); ?></label></th>
											<td>
												<select name="read-more-visibility" id="read-more-visibility" class="regular-text" />
													<option value="1" <?php selected( $current_options['read-more-visibility'] , '1' ); ?>><?php _e('Visible','timeline-express'); ?></option>
													<option value="0" <?php selected( $current_options['read-more-visibility'] , '0' ); ?>><?php _e('Hidden','timeline-express'); ?></option>
												</select>
												<p class="description">
													<?php _e('Toggle the visibility of the read more button. Hide to prevent users from viewing the full announcement.','timeline-express'); ?>
												</p>
											</td>
										</tr>

										<!-- Default Announcement Icon -->
										<tr valign="top">
											<th scope="row"><label for="default-announcement-icon"><?php _e('Default Icon','timeline-express'); ?></label></th>
											<td>
												<?php
													// display our dropdown, pass in the ID, and empty desc.
													timeline_express_build_bootstrap_icon_dropdown( array( 'id' => 'default-announcement-icon' , 'desc' => '' ) , 'fa-'.$current_options['default-announcement-icon'] );
												?>
												<p class="description">
													<?php _e('Select the font-awesome icon that you would like to use as a default icon for new announcements.','timeline-express'); ?> <a href="http://fortawesome.github.io/Font-Awesome/cheatsheet/" target="_blank" style="font-size:12px;font-style:em;">cheat sheet</a>
												</p>
											</td>
										</tr>

										<!-- Default Announcement Color -->
										<tr valign="top">
											<th scope="row"><label for="default-announcement-color"><?php _e('Default Announcement Color','timeline-express'); ?></label></th>
											<td>
												<input name="default-announcement-color" type="text" id="default-announcement-color" value="<?php echo $current_options['default-announcement-color']; ?>" class="regular-text color-picker-field" />
												<p class="description">
													<?php _e('Select the default color for all new events. Note : this setting can be overwritten','timeline-express'); ?>
												</p>
											</td>
										</tr>

										<!-- Single Announcement Container Background -->
										<tr valign="top">
											<th scope="row"><label for="announcement-bg-color"><?php _e('Announcement Container Background','timeline-express'); ?></label></th>
											<td>
												<input type="text" name="announcement-bg-color" class="color-picker-field" value="<?php echo $current_options['announcement-bg-color']; ?>" />
												<p class="description">
													<?php _e('Select the background color of the announcement container.','timeline-express'); ?>
												</p>
											</td>
										</tr>

										<!-- Single Announcement Box Shadow Color -->
										<tr valign="top">
											<th scope="row"><label for="announcement-box-shadow-color"><?php _e('Announcement Shadow Color','timeline-express'); ?></label></th>
											<td>
												<input type="text" name="announcement-box-shadow-color" class="color-picker-field" value="<?php echo $current_options['announcement-box-shadow-color']; ?>" />
												<p class="description">
													<?php _e('Select the shadow color for the announcement container.','timeline-express'); ?>
												</p>
											</td>
										</tr>

										<!-- Background Line Color -->
										<tr valign="top">
											<th scope="row"><label for="announcement-background-line-color"><?php _e('Background Line Color','timeline-express'); ?></label></th>
											<td>
												<input type="text" name="announcement-background-line-color" class="color-picker-field" value="<?php echo $current_options['announcement-background-line-color']; ?>" />
												<p class="description">
													<?php _e('Select the color of the line in the background of the timeline.','timeline-express'); ?>
												</p>
											</td>
										</tr>

										<!-- No Announcements Message -->
										<tr valign="top">
											<th scope="row"><label for="no-events-message"><?php _e('No Announcements Message','timeline-express'); ?></label></th>
											<td>
												<?php wp_editor( stripslashes( $current_options['no-events-message'] ) , 'no-events-message', $no_event_messages_parameters); ?>
												<p class="description">
													<?php _e('This is the message that will display when no announcements are found.','timeline-express'); ?>
												</p>
											</td>
										</tr>

										<!-- Publicly Query Timeline Announcements Checkbox -->
										<tr valign="top">
											<th scope="row"><label for="delete-announcement-posts-on-uninstallation"><?php _e('Exclude Announcements from Site Searches','timeline-express'); ?></label></th>
											<td>
												<select name="announcement-appear-in-searches" id="announcement-appear-in-searches" class="regular-text" />
													<option value="true"<?php echo ($current_options['announcement-appear-in-searches'] === 'true' ? ' selected' : ''); ?>><?php _e('True','timeline-express'); ?></option>
													<option value="false"<?php echo ($current_options['announcement-appear-in-searches'] === 'false' ? ' selected' : ''); ?>><?php _e('False','timeline-express'); ?></option>
												</select>
												<p class="description">
													<?php _e('Set to true to exclude announcements from all site searches. False will include announcements in site searches.','timeline-express'); ?>
												</p>
											</td>
										</tr>

										<!-- Delete Announcements On Uninstall Checkbox -->
										<tr valign="top">
											<th scope="row"><label for="delete-announcement-posts-on-uninstallation"><?php _e('Delete Announcements On Uninstall?','timeline-express'); ?></label></th>
											<td>
												<input type="checkbox" name="delete-announcement-posts-on-uninstallation" onclick="toggleDeleteCheckClass();" <?php checked( $current_options['delete-announcement-posts-on-uninstallation'] , '1' ); ?> value="1" /><span class="<?php if( $current_options['delete-announcement-posts-on-uninstallation'] == '0' ) { ?> delete-no <?php } else { ?> delete-yes <?php } ?>" onclick="toggle_delete_checkbox();"></span>
												<p class="description">
													<?php _e('Select this to delete all announcement posts from the data base on plugin uninstallation. this can not be undone, once they are deleted they are gone forever. If you want to keep them, export your announcements before uninstalling.','timeline-express'); ?>
												</p>
											</td>
										</tr>
										<!-- Submit Button -->
										<tr>
											<td></td>
											<td>
												<br />
												<input type="hidden" name="save-timeline-express-options" value="true" />
												<input type="submit" name="submit" id="submit" class="button-primary" value="<?php _e( 'Save Settings' , 'timeline-express' ); ?>">
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

					<!-- CodeParrots Metabox -->
					<div class="postbox">
						<div class="inside">
							<a href="http://www.wp-timelineexpress.com" target="_blank" style="display:block;">
								<img src="<?php echo TIMELINE_EXPRESS_URL . 'lib/admin/images/timeline-express-logo-128.png'; ?>" style="display:block;margin:0 auto;margin-bottom:5px;" title="Timeline Express" />
							</a>
							<a href="https://www.codeparrots.com" target="_blank" style="display:block;">
								<img src="<?php echo TIMELINE_EXPRESS_URL . 'lib/admin/images/code-parrots-logo-dark.png'; ?>" title="Code Parrots" style="max-width:100%;" />
							</a>
						</div>
						<!-- .inside -->
					</div>
					<!-- codeparrots metabox -->

					<!-- Rating -->
					<div class="postbox" style="text-align:center;">
						<h2><span><?php esc_attr_e( 'Support Timeline Express', 'timeline-express' ); ?></span></h2>
						<div class="inside">

								<p style="margin-bottom:0;"><?php _e( 'Leave A Review', 'timeline-express' ); ?></p>
								<div class="dashicons dashicons-star-filled"></div><div class="dashicons dashicons-star-filled"></div><div class="dashicons dashicons-star-filled"></div><div class="dashicons dashicons-star-filled"></div><div class="dashicons dashicons-star-filled"></div>

								<p style="margin-bottom:0;"><?php _e( 'Tweet About It', 'timeline-express' ); ?></p>
								<a href="https://twitter.com/share" class="twitter-share-button" data-url="http://www.wp-timelineexpress.com" data-text="I am using the Timeline Express #WordPress plugin on my site!" data-via="CodeParrots" data-size="large">Tweet</a>
								<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+'://platform.twitter.com/widgets.js';fjs.parentNode.insertBefore(js,fjs);}}(document, 'script', 'twitter-wjs');</script>

						</div>
						<!-- .inside -->
					</div>
					<!-- codeparrots metabox -->

					<!-- Documentation Metabox -->
					<div class="postbox">
						<h2 style="text-align:center;"><span><?php esc_attr_e( 'Help & Documentation', 'timeline-express' ); ?></span></h2>
						<div class="inside">
							<p><?php esc_attr_e(
									'If you need help, or run into any issues, you can reach out for support in the WordPress.org support forums. Additionally, please see our documentation for tutorials, frequent issues and how-tos.',
									'timeline-express'
								); ?></p>
							<a href="https://wordpress.org/support/plugin/timeline-express" target="_blank" class="button-secondary"><?php esc_attr_e( 'Support Forums', 'timeline-express' ); ?></a>
							<a href="www.wp-timelineexpress.com/documentation/" target="_blank" class="button-secondary"><?php esc_attr_e( 'Documentation', 'timeline-express' ); ?></a>
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
