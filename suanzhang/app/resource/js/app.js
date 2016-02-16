$(document).ready(function () {
/*    $('body').autoBackgroundScroll({
        speed: 0.3,
        direction1: 'bottom',
        direction2: 'right',
        imageWidth: 2000,
        imageHeight: 2000
    });*/
    var animating = false, submitPhase1 = 1100, submitPhase2 = 400, logoutPhase1 = 800, $login = $('.login'), $app = $('.app'),intiApp = 0;
    function ripple(elem, e) {
        $('.ripple').remove();
        var elTop = elem.offset().top, elLeft = elem.offset().left, x = e.pageX - elLeft, y = e.pageY - elTop;
        var $ripple = $('<div class=\'ripple\'></div>');
        $ripple.css({
            top: y,
            left: x
        });
        elem.append($ripple);
    };
    $(document).on('click', '.login__submit', function (e) {
    	intiApp ++;
        if (animating)
            return;
        animating = true;
        var that = this;
        ripple($(that), e);
        $(that).addClass('processing');
        var username = $('.login__form input[name=username]').val();
        var password = $('.login__form input[name=password]').val();
        $.post('?module=/Home/show/index/getApp',{'username':username,"password":password},function(data){

        	if(data){
	            $(that).addClass('success');
	            setTimeout(function () {
	            	$app.html(data);
                getBook();
	                $app.show();
	                $app.css('top');
	                $app.addClass('active');
	                App.init();
	            }, submitPhase2 - 70);
	            setTimeout(function () {
	                $login.hide();
	                $login.addClass('inactive');
	                animating = false;
	                $(that).removeClass('success processing');
	            }, submitPhase2);
	        }else{
	            animating = false;
	            $(that).removeClass('success processing');
	            if(intiApp>1){
		            $('.login__check').hide(300);
		            $('.login__wrong').show(300);
		        }
	        }
        });
    });
	$('.login__submit').trigger('click');
  $(document).on('click', '.app__logout', function (e) {
      if (animating)
          return;
      $('.ripple').remove();
      animating = true;
      var that = this;
      $(that).addClass('clicked');

      $.post('?module=/Login/action/check/logout',{},function(data){
          $('.login__check').show(300);
          $('.login__wrong').hide(300);
        setTimeout(function () {
            $app.removeClass('active');
            $login.show();
            $login.css('top');
            $login.removeClass('inactive');
        }, logoutPhase1 - 120);
        setTimeout(function () {
            $app.hide();
            animating = false;
            $(that).removeClass('clicked');
        }, logoutPhase1);
      });
  });
  $(document).on('click', '#compose_submit', function (e) {
      var that = this;
      ripple($(that), e);
      var date = $('#compose-date').val();
      var money = $('#compose-title').val();
      var description = $('#compose-detail').val();
      if(date!="" && money!=""){
        if (animating)
            return;
        animating = true;
        $(that).addClass('clicked');
        $.post('?module=/Home/record/index/saveBook',{"date":date,"money":money,"description":description},function(data){
              animating = false;
              setTimeout(function () {
                $(that).removeClass('clicked');
              }, logoutPhase1 - 120);
              setTimeout(function () {
                $('.login__submit').trigger('click');
              }, logoutPhase1);
        });
      }
  });
  var book_type = 1, book_page = 1, book_total = 0;
  $(document).on('click', '#book_all', function (e) {
    book_type = 1;
    book_page = 1;
    $('#book_page').text(1);
    $('#book_all').addClass('active');
    $('#book_me').removeClass('active');
    getBook(this,e);
  });
  $(document).on('click', '#book_me', function (e) {
    book_type = 2;
    book_page = 1;
    $('#book_page').text(1);
    $('#book_me').addClass('active');
    $('#book_all').removeClass('active');
    getBook(this,e);
  });
  $(document).on('click', '#book_prev', function (e) {
    if(book_page>1){
      book_page--;
      $('#book_page').text(book_page);
      getBook(this,e);
    }
  });
  $(document).on('click', '#book_next', function (e) {
    if(book_page<book_total){
      book_page++;
      $('#book_page').text(book_page);
      getBook(this,e);
    }
  });
  function getBook(that,e){
    if(that){
      ripple($(that), e);
    }
    $.post('?module=/Home/show/index/getBook',{'page':book_page,"type":book_type},function(data){
      $('#books').html(data);
    });
    $.post('?module=/Home/record/index/getBookPage',{"type":book_type},function(data){
      if(data){
        book_total = data;
        $('#book_total').html(data);
      }
    });
  }

  $(document).on('click', '#refresh', function (e) {
    animating = false;
    $('.login__submit').trigger('click');
  });
  
  var id,id2;
  $(document).on('click', '#kaisuan', function (e) {
      var that = this;
      ripple($(that), e);
      $('span',that).text('等待其他人点击结算..');
      $.get('?module=/Home/record/index/suanzhangKaishi');
      id=window.setInterval(getjiesuan,1000);

  });
   function getjiesuan(){
      $.get('?module=/Home/show/index/getjiesuan',function(data){
        if(data){
          window.clearTimeout(id);
          $('#kaisuan_content').html(data);
          $('#kaisuan').remove();
        }
      });
   }
  $(document).on('click', '#jiesuan_submit', function (e) {
      var that = this;
      ripple($(that), e);
      $(that).after('<span id="show_span">等待其他人点击确定..</span>');
      $('.nav').remove();
      $('#jiesuan_submit').addClass('clicked');
      $.get('?module=/Home/record/index/jiesuanKaishi');
      id2=window.setInterval(jiesuanKaishi,1000);
  });
   function jiesuanKaishi(){
      $.get('?module=/Home/record/index/jiesuanOver',function(data){
        if(data){
          window.clearTimeout(id2);
          $('.login__submit').trigger('click');
          $('#jiesuan_submit').removeClass('clicked');
        }
      });
   }
});

