<?php

namespace App\Http\Controllers;

use App\Models\ConfigMenuModel;
use App\Models\ConfigPageModel;
use Illuminate\Http\Request;

class ConfigMenuController extends Controller
{

	function __construct() {
		$this->key = 'configMenu';
		$this->label = 'Config. Menu';
		$this->model = ConfigMenuModel::class;
	}

	public function index(Request $request) {
		$model = $this->model::query();

		$model->where('user_id', $request['payload']->user->id);
		$model->orWhere('user_type_id', $request['payload']->user->userType);

		$query = $model->get();

		$configPage = [];

		foreach ($query as $item) {
			if (!isset($configPage[$item->config_page_id])) {
				$configPage[$item->config_page_id] = ConfigPageModel::select([
					'id',
					'name',
					'title',
					'subtitle',
					'icon',
					'description',
				])->find($item->config_page_id);
			}
		}

		return $configPage;
	}
}
