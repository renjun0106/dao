"use strict";

window.onload = function() {
    new Enjine.Application().Initialize();
}
;

var Enjine = {};
Enjine.Application = function() {
    this.stateContext = this.raf = this.canvas = null 
}
;
Enjine.Application.prototype = {
    Initialize: function() {
        this.canvas = new Enjine.GameCanvas();
        this.canvas.Initialize("aWorld");
        Enjine.MousePress.Initialize(this);
        
        var that = this;
        Enjine.Helper.Ajax("GetInitObject.php", function(data) {
            that.stateContext = new Enjine.GameStateContext();
            that.stateContext.Initialize(data);
            that.Begin();
        }
        );
    },
    Update: function() {
        this.stateContext.Update(this.canvas.Canvas);
        this.canvas.ClearContext2D();
        this.stateContext.Draw(this.canvas.Context2D);
        this.Begin();
    },
    Begin: function() {
        var that = this;
        this.raf = window.requestAnimationFrame(function() {
            that.Update();
        });
    },
    Pause: function() {
        window.cancelAnimationFrame(this.raf);
    }
};

Enjine.GameCanvas = function(Canvasid) {
    this.Context2D = this.Canvas = this.Canvasid = null ;
}
;
Enjine.GameCanvas.prototype = {
    Initialize: function(Canvasid) {
        this.Canvas = document.getElementById(Canvasid);
        this.Canvas.width = window.innerWidth;
        this.Canvas.height = window.innerHeight;
        this.Context2D = this.Canvas.getContext("2d")
    },
    ClearContext2D: function() {
        this.Context2D.clearRect(0, 0, this.Canvas.width, this.Canvas.height)
    }
};

Enjine.Helper = {
    Ajax: function(url, func) {
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                func(window.JSON.parse(xmlhttp.responseText));
            }
        }
        xmlhttp.open("GET", url, true);
        xmlhttp.send();
    }
};

Enjine.MousePress = {
    PressRight: {},
    Initialize: function(application) {
        var that = this
		document.oncontextmenu = function stop(){ 
			return false; 
		};

		application.canvas.Canvas.onmousedown = function(e){
        	if(e.button == "2"){
				that.PressRight.x = e.clientX-application.stateContext.camera.X;
				that.PressRight.y = e.clientY-application.stateContext.camera.Y;;
				that.PressRight.isPress = !0;
        	}else{
				var oldclient = {x:e.clientX,y:e.clientY};
				application.canvas.Canvas.onmousemove = function(e) {
					var isX = e.clientX - oldclient.x;
					var isY = e.clientY - oldclient.y;

					if(isX > 10 || isY > 10 || isX < -10 || isY < -10){
						oldclient.x = e.clientX;
						oldclient.y = e.clientY;
						application.stateContext.camera.change(isX,isY);
					}

				};
			}
		};
		application.canvas.Canvas.onmouseup = function(){
			application.canvas.Canvas.onmousemove = null;
		};
    },
};

Enjine.Camera = function() {
    this.Y = this.X = 100;
};
Enjine.Camera.prototype = {
	change : function(x,y){
		this.X -= x;
		this.Y -= y;
	}
}

Enjine.GameStateContext = function() {
    this.drawManager = this.camera = null ;
};
Enjine.GameStateContext.prototype = {
    Initialize: function(data) {
        this.drawManager = new Enjine.DrawableManager();
    	this.camera = new Enjine.Camera();
        var Ojects = Enjine.GameOjects.CreateGameOjects(data);
        this.drawManager.AddRange(Ojects);
    },
    Update: function(Canvas) {
        this.drawManager.Update(Canvas,this.camera)
    },
    Draw: function(Context2D) {
        this.drawManager.Draw(Context2D,this.camera)
    }
};

