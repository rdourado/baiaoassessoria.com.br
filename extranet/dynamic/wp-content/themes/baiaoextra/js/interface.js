/*
@codekit-prepend "jquery.fancybox.pack.js"
@codekit-prepend "jquery.tinycarousel.min.js"
*/
$(document).ready(function(){
	try{
		$('#slider').tinycarousel({ pager : true });
	}catch(e){}
	try{
		$('.fancybox').fancybox({
			padding: 5,
			helpers: {
				title: {
					type: 'over'
				}
			}
		});
	}catch(e){}
});