<?php
//print_r(get_option('widget_nmedia_mail_chimp'));
echo '<link rel="stylesheet" type="text/css" href="'.plugins_url('style.css', __FILE__).'"/>';

if ( count($_POST) > 0 && isset($_POST['btn_options']) )
{
		delete_option('nm_sticky_message');
		add_option('nm_sticky_message', $_POST['message']);
		
		delete_option('nm_sticky_position');
		add_option('nm_sticky_position', $_POST['nm_sticky_position']);	 
		
		delete_option('nm_sticky_width');
		add_option('nm_sticky_width', $_POST['width']);	 
		
		delete_option('nm_sticky_bgcolor');
		add_option('nm_sticky_bgcolor', $_POST['bgcolor']);	 
		
		delete_option('nm_sticky_bordercolor');
		add_option('nm_sticky_bordercolor', $_POST['bordercolor']);	
		
		delete_option('nm_sticky_fontcolor');
		add_option('nm_sticky_fontcolor', $_POST['fontcolor']);	
		
		delete_option('nm_sticky_fontsize');
		add_option('nm_sticky_fontsize', $_POST['fontsize']);	 
		
		
}

$message	= stripcslashes(get_option('nm_sticky_message'));
$position	= get_option('nm_sticky_position');
$width		= get_option('nm_sticky_width');
$bgcolor	= get_option('nm_sticky_bgcolor');
$bordercolor= get_option('nm_sticky_bordercolor');
$fontcolor	= get_option('nm_sticky_fontcolor');
$fontsize	= get_option('nm_sticky_fontsize');

$hSelected = ($position == 'Header') ? "selected='selected'" : '';
$fSelected = ($position == 'Footer') ? "selected='selected'" : '';
?>

<h1>Nmedia Sticky Header/Footer Plugin</h1>
<h3>Plugin Developed by <a href="http://www.najeebmedia.com/">Nmedia</a></h3>
<p>This plugin lets you put sticky header or footer at your website.</p>
<strong>Features</strong>
<ol>
	<li>Type Custome Message</li>
    <li>HTML supported</li>
    <li>Custom Background Color</li>
    <li>Custom Border Color</li>
    <li>Font Color</li>
    <li>Font Size</li>
    <li>Switch b/w Header and Footer</li>
</ol>
<br />
<br />

<h2>Options</h2>
<form action="<?php echo str_replace( '%7E', '~', $_SERVER['REQUEST_URI'])?>" method="post">
<table width="800" class="xet_settings_tbl">
  <tr>
    <td valign="middle">You Message</td>
    <td valign="top"><textarea name="message" cols="63" rows="8" id="message"><?php echo $message?></textarea>
	<span class="nm_help">Note: html can be used</span>
    </td>
  </tr>
  <tr>
    <td valign="middle">Select Area</td>
    <td valign="top">
    	<select id="nm_sticky_position" name="nm_sticky_position">
        	<option value="Header" <?php echo $hSelected ?>>Header</option>
            <option value="Footer" <?php echo $fSelected?>>Footer</option>
        </select>
    </td>
  </tr>
  
  <tr>
    <td valign="middle">Width</td>
    <td valign="top">
    	<input type="text" name="width" size="10" value="<?php echo $width?>" />
		<span class="nm_help">e.g: 250</span>
    </td>
  </tr>
  
  <tr>
    <td valign="middle">Background Color</td>
    <td valign="top">
    	<input type="text" name="bgcolor" size="10" value="<?php echo $bgcolor?>" />
		<span class="nm_help">e.g: #ccccc 2px solid</span>
    </td>
  </tr>
  
  <tr>
    <td valign="middle">Border Color</td>
    <td valign="top">
    	<input type="text" name="bordercolor" size="20" value="<?php echo $bordercolor?>" />
		<span class="nm_help">e.g: #ccccc 2px solid</span>
    </td>
  </tr>
  
  <tr>
    <td valign="middle">Font Color</td>
    <td valign="top">
    	<input type="text" name="fontcolor" size="10" value="<?php echo $fontcolor?>" />
		<span class="nm_help">e.g: #ccccc</span>
    </td>
  </tr>
  
  <tr>
    <td valign="middle">Font Size</td>
    <td valign="top">
    	<input type="text" name="fontsize" size="10" value="<?php echo $fontsize?>" />
		<span class="nm_help">e.g: 12px</span>
    </td>
  </tr>
  
  <tr>
    <td valign="top">&nbsp;</td>
    <td valign="top"><input type="submit" value="Save Settings" name="btn_options" class="button" /></td>
  </tr>
  <tr>
    <td valign="top">&nbsp;</td>
    <td valign="top">&nbsp;</td>
  </tr>
</table>
</form>
<br /><br />


<a href="http://www.najeebmedia.com/"><img src="http://www.najeebmedia.com/logo.png" alt="Nmedia Logo" border="0" width="175" /></a>
<p>
Nmedia providing Web Application Development and Designing services with a team of Skilled and Professional Yound guys. We have developed many E-commerce, Wordpress, Bespoke web projects at very reasonable prices. Must see our projects and feedbacks from our respected clients by visiting company site: <a href="http://www.najeebmedia.com/">Nmedia</a><br />
<br />
Thanks<br />
Najeeb Ahmad<br />
<a href="mailto:ceo@najeebmedia.com">ceo@najeebmedia.com</a>
</p>