Enjine.DrawableManager = function() {
    this.Objects = []
};
Enjine.DrawableManager.prototype = {
    Add: function(Object) {
        this.Objects.push(Object);
    },
    AddRange: function(Objects) {
        this.Objects = this.Objects.concat(Objects);
    },
    Clear: function() {
        this.Objects.splice(0, this.Objects.length)
    },
    Contains: function(Object) {
        for (var ObjectsIndex = this.Objects.length; ObjectsIndex--; )
            if (this.Objects[ObjectsIndex] === Object)
                return !0;
        return !1
    },
    Remove: function(aObject) {
        this.Objects.splice(this.Objects.indexOf(aObject), 1)
    },
    RemoveAt: function(ObjectsIndex) {
        this.Objects.splice(ObjectsIndex, 1)
    },
    RemoveRange: function(ObjectStartIndex, ObjectEndIndex) {
        this.Objects.splice(ObjectStartIndex, ObjectEndIndex)
    },
    RemoveList: function(ObjectList) {
        for (var ObjectsIndex = 0, ObjectListIndex = 0, ObjectListIndex = 0; ObjectListIndex < ObjectList.length; )
            for (ObjectsIndex = 0; ObjectsIndex < this.Objects.length; ObjectsIndex++)
                if (this.Objects[ObjectsIndex] === ObjectList[ObjectListIndex]) {
                    this.Objects.splice(ObjectsIndex, 1);
                    ObjectList.splice(ObjectListIndex, 1);
                    ObjectListIndex--;
                    break
                }
    },
    SortObjects:function(){
        this.Objects.sort(function(object1, object2) {
            return object1.ZOrder - object2.ZOrder
        });
    },
    Update: function(Canvas,camera) {
        for (var ObjectsIndex = 0, ObjectsIndex = 0; ObjectsIndex < this.Objects.length; ObjectsIndex++)
            this.Objects[ObjectsIndex].Update && this.Objects[ObjectsIndex].Update(Canvas,camera)
    },
    Draw: function(Context2D, camera) {
		Context2D.save();
		Context2D.translate(camera.X,camera.Y);
        for (var ObjectsIndex = 0, ObjectsIndex = 0; ObjectsIndex < this.Objects.length; ObjectsIndex++)
            this.Objects[ObjectsIndex].Draw && this.Objects[ObjectsIndex].Draw(Context2D);
		Context2D.restore();
    }
};

Enjine.GameOjects = {
    
    CreateGameOjects: function(data) {
        var Ojects = new Array();
        for (var i in data) {
        	var object;
        	eval("object = new Enjine."+data[i]["name"]+"("+data[i]["arguments"]+");");
            Ojects[i] = object;
        }
        return Ojects;
    }
};

Enjine.CreateCanvas = function(){
	this.x = this.y = null;
}

Enjine.CreateCanvas.prototype = {
	Update:function(){

	},
	Draw :function(){

	}
}

Enjine.CreateStaticCanvas = function(x,y,r){
	this.x = x;
	this.y = y;
	this.r = r;
	this.ZOrder = 10;
};
Enjine.CreateStaticCanvas.prototype = new Enjine.CreateCanvas();
Enjine.CreateStaticCanvas.prototype.Draw = function(Context2D){
	Enjine.HelperCanvas.Context2D = Context2D;
    Enjine.HelperCanvas.DrawCircle(this.x,this.y,this.r);
}

Enjine.CreateMeCanvas = function(x,y,r){
	this.x = x;
	this.y = y;
	this.r = r;
	this.ZOrder = 10;
};
Enjine.CreateMeCanvas.prototype = new Enjine.CreateCanvas();
Enjine.CreateMeCanvas.prototype.Draw = function(Context2D){
	Enjine.HelperCanvas.Context2D = Context2D;
    Enjine.HelperCanvas.DrawCircle(this.x,this.y,this.r);
}
Enjine.CreateMeCanvas.prototype.Update = function(canvas,camera){
	if(Enjine.MousePress.PressRight.isPress){
		var drt = Math.sqrt(Math.pow(Enjine.MousePress.PressRight.x-this.x,2)+Math.pow(Enjine.MousePress.PressRight.y-this.y,2));
		if(drt>1){
			this.x += (Enjine.MousePress.PressRight.x-this.x)/drt;
			this.y += (Enjine.MousePress.PressRight.y-this.y)/drt;
		}
	}
}


Enjine.HelperCanvas =  {
    Initialize: function(width, height) {
        this.Canvas = document.createElement("canvas");
        this.Canvas.width = window.innerWidth;
        this.Canvas.height = window.innerHeight;
        this.Context2D = this.Canvas.getContext("2d");
    },
    SaveCanvas: function() {
        this.Context2D.save();
        return this;
    },
    RestoreCanvas: function() {
        this.Context2D.restore();
        return this;
    },
    SetFillStyle: function(fillStyle) {
        this.Context2D.fillStyle = fillStyle;
        return this;
    },
    SetShadow: function(Color, Blur, OffsetX, OffsetY) {
        this.Context2D.shadowColor = Color;
        this.Context2D.shadowBlur = Blur;
        this.Context2D.shadowOffsetX = OffsetX;
        this.Context2D.shadowOffsetY = OffsetY;
    },
    DrawPolygon: function(Polygon) {
        this.Context2D.beginPath();
        for (var i = 0; i < Polygon.points.length; i++) {
            this.Context2D.lineTo(Polygon.points[i].x, Polygon.points[i].y);
        }
        this.Context2D.closePath();
        this.Context2D.fill();
        
        return this;
    },
    DrawCircle: function(x,y,r) {
        this.Context2D.beginPath();
        this.Context2D.arc(x, y,r, 0,2*Math.PI);
        this.Context2D.stroke();
        return this;
    },
    ClearCanvasImage: function() {
        delete this.Context2D;
        delete this.Canvas;
    }

}
