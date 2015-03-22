<?php 

if ( isset( $_REQUEST['action'] ) ) {
	$action=$_REQUEST['action']; 
}

if ( !isset( $action ) )    /* display the contact form */  { 
    ?> 
	<p><?php _e( 'If you need support, please fill out the following form. I will get back to you with some support as soon as possible.' , 'timeline-express' ); ?></p>
	<p><em><?php _e( 'note: support requests are limited to one per hour, to help reduce spam.' , 'timeline-express' ); ?></em></p>
    <form  action="" method="POST" enctype="multipart/form-data"> 
		<input type="hidden" name="action" value="submit">
		<label for="name"><?php _e( 'Your name' , 'timeline-express' ); ?>: <br />
		<input name="name" type="text" value="<?php echo $license_data->customer_name; ?>" size="30"/></label>
		<label for="message"><?php _e( 'Your message' , 'timeline-express' ); ?>:<br> 
		<textarea name="message" rows="7" cols="30" placeholder="<?php _e( 'please describe your issue in as much detail as possible' , 'timeline-express' ); ?>"></textarea></label>
		<input type="submit" class="button-primary" value="Get Spport"/> 
    </form> 
    <?php 
    } else  /* send the submitted data */ { 
	$name = trim( $_REQUEST['name'] ); 
    $email = $license_data->customer_email;
	// append the users license key, and other data
    $message = '<strong>License Key :</strong> ' . $license . '<br /><strong>Expires :</strong> ' . date( 'F jS, Y' , strtotime( $license_data->expires ) ) . ' <br /><br /> <strong>Support Issue :</strong><br />' . $_REQUEST['message']; 
	
    if ( ( $name=="" ) || ( $email=="" ) || ( $_REQUEST['message']=="" ) ) { 
        echo "All fields are required, please fill <a href=\"\">the form</a> again."; 
    } else {
        $from="From: $name <$email>"; 
        $content_type='Content-type: text/html';
		$subject="Premium Support Request: Timeline Express"; 
		$headers = array( $from , $content_type );
		
        $email = wp_mail("evan.m.herman@gmail.com", $subject, $message, $headers); 
		
		if ( is_wp_error( $email ) ) {
			echo '<p>' . __( 'There was an error sending your request' , 'timeline-express' ) . ' : ' . $email->get_error_message() . '</p>';
			echo '<p>' . __( 'If the error persists, please contact me directly for support at' , 'timeline-express' ) . '<a href="mailto:Evan.M.Herman@gmail.com" title="Email Support">Evan.M.Herman@Gmail.com</a></p>';
		} else {
			if ( $email ) {
				set_transient( 'timeline_express_support_request_sent', '1', 1 * HOUR_IN_SECONDS );
				echo '<p>' . __( "Support request successfully sent. I will be in touch regarding your issue shortly." , "timeline-express" ) . '</p>';
			}
		}
			
			
    }
}   
?> 