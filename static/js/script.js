var analytics = function($){
	if ((typeof GA_ACCOUNT !== 'undefined') && Boolean(GA_ACCOUNT)){
		// Google analytics code
		var _sf_startpt=(new Date()).getTime();
		var _gaq = _gaq || [];
		_gaq.push(['_setAccount', GA_ACCOUNT]);
		_gaq.push(['_setDomainName', 'none']);
		_gaq.push(['_setAllowLinker', true]);
		_gaq.push(['_trackPageview']);
		(function(){
			var ga = document.createElement('script');
			ga.type = 'text/javascript';
			ga.async = true;
			ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
			var s = document.getElementsByTagName('script')[0];
			s.parentNode.insertBefore(ga, s);
		})();
	}
};

var handleExternalLinks = function($){
	var func = function(){
		var url   = $(this).attr('href');
		var host  = window.location.host.toLowerCase();
		
		if (url && url.search(host) < 0 && url.search('http') > -1){
			$(this).attr('target', '_blank');
		}
		
		return true;
	};
	
	$('a').click(func);
};

var chartbeat = function($){
	if ((typeof CB_UID !== 'undefined') && Boolean(CB_UID)){
		var _sf_async_config={
			uid   : parseInt(CB_UID),
			domain: CB_DOMAIN
		};
		(function(){
			function loadChartbeat() {
				window._sf_endpt=(new Date()).getTime();
				var e = document.createElement('script');
				e.setAttribute('language', 'javascript');
				e.setAttribute('type', 'text/javascript');
				e.setAttribute('src',
					(
						("https:" == document.location.protocol) ?
						"https://s3.amazonaws.com/" : "http://"
					) + "static.chartbeat.com/js/chartbeat.js"
				);
				document.body.appendChild(e);
			}
			var oldonload = window.onload;
			window.onload = (typeof window.onload != 'function') ?
				loadChartbeat : function() {
					oldonload(); loadChartbeat();
				};
		})();
	}
};

(function($){
	chartbeat($);
	analytics($);
	handleExternalLinks($);
	
	
	
	/* 
		Hide alert when close button is clicked 
	*/
	(function() {
		var ALERT_COOKIE_NAME = 'ucf_today_alerts';
		
		function extract_post_meta(data) {
			var post = [];
			post['id'] 		= data.substr(0, data.indexOf('-'));
			post['time']	= data.substr(data.indexOf('-') + 1, data.length);
			return (post['id'] == undefined || post['time'] == undefined) ? null : post;
		}
		function compact_post_meta(id, time) {return id + '-' + time;}
		
		
		$('#alerts > li')
			.each(function(index, li){
				$(li).find('a.close')
					.click(function(_event) {
						_event.preventDefault();
						var li 				= $('#alerts > li:eq(' + index + ')'),
							hidden_posts 	= $.cookie(ALERT_COOKIE_NAME);
							
						var cur_post = extract_post_meta(li.attr('id').replace('alert-', ''));
						
						if(cur_post != null) {	
							if(hidden_posts != null) { // the cookie is not set
								if(hidden_posts.indexOf(cur_post['id']) != -1) { // first time this post is being hidden? 
									hidden_posts = hidden_posts.split(',');
								
									for(var _index in hidden_posts) {
										var post = extract_post_meta(hidden_posts[_index]);
										if(post != null && cur_post['id'] == post['id']) {
											if(cur_post['time'] != post['id']) {
												/*	
													This alert is being hidden after it was updated in Wordpress.
													Update the cookie with the new post_modified time.
												*/ 
												$.cookie(ALERT_COOKIE_NAME, 
													$.cookie(ALERT_COOKIE_NAME)
														.replace(compact_post_meta(post['id'],post['time']), 
															compact_post_meta(cur_post['id'], cur_post['time'])),
																{ path: '/', domain: '.ucf.edu'});
											}
											break;
										}
									}
								} else {
									$.cookie(ALERT_COOKIE_NAME, 
												$.cookie(ALERT_COOKIE_NAME) + ',' + compact_post_meta(cur_post['id'], cur_post['time']),
													{ path: '/', domain: '.ucf.edu'});
								}
							} else {
								$.cookie(ALERT_COOKIE_NAME, 
											compact_post_meta(cur_post['id'], cur_post['time']),
												{ path: '/', domain: '.ucf.edu'});
							}
						}
						li.hide();
					});
			});
	})();
	
	
})(jQuery);
