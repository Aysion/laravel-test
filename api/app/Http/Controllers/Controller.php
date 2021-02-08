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

	public function paginate(Request $request, $keyModel) {
		$pathModel = '\App\Models\\' . ucfirst($keyModel) . 'Model';
		$model = new $pathModel;

		Gate::forUser($request['payload'])->authorize("{$keyModel}-viewAny", $model);

		if ($request->header('gpModelParams')) {
			$gpModelParams = json_decode($request->header('gpModelParams'));

			if ($gpModelParams->withTrashed) {
				$model->withTrashed();
			}

		}

		return $model->simplePaginate(3)->withPath("/api/paginate/{$keyModel}");
	}
}
