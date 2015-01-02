<?php
/*
	Premium support template
	// to do - setup chron to check license status once a day
	// double check if we can't move this all into it's own support class file
	//
*/
wp_enqueue_style( 'slideshow-css' , TIMELINE_EXPRESS_URL . 'css/timeline-express-css3-slideshow.css' );
wp_register_script( 'slideshow-js' , TIMELINE_EXPRESS_URL . 'js/support/jquery.slides.min.js' , array( 'jquery' ) , 'all' ); 
wp_enqueue_script( 'slideshow-js' );

$review_images = scandir( TIMELINE_EXPRESS_PATH . 'images/support/reviews' ); 
$license 	= get_option( 'timeline_express_license_key' );
$status 	= get_option( 'timeline_express_license_status' );			 
$license_data = get_option( 'timeline_express_license_data' );
?>

<div id="timeline-express-support-page-wrap">


	<section id="timeline-express-support-page-header">

		<img src="<?php echo TIMELINE_EXPRESS_URL . 'images/support/timeline-express-logo-256.png'; ?>" title="Timeline Express Logo" class="te-logo" >
		
		<section class="support-subhead">
			<h1 style="margin:0 0 1.2em 0;font-size:25px;"><?php _e( 'Timeline Express Support' , 'timeline-express' ); ?></h1>
			<?php if( false !== $license ) {
					if( $status !== false && $status == 'valid' ) { ?>
						<p style="font-weight:200;"><?php _e( 'Thank you for purchasing a support license!' , 'timeline-express' ); ?></p>
						<p style="font-weight:200;"><?php _e( 'If you run into any issues, or need support, feel free to submit a support ticket via the contact form below.' , 'timeline-express' ); ?></p>
			<?php } else { ?>
						<p style="font-weight:200;">
							<?php _e( 'Have a support request? Please consider ' , 'timeline-express' ); ?>
							<a href="http://www.evan-herman.com/wordpress-plugin/timeline-express/" title="Purchase a Support License Now" target="_blank"><?php _e( 'purchasing ' , 'timeline-express' ); ?></a>
							<?php _e( 'a support license.' , 'timeline-express' ); ?>
						</p>	
						<p style="font-weight:200;"><?php _e( 'Your purchase will go towards the continued development and support of Timeline Express, so the plugin will continue to thrive and improve.' , 'timeline-express' ); ?></p>
			<?php }
				} ?>
				
			<!-- if the user doesn't have a license key, lets display the slider -->
			<?php if( false !== $license ) {
	
				if( $status !== false && $status != 'valid' || $status == false ) { ?>
				
					<div class="te-slider-container">
						<div id="slides">
						 <?php 
							foreach( $review_images as $review ) {
								if ( $review != '.' && $review != '..' ) {
									echo '<img src="' . TIMELINE_EXPRESS_URL  .'images/support/reviews/' . $review . '" alt="review" >';
								}
							}
						 ?>
						</div>
					</div>
			
			<?php 
				}
			} ?>
		
		</section>
		
	</section>

	<hr />
		
	<form id="support-license-form" method="post" action="options.php">
				
		<?php settings_fields('timeline_express_license'); ?>	
				
		<label for="timeline_express_license_key">
			<strong><?php _e( 'Support License Key' , 'timeline-express' ); ?></strong>
			
			<p style="display:inline-block;width:100%;">
				
				<input id="timeline_express_license_key" type="text" placeholder="<?php _e( 'Support license key' , 'timeline-express' ); ?>" name="timeline_express_license_key" value="<?php esc_attr_e( $license ); ?>">
				<?php if( false !== $license ) {
					if( $status !== false && $status == 'valid' ) {  $license_data = get_option( 'timeline_express_license_data' ); ?>
						<span class="dashicons dashicons-yes timeline-express-valid-license" title="<?php _e( 'Valid and Active License' , 'timeline-express' ); ?>"></span>
				<?php } else if ( $status !== false && $status == 'invalid' && $license_data->error == 'revoked' ) { // invalid status returned ?>
						<a href="http://www.evan-herman.com/wordpress-plugin/timeline-express/" title="Purchase a Support License Now" target="_blank">
							<input type="button" class="button-secondary purchase-support-license" value="<?php _e( 'Purchase a License' , 'timeline-express' ); ?>">
						</a>
						<section class="timeline-express-invalid-license-error"><span class="dashicons dashicons-no-alt"></span><?php echo __( 'There was an error with your license. It appears that your license key has been ' , 'timeline-express' ) . '<strong>' . $license_data->error . '</strong>' . '. ' .  __( 'Please get in contact with support at ' , 'timeline-express' ); ?><a href="http://www.evan-herman.com/contact/" title="Evan Herman Plugin Development"><?php _e( 'EH Dev. Shop' , 'timeline-express' ); ?></a> <?php _e( ' to resolve the issue' , 'timeline-express' ); ?>.</section>
				<?php } else if ( $status !== false && $status == 'invalid' && $license_data->error == 'missing' ) { // invalid api key...doesn't exist in the database, was never purchased. ?>
						<a href="http://www.evan-herman.com/wordpress-plugin/timeline-express/" title="Purchase a Support License Now" target="_blank">
							<input type="button" class="button-secondary purchase-support-license" value="<?php _e( 'Purchase a License' , 'timeline-express' ); ?>">
						</a>
						<section class="timeline-express-invalid-license-error"><span class="dashicons dashicons-no-alt"></span><?php echo __( 'Sorry this license key appears to be invalid. Please purchase a valid license key.' , 'timeline-express' ); ?></section>
				<?php } else if ( $status !== false && $status == 'invalid' && $license_data->error == 'expired' || $status !== false && $status == 'expired' ) { // invalid api key...doesn't exist in the database, was never purchased. ?>
						<a href="http://www.evan-herman.com/wordpress-plugin/timeline-express/" class="button-secondary purchase-support-license" alt="<?php esc_attr_e( $license ); ?>" title="<?php _e( 'Renew your Timeline Express license' , 'timeline-express' ); ?>"  target="_blank">
							<?php _e( 'Renew Your License' , 'timeline-express' ); ?>
						</a>
						<section class="timeline-express-invalid-license-error"><span class="dashicons dashicons-no-alt"></span><?php echo __( 'Oops, it looks like your license has expired. Please consider renewing your license for another year to continue receiving support.' , 'timeline-express' ); ?></section>
				<?php } else { ?> 
						<a href="http://www.evan-herman.com/wordpress-plugin/timeline-express/" title="Purchase a Support License Now" target="_blank">
							<input type="button" class="button-secondary purchase-support-license" value="<?php _e( 'Purchase a License' , 'timeline-express' ); ?>">
						</a>
				<?php	
						} 
					}
				?>				
			</p>
			
		</label>
		
		<section class="timeline-express-license-buttons">
		
			<input type="submit" class="button-primary" value="Save Changes" style="float:left; margin-right: 1em;">
			
			<!-- when active key, display a support ticketing form -->
			<?php if( false !== $license ) { ?>
				<?php if( $status !== false && $status == 'valid' ) {  $license_data = get_option( 'timeline_express_license_data' ); ?>
					<?php wp_nonce_field( 'timeline_express_nonce', 'timeline_express_nonce' ); ?>
					<input type="submit" class="button-secondary" name="timeline_express_license_deactivate" value="<?php _e('Deactivate License'); ?>"/>
				<?php } else {
					if ( $license != '' ) {
						wp_nonce_field( 'timeline_express_nonce', 'timeline_express_nonce' ); ?>
						<input type="submit" class="button-secondary" name="timeline_express_license_activate" value="<?php _e('Activate License'); ?>"/>
				<?php } } ?>
			<?php } ?>
		
		</section>
									
	</form>
	
	<?php if( false !== $license ) {
	
		 if( $status !== false && $status == 'valid' ) {  
			
			$license_data = get_option( 'timeline_express_license_data' ); ?>	
			
			<hr style="margin-bottom:2.5em;" />
			
			<div style="width:100%; display:inline-block;">
			
				<table class="widefat fixed" cellspacing="0" style="width:100%;max-width:500px; float:right;">
					<thead>
						<tr>
							<th id="columnname" class="manage-column column-columnname" scope="col"><?php _e( 'License Info.' , 'timeline-express' ); ?></th>
							<th id="columnname" class="manage-column column-columnname num" scope="col"></th>
						</tr>
					</thead>

					<tbody>
						
						<tr class="alternate">
							<td class="column-columnname"><b><?php _e( 'License Holder' , 'timeline-express' ); ?></b></td>
							<td class="column-columnname" style="text-align:center;"><?php echo $license_data->customer_name; ?></td>								
						</tr>
						
						<tr class="alternate">
							<td class="column-columnname"><b><?php _e( 'Sites Active/Limit' , 'timeline-express' ); ?></b></td>
							<td class="column-columnname" style="text-align:center;"><?php echo $license_data->site_count . '/' . $license_data->license_limit; ?></td>								
						</tr>
										
						<tr>
							<td class="column-columnname"><b><?php _e( 'License Expires' , 'timeline-express' ); ?></b></td>
							<td class="column-columnname" style="text-align:center;"><?php echo date( 'F jS, Y' , strtotime( $license_data->expires ) ); $days_remaining = (strtotime( $license_data->expires ) - strtotime('now'))  / (60 * 60 * 24); if ( round( $days_remaining ) < 30 ) { echo '<span class="license-expiring-soon">expiring soon</span>'; } ?></td>
						</tr>

					</tbody>
				</table>	
				
				
				<section id="premium-support-contact-form">
					<h2 style="margin-bottom:.5em;margin-top:0;"><?php _e( 'Premium Support Ticketing' , 'timeline-express' ); ?></h2>
					<?php 
						// check if the user has sent a request in the past hour
						if ( false === get_transient( 'timeline_express_support_request_sent' ) ) {
							require_once TIMELINE_EXPRESS_PATH . 'lib/support-contact-form.php'; 
						} else {
							_e( "It looks like you have recently sent us a support request. We limit the number of support requests to 1 per hour, to avoid spam. Sorry for the inconvinience, and thank you for understanding." , "timeline-express" );
						}	
					?>		
				</section>
				
			</div>
			
	<?php 
		}
	}
	?>	

	<section id="eh-logos" style="display:block;width:100%;text-align:right;">
		<a href="http://www.evan-herman.com" target="_blank" title="Evan Herman Professional WordPress Development">
			<img src="<?php echo TIMELINE_EXPRESS_URL; ?>images/evan_herman_logo.png" alt="Evan Herman Logo" style="margin-right:4.5em;"><br />
			<img src="<?php echo TIMELINE_EXPRESS_URL; ?>images/evan-herman-mascot.png" alt="Evan Herman Mascot" style="width:300px;margin-top:1em;" >
		</a>
	</section>
	
</div>

<!-- initialize the slider :) -->
 <script>
    jQuery(function() {
      jQuery('#slides').slidesjs({
		 height: 200,
         play: {
          active: true,
          auto: true,
          interval: 6000,
          swap: true
        }
      });
    });
 </script>