<?php 
	function custom_slidessc($atts, $content = null){
		$class = shortcode_atts( array('text_color' => '#ffffff', 'image' => '', 'video_vimeo' => '', 'video_youtube' => '', 'video_mp4' => '', 'video_ogg' => '', 'video_webm' => '', 'video_poster' => '', 'slide_desc' => '', 'slide_horizontal' => '', 'slide_fitscreen' => '', 'slide_noresize' => '', 'custom' => ''), $atts );

		/* Slide Description */
		if($class['slide_desc'] != ''){ 
			$slide_desc = $class['slide_desc']; 
			$slide_desc = "data-title=\"".$slide_desc."\"";
		}
		
		/* Slide Text/Cursor Color */
		if($class['text_color'] == '#ffffff'){
			$text_color = 'text_white'; 
		}else{
			$text_color = 'text_black'; 
		}
		
		/* ------------------------------------*/
		/* -------->>> IMAGE SLIDE <<<---------*/
		/* ------------------------------------*/
		if($class['image'] != ''){
			$image = $class['image'];
			if($class['slide_horizontal'] == 'true'){ $horizontal = 'slide_horizontal '; }else{ $horizontal = ''; }
			if($class['slide_horizontal'] == 'true' || $class['slide_fitscreen'] == 'true'){ $slide_fitscreen = 'slide_fitscreen'; }else{ $slide_fitscreen = ''; }
			return '<img class="myimage '.$text_color.' '.$horizontal.$slide_fitscreen.'" src="'.$image.'" alt="" '.$slide_desc.' />';

		/* ------------------------------------*/
		/* ----->>> HTML5 VIDEO SLIDE <<<------*/
		/* ------------------------------------*/
		}elseif(($class['video_mp4'] != '' or $class['video_ogg'] != '' or $class['video_webm'] != '') AND !$mobile){
			$video_mp4 = $class['video_mp4'];
			$video_ogg = $class['video_ogg'];
			$video_webm = $class['video_webm'];
			if($class['video_poster'] != ''){ $video_poster = "poster=\"".$class['video_poster']."\""; }else{ $video_poster = ""; }
			return '<div class="myimage myvideo '.$text_color.'" '.$slide_desc.'>'.do_shortcode('[video mp4="'.$video_mp4.'" ogg="'.$video_ogg.'" webm="'.$video_webm.'" '.$video_poster.' preload="true"]').'</div>';
			
		/* ------------------------------------*/
		/* ------->>> YOUTUBE SLIDE <<<--------*/
		/* ------------------------------------*/
		}elseif($class['video_youtube'] != ''){
			$video_youtube = $class['video_youtube'];
			if($class['slide_noresize'] = 'true'){ $video_noresize = 'height="360" width="640"'; }else{ $video_noresize = 'height="100%" width="100%"'; }
			$strText = preg_replace( '/(http|ftp)+(s)?:(\/\/)((\w|\.)+)(\/)?(\S+)?/i', 'link', $video_youtube );
			if($strText == 'link'){ $array_link_explode = explode('v=', $video_youtube); $array_link_explode = explode('&', $array_link_explode[1]); $video_youtube =$array_link_explode[0]; }
			$video_poster = $class['video_poster'];
			
			if($video_poster != ''){
				return '<div class="myimage myvideo myvideo_yt description_capable '.$text_color.'"  '.$slide_desc.' style="position: relative;"><div style="right: 0; left: 0; margin: auto; bottom: 0; top: 0; height: 360px; width: 640px; position: absolute;"><iframe class="youtube-player" style="position:absolute;top:0;bottom:0;margin:auto;z-index: 10;" type="text/html" '.$video_noresize.' src="http://www.youtube.com/embed/'.$video_youtube.'?wmode=opaque" frameborder="0"></iframe></div><img src="'.$video_poster.'" alt="" style="position:relative;max-width:1120px;" /></div>';
			}else{
				return '<div class="myimage myvideo myvideo_yt description_below_capable '.$text_color.'" '.$slide_desc.'><iframe class="youtube-player" type="text/html" width="1120" height="660" src="http://www.youtube.com/embed/'.$video_youtube.'?wmode=opaque" frameborder="0"></iframe></div>';
			}

		/* ------------------------------------*/
		/* -------->>> VIMEO SLIDE <<<---------*/
		/* ------------------------------------*/
		}elseif($class['video_vimeo'] != ''){
			$video_vimeo = $class['video_vimeo'];
			if($class['slide_noresize'] = 'true'){ $video_noresize = 'height="360" width="640"'; }else{ $video_noresize = 'height="100%" width="100%"'; }
			$strText = preg_replace( '/(http|ftp)+(s)?:(\/\/)((\w|\.)+)(\/)?(\S+)?/i', 'link', $video_vimeo );
			if($strText == 'link'){ $array_link_explode = explode('.com/', $video_vimeo); $video_vimeo = $array_link_explode[1]; }
			$video_poster = $class['video_poster'];
			
			if($video_poster != ''){
				return '<div class="myimage myvideo myvideo_vimeo description_capable '.$text_color.'"  '.$slide_desc.' style="position: relative;"><div style="right: 0; left: 0; margin: auto; bottom: 0; top: 0; height: 360px; width: 640px; position: absolute;"><iframe style="bottom: 0; margin: auto; position: absolute; top: 0; z-index: 10;" src="http://player.vimeo.com/video/'.$video_vimeo.'?title=0&amp;byline=0&amp;portrait=0&amp;color=ffffff" '.$video_noresize.' frameborder="0" webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe></div><img src="'.$video_poster.'" alt="" style="position:relative;max-width:1120px;" /></div>';
			}else{
				return '<div class="myimage myvideo myvideo_vimeo description_below_capable '.$text_color.'" '.$slide_desc.'><iframe src="http://player.vimeo.com/video/'.$video_vimeo.'?title=0&amp;byline=0&amp;portrait=0&amp;color=ffffff" width="1120" height="630" frameborder="0" webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe></div>';
			}
		/* -------------------------------------*/
		/* -------->>> CUSTOM SLIDE <<<---------*/
		/* -------------------------------------*/
		}elseif($class['custom'] != ''){
			$class['custom'] = str_replace("flowleftbracket67", "<", $class['custom']);
			$class['custom'] = str_replace("flowrightbracket67", ">", $class['custom']);
			$class['custom'] = str_replace("*", '"', $class['custom']);
			return $class['custom'];
			//return false;
		}else{
			//return '[slide] error: no data<br />'.$content;
			return false;
		}
	}
	add_shortcode("slide", "custom_slidessc");
?>