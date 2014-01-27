$(document).ready(function(){

	try{
		$('#slides').tinycarousel({
			pager: true,
			interval: true,
			intervaltime: 8000
		});
	}catch(e){}

	try{
		$('.fancybox,.gallery-icon a').fancybox({
			padding: 5,
			helpers: {
				title: {
					type: 'over'
				}
			}
		});
	}catch(e){}

});