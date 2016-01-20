"use strict";
define(['g','c'],function (g,c){


	var getme = function(){
		g.me.size = 32;
		g.me.offsetX = 0;
		g.me.direction = c.DOWN;
		g.me.move = false;
		g.me.v = 5;
		g.me.angle = 0;
		g.me.z = "1/yu/ren/nan";
		g.me.x = 3000;
		g.me.y = 3000;
		g.me.oldx = 4000;
		g.me.oldy = 3600;
		g.me.margin = 0.8;
	}

　　return {
		getme:getme
　　};
});