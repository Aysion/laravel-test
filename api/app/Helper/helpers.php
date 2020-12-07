<?php

use Illuminate\Support\Facades\Auth;

function authMenu($route) {
	$mapAuthMenu = [
		'panel.home' => [0],
		'panel.configUser' => [99, 1, 2],
		'panel.userType' => [99, 1],
		'panel.user' => [99, 1, 2],
	];

	$level = Auth::user()->userType->level;

	return isset($mapAuthMenu[$route]) ? in_array($level, $mapAuthMenu[$route]) : false;
}