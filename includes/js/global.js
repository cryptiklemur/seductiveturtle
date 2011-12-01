$j(document).ready(function() {
	$j.post(
			"/index/tracking",
			{useragent:navigator.userAgent, url: window.location.href, referer: referrer }
		)
});