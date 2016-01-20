"use strict";
define(function (){
	var ctx;
	var WINDOW_WIDTH = window.innerWidth ;
	var WINDOW_HEIGHT = window.innerHeight;
	var conf = {
	};

	var map = [];
	var block = [];
	var me = {};
	var isPhone = -1;

　　return {
		ctx:ctx,
		WINDOW_WIDTH:WINDOW_WIDTH,
		WINDOW_HEIGHT:WINDOW_HEIGHT,
		conf:conf,
		map:map,
		me:me,
		isPhone:isPhone,
		block:block
　　};
});