<?php

namespace App\Http\Controllers;

use App\Models\ConfigListModel;

class ConfigListController extends Controller
{

	function __construct() {
		$this->key = 'configList';
		$this->label = 'Config. List';
		$this->model = ConfigListModel::class;
	}

}
