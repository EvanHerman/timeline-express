<?php
add_action('wp_ajax_timeline_express_settings_form', 'timeline_express_ajaxActions');

function timeline_express_ajaxActions()
	{
		global $timelineExpressBase;
		require_once TIMELINE_EXPRESS_PATH.'/lib/process/ajax.php';
		exit;
	}
		
?>