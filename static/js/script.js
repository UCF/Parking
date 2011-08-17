jQuery(document).ready(function($) {
	Webcom.slideshow($);
	Webcom.chartbeat($);
	Webcom.analytics($);
	Webcom.handleExternalLinks($);
	Webcom.loadMoreSearchResults($);
	
	// Hide alert when close button is clicked and append to cookie
	$('#alerts a.close').click(function(e) {
		e.preventDefault();
		var li = $(this).parents('li');
		var hide = li.attr('id').replace('alert-', '');
		var old  = $.cookie('parking_alerts') ? $.cookie('parking_alerts') : '';
		var val     = old + hide + ',';
		$.cookie('parking_alerts',  val);
		li.hide();
	});
	
});
