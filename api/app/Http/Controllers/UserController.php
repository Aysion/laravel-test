<?php

namespace App\Http\Controllers;

use App\Models\UserModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class UserController extends Controller
{

	function __construct() {
		$this->key = 'user';
		$this->label = 'Usuário';
		$this->model = UserModel::class;
	}

	/**
	* Store a newly created resource in storage.
	*
	* @param  \Illuminate\Http\Request  $request
	* @return \Illuminate\Http\Response
	*/
	public function store(Request $request)
	{
		Gate::forUser($request['payload'])->authorize('user-create');

		$data = $request->all();

		if ($hasInvalidRules = hasInvalidRulesModel(UserModel::$rules, $data)) {
			return $hasInvalidRules;
		}

		$userType = new UserModel;

		if ($userType->where('email', $data['email'])->first()) {
			return response()->json([ 'errors' => ['Usuário já cadastrado'] ], 409);
		}

		$userType->fill($data)->save();

		return $userType;
	}

	/**
	* Update the specified resource in storage.
	*
	* @param  \Illuminate\Http\Request  $request
	* @param  int  $id
	* @return \Illuminate\Http\Response
	*/
	public function update(Request $request, $id)
	{
		if ($user = UserModel::find($id)) {
			Gate::forUser($request['payload'])->authorize('user-update', $user);

			$data = $request->all();

			$rules = UserModel::$rules;

			if (!isset($data['password'])) {
				unset($rules['password']);
			}

			if ($hasInvalidRules = hasInvalidRulesModel($rules, $data)) {
				return $hasInvalidRules;
			}

			$user->fill($data)->save();

			return $user;
		}

		return response()->json([ 'errors' => ['Usuário não existente ou desativado'] ], 410);
	}

}
