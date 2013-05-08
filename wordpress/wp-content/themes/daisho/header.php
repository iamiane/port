<!DOCTYPE html>
<html <?php language_attributes(); ?> xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<meta charset="<?php bloginfo('charset'); ?>" />
	<?php if(strstr($_SERVER['HTTP_USER_AGENT'],'iPhone') || strstr($_SERVER['HTTP_USER_AGENT'],'iPod') || strstr($_SERVER['HTTP_USER_AGENT'],'Android') || strstr($_SERVER['HTTP_USER_AGENT'],'Windows Phone')){ ?>
		<meta name="viewport" content="user-scalable=yes, width=735" />
		<meta name="apple-mobile-web-app-capable" content="yes" />
		<meta name="apple-mobile-web-app-status-bar-style" content="black">
	<?php }else if(strstr($_SERVER['HTTP_USER_AGENT'],'iPad')){ ?>
		<meta name="viewport" content="user-scalable=yes, width=980" />
		<meta name="apple-mobile-web-app-capable" content="yes" />
		<meta name="apple-mobile-web-app-status-bar-style" content="black">
	<?php } ?>
	<title><?php
		if(is_singular() && $flow_seo_title = get_post_meta($post->ID, 'flow_seo_title', true)){
			echo preg_replace('/\s+/', ' ', trim(esc_attr(strip_tags($flow_seo_title))));
		}else if(is_home()){
			printf(_x('%s - Home', 'Homepage title', 'flowthemes'), get_bloginfo('name'));
		}else if(is_category()){
			printf(_x('Browsing the Category %s', 'Category page title', 'flowthemes'), wp_title(' ', false, ''));
		}else if(is_archive()){
			printf(_x('Browsing Archives of %s', 'Archives page title', 'flowthemes'), wp_title(' ', false, ''));
		}else if(is_search()){
			printf(_x('Search Results for %s', 'Search page title', 'flowthemes'), esc_attr($s));
		}else if(is_404()){
			_e('404 - Page Not Found', 'flowthemes');
		}else{
			wp_title('-', true, 'right'); bloginfo('name');
		} ?></title>
	<link rel="alternate" type="application/rss+xml" title="RSS 2.0" href="<?php bloginfo('rss2_url'); ?>" />
	<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />
	<link rel="shortcut icon" href="<?php $flow_favicon=get_option("flow_favicon"); print((($flow_favicon)?$flow_favicon:bloginfo('template_directory')."/images/favicon.ico")); ?>" />
	<link rel="stylesheet" type="text/css" media="screen" href="<?php bloginfo('template_directory'); ?>/fonts.css" />
	<link rel="stylesheet" type="text/css" media="screen" href="<?php bloginfo('stylesheet_url'); ?>" />
	<?php wp_head(); ?>
	<link href='http://fonts.googleapis.com/css?family=Dosis:400,800,700,600,500,300,200' rel='stylesheet' type='text/css'>
	<link href='http://fonts.googleapis.com/css?family=Open+Sans:400,800,800italic,700italic,700,600italic,600,400italic,300italic,300&amp;subset=latin,latin-ext' rel='stylesheet' type='text/css'>
	<link href='http://fonts.googleapis.com/css?family=Lato:400,700,400italic,900,300italic,300,100,700italic' rel='stylesheet' type='text/css'>
	
	<!--[if lt IE 9]>
		<script src="http://html5shiv.googlecode.com/svn/trunk/html5.js" type="text/javascript"></script>
	<![endif]-->
	<!--[if IE]>
		<style type="text/css">
			.sidebar-left-shadow { border-left:1px solid #dcdcdc; }
			.sidebar-right-shadow { border-right:1px solid #dcdcdc; }
		</style>
	<![endif]-->
	
	<!--[if lt IE 9]>
	<script type="text/javascript">alert('<?php _e('It looks like your browser doesn\'t fully support HTML5 and CSS3. You need a recent version of Internet Explorer, Firefox, Chrome or Safari to display this website correctly.', 'flowthemes'); ?>');</script>
	<![endif]-->

	<?php
	/* This will return data of first found post on archives and search pages - to prevent that I use is_singular(). */
	if(is_singular()){
		$page_image = get_post_meta($post->ID, 'bg_image', true);
		$page_color = get_post_meta($post->ID, 'bg_color', true);
		$page_repeat = get_post_meta($post->ID, 'bg_repeat', true);
		$page_position = get_post_meta($post->ID, 'bg_position', true);
		$page_attachment = get_post_meta($post->ID, 'bg_attachment', true);
		$page_size = get_post_meta($post->ID, 'bg_size', true);
		$page_fullscreen = get_post_meta($post->ID, 'bg_fullscreen', true);
		$page_opacity = get_post_meta($post->ID, 'bg_opacity', true);
		if($page_image){ $style_output = 'background-image: url("'.$page_image.'"); '; }
		if($page_color){ $style_output .= 'background-color: '.$page_color.'; '; }
		if($page_repeat){ $style_output .= 'background-repeat: '.$page_repeat.'; '; }
		if($page_position){ $style_output .= 'background-position: '.$page_position.'; '; }
		if($page_attachment){ $style_output .= 'background-attachment: '.$page_attachment.'; '; }
		if($page_size){ $style_output .= 'background-size: '.$page_size.'; '; }
		if($style_output and !$page_fullscreen){ print("<style type=\"text/css\">body{ ".$style_output."}</style>"); }
	}
	?>

	<?php
	$custom_css_style = get_option("custom_css_style");
	if($custom_css_style){
		print("<style type=\"text/css\">".stripslashes($custom_css_style)."</style>");
	}
	?>
	<script type="text/javascript">
		jQuery(document).ready(function(){
			jQuery('body').addClass('body-visible');
		});
	</script>
    


</head>
<body <?php if(!isset($class)){ $class = ''; } body_class($class); ?>>



<div class="header-search-form"><?php get_template_part('searchform', 'header'); ?></div>

<?php if($page_fullscreen && $page_image){ ?>
	<script type="text/javascript">
		jQuery(document).ready(function(){
			resizeimageslide(jQuery("#myimage_original"),false,false);
			jQuery(window).resize(function(){
				resizeimageslide(jQuery("#myimage_original"),false,false);
			});
		});
	</script>
	<img src="<?php echo $page_image; ?>" alt="" id="myimage_original" style="<?php if($page_opacity or $page_opacity == 0){ echo'opacity:'.$page_opacity.';'; } ?>">
<?php } ?>

<header id="header">
	<div class="inner clearfix">
		<?php
		$logo_type = get_option('flow_logo_svg');
		if($logo_type == ''){ $logo_type = get_option('flow_logo'); }
		if($logo_type == ''){ $logo_type = get_option('logo_type'); }
		$lng_switcher = language_selector_flags();
		if(preg_match('/^.*\.(jpg|jpeg|png|gif|ico|svg|svgz)$/i', $logo_type)){
			$blog_url = get_home_url();
			$blog_desc = get_bloginfo('description');
			echo "<div id=\"logo-image\"><a title=\"". $blog_desc ."\" href=\"". $blog_url ."\"><img src=\"".$logo_type."\" alt=\"" . $blog_desc . "\" /></a>".$lng_switcher."<div class=\"clear\"></div></div>";
		}else{ ?>
			<div id="logo-text">
				<div class="logo-text-inner">
					<h1><a href="<?php bloginfo('url'); ?>"><?php bloginfo('name'); ?></a></h1>
					<?php if(get_option('flow_tagline') == 0){ ?>
					<div id="tagline">
						<a rel="home" title="<?php bloginfo('description'); ?>" href="<?php bloginfo('url'); ?>"><?php bloginfo('description'); ?></a>
					</div>
					<?php } ?>
					<div class="clear"></div>
				</div>
			</div>
			<?php echo $lng_switcher; ?>
		<?php } ?>
		<nav id="navigation">
			<?php wp_nav_menu(array('sort_column' => 'menu_order', 'theme_location' => 'main_menu', 'menu_class' => 'flow_smart_menu', 'menu_id' => 'menu', 'walker' => new description_walker())); ?>
			<?php wp_nav_menu(array('sort_column' => 'menu_order', 'theme_location' => 'mobile_menu', 'menu_id' => 'mobile_menu', 'items_wrap' => '<select name="-Menu-" id="%1$s" class="%2$s">%3$s</select>', 'walker' => new select_menu_walker())); ?>
		</nav>
	</div> <!-- /.inner -->
</header>
<?php 
$info_box_page = get_option('info_box');
	if($page_id = $info_box_page){
		$page_data = get_page($page_id);
?>
		
<?php } ?>

<?php 
	if(is_page_template('template-blog.php') or is_archive() or is_singular('post') or is_search() or is_home() or is_page_template('template-portoflio.php') or is_singular('portfolio')){
	$blog_page = get_option('flow_blog_page');
	$blog_page_link = get_permalink($blog_page);
	if(is_page_template('template-blog.php')){ $blog_page_link = get_bloginfo('url'); }
	if(is_home() or is_page_template('template-portoflio.php')){ 
		$visible_or_not = '';
		$blog_page_link = 'javascript:void(null);';
	}else if(is_singular('portfolio')){
		$visible_or_not = 'class="compact_navigation_container-visible"';
		$blog_page_link = 'javascript:void(null);';
	}else{
		$visible_or_not = 'class="compact_navigation_container-visible"';
	}
?>
	<nav id="compact_navigation_container" <?php echo $visible_or_not; ?>>
		<div class="clearfix inner">
			<a class="header-back-to-blog-link" href="<?php echo $blog_page_link; ?>">
				<div class="header-back-to-blog clearfix">
					<div class="header-back-to-blog-icon"></div>
					<div class="header-back-to-blog-message"><?php _e('Back', 'flowthemes'); ?></div>
				</div>
			</a>
			<div class="header-search">
				<div class="header-search-icon">L</div>
				<div class="header-search-text"><?php _e('Search', 'flowthemes'); ?></div>
			</div>
			<?php wp_nav_menu(array('sort_column' => 'menu_order', 'theme_location' => 'main_menu', 'menu_class' => 'flow_smart_menu', 'menu_id' => 'compact_menu', 'walker' => new compact_menu_walker())); ?>
		</div>
	</nav>
<?php } ?>
<?php if(is_user_logged_in()){
//echo '<xmp>';
//var_dump( $wp_query );
//var_dump( $post );
//the_ID();
//echo  get_option('page_on_front');
//echo '</xmp>';
 } ?>