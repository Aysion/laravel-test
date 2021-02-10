<?php

namespace App\Http\Controllers;

use App\Models\UserTypeModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
class UserTypeController extends Controller
{

	function __construct() {
		$this->key = 'userType';
		$this->label = 'Tipo de usuário';
		$this->model = UserTypeModel::class;
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

		$userType = $this->model;

		if ($userType->where('name', $data['name'])->where('level', $data['level'])->first()) {
			return response()->json([ 'errors' => ["{$this->label} já cadastrado"] ], 409);
		}

		$userType->fill($data)->save();

		return $userType;
	}

}
