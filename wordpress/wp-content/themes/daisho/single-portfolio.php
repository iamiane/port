<?php get_header(); ?>
<?php
$welcome_text 		= 	get_option("welcome_text");
$front_page 		= 	get_option('front_page');
	if($_GET['prj'] == 'classic') { $_SESSION['prj'] = 0; }
	if($_GET['prj'] == 'thumb') { $_SESSION['prj'] = 1; }
	$portfolio_mode 	= 	get_option('portfolio_mode'); // 1 = thumbnail grid, 0 = classic
	if(isset($_SESSION['prj']) && ($_SESSION['prj'] == 0)){ $portfolio_mode = 0; }
	if(isset($_SESSION['prj']) && ($_SESSION['prj'] == 1)){ $portfolio_mode = 1; }
	$portfolio_recent 	= 	get_option('portfolio_recent');
	$blog_recent 		= 	get_option('blog_recent');
	$post_id			=	esc_url(get_permalink($post->ID));
	$temp 				= 	$post;
	$flow_shuffle_button		=	get_option('flow_homepage_shuffle_button');
?>

<?php if($welcome_text){ ?>
	<div class="welcome-text"><?php echo stripslashes($welcome_text); ?></div>
<?php } ?>

<?php if($portfolio_mode == '1'){ ?>
<?php }else{ ?>
	<?php get_template_part('slideshow'); ?>
	<?php 
	if($page_id = $front_page){
		$page_data = get_page( $page_id );
		if(get_post_meta($page_data->ID, 'Description', true)){ ?>
			<div class="page-description" style="margin: 15px auto 50px;"><?php echo get_post_meta($page_data->ID, 'Description', true); ?></div>
		<?php } ?>
		<div class="page-content clearfix container_12"><?php echo do_shortcode($page_data->post_content); ?></div>
	<?php } ?>
<?php } $post = $temp; ?>

<?php get_template_part('project', 'container'); ?>

