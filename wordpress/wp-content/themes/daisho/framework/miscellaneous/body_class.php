<?php
add_filter('body_class','flow_class_names');
function flow_class_names($classes){

	if($_GET['prj'] == 'classic') { $_SESSION['prj'] = 0; }
	if($_GET['prj'] == 'thumb') { $_SESSION['prj'] = 1; }
	$portfolio_mode = get_option('portfolio_mode'); /* 1 = thumbnail grid, 0 = classic */
	if(isset($_SESSION['prj']) && ($_SESSION['prj'] == 0)){ $portfolio_mode = 0; }
	if(isset($_SESSION['prj']) && ($_SESSION['prj'] == 1)){ $portfolio_mode = 1; }
	
	if((($portfolio_mode == '1' and is_home()) or is_page_template('template-portoflio.php')) or ($portfolio_mode == '1' and is_singular('portfolio'))){ /* THUMBNAIL VIEW */
		$classes[] = 'daisho-portfolio';
	}else if(($portfolio_mode == '0' and is_home()) || ($portfolio_mode == '0' && is_singular('portfolio'))){ /* CLASSIC VIEW */
		$classes[] = 'daisho-classic';
		if(!get_option('flow_featured_slideshow')){
			$classes[] = 'daisho-classic-has-slideshow';
		}
		if(get_option("welcome_text")){
			$classes[] = 'daisho-classic-has-welcome-text';
		}
	}
	
	if(is_singular('portfolio')){
		$classes[] = 'daisho-portfolio-viewing-project';
	}
		
	// add 'class-name' to the $classes array
	//$classes[] = 'class-name';
	
	/* Potential fix for styling */
	/* global $ipad;
	global $mobile;
	
	if(isset($ipad) && ($ipad || $mobile)){
		$classes[] = 'apple';
	} */
	
	// return the $classes array
	return $classes;
}
?>