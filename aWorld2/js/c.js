"use strict";
define(function (){

	var RESOURCE_IMAGE = new Image();

	var POS = new Array();
	POS["selectTank"] = [128,96];
	POS["stageLevel"] = [396,96];
	POS["num"] = [256,96];
	POS["map"] = [0,96];
	POS["home"] = [256,0];
	POS["score"] = [0,112];
	POS["player"] = [0,0];
	POS["protected"] = [160,96];
	POS["enemyBefore"] = [256,32];
	POS["enemy1"] = [0,32];
	POS["enemy2"] = [128,32];
	POS["enemy3"] = [0,64];
	POS["bullet"] = [80,96];
	POS["tankBomb"] = [0,160];
	POS["bulletBomb"] = [320,0];
	POS["over"] = [384,64];
	POS["prop"] = [256,110];

　　return {
		RESOURCE_IMAGE: RESOURCE_IMAGE,
		POS: POS,
		UP: 0,
		DOWN: 1,
		LEFT: 2,
		RIGHT: 3,
		movelimit:10,
		canvasid:'aWorld',
		freshTime:1000
　　};
});