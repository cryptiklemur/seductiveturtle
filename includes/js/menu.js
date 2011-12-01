$j(document).ready(function(){
// executed after the page has finished loading

	$j('#navigationMenu li .normalMenu').each(function(){	// for each menu item

		// create a duplicate hyperlink and position it above the current one
		$j(this).before($j(this).clone().removeClass().addClass('hoverMenu'));

	});

	$j('#navigationMenu li').hover(function(){	// using the hover method..

		// we assign an action on mouse over
		$j(this).find('.hoverMenu').stop().animate({marginTop:'0px'},200);
		// the animate method provides countless possibilities

	},

	function(){
		// and an action on mouse out
		$j(this).find('.hoverMenu').stop().animate({marginTop:'-25px'},200);

	});

});