"use strict";
define(["g","c","h"],function (g,c,h){


	var getMap = function(){
		var params = {
			z:g.me.z,x:g.me.x,y:g.me.y,w:g.WINDOW_WIDTH,h:g.WINDOW_HEIGHT,
			mapkeystr:h.splitKey(g.map,'|'),
			blockkeystr:h.splitKey(g.block,'|')
		};
		h.ajax("actions/getMap.php",params,function(data){
			var json = window.JSON.parse( data + "" );
			if(json){
				h.setArrayvalue(g.map,'isdraw',false);
				h.setArrayvalue(g.block,'isdraw',false);
				
				setMap(json.map);
				setBlock(json.block);
			}
			g.getMapnow = false;
		});

		g.me.oldx = g.me.x;
		g.me.oldy = g.me.y;
	}

	var setMap = function(map){
		for(var m in map ){
			if(map[m].background){
				g.map[m] = {
					points:h.transformPoint(m),
					fillStyle: h.drawFillStyle(map[m].background,c.RESOURCE_IMAGE)
				}

			}
			g.map[m].isdraw = map[m].isdraw;
		}
	};

	var setBlock = function(block){
		for(var b in block ){
			if(block[b].background){
				g.block[b] = {
					points:h.transformPoint(b),
					fillStyle:h.drawFillStyle(block[b].background,c.RESOURCE_IMAGE),
					shadow:block[b].background.shadow
				};
			}else{
				g.block[b] = {};
			}
			g.block[b].lines = block[b].lines || null;
			g.block[b].objects = block[b].objects || null;

			g.block[b].isdraw = block[b].isdraw;
		}
	};


　　return {
		getMap:getMap
　　};
});