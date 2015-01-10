<?php
	$current_user_object = wp_get_current_user();
	$current_user_name = $current_user_object->user_firstname;
	$current_user_name .= ' ' . $current_user_object->user_lastname;
?>

<style>
.cmb-type-custom_about_the_author_callback th {
		display: none;
	}
.dashicons-heart {
		background: -webkit-linear-gradient(top, #ff8cf7, #e2a5e0);
		background: linear-gradient(top, #ff8cf7, #e2a5e0);
		-webkit-background-clip: text;
		-webkit-text-fill-color: transparent;
		line-height: 1.5;
		font-size: 13px;
		width: 13px;
	}
.cmb-type-custom_about_the_author_callback td {
		padding: 15px 2px !important;
	}		
	#about_the_author .inside {
		padding-bottom: 0;
	}
.te-button-container {
	display: inline-block;
	text-align: center;
	width: 100%;
	margin-bottom: .75em;
}	
	.te-button-container a.button-secondary {
		margin: 0 5px !important;
	}	
</style>
		
<section class="te-button-container">
	<a class="button-secondary" href="<?php echo admin_url() . 'edit.php?post_type=te_announcements&page=timeline-express-support'; ?>" target="_blank"><?php _e( 'Help!' , 'timeline-express' ); ?></a>
	<a class="button-secondary" href="https://wordpress.org/support/view/plugin-reviews/timeline-express" target="_blank"><?php _e( 'Review' , 'timeline-express' ); ?></a>
	<a class="button-secondary" href="http://www.evan-herman.com/contact/?contact-name=<?php echo $current_user_name; ?>&contact-reason=I want to make a donation for all your hard work" target="_blank"><?php _e( 'Donate' , 'timeline-express' ); ?></a>	
<br />
<br />
<!-- social media buttons -->
<a href="https://profiles.wordpress.org/eherman24#content-plugins" title="WordPress" class="evan_herman_about_icon"><img src="<?php echo TIMELINE_EXPRESS_URL; ?>/images/wordpress-icon.png" style="border: 0px none;" alt="Evan Herman - WordPress Profile" height="24" width="24"></a> 
<a href="http://twitter.com/evanmherman" title="Twitter" target="_blank" class="evan_herman_about_icon"><img src="<?php echo TIMELINE_EXPRESS_URL; ?>/images/twitter.png" style="border: 0px none;" alt="Evan Herman - Twitter Profile" height="24" width="24"></a> 
<a href="https://www.linkedin.com/profile/view?id=46246110" title="Linkedin" target="_blank" class="evan_herman_about_icon"><img src="<?php echo TIMELINE_EXPRESS_URL; ?>/images/linkedin.png" alt="Evan Herman - LinkedIn Profile" border="0" height="24" width="24"></a>
<a href="http://www.evan-herman.com/feed/" title="RSS Feed" target="_blank" class="evan_herman_about_icon"><img src="<?php echo TIMELINE_EXPRESS_URL; ?>/images/rss_icon.png" alt="Evan Herman - RSS Feed" border="0" height="24" width="24"></a>
</section>

<em style="display:block;font-size:12px; text-align:center;margin:.5em 0;"><?php _e( 'this plugin was made with ' , 'timeline-express' ); ?><div class="dashicons dashicons-heart" style="line-height:1.2;"></div>, <?php _e( 'by' , 'timeline-express' ); ?> <a href="http://www.evan-herman.com" target="_blank">Evan Herman</a></em>