<?php

$objects = array(
	array(
		'name'=>'CreateMeCanvas','type'=>'me','arguments'=>'250,260,30'
		),
	array(
		'name'=>'CreateStaticCanvas','type'=>'bulings','arguments'=>'50,60,30'
		),
	array(
		'name'=>'CreateStaticCanvas','type'=>'object','arguments'=>'150,160,40'
		),
	);

echo json_encode($objects);