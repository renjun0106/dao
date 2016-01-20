"use strict";
define(["g","c","m","r","t","h","s"],function (g,c,m,r,t,h,s){



	var go = function(){
		g.isPhone = h.intiIsphone();

		h.ajax("actions/getResource.php",null,function(data){
			intiResourse(data);
			initScreen();
			initObject();
			initEvent();

	
			document.getElementById("loadpage").style.display="none";
			window.requestAnimationFrame(s.run);
		});
	};

	var intiResourse = function(data){
		c.RESOURCE_IMAGE.src = data;
	};

	var initScreen = function(){
		var canvas = document.getElementById(c.canvasid);
		canvas.width = g.WINDOW_WIDTH;
		canvas.height = g.WINDOW_HEIGHT;

		g.canvas = canvas;
		g.ctx = canvas.getContext("2d");

	};

	var initObject = function(){
		r.getme();
		m.getMap();
	};

	var initEvent = function(){
		t.registerEvent();
	};

　　return {
　　    go: go
　　};
});