var App = {
  init: function() {
    this.datetime(), this.side.nav(), this.navigation(), this.hyperlinks(), setInterval("App.datetime();", 1e3)
  },
  datetime: function() {
    var e = new Array("Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"),
      t = new Array("January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"),
      a = new Date,
      i = a.getYear();
    1e3 > i && (i += 1900);
    var n = a.getDay(),
      s = a.getMonth(),
      l = a.getDate();
    10 > l && (l = "0" + l);
    var r = a.getHours(),
      o = a.getMinutes(),
      c = a.getSeconds(),
      v = "AM";
    r >= 12 && (v = "PM"), r > 12 && (r -= 12), 0 == r && (r = 12), 9 >= o && (o = "0" + o), 9 >= c && (c = "0" + c), $(".welcome .datetime .day").text(e[n]), $(".welcome .datetime .date").text(t[s] + " " + l + ", " + i), $(".welcome .datetime .time").text(r + ":" + o + ":" + c + " " + v)
  },
  title: function(e) {
    return $(".header>.title").text(e)
  },
  side: {
    nav: function() {
      this.toggle(), this.navigation()
    },
    toggle: function() {
      $(".ion-ios-navicon").on("touchstart click", function(e) {
        e.preventDefault(), $(".sidebar").toggleClass("active"), $(".nav").removeClass("active"), $(".sidebar .sidebar-overlay").removeClass("fadeOut animated").addClass("fadeIn animated")
      }), $(".sidebar .sidebar-overlay").on("touchstart click", function(e) {
        e.preventDefault(), $(".ion-ios-navicon").click(), $(this).removeClass("fadeIn").addClass("fadeOut")
      })
    },
    navigation: function() {
      $(".nav-left a").on("touchstart click", function(e) {
        e.preventDefault();
        var t = $(this).attr("href").replace("#", "");
        $(".sidebar").toggleClass("active"), $(".html").removeClass("visible"), "home" == t || "" == t || null == t ? $(".html.welcome").addClass("visible") : $(".html." + t).addClass("visible"), App.title($(this).text())
      })
    }
  },
  navigation: function() {
    $(".nav .mask").on("touchstart click", function(e) {
      e.preventDefault(), $(this).parent().toggleClass("active")
    })
  },
  hyperlinks: function() {
    $(".nav .nav-item").on("click", function(e) {
      e.preventDefault();
      var t = $(this).attr("href").replace("#", "");
      $(".html").removeClass("visible"), $(".html." + t).addClass("visible"), $(".nav").toggleClass("active"), App.title($(this).text())
    })
  }
};