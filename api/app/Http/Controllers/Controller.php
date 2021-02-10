<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Gate;

class Controller extends BaseController {
	use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

	// function __construct() {
	// 	$this->key = '';
	// 	$this->model = null;
	// }

	/**
	 * The method is called directly by the router,
	 * never called by another child controller
	 */
	public function paginate(Request $request, $keyModel) {
		$pathModel = '\App\Models\\' . ucfirst($keyModel) . 'Model';

		// return (new $pathModel())->where('level', '!=', '101')->get();

		$this->model = new $pathModel;
		$this->key = $keyModel;

		// Gate::forUser($request['payload'])->authorize("{$keyModel}-viewAny", [ $this->model ]);

		// $this->generateGpModelParams($request);

		$this->model->where('level', '!=', '101');
		return $this->model->get();

		return $this->model->simplePaginate(30)->withPath("/api/paginate/{$keyModel}");
	}


	protected function generateGpModelParams(Request $request) {
		if ($request->header('gpModelParams')) {
			$gpModelParams = json_decode($request->header('gpModelParams'));

			if ($gpModelParams->withTrashed) {
				$this->model->withTrashed();
			}

		}
	}

	/**
	* Display a listing of the resource.
	*
	* @return \Illuminate\Http\Response
	*/
	public function index(Request $request) {
		print_r($this->model::query()->get());die;

		Gate::forUser($request['payload'])->authorize("{$this->key}-viewAny", [ $this->model ]);

		$this->generateGpModelParams($request);

		return $this->model->get();
	}

	/**
	* Store a newly created resource in storage.
	*
	* @param  \Illuminate\Http\Request  $request
	* @return \Illuminate\Http\Response
	*/
	public function store(Request $request) {
		Gate::forUser($request['payload'])->authorize("{$this->key}-create");

		$data = $request->all();

		if ($hasInvalidRules = hasInvalidRulesModel($this->model::$rules, $data)) {
			return $hasInvalidRules;
		}

		$model = new $this->model;

		$model->fill($data)->save();

		return $model;
	}

	/**
	* Display the specified resource.
	*
	* @param  int  $id
	* @return \Illuminate\Http\Response
	*/
	public function show(Request $request, $id) {
		if ($model = $this->model::find($id)) {
			Gate::forUser($request['payload'])->authorize("{$this->key}-view", $model);

			return $model;
		}

		return response()->json([ 'errors' => ["{$this->label} não existente ou desativado"] ], 410);
	}

		/**
	* Update the specified resource in storage.
	*
	* @param  \Illuminate\Http\Request  $request
	* @param  int  $id
	* @return \Illuminate\Http\Response
	*/
	public function update(Request $request, $id) {
		if ($model = $this->model::find($id)) {
			Gate::forUser($request['payload'])->authorize("{$this->key}-update", $model);

			$data = $request->all();

			if ($hasInvalidRules = hasInvalidRulesModel($this->model::$rules, $data)) {
				return $hasInvalidRules;
			}

			$model->fill($data)->save();

			return $model;
		}

		return response()->json([ 'errors' => ["{$this->label} não existente ou desativado"] ], 410);
	}

	/**
	* Remove the specified resource from storage.
	*
	* @param  int  $id
	* @return \Illuminate\Http\Response
	*/
	public function destroy(Request $request, $id) {
		if ($model = $this->model::find($id)) {
			Gate::forUser($request['payload'])->authorize("{$this->key}-delete", [ $model ]);

			$model->delete();

			return $model;
		}

		return response()->json([ 'errors' => ["{$this->label} não existente ou já desativado"] ], 410);
	}

	public function restore (Request $request, $id) {
		if ($model = $this->model::withTrashed()::find($id)) {
			Gate::forUser($request['payload'])->authorize("{$this->key}-restore", [ $model ]);

			$model->restore();

			return $model;
		}

		return response()->json([ 'errors' => ["{$this->label} não existente"] ], 410);
	}

}
