<?php
	if($_SERVER['SERVER_NAME'] == 'themes.devatic.com'){ $demoServer = true; }else{ $demoServer = false; }
	
	if(strpos($_SERVER['HTTP_USER_AGENT'],'iPad') !== false){ $ipad = true; }else{ $ipad = false; }
	if(strstr($_SERVER['HTTP_USER_AGENT'],'iPhone') || strstr($_SERVER['HTTP_USER_AGENT'],'iPod') || strstr($_SERVER['HTTP_USER_AGENT'],'Android')){ $mobile = true; }else{ $mobile = false; }
	
	if(strstr($_SERVER['HTTP_USER_AGENT'],'MSIE')){ $ie = true; }
	if(strstr($_SERVER['HTTP_USER_AGENT'],'MSIE 6')){ $ie6 = true; }
	if(strstr($_SERVER['HTTP_USER_AGENT'],'MSIE 7')){ $ie7 = true; }
	if(strstr($_SERVER['HTTP_USER_AGENT'],'MSIE 8')){ $ie8 = true; }
	
	if(!$mobile AND !$ipad){ $desktop = true; }
	
	global $mobile;
	global $ipad;
	global $desktop;
	global $demoServer;
	global $safari;
	global $ie;
	global $ie6;
	global $ie7;
	global $ie8;
?>