<?php if($portfolio_mode == '1'){ ?>
<div class="tn-grid-container">
<section id="content">
	<section id="options" class="clearfix">
		<?php
			$taxonomy = 'portfolio_category';
			$tax_terms = get_terms($taxonomy);
		?>
		<ul id="filters" class="option-set clearfix" data-option-key="filter">
			<li><a href="#filter" data-option-value="*" class="selected"><?php _e('All Works', 'flowthemes'); ?></a></li>
			<?php
				foreach ($tax_terms as $tax_term) {
					//echo '<li>' . '<a href="#filter" data-option-value=".' . strtolower(str_replace(" ", "-", $tax_term->name)) . '">' . $tax_term->name  . '</a></li>';
					echo '<li>' . '<a href="#filter" data-option-value=".' . sanitize_title($tax_term->slug) . '">' . $tax_term->name  . '</a></li>';
				}
			?>
		</ul>
		<ul id="etc" class="clearfix">
			<li id="toggle-sizes"><a href="#toggle-sizes" class="toggle-selected"><?php _e('Toggle sizes', 'flowthemes'); ?></a><a href="#toggle-sizes"><?php _e('Toggle sizes', 'flowthemes'); ?></a></li>
			<?php if($flow_shuffle_button){ ?>
			<li id="shuffle"><a href='#shuffle'><?php _e('Shuffle', 'flowthemes'); ?></a></li>
			<?php } ?>
		</ul>
	</section> <!-- #options -->

<div id="container" class="clickable variable-sizes clearfix">
<?php } ?>
<?php 
	$count = 0;
	$i = -1;
	$r = 0;
	$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
	$post_per_page = -1;
	$do_not_show_stickies = 1; // 0 to show stickies
	$pf_categorynotin = get_post_meta($wp_query->post->ID, "exclude-pf-categories", true);
  
	$args=array(
		'post_type' => array ('portfolio'),
		'orderby' => $orderby,
		'order' => 'DESC',
		'paged' => $paged,
		'posts_per_page' => $post_per_page,
		'ignore_sticky_posts' => $do_not_show_stickies
	);
	if($pf_categorynotin){
		$args['tax_query'] = array(
			array(
				'taxonomy' => 'portfolio_category',
				'field' => 'slug',
				'terms' => $pf_categorynotin,
				'operator' => 'NOT IN'
			)
		); //category__in
	}

	$temp = $wp_query;  // assign orginal query to temp variable for later use   
	$wp_query = null;
	$wp_query = new WP_Query($args);
	$fg_image = '';
	$fg_imagemain = '';
	if( have_posts() ) : 
		while ($wp_query->have_posts()) : $wp_query->the_post();
		
			/* Get post categories */
			$post_cat = array();
			$post_cat = wp_get_object_terms($post->ID, "portfolio_category");
			$post_cats = array();
			$post_rel = ' all ';
			for($h=0;$h<count($post_cat);$h++){
				$post_rel .= $post_cat[$h]->slug.' ';
				$post_cats[] = $post_cat[$h]->name;
			}
			
			/* Get and process image */
			unset($attachments);
			unset($thumbnail_hover_color);
			$attachments = get_post_meta($post->ID, '300-160-image', true);
			$thumbnail_hover_color = get_post_meta($post->ID, 'thumbnail_hover_color', true);
			/* $image_resizer_output = '';
			if($width = get_post_meta($post->ID, 'image_width', true)) { $image_resizer_output.= 'width='.$width.'&amp;';}else{$image_resizer_output.= 'width=400&amp;';}
			if($height = get_post_meta($post->ID, 'image_height', true)) { $image_resizer_output.= 'height='.$height.'&amp;';}else{$image_resizer_output.= 'height=300&amp;';}
			if($crop_ratio_x_y = get_post_meta($post->ID, 'crop_ratio_x_y', true)) { $image_resizer_output.= 'cropratio='.$crop_ratio_x_y.'&amp;';}else{$image_resizer_output.= 'cropratio=4:3&amp;';}
			$image_resizer_output2 = 'width=1120&amp;'; */
			if ($attachments or $thumbnail_hover_color) {
				$post_cat = array();
				$post_cat = wp_get_object_terms($post->ID, "portfolio_category");
				$post_cats = array();
				for($h=0;$h<count($post_cat);$h++){
					$post_cats[] = $post_cat[$h]->name;
				}
				$cats_pf_this = implode(", ", $post_cats);
				
				$post_cats_sanitized2 = array();
				for($h=0;$h<count($post_cat);$h++){
					$post_cats_sanitized2[] = $post_cat[$h]->slug;
				}
				$post_cats_sanitized = array();
				foreach($post_cats_sanitized2 as $key => $value){ $post_cats_sanitized[] = $value; }
	
				$cats_pf_this_class = implode(" ", $post_cats_sanitized);
				
				$cprojvalid = false;
				if(get_post_meta($post->ID, 'Title', true)){
					$cprojvalid = true;
					$thumb_title = get_post_meta($post->ID, 'Title', true);
				}else{
					$thumb_title = get_the_title(); 
				}
				//$thumb_descr = addslashes(preg_replace('/\s+/', ' ', trim(get_post_meta($post->ID, 'Description', true))));
				$thumb_descr = do_shortcode(get_post_meta($post->ID, 'Description', true));
				$tmpddourrole = get_post_meta($post->ID, 'portfolio_ourrole', true);
				$tmpdddate = get_post_meta($post->ID, 'portfolio_date', true);
				$tmpddclient = get_post_meta($post->ID, 'portfolio_client', true);
				$tmpddagency = get_post_meta($post->ID, 'portfolio_agency', true);
				$tmpddbgimg = get_post_meta($post->ID, 'bg_image', true);
				$tmpddtxtcolor = get_post_meta($post->ID, 'portfolio_text_color', true);
				$tmpddsize = get_post_meta($post->ID, 'thumbnail_size', true);
				$tmpddlink = get_post_meta($post->ID, 'thumbnail_link', true);
				$tmpddLinkNewWindow = get_post_meta($post->ID, 'thumbnail_link_newwindow', true);
				if($tmpddLinkNewWindow == 1){ $tmpddLinkNewWindow = 'target="_blank"'; }else{ $tmpddLinkNewWindow = ''; }
				$tmpdddisplay = get_post_meta($post->ID, 'thumbnail_meta', true);
				if($tmpdddisplay == 1){ $tmpdddisplay = 'tn-display-meta'; }else{ $tmpdddisplay = ''; }
				$tmpddslides = get_post_meta($post->ID, 'slides', true);
				
				/* $resizepath_mobile = get_bloginfo('template_directory').'/image.php?'.str_replace('&amp;', '&', $image_resizer_output).'image=http';
				$resizepath_desktop = get_bloginfo('template_directory').'/image.php?'.str_replace('&amp;', '&', $image_resizer_output2).'image=http';
				if(preg_match('/\.(bmp|jpg|jpeg|pjpeg|png|gif)$/i',$tmpddslides)){
					if($mobile){ $tmpddslides = str_replace('http', $resizepath_mobile , $tmpddslides); }else{ $tmpddslides = str_replace('http', $resizepath_desktop , $tmpddslides); }
				} */
				
				// Set thumbnail sizes
				// Empty(small); 0(random); 1(large); 1,5(horizontal); 2,4(small); 3(medium); 6(vertical)

				unset($tmpddvertical);
				if($tmpddsize == ''){ $tmpddsize = rand(2,11);
				}else if($tmpddsize == '0'){ $tmpddsize = rand(2,11); 
				}else if($tmpddsize == '1'){ $tmpddsize = 7; 
				}else if($tmpddsize == '2'){ $tmpddsize = 3;
				}else if($tmpddsize == '3'){ $tmpddsize = 6;
				}else if($tmpddsize == '4'){ $tmpddsize = 5;
				}else if($tmpddsize == '5'){ $tmpddsize = 2; 
				}else{ $tmpddsize = 2; }
				if($tmpddsize == 6 or $tmpddsize == 9){ $tmpddvertical = 'vertical-thumbnail'; }

				if(!$tmpddlink){ $i++; }
				$r++;
				
				if($portfolio_mode == '0' AND $r <= 5){ //Static Homepage portfolio enabled.
					unset($element_image);
					if($attachments){
						$element_image = '<img class="project-img" style="z-index: 1;" src="'.$attachments.'" alt="" />';
					}
					if(!$tmpddlink){ $e = $i; }else{ $e = ''; }
					$element_small .= '<div class="element element-stand-alone '.$tmpdddisplay.'">';
					if($tmpddlink){ $element_small .= '<a class="thumbnail-link" href="'.$tmpddlink.'" '.$tmpddLinkNewWindow.'></a>'; }
					$element_small .= '<p class="number" style="z-index:3;">'.$tmpddsize.'</p>
						<h3 class="symbol" style="z-index:3;">'.$thumb_title.'</h3>
						<h2 class="name" style="z-index:3;">'.$tmpddclient.'</h2>
						<h2 class="categories" style="z-index:3;">'.$cats_pf_this.'</h2>
						<p class="id" style="display:none;">'.$e.'</p>
						<div style="background-color:'.$thumbnail_hover_color.'; width: 100%; height: 100%; z-index: 2;" class="thumbnail-hover"></div>
						'.$element_image.'
						<div style="background-color:'.$thumbnail_hover_color.'; width: 100%; height: 100%;z-index:0;"></div>
					</div>';
				}else if($portfolio_mode == '1'){ ?>
				
			<div class="element <?php echo $cats_pf_this_class; ?> <?php if(isset($tmpddvertical)){ echo $tmpddvertical; } ?> <?php echo $tmpdddisplay; ?>" data-symbol="Mg" data-category="alkaline-earth">
				<?php if($tmpddlink){ echo '<a class="thumbnail-link" href="'.$tmpddlink.'" '.$tmpddLinkNewWindow.'></a>'; } ?>
				<p class="number"><?php echo $tmpddsize; ?></p>
				<h3 class="symbol"><?php echo $thumb_title; ?></h3>
				<h2 class="name"><?php echo $tmpddclient; ?></h2>
				<h2 class="categories"><?php echo $cats_pf_this; ?></h2>
				<p class="id" style="display:none;"><?php if(!$tmpddlink){ echo $i; } ?></p>
				<div style="background-color: <?php echo $thumbnail_hover_color ?>; width: 100%; height: 100%;" class="thumbnail-hover"></div>
				<?php if($attachments){ ?>
					<img class="project-img" src="<?php echo $attachments; ?>" alt="" />
				<?php } ?>
				<div style="background-color: <?php echo $thumbnail_hover_color ?>; width: 100%; height: 100%;z-index:-2;"></div>
			</div>
			<?php }
			if(!$tmpddlink){
			$phpPortfolioArray[$i] = array(json_encode($thumb_title), json_encode($thumb_descr), json_encode($tmpdddate), json_encode($tmpddclient), json_encode($tmpddagency), json_encode($tmpddourrole), json_encode(do_shortcode($tmpddslides)), json_encode(get_permalink($post->ID)), json_encode($tmpddlink));
			
			$portfolioArray .='
				portfolioArray['.$i.'] = [];
				portfolioArray['.$i.'][0]="'.$thumb_title.'";
				portfolioArray['.$i.'][1]="'.$thumb_descr.'";
				portfolioArray['.$i.'][2]="'.$tmpdddate.'";
				portfolioArray['.$i.'][3]="'.$tmpddclient.'";
				portfolioArray['.$i.'][4]="'.$tmpddagency.'";
				portfolioArray['.$i.'][5]="'.$tmpddourrole.'";
				portfolioArray['.$i.'][6]="'.preg_replace("/(\n|\r|\r\n)/", '', str_replace("\"","\\\"",do_shortcode($tmpddslides))).'";
				portfolioArray['.$i.'][7]="'.get_permalink( $post->ID ).'";
				';
			} /* Exclude external link thumbnails */
			?>
			<?php } //if image exists, project is valid ?>
			<?php endwhile ?>
			<?php else : ?>
				<h2 class="center"><?php _e('Not Found', 'flowthemes'); ?></h2>
				<p class="center"><?php _e('Sorry, but you are looking for something that isn\'t here.', 'flowthemes'); ?></p>
			<?php endif; $wp_query = $temp;  //reset back to original query ?>
