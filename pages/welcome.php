<?php
//
// Welcome Page Template
// Users are redirected here upon activation
//

$current_user_object = wp_get_current_user();
$current_user_name = $current_user_object->user_firstname;
$current_user_name .= ' ' . $current_user_object->user_lastname;

?>
<script>
jQuery(document).ready(function() {
	jQuery(window).resize(function() {
		var window_width = jQuery(window).width();
		console.log(window_width);
		var height = jQuery( '.slides' ).css('height');
		var new_height = parseFloat( '.40' ) * parseInt( window_width );
		console.log(new_height);
		jQuery( '.slides' ).css('height',new_height+'px');
		jQuery( '.slides' ).find('li').find('div').css('height',new_height+'px');
	});
});
</script>
<!-- used for the media query -->
<meta name="viewport" content="width=device-width" />

<div class="wrap yksme-page-about">

	<div id="ykseme-icon" class="icon32"></div>
	
	<div id="welcome-page-content" class="col-md-9">
		
		<!-- Brand and toggle get grouped for better mobile display -->
		<div class="navbar-header">	
			
			<a href="http://www.Evan-Herman.com" target="_blank" class="timeline_express_header_logo" style="margin-top:10px; float:right; margin-right:15px;">
				<img src="<?php echo TIMELINE_EXPRESS_URL . 'images/evan_herman_logo.png'; ?>" alt="Evan Herman" width=65 title="Evan Herman" />
			</a>
			
			<h1 id="timeline-express-page-header">
				<div id="timeline-express-icon" class="icon32"></div><?php _e('Welcome to Timeline Express','timeline-express'); ?> v<?php echo TIMELINE_EXPRESS_VERSION_CURRENT; ?>
			</h1>
								
			<p style="font-size:20px;"><?php _e( "Thanks for installing Timeline Express. We know you're going to find this free plugin super helpful and easy to use! To get started, hover over 'Timeline Express', in the admin menu, and click" , "timeline-express" ); ?> <a href="<?php echo admin_url(); ?>post-new.php?post_type=te_announcements"><?php _e( "'New Announcement'" , "timeline-express" ); ?></a><?php _e( " to start adding announcements your timeline!" , "timeline-express" ); ?></p>
				
			<p style="font-size:20px;"><?php _e( 'or head over to the' , 'timeline-express' ); ?> <a class="button-secondary" href="<?php echo admin_url(); ?>edit.php?post_type=te_announcements&page=timeline-express-settings"><?php _e( "Settings Page" , "timeline-express" ); ?></a> <?php _e( 'to customize and style your form' , 'timeline-express' ); ?></p>
				
		</div>
		
		<hr />		
				
		<div class="row">
		  
		  <div class="col-md-6 timeline-screenshot">
			<h2><?php _e( 'Create a Beautiful Timeline In Minutes' , 'timeline-express' ); ?></h2>
			<p><?php _e( 'Create a vertical and responsive, CSS3 animated timeline fast...without ever writing a single line of code.' , 'timeline-express' ); ?></p>
			
			<div class="font-awesome-background">
				<h1 style="width:350px;display:block;margin:0 auto;line-height:1;margin-bottom:2em;background:#F1F1F1;padding:.5em;"><?php _e( 'Font Awesome Included' , 'timeline-express' ); ?></h1>
				<p style="display:block;background:#F1F1F1;padding:.5em;font-size:18px;"><em><?php _e( 'Hundreds of icons to choose from to make your announcements really stand out!' , 'timeline-express' ); ?></em></p>
			</div>
						
			<hr />
			
			<div class="slides">
				<ul>
					<li>
						<div class="intuitive-post-creation"></div>
						<h2 class="promo-text"><?php _e( 'Intuitive Custom Post Creation Screen' , 'timeline-express' ); ?></h2>
					</li>
					<li>
						<div class="admin-manage-announcements"></div>
						<h2 class="promo-text"><?php _e( 'Manage Announcements Easily' , 'timeline-express' ); ?></h2>
					</li>
					<li>
						<div class="customize-your-timeline"></div>
						<h2 class="promo-text"><?php _e( 'Style The Timeline' , 'timeline-express' ); ?></h2>
					</li>
				</ul>
			</div>
			
			<hr style="margin-bottom:0;" />
			
			<div class="timeline-express-image">
				<h2 style="display:block;text-align:center;padding-top:4em;"><?php _e( 'Timeline Express // Sample Timeline' , 'timeline-express' ); ?></h2><img style="width:60%;display:block;margin:0 auto;padding-top:1em;" src="<?php echo TIMELINE_EXPRESS_URL . 'images/welcome/timeline-screenshot.png'; ?>" alt="Sample Timeline Express" title="Timeline Express Example" >
			</div>
			
			<hr style="margin-top:0;" />
		  
		  </div>
		  		
	</div>
	
	
	<div id="welcome-page-sidebar" class="col-md-3">
		
			<em><?php _e( 'this free plugin was made with' , 'timeline-express' ); ?><div class="dashicons dashicons-heart"></div>, <?php _e( 'by' , 'timeline-express' ); ?> <a href="http://www.evan-herman.com" target="_blank">Evan Herman</a></em><span style="float:right;"><?php _e( 'Please consider making a' , 'timeline-express' ); ?> <a href="http://www.evan-herman.com/contact/?contact-name=<?php echo $current_user_name; ?>&contact-reason=I want to make a donation for all your hard work" target="_blank"><?php _e( 'donation' , 'timeline-express' ); ?></a> <?php _e( 'if you need support in any way.' , 'timeline-express' ); ?></span>
		<hr />
					
		<div class="social-media-buttons" style="height:40px;">
			<strong style="display:inline-block;float:left;margin-top:10px;font-size:16px;"><?php _e( 'Keep Up With Me Elsewhere ' , 'timeline-express' ); ?>:</strong>
			<span style="display:inline-block;width:115px; margin-left:15px;margin-top:5px;">
				<a href="https://profiles.wordpress.org/eherman24#content-plugins" title="WordPress" target="_blank" class="evan_herman_about_icon"><img src="<?php echo TIMELINE_EXPRESS_URL; ?>/images/wordpress-icon.png" style="border: 0px none;" alt="Evan Herman - WordPress Profile" height="24" width="24"></a> 
				<a href="http://twitter.com/evanmherman" title="Twitter" target="_blank" class="evan_herman_about_icon"><img src="<?php echo TIMELINE_EXPRESS_URL; ?>/images/twitter.png" style="border: 0px none;" alt="Evan Herman - Twitter Profile" height="24" width="24"></a> 
				<a href="https://www.linkedin.com/profile/view?id=46246110" title="Linkedin" target="_blank" class="evan_herman_about_icon"><img src="<?php echo TIMELINE_EXPRESS_URL; ?>/images/linkedin.png" alt="Evan Herman - LinkedIn Profile" border="0" height="24" width="24"></a>
				<a href="http://www.evan-herman.com/feed/" title="RSS Feed" target="_blank" class="evan_herman_about_icon"><img src="<?php echo TIMELINE_EXPRESS_URL; ?>/images/rss_icon.png" alt="Evan Herman - RSS Feed" border="0" height="24" width="24"></a>
			</span>
			<a style="float:right;" href="http://www.evan-herman.com" title="EH Development Shop" target="_blank"><img src="<?php echo TIMELINE_EXPRESS_URL; ?>/images/evan_herman_logo.png" alt="Evan Herman" class="timeline_express_header_logo" /></a>
		</div>

		
	</div>
	
</div>