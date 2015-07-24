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


    $(function () {
    var animationLibrary = 'animate';
    $.easing.easeOutQuart = function (x, t, b, c, d) {
        return -c * ((t = t / d - 1) * t * t * t - 1) + b;
    };
    $('[ripple]:not([disabled],.disabled)').on('mousedown', function (e) {
        var button = $(this);
        var touch = $('<touch><touch/>');
        var size = button.outerWidth() * 1.8;
        var complete = false;
        $(document).on('mouseup', function () {
            var a = { 'opacity': '0' };
            if (complete === true) {
                size = size * 1.33;
                $.extend(a, {
                    'height': size + 'px',
                    'width': size + 'px',
                    'margin-top': -size / 2 + 'px',
                    'margin-left': -size / 2 + 'px'
                });
            }
            touch[animationLibrary](a, {
                duration: 500,
                complete: function () {
                    touch.remove();
                },
                easing: 'swing'
            });
        });
        touch.addClass('touch').css({
            'position': 'absolute',
            'top': e.pageY - button.offset().top + 'px',
            'left': e.pageX - button.offset().left + 'px',
            'width': '0',
            'height': '0'
        });
        button.get(0).appendChild(touch.get(0));
        touch[animationLibrary]({
            'height': size + 'px',
            'width': size + 'px',
            'margin-top': -size / 2 + 'px',
            'margin-left': -size / 2 + 'px'
        }, {
            queue: false,
            duration: 500,
            'easing': 'easeOutQuart',
            'complete': function () {
                complete = true;
            }
        });
    });
});
});