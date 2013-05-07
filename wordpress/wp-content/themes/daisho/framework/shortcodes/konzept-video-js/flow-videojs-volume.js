function videojsvolumemuteclick(){
	jQuery(".vjs-volume-control").click(function() {
		if(jQuery(".video-js").prop('muted')){
			jQuery(".video-js").prop('muted', false).prop('volume', 1);
		}else{
			jQuery(".video-js").prop('muted', true).prop('volume', 0);
		}
	});
}

jQuery(window).load(function(){
	try{
		videojsvolumemuteclick();
	}catch(e){}
});