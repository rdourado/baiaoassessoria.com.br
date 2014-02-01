/*
@codekit-prepend "jquery.fancybox.pack.js"
@codekit-prepend "jquery.tinycarousel.min.js"
*/
$(document).ready(function(){
	try{
		$('#slider').tinycarousel({ pager: true, interval: true, intervalTime: 10000 });
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
	try{
		if ($('.PDS_Poll','.e-content').length) {
			$('.PDS_Poll','.widget').parent().parent().remove();
		}
	}catch(e){}
});