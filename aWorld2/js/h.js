"use strict";
define(function (){

	var drawFillStyle = function(background,RESOURCE_IMAGE){
		var image = background.image;
		var color = background.color;

		if(image){
			var backcanvas = document.createElement("canvas");
			var backctx = createCanvas(backcanvas,image.swidth,image.sheight)

			setBackgroundcolor(backctx,color,image.swidth,image.sheight);

			backctx.globalCompositeOperation = image.globalCompositeOperation;
			backctx.globalAlpha = image.globalAlpha;

			clipImage(backctx,RESOURCE_IMAGE,image.sx,image.sy,image.swidth,image.sheight);
			
            return backctx.createPattern(backcanvas,image.type);
		}else{
			return color;
		}
	};

	var createCanvas = function(canvas,width,height){
		var ctx = canvas.getContext("2d");
		canvas.width = width;
		canvas.height = height;
        return ctx;
	};
	var setBackgroundcolor = function(ctx,color,width,height){
		ctx.rect(0,0,width,height);
		ctx.fillStyle = color;
		ctx.fill();
	};
	var clipImage = function(ctx,img,sx,sy,swidth,sheight){
		ctx.drawImage(img,sx,sy,swidth,sheight,0,0,swidth,sheight);
	};

 	var drawPolygon = function(ctx,piece){
 		
		ctx.beginPath();
		for(var i=0;i<piece.points.length;i++){
	 		ctx.lineTo(piece.points[i].x,piece.points[i].y);
		}
		if(piece.shadow){
			ctx.shadowColor = piece.shadow.Color;
			ctx.shadowBlur = piece.shadow.Blur;
			ctx.shadowOffsetX = piece.shadow.OffsetX;
			ctx.shadowOffsetY = piece.shadow.OffsetY;

		}

		ctx.closePath();
 		ctx.fillStyle = piece.fillStyle;
		ctx.fill();
	};

	var intiIsphone = function() {
	    var userAgentInfo = navigator.userAgent;
	    var Agents = ["Android", "iPhone","SymbianOS", "Windows Phone","iPad", "iPod"];
	    var flag = false;
	    for (var v = 0; v < Agents.length; v++) {
	        if (userAgentInfo.indexOf(Agents[v]) > 0) {
	            flag = true;
	            break;
	        }
	    }
	    return flag;
	};

	////多边形与线段是否有交集
	var pnpoly_line = function(polygon, pointstar, pointend){

		
		for (var i=0; i < polygon.length-1; i++) {
	        if(line_line(pointstar,pointend,polygon[i],polygon[i+1])){
	        	
	            return true;
	        }
	    }
	    
		return false;
	};

	////线段与线段是否有交集
	var line_line = function(s1,e1,s2,e2){
		return( (Math.max(s1['x'],e1['x'])>=Math.min(s2['x'],e2['x']))&&
		(Math.max(s2['x'],e2['x'])>=Math.min(s1['x'],e1['x']))&& 
		(Math.max(s1['y'],e1['y'])>=Math.min(s2['y'],e2['y']))&& 
		(Math.max(s2['y'],e2['y'])>=Math.min(s1['y'],e1['y']))&& 
		(multiply(s2,e1,s1)*multiply(e1,e2,s1)>=0)&&
		(multiply(s1,e2,s2)*multiply(e2,e1,s2)>=0)); 
	};

	//得到(sp-op)*(ep-op)的叉积
	var multiply = function(sp, ep, op) { 
		return ((sp['x']-op['x'])*(ep['y']-op['y'])-(ep['x']-op['x'])*(sp['y']-op['y']));
	};

	var setArrayvalue = function(arr,key,value){
		var a;
		for(a in arr){
			arr[a][key] = value;
		}
	}

	var transformPoint = function(m){
		var points = new Array();
		var pointarr = m.split(',');
		var n = 0;
		for(var p in pointarr){
			var xy = pointarr[p].split('_');
			points[n] = {x:xy[0],y:xy[1]};
			n++;
		}
		return points;
	}

	var splitKey = function(arr,sep){
		var str = sep;
		for(var a in arr){
			str += a + sep;
		}
		return str;
	}

	var ajax = function(url,params,func){
		var xmlhttp = new XMLHttpRequest();
		xmlhttp.onreadystatechange=function(){
		  	if(xmlhttp.readyState==4 && xmlhttp.status==200){
		    	func(xmlhttp.responseText);
		    }
		}
		xmlhttp.open('POST',url,true);
		xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
		var str = "";
		for(var p in params){
			str += p+"="+params[p]+"&";
		}
		xmlhttp.send(str);
	}


　　return {
　　    createCanvas: createCanvas,
		setBackgroundcolor: setBackgroundcolor,
		clipImage: clipImage,
		drawPolygon: drawPolygon,
		intiIsphone: intiIsphone,
		pnpoly_line: pnpoly_line,
		drawFillStyle: drawFillStyle,
		setArrayvalue: setArrayvalue,
		transformPoint: transformPoint,
		splitKey: splitKey,
		ajax:ajax
　　};
});