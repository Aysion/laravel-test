<?php

namespace App\Http\Controllers;

use App\Models\UserModel;
use Illuminate\Http\Request;

class UserController extends Controller
{
	/**
	* Display a listing of the resource.
	*
	* @return \Illuminate\Http\Response
	*/
	public function index()
	{
		return UserModel::get();
	}

	/**
	* Store a newly created resource in storage.
	*
	* @param  \Illuminate\Http\Request  $request
	* @return \Illuminate\Http\Response
	*/
	public function store(Request $request)
	{
		$data = $request->all();

		if ($hasInvalidRules = hasInvalidRulesModel(UserModel::class, $data)) {
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
	* Display the specified resource.
	*
	* @param  int  $id
	* @return \Illuminate\Http\Response
	*/
	public function show($id)
	{
		return UserModel::find($id) ?? response()->json([ 'errors' => ['Usuário não existente ou desativado'] ], 410);
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
		$data = $request->all();

		if ($hasInvalidRules = hasInvalidRulesModel(UserModel::class, $data)) {
			return $hasInvalidRules;
		}

		$userType = UserModel::find($id);

		if ($userType) {
			$userType->fill($data)->save();

			return $userType;
		}

		return response()->json([ 'errors' => ['Usuário não existente ou desativado'] ], 410);
	}

	/**
	* Remove the specified resource from storage.
	*
	* @param  int  $id
	* @return \Illuminate\Http\Response
	*/
	public function destroy($id)
	{
		$userType = UserModel::find($id);

		if ($userType) {
			$userType->delete();

			return $userType;
		}

		return response()->json([ 'errors' => ['Usuário não existente ou já desativado'] ], 410);
	}
}
