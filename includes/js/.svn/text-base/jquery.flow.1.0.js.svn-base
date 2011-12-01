/* Copyright (c) 2008 Kean Loong Tan http://www.gimiti.com/kltan
 * Licensed under the MIT (http://www.opensource.org/licenses/mit-license.php)
 * jFlow
 * Version: 1.0 (May 13, 2008)
 * Requires: jQuery 1.2+
 */
 
(function($) {

	$.fn.jFlow = function(options) {
		var opts = $.extend({}, $.fn.jFlow.defaults, options);
		var cur = 0;
		var maxi = $(".jFlowControl").length;
		$(this).find(".jFlowControl").each(function(i){
			$(this).click(function(){
				$(".jFlowControl").removeClass("jFlowSelected");
				$(this).addClass("jFlowSelected");
				var dur = Math.abs(cur-i+1);
				$(opts.slides).animate({
					marginLeft: "-" + (i * $(opts.slides).find(":first-child").width() + "px")
				}, opts.duration*(dur));
				cur = i;
			});
		});	
		
		$(opts.slides).before('<div id="jFlowSlide"></div>').appendTo("#jFlowSlide");
		
		$(opts.slides).find("div").each(function(){
			$(this).before('<div class="jFlowSlideContainer"></div>').appendTo($(this).prev());
		});
		
		//initialize the controller
		$(".jFlowControl").eq(cur).addClass("jFlowSelected");
		
		var resize = function (x){
			$("#jFlowSlide").css({
				position:"relative",
				width: opts.width,
				height: opts.height,
				overflow: "hidden"
			});
		
			$(opts.slides).css({
				position:"relative",
				width: $("#jFlowSlide").width()*$(".jFlowControl").length+"px",
				height: $("#jFlowSlide").height()+"px",
				overflow: "hidden"
			});
		
			$(opts.slides).children().css({
				position:"relative",
				width: $("#jFlowSlide").width()+"px",
				height: $("#jFlowSlide").height()+"px",
				"float":"left"
			});
			
			$(opts.slides).css({
				marginLeft: "-" + (cur * $(opts.slides).find(":first-child").width() + "px")
			});
		}
		
		resize();
		
		$(window).resize(function(){
			resize();						  
		});
		
		$(".jFlowPrev").click(function(){
			if (cur > 0)
				cur--;
			else
				cur = maxi -1;
			
			$(".jFlowControl").removeClass("jFlowSelected");
			$(opts.slides).animate({
				marginLeft: "-" + (cur * $(opts.slides).find(":first-child").width() + "px")
			}, opts.duration);
			$(".jFlowControl").eq(cur).addClass("jFlowSelected");
		});
		
		$(".jFlowNext").click(function(){
			if (cur < maxi - 1)
				cur++;
			else
				cur = 0;
				
			$(".jFlowControl").removeClass("jFlowSelected");
			$(opts.slides).animate({
				marginLeft: "-" + (cur * $(opts.slides).find(":first-child").width() + "px")
			}, opts.duration);
			$(".jFlowControl").eq(cur).addClass("jFlowSelected");
		});
	};
	
	$.fn.jFlow.defaults = {
		easing: "swing",
		duration: 400,
		width: "100%"
	};
	
})(jQuery);
