<?php

use Illuminate\Support\Facades\Auth;

function authMenu($route) {
	$mapAuthMenu = [
		'panel.home' => [0],
		'panel.configUser' => [99, 1, 2],
		'panel.userType' => [99, 1],
		'panel.user' => [99, 1, 2],
	];

	$permission = Auth::user()->userType->permission;

	return isset($mapAuthMenu[$route]) ? in_array($permission, $mapAuthMenu[$route]) : false;
}