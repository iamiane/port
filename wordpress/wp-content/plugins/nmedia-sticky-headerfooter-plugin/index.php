<?php
/*
 Plugin Name: Nmedia Sticky Header/Footer Plugin
Plugin URI: http://www.najeebmedia.com/2011/08/07/nmedia-sticky-headerfooter-plugin/
Description: This plugin placed a sticky (fixed) footer or header on your website with your message
Version: 1.3
Author: Najeeb Ahmad
Author URI: http://www.najeebmedia.com/
*/



//ini_set('display_errors',1);
//error_reporting(E_ALL);

class nmSticky{

	var $with;
	var $position;
	var $widthMessageDiv;
	var $message;
	var $bgcolor;
	var $bdcolor;
	var $fontcolor;
	var $fontsize;
	
	var $shortname = 'nm_sticky';

	function __construct(){

		$this -> loadJS();

		$this -> width 		= get_option('nm_sticky_width');
		$this -> position	= get_option('nm_sticky_position');
		$this -> widthMessageDiv = $this -> width - 40;
		$this -> message	= get_option('nm_sticky_message');
		$this -> bgcolor	= get_option('nm_sticky_bgcolor');
		$this -> bdcolor	= get_option('nm_sticky_bordercolor');
		$this -> fontcolor	= get_option('nm_sticky_fontcolor');
		$this -> fontsize	= get_option('nm_sticky_fontsize');

		//making position rule
		if($this -> position == 'Header')
			$this -> position = 'top:0';
		else
			$this -> position = 'bottom:0';
		
		
		add_action('wp_footer', array($this,'renderStickyDiv'));

	}


	public function setOptions () {
		add_submenu_page('options-general.php', 'Nmedia Sticky',
				'Sicky Header/Footer', 'activate_plugins', 'nm-sticky', array('nmSticky', 'adminPage'));
	}


	public function loadJS()
	{
		wp_enqueue_script( 'jquery' );

		//Load custom script
		wp_register_script('nm_sticky',plugins_url('js/sticky.js', __FILE__), 'jquery'); //'jquery_validator' is passed as a reference so that this loads AFTER the plugin
		wp_enqueue_script('nm_sticky');
	}


	public function adminPage()
	{
		$file = dirname(__FILE__).'/options.php';
		include($file);
	}

	function renderStickyDiv()
	{
		if(!is_admin() and !$this -> is_login_page())
		{
			$file = dirname(__FILE__).'/sticky.php';
			include($file);
		}
	}

	function is_login_page() {
		return in_array($GLOBALS['pagenow'], array('wp-login.php', 'wp-register.php'));
	}

	/*
	 ** Enqueue style-file, if it exists.
	*/
	function stickyStyle() {

		wp_register_style('sticky_stylesheet', plugins_url('style.css', __FILE__));
		wp_enqueue_style( 'sticky_stylesheet');
	}

	// plugin localization
	function nm_mc_textdomain() {
		load_plugin_textdomain('nm_sticky', false, dirname(plugin_basename( __FILE__ )) . '/locale/');
	}

}



add_action('admin_menu', array('nmSticky', 'setOptions'));
register_activation_hook( __FILE__, 'nm_activatePlugin' );

$nm_sticky = new nmSticky();
//var_dump($nm_sticky);

/* hook: styilng */
add_action('wp_print_styles', array($nm_sticky, 'stickyStyle'));


function nm_activatePlugin()
{
	$width 		= 850;
	$position	= 'Header';
	$widthMessageDiv = $width - 40;
	$message	= "<strong>Hello Budy!</strong> plugin is activated, now you need to set option from <i>Settings -> Sticky Header/Footer</i> menu";
	$bgcolor	= '#cfffcc';
	$bdcolor	= '#000 2px solid';
	$fontcolor	= '#000';
	$fontsize	= '9px';


	delete_option('nm_sticky_message');
	add_option('nm_sticky_message', $message);

	delete_option('nm_sticky_position');
	add_option('nm_sticky_position', $position);

	delete_option('nm_sticky_width');
	add_option('nm_sticky_width', $width) ;

	delete_option('nm_sticky_bgcolor');
	add_option('nm_sticky_bgcolor', $bgcolor);

	delete_option('nm_sticky_bordercolor');
	add_option('nm_sticky_bordercolor', $bdcolor);

	delete_option('nm_sticky_fontcolor');
	add_option('nm_sticky_fontcolor', $fontcolor);

	delete_option('nm_sticky_fontsize');
	add_option('nm_sticky_fontsize', $fontsize);
}



?>