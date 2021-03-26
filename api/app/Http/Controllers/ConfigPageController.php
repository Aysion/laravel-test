<?php

namespace App\Http\Controllers;

use App\Models\ConfigPageModel;

class ConfigPageController extends Controller
{

	function __construct() {
		$this->key = 'configPage';
		$this->label = 'Config. Page';
		$this->model = ConfigPageModel::class;
	}

}
