<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Gate;

class Controller extends BaseController
{
	use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

	function __construct() {
		$this->key = '';
		$this->model = null;
	}

	/**
	 * The method is called directly by the router,
	 * never called by another child controller
	 */
	public function paginate(Request $request, $keyModel) {
		$pathModel = '\App\Models\\' . ucfirst($keyModel) . 'Model';

		$this->model = $pathModel::query();
		$this->key = $keyModel;

		Gate::forUser($request['payload'])->authorize("{$keyModel}-viewAny", [ $this->model ]);

		$this->generateGpModelParams($request);

		return $this->model->simplePaginate(30)->withPath("/api/paginate/{$keyModel}");
	}

	/**
	* Display a listing of the resource.
	*
	* @return \Illuminate\Http\Response
	*/
	public function index(Request $request)
	{
		Gate::forUser($request['payload'])->authorize("{$this->key}-viewAny", [ $this->model ]);

		$this->generateGpModelParams($request);

		return $this->model->get();
	}

	protected function generateGpModelParams(Request $request) {
		if ($request->header('gpModelParams')) {
			$gpModelParams = json_decode($request->header('gpModelParams'));

			if ($gpModelParams->withTrashed) {
				$this->model->withTrashed();
			}

		}
	}
}
