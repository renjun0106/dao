"use strict";
define(['g','c','h','m'],function (g,c,h,m){

	var run = function(){
		g.ctx.clearRect(0,0,g.WINDOW_WIDTH,g.WINDOW_HEIGHT);
		meMove();
		drawmap();
		drawBlock();
		drawme();
		freshMap();

		window.requestAnimationFrame(run);
	};



	var meMove = function(){

		var movex = 0,movey = 0,b,l;
		if(g.me.move){
			switch(g.me.direction){
				case c.LEFT:
					movex = -g.me.v;
					break;
				case c.RIGHT:
					movex = g.me.v;
					break;
				case c.UP:
					movey = -g.me.v;
					break;
				case c.DOWN:
					movey = g.me.v;
					break;
			}

			
			if(g.me.move){
				for(b in g.block ){
					var lines = g.block[b].lines;
					if(lines){
						for(l in lines){
							g.me.ponits = [
								{x:g.me.x+g.me.size/2+movex*g.me.margin,y:g.me.y+g.me.size/2+movey*g.me.margin},
								{x:g.me.x-g.me.size/2+movex*g.me.margin,y:g.me.y+g.me.size/2+movey*g.me.margin},
								{x:g.me.x-g.me.size/2+movex*g.me.margin,y:g.me.y-g.me.size/2+movey*g.me.margin},
								{x:g.me.x+g.me.size/2+movex*g.me.margin,y:g.me.y-g.me.size/2+movey*g.me.margin},
								{x:g.me.x+g.me.size/2+movex*g.me.margin,y:g.me.y-g.me.size/2+movey*g.me.margin}
							];
							if(h.pnpoly_line(g.me.ponits,{x:lines[l].sx,y:lines[l].sy},{x:lines[l].ex,y:lines[l].ey})){
								g.me.move = false;
								movex = 0;
								movey = 0;
							}
						}
					}
				}
			}
		}else{
			movex = 0;
			movey = 0;
		}
		//console.log(movex+','+movey)
		g.me.x += movex;
		g.me.y += movey;
	};

	var drawmap = function(){
		var m;

 		g.ctx.save();
		g.ctx.translate(-(g.me.x-g.WINDOW_WIDTH/2),-(g.me.y-g.WINDOW_HEIGHT/2));
		for(m in g.map){
			if(g.map[m].isdraw){
				h.drawPolygon(g.ctx,g.map[m]);
			}
		}
		g.ctx.restore();
	};

	var drawBlock = function(){
		var b;
 		g.ctx.save();
		g.ctx.translate(-(g.me.x-g.WINDOW_WIDTH/2),-(g.me.y-g.WINDOW_HEIGHT/2));
		for(b in g.block){
			if(g.block[b].isdraw){
				var points = g.block[b].points;
				var objects = g.block[b].objects;
				if(points){
					h.drawPolygon(g.ctx,g.block[b]);
				}
				if(objects){
					var o;
					for(o in objects){
						var object = objects[o];
						g.ctx.drawImage(c.RESOURCE_IMAGE,object.image.sx,object.image.sy,
							object.image.swidth,object.image.sheight,object.point.x,object.point.y,
							object.image.swidth*object.image.size,object.image.sheight*object.image.size);
					}
				}
			}
		}
		g.ctx.restore();
	};

	var drawme = function(){
		g.ctx.drawImage(c.RESOURCE_IMAGE,c.POS["player"][0]+g.me.offsetX+g.me.direction*g.me.size,c.POS["player"][1],g.me.size,g.me.size,g.WINDOW_WIDTH/2-g.me.size/2,g.WINDOW_HEIGHT/2-g.me.size/2,g.me.size,g.me.size);
	};

	var freshMap = function(){
		if(!g.getMapnow){
			if(Math.abs(g.me.x-g.me.oldx)>=g.WINDOW_WIDTH || Math.abs(g.me.y-g.me.oldy)>=g.WINDOW_HEIGHT){
				g.getMapnow = true;
				m.getMap();
			}
		}
	};


　　return {
　　    run: run
　　};
});