<?php if($portfolio_mode == '1'){ ?>
</div> <!-- /#container -->
</section>
</div>
<?php } ?>

<?php if($portfolio_mode == '1'){ }else{ ?>
	<?php if($portfolio_recent == '1'){ }else{ ?>
		<div class="recent-heading-container clearfix">
		<div class="recent-heading"><!--<span class="spacer"></span>--><h1><?php _e('Recent Projects', 'flowthemes'); ?></h1><span class="spacer"></span><a href="#"><?php _e('View Portfolio', 'flowthemes'); ?></a></div><div id="content-small" style="margin-top: 15px;" class="clearfix"><?php echo $element_small; ?></div></div>
	<?php } ?>

	<?php if($blog_recent == '1'){ }else{ ?>
	<div style="max-width:1120px; width: 92%; margin: 0 auto -3px; padding-top: 15px; clear:both; position: relative;" class="clearfix recent-blog-container">
	<div class="recent-heading"><!--<span class="spacer"></span>--><h1><?php _e('New Blog Posts', 'flowthemes'); ?></h1><span class="spacer"></span><a href="#"><?php _e('View Blog', 'flowthemes'); ?></a></div><div style="margin-top: 15px; background-color:#eeeeee;" class="clearfix">
		<div class="related-posts related-posts-home clearfix" style="border: none; max-width: 1120px; width: 100%; margin: 0 auto;">
			<?php wp_reset_query();
			query_posts('posts_per_page=4');
			if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
			<div class="related-posts-title"><a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a><small><?php echo date_i18n(get_option('date_format'), strtotime($post->post_date)); //the_time('F jS, Y'); ?></small></div>
			<?php endwhile; else: _e("No posts found.", 'flowthemes'); endif; wp_reset_query(); ?>
		</div>
		</div></div>
	<?php } ?>
<?php } ?>

