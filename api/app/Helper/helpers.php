<?php
// Comando para registrar novos Helpers depois de adicionados no composer.json
// composer dump-autoload

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

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

function hasInvalidRulesModel($modelClass, $data) {
	$validator = Validator::make($data, $modelClass::$rules);

	if ($validator->fails()) {
		return response()->json([ 'errors' => $validator->errors()->all() ], 422);
	}

	return null;
}