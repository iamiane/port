<footer>
            	<div class="footer">
					<ul>
						<li><a href="http://www.behance.net/iamiane" target="">behance</a></li>
						<li><a href="https://twitter.com/beholdiamiane" target="">Twitter</a></li>
						<li><a href="http://www.linkedin.com/in/iamiane" target="">LinkedIn</a></li>
					</ul>
                    </div>
            </footer>
            
		</div>


		<!-- classie.js by @desandro: https://github.com/desandro/classie -->
		<script src="<?php echo get_template_directory_uri(); ?>/library/js/classie.js"></script>
		<script src="<?php echo get_template_directory_uri(); ?>/library/js/cbpAnimatedHeader.min.js"></script>



		<!-- isotope -->
		<script src="<?php echo get_template_directory_uri(); ?>/library/js/jquery.isotope.min.js"></script>
		
		<script>
				$(document).ready(init);

function init() {
	var things = $('#things');
	var filters = {};
	
	things.isotope({
		itemSelector : '.thing'
	});
	
	// when everything loads, make the "all" options selected
	$('.filter a[data-filter-value=""]').addClass('selected');

	// filter buttons
	$('.filter a').click(
		function(e){
			e.preventDefault();
			var clicked_filter = $(this);
		
			// if the clicked link is already selected, don't do anything
			if ( clicked_filter.hasClass('selected') ) {
				return;
			}
			var optionSet = clicked_filter.parents('.option-set');
		
			// get rid of the ".selected" class on any links in this group and put it on the clicked link
			optionSet.find('.selected').removeClass('selected');
			clicked_filter.addClass('selected');
			
			// store the filters in the filters object, indexed by the group they're in
			// i.e. filters.category = 'animal'
			var group = optionSet.attr('data-filter-group');
			filters[ group ] = clicked_filter.attr('data-filter-value');
		
			// convert the filters object into an array of strings which are CSS class selectors
			var filters_to_use = [];
			for ( var group in filters ) {
				filters_to_use.push( filters[ group ] )
			}
			
			// smash the array together to get a big selector which will filter all elements with the filter classes
			var selector = filters_to_use.join('');
			
			// run the filter on the isotope element
			things.isotope({ filter: selector });
		}
	);
}
		</script>
  

       
		<?php wp_footer(); ?>
	</body>
</html>