<script type="text/javascript">
var portfolioArray = [];
<?php //echo $portfolioArray; ?>

<?php
echo "var phpPortfolioArray = [];\n";
if(is_array($phpPortfolioArray)){
	foreach($phpPortfolioArray as $k => $v){
		echo "phpPortfolioArray[".$k."] = [];\n";
		echo "phpPortfolioArray[".$k."][0] = ".$v[0].";\n";
		echo "phpPortfolioArray[".$k."][1] = ".$v[1].";\n";
		echo "phpPortfolioArray[".$k."][2] = ".$v[2].";\n";
		echo "phpPortfolioArray[".$k."][3] = ".$v[3].";\n";
		echo "phpPortfolioArray[".$k."][4] = ".$v[4].";\n";
		echo "phpPortfolioArray[".$k."][5] = ".$v[5].";\n";
		echo "phpPortfolioArray[".$k."][6] = ".$v[6].";\n";
		echo "phpPortfolioArray[".$k."][7] = ".$v[7].";\n";
		echo "phpPortfolioArray[".$k."][8] = ".$v[8].";\n";
	}
}
?>

/* Create an array of standard projects and exclude external link thumbnails */
var portfolioArrayValid = [];
/* for(var pai=0;pai<portfolioArray.length;pai++){
	if(portfolioArray[pai][6]){
	if(!portfolioArray[pai][8]){
		portfolioArrayValid[portfolioArrayValid.length] = portfolioArray[pai];
	}
} */
portfolioArray = phpPortfolioArray;
portfolioArrayValid = portfolioArray;
portfolioArrayValid = phpPortfolioArray;

