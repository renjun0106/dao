$(function(){
	var ismenushow = 0;
	$('.menubutton').click(function(){
		$(this).trigger('blur');
		if(ismenushow){
			ismenushow = 0;
			if($(window).scrollTop()<34){
				$(this).animate({height : '50px'},100);
			}
			$('#menu').animate({top : '-364px'},100,"swing",function(){
				$(this).toggle();
			});
		}else{
			ismenushow = 1;
			$(this).animate({height : '25px'},100);
			$('#menu').animate({top : 0},100).toggle();
		}
	});

	$(window).scroll(function(){
		if($(window).scrollTop()<34){
			if(!ismenushow){
				$('.menubutton').animate({height : '50px'},100);
			}
		}else{
			$('.menubutton').animate({height : '25px'},100);
		}
	});

	$(window).load(function(){
		if($(window).scrollTop()>34){
			$('.menubutton').css('height','25px');
		}
	});
});