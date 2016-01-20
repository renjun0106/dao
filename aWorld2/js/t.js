"use strict";
define(['g','c','h'],function (g,c,h){


	var registerEvent = function(){
		if(g.isPhone){
			phoneEvent();
		}else{
			pcEvent();
		}
	};

	var pcEvent = function(){
		document.oncontextmenu = function stop(){ 
			return false; 
		};

		g.canvas.onmousedown = function(e){
			g.me.move = false;
			var oldclient = {x:e.clientX,y:e.clientY};
			g.canvas.onmousemove = function(e) {
				var dir = g.me.direction;
				var isX = e.clientX - oldclient.x;
				var isY = e.clientY - oldclient.y;

				if(isX > c.movelimit || isY > c.movelimit || isX < -c.movelimit || isY < -c.movelimit){
					var isXY = Math.abs(isX) > Math.abs(isY);
				  	if(isXY){
				  		if(isX>0){
				  			dir = c.RIGHT;
				  		}else{
				  			dir = c.LEFT;
				  		}
				  	}else{
				  		if(isY>0){
				  			dir = c.DOWN;
				  		}else{
				  			dir = c.UP;
				  		}
				  	}
					oldclient.x = e.clientX;
					oldclient.y = e.clientY;
					g.me.move = true;
				}
				g.me.direction = dir;

			};
		};
		g.canvas.onmouseup = function(){
			g.canvas.onmousemove = null;
		};

	};

	var phoneEvent = function(){
		
		g.canvas.ontouchstart = function(e){
			g.me.move = false;
			var touch = e.touches[0];
			var oldclient = {x:touch.clientX,y:touch.clientY};

			g.canvas.ontouchmove = function(e) {
				var dir = g.me.direction;
				var touch = e.touches[0];
				var isX = touch.clientX - oldclient.x;
				var isY = touch.clientY - oldclient.y;

				if(isX > c.movelimit || isY > c.movelimit || isX < -c.movelimit || isY < -c.movelimit){
					var isXY = Math.abs(isX) > Math.abs(isY);
				  	if(isXY){
				  		if(isX>0){
				  			dir = c.RIGHT;
				  		}else{
				  			dir = c.LEFT;
				  		}
				  	}else{
				  		if(isY>0){
				  			dir = c.DOWN;
				  		}else{
				  			dir = c.UP;
				  		}
				  	}
					oldclient.x = touch.clientX;
					oldclient.y = touch.clientY;
					g.me.move = true;
				}
				g.me.direction = dir;

			};
		};
		g.canvas.ontouchend = function(){
			g.canvas.ontouchmove = null;
		};

	};



　　return {
　　    registerEvent: registerEvent
　　};
});