<?php if($demoServer){ ?>
/* Create and randomize an array of projects with slides only */
portfolioArrayValid = [];
for(var pai2=0;pai2<portfolioArray.length;pai2++){
	if(portfolioArray[pai2][6]){
		portfolioArrayValid[portfolioArrayValid.length] = portfolioArray[pai2];
	}
}
for(var pai2=0;pai2<portfolioArray.length;pai2++){
	if(portfolioArray[pai2][6]){
		portfolioArrayValid[portfolioArrayValid.length] = portfolioArray[pai2];
	}
}
<?php } ?>

/* $ = jQuery.noConflict(); */
	
	var portfolio_closenum = 0;
	var portfolio_closedir = false;
	var homepage_title = '<?php printf(_x('%s - Home', 'Homepage title', 'flowthemes'), get_bloginfo('name')); ?>';
	//var home_url = "<?php //echo home_url(); ?>";
	
	<?php get_template_part('project', 'script'); ?>

	window.onpopstate = function(){
		window.onpopstate = function(ev){
			var evstate = ev.state?ev.state:{};
			if(!evstate.cancelback){
				closePortfolioItem();
			}else{
				if(evstate.projid || evstate.projid == 0){
					bringPortfolio(evstate.projid);
				}
			}
		}
	}
	
jQuery(function(){
    
    var $container = jQuery('#container');
    var $containerSmall = jQuery('#content-small');
    
      // add randomish size classes
      $container.find('.element').each(function(){
        var $this = jQuery(this),
            number = parseInt( $this.find('.number').text(), 10 );
        if ( number % 7 % 2 === 1 ) {
          $this.addClass('width2');
        }
        if ( number % 3 === 0 ) {
          $this.addClass('height2');
        }        
		if ( number % 7 === 0 ) { //Rare because it picks random number from 1 to 11 and only 7 matches criteria
          $this.addClass('width3');
          $this.addClass('height2');
        }
      });
	  
	// center images inside elements
	function centerIsotypeImages(){
		jQuery('.element').each(function(){
			var $this = jQuery(this);
			if($this.find('img').get(0) === undefined){ return; }
			var cont_ratio = $this.width() / $this.height();
			var img_ratio = $this.find('img').get(0).width / $this.find('img').get(0).height;

			if(cont_ratio <= img_ratio){
				$this.find('img').css({ 'width' : 'auto', 'height' : '100%', 'top' : 0 }).css({ 'left' : ~(($this.find('img').width()-$this.width())/2)+1 });
				$this.find('img').stop(true, true).fadeIn(200);
				$this.find('img').addClass('project-img-visible');
			}else{
				$this.find('img').css({ 'width' : '100%', 'height' : 'auto', 'left' : 0 }).css({ 'top' : ~(($this.find('img').height()-$this.height())/2)+1 });
				$this.find('img').stop(true, true).fadeIn(200);
				$this.find('img').addClass('project-img-visible');
			}
		});
	}
	jQuery(window).load(function(){
		centerIsotypeImages();
		verticalimageflow();
	});
	
	jQuery(".project-img").one("load",function(){
		var $this = jQuery(this);
		var cont_ratio = $this.parent().width() / $this.parent().height();
		var img_ratio = $this.get(0).width / $this.get(0).height;
		if(cont_ratio <= img_ratio){
			$this.css({ 'width' : 'auto', 'height' : '100%', 'top' : 0 }).css({ 'left' : ~(($this.width()-$this.parent().width())/2)+1 });
			$this.addClass('project-img-visible');
		}else{
			$this.css({ 'width' : '100%', 'height' : 'auto', 'left' : 0 }).css({ 'top' : ~(($this.height()-$this.parent().height())/2)+1 });
			$this.addClass('project-img-visible');
		}
	});
	
	var number_of_ids = portfolioArrayValid.length;
	if(number_of_ids >= 1){
		for(var current_id = 0;current_id<number_of_ids;current_id=current_id+1){
			if(portfolioArrayValid[current_id][7] == '<?php echo $post_id; ?>'){
				jQuery('.portfolio-arrowright').click(function(){ current_id++; if(current_id == number_of_ids){ current_id = 0; } bringPortfolio( current_id ); });
				jQuery('.portfolio-arrowleft').click(function(){ current_id--; if(current_id == -1){ current_id = number_of_ids-1; } bringPortfolio( current_id ); });
				break;
			}
		}
	}
    
    $container.isotope({
      itemSelector : '.element',
      masonry : {
        //columnWidth : 120
        columnWidth : 5,
		gutterWidth: 5,
      },
      masonryHorizontal : {
        rowHeight: 120
      },
      cellsByRow : {
        columnWidth : 240,
        rowHeight : 240
      },
      cellsByColumn : {
        columnWidth : 240,
        rowHeight : 240
      },
      getSortData : {
        symbol : function( $elem ) {
          return $elem.attr('data-symbol');
        },
        category : function( $elem ) {
          return $elem.attr('data-category');
        },
        number : function( $elem ) {
          return parseInt( $elem.find('.number').text(), 10 );
        },
        weight : function( $elem ) {
          return parseFloat( $elem.find('.weight').text().replace( /[\(\)]/g, '') );
        },
        name : function ( $elem ) {
          return $elem.find('.name').text();
        }
      }
    });
    
    
      var $optionSets = jQuery('#options .option-set'),
          $optionLinks = $optionSets.find('a');

      $optionLinks.click(function(){
        var $this = jQuery(this);
        // don't proceed if already selected
        if ( $this.hasClass('selected') ) {
          return false;
        }
        var $optionSet = $this.parents('.option-set');
        $optionSet.find('.selected').removeClass('selected');
        $this.addClass('selected');
  
        // make option object dynamically, i.e. { filter: '.my-filter-class' }
        var options = {},
            key = $optionSet.attr('data-option-key'),
            value = $this.attr('data-option-value');
        // parse 'false' as false boolean
        value = value === 'false' ? false : value;
        options[ key ] = value;
        if ( key === 'layoutMode' && typeof changeLayoutMode === 'function' ) {
          // changes in layout modes need extra logic
          changeLayoutMode( $this, options )
        } else {
          // otherwise, apply new options
          $container.isotope( options );
        }
        
        return false;
      });


    
      // change layout
      var isHorizontal = false;
      function changeLayoutMode( $link, options ) {
        var wasHorizontal = isHorizontal;
        isHorizontal = $link.hasClass('horizontal');

        if ( wasHorizontal !== isHorizontal ) {
          // orientation change
          // need to do some clean up for transitions and sizes
          var style = isHorizontal ? 
            { height: '80%', width: $container.width() } : 
            { width: 'auto' };
          // stop any animation on container height / width
          $container.filter(':animated').stop();
          // disable transition, apply revised style
          $container.addClass('no-transition').css( style );
          setTimeout(function(){
            $container.removeClass('no-transition').isotope( options );
          }, 100 )
        } else {
          $container.isotope( options );
        }
      }

    
      // close bringPortfolio()
      jQuery('#compact_navigation_container').delegate( '.header-back-to-blog-link', 'click', function(){
		jQuery('.portfolio_box').removeClass('portfolio_box-visible');
		jQuery('body').removeClass('daisho-portfolio-viewing-project');
		jQuery('#compact_navigation_container').removeClass('compact_navigation_container-visible');
		jQuery('.project-coverslide').removeClass('project-coverslide-visible');
		jQuery('.project-navigation').removeClass('project-navigation-visible');
		jQuery('.project-slides').empty();
		jQuery('title').text(homepage_title);
		if(!jQuery.browser.msie){
			var document_title = "<?php bloginfo('name'); ?><?php wp_title('-'); ?>";
			var portfoliohistorywpurl = "<?php $biurl=substr(get_bloginfo("url"),7);if(strpos($biurl,"/")!==false){print(substr($biurl,strpos($biurl,"/")+1));} ?>";
			window.history.pushState({}, document_title, ((portfoliohistorywpurl)?("/"+portfoliohistorywpurl+""):"/"));
		}
      });      
	  
		// change size of clicked element
		$container.delegate( '.element', 'click', function(){
			if(jQuery(this).find('.thumbnail-link').length != 0){ return; }
			var current_id = jQuery(this).find('.id').text();
			bringPortfolio(current_id);
			//  jQuery(this).toggleClass('large');
			//  $container.isotope('reLayout', centerIsotypeImages);
		});		
		
		// change size of clicked element (small)
		$containerSmall.delegate( '.element', 'click', function(){
			var current_id = jQuery(this).find('.id').text();
			bringPortfolio(current_id);
		});
	  

      // toggle variable sizes of all elements
      jQuery('#toggle-sizes').find('a').click(function(){
	  if(jQuery(this).hasClass('toggle-selected')){ return false; }
		jQuery('#toggle-sizes').find('a').removeClass('toggle-selected');
		jQuery(this).addClass('toggle-selected');
		if(!jQuery('#toggle-sizes a:first-child').hasClass('toggle-selected')){ $container.find('.element').addClass('element-small'); }else{ $container.find('.element').removeClass('element-small'); }
		$container.find('img').fadeOut(0);
        $container
          .toggleClass('variable-sizes')
          .isotope('reLayout');
          centerIsotypeImages();
        return false;
      });

    
      jQuery('#insert a').click(function(){
        var $newEls = jQuery( fakeElement.getGroup() );
        $container.isotope( 'insert', $newEls );

        return false;
      });

      jQuery('#append a').click(function(){
        var $newEls = jQuery( fakeElement.getGroup() );
        $container.append( $newEls ).isotope( 'appended', $newEls );

        return false;
      });


    var $sortBy = jQuery('#sort-by');
    jQuery('#shuffle a').click(function(){
		$container.isotope('shuffle');
		$sortBy.find('.selected').removeClass('selected');
		$sortBy.find('[data-option-value="random"]').addClass('selected');
		return false;
    });
});
</script>

<?php get_footer(); ?>