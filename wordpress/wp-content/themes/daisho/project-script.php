function verticalimageflow(){
	jQuery('.project-slides').find('.myimage').each(function(){
		var current_image = jQuery(this);
		if(current_image.is("img")){
			jQuery('<img />').attr("src",this.src).load(function(){
				if((this.width < 1120) && (this.width != 0)){ var img_max_width = this.width+"px"; var img_width = '100%'; }else{ var img_max_width = '100%'; var img_width = '100%'; }
				current_image.wrap("<div class=\"project-slides-container\" style=\"margin: 0 auto; max-width: "+img_max_width+"; width: "+img_width+"\"></div>");
				if(((current_image.attr('data-title') != '') && (current_image.attr('data-title') != '<h4></h4>')) && (current_image.attr('data-title') != undefined)){ var currentslidetitle = current_image.attr('data-title'); while(currentslidetitle.indexOf('*') != -1){ currentslidetitle = currentslidetitle.replace('*','"'); } current_image.after('<span style="opacity:0;">'+currentslidetitle.replace("</h4>", "</h4><p>")+'</p></span>'); current_image.next('span').delay(800).css({"opacity" : 1}); }
			});
		}else if(current_image.is("div") && current_image.hasClass('description_capable')){
			if(((current_image.attr('data-title') != '') && (current_image.attr('data-title') != '<h4></h4>')) && (current_image.attr('data-title') != undefined)){ 
				var currentslidetitle = current_image.attr('data-title'); 
				while(currentslidetitle.indexOf('*') != -1){ currentslidetitle = currentslidetitle.replace('*','"'); }
				current_image.find('img').after('<span style="opacity:0;" class="project-slide-description">'+currentslidetitle.replace("</h4>", "</h4><p>")+'</p></span>'); 
				current_image.find('img').next('span').delay(800).css({"opacity" : 1}); 
			}
		}else if(current_image.is("div") && current_image.hasClass('description_below_capable')){
			if(((current_image.attr('data-title') != '') && (current_image.attr('data-title') != '<h4></h4>')) && (current_image.attr('data-title') != undefined)){ 
				var currentslidetitle = current_image.attr('data-title'); 
				while(currentslidetitle.indexOf('*') != -1){ currentslidetitle = currentslidetitle.replace('*','"'); }
				current_image.after('<span style="opacity:0;" class="project-slide-description-below">'+currentslidetitle.replace("</h4>", "</h4><p>")+'</p></span>'); 
				current_image.next('span').delay(800).css({"opacity" : 1}); 
			}
		}
	});
}

function supports_history_api(){
	return !!(window.history && history.pushState);
}

function bringPortfolio(current_id){
  if(portfolioArrayValid[current_id] === undefined){ if(portfolioArrayValid.length != 0){ bringPortfolio(0); } return; }
  var title = portfolioArrayValid[current_id][0];
  if(title == ''){ var title = 'Title not specified'; }
  var desc = portfolioArrayValid[current_id][1];
  var date = portfolioArrayValid[current_id][2];
  var client = portfolioArrayValid[current_id][3];
  var agency = portfolioArrayValid[current_id][4];
  var ourrole = portfolioArrayValid[current_id][5];
  var slides = portfolioArrayValid[current_id][6];
  var permalink = portfolioArrayValid[current_id][7];
  var number_of_ids = portfolioArrayValid.length;

   jQuery('body,html').animate({scrollTop:0},800);
   jQuery('.portfolio_box').removeClass('portfolio_box-visible');
   
   jQuery('body').addClass('daisho-portfolio-viewing-project');

   setTimeout(function(){
	if(date == ''){ jQuery('.project-date').hide(); }else{ jQuery('.project-date').show(); }
	if(client == ''){ jQuery('.project-client').hide(); }else{ jQuery('.project-client').show(); }
	if(agency == ''){ jQuery('.project-agency').hide(); }else{ jQuery('.project-agency').show(); }
	if(ourrole == ''){ jQuery('.project-ourrole').hide(); }else{ jQuery('.project-ourrole').show(); }

	jQuery('.portfolio_box').addClass('portfolio_box-visible');
	jQuery('#compact_navigation_container').addClass('compact_navigation_container-visible');
	jQuery('.project-coverslide').addClass('project-coverslide-visible');
	jQuery('.project-navigation').addClass('project-navigation-visible');
	
	jQuery('.project-title').html(title);
	jQuery('.project-description').html(desc);
	jQuery('.project-exdate').html(date);
	jQuery('.project-exclient').html(client);
	jQuery('.project-exagency').html(agency);
	jQuery('.project-exourrole').html(ourrole);
	jQuery('.project-slides').html(slides);
	verticalimageflow();
	
	if(!jQuery.browser.msie){
		if(!window.history.state || (window.history.state.projid != current_id)){
			window.history.pushState({'cancelback': true, 'projid': current_id}, title, permalink);
		}
	}
	jQuery('title').text(title);
	
	if(jQuery(".sharing-icons").length){
		jQuery(".sharing-icons-twitter").attr("href", "https://twitter.com/share?url="+escape(window.location.href)+"&amp;text="+escape(title));
		jQuery(".sharing-icons-facebook").attr("href", "http://www.facebook.com/sharer.php?u="+escape(window.location.href)+"&amp;t="+escape(title));
		jQuery(".sharing-icons-googleplus").attr("href", "https://plus.google.com/share?url="+escape(window.location.href));
	}
	
	setTimeout(function(){
		try{
			VideoJS.setupAllWhenReady();
			videojsvolumemuteclick();
		}catch(e){}
	}, 500);

	jQuery('.portfolio-arrowright').unbind('click');
	jQuery('.portfolio-arrowleft').unbind('click');

	jQuery('.portfolio-arrowright').click(function(){
		current_id++; if(current_id == number_of_ids){ current_id = 0; }
		bringPortfolio( current_id );
	});
	jQuery('.portfolio-arrowleft').click(function(){
		current_id--; if(current_id == -1){ current_id = number_of_ids-1; }
		bringPortfolio( current_id );
	});
	
	}, 200); //animate opaciy 0 (.portfolio_box)
}

function closePortfolioItem(){
	jQuery('.portfolio_box').removeClass('portfolio_box-visible');
	jQuery('body').removeClass('daisho-portfolio-viewing-project');
	jQuery('#compact_navigation_container').removeClass('compact_navigation_container-visible');
	jQuery('.project-coverslide').removeClass('project-coverslide-visible');
	jQuery('.project-navigation').removeClass('project-navigation-visible');
	jQuery('.project-slides').empty();
	jQuery('title').text(homepage_title);
}