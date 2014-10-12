<?php
/*
This page gets included from lib.ajax and then processes
the post. This page should never get called by itself.
*/
if(!empty($_POST)
&& isset($_POST['form_action']))
	{	
	switch($_POST['form_action'])
		{
		
		
		
default:
	echo '-1';
	break;
	
case 'update_options':
	$action	= $timelineExpressBase->updateOptions($_POST);
	if($action)
		{
		echo '1';
		}
	else echo '-1';
	break;

case 'update_debug_options':
	$action	= $timelineExpressBase->updateDebugOptions($_POST);
	if($action)
		{
		echo '1';
		}
	else echo '-1';
	break;		
	
case 'yks_mc_reset_plugin_settings':
	$validate_action = $timelineExpressBase->resetPluginSettings($_POST);
	break;
	
		}
	}
?>