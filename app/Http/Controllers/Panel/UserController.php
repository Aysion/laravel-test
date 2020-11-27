<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Models\UserModel;
use App\Models\UserTypeModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{

	function list()
	{
		$this->authorize('user-list');

		$listTable = UserModel::withTrashed()->with(['userType', 'user'])->orderBy('name')->get();

		return view('panel.pages.user.list', [
			'listTable' => $listTable,
		]);
	}

	function form(Request $request, $id = null)
	{
		$dataForm = is_null($id) ? null : UserModel::find($id);

		$higher = null;

		if ($dataForm) {
			switch ($dataForm->userType->level) {
				case 2:
					$higher = 1;
					break;

				case 3:
					$higher = 2;
					break;
			};
		}

		$this->authorize('user-form', $dataForm);

		return view('panel.pages.user.form', [
			'form' => $dataForm,
			'selectBox' => [
				'userType' => UserTypeModel::orderBy('name')->get(),
				'higher' => $higher ? UserModel::whereHas('userType', function ($query) use ($higher) {
					$query->where('level', $higher);
				})->orderBy('name')->get() : [],
			]
		]);
	}

	function save(Request $request)
	{
		$user = new UserModel;
		$input = $request->all();

		if ($request->get('id')) {
			$user = UserModel::find($request->get('id'));
		}

		if (!(
			isset($input['password'])
			&& $input['password']
			&& isset($input['passwordConf'])
			&& $input['password'] === $input['passwordConf']
		)) {
			unset($input['password']);
		}

		$this->authorize('user-save', $request->get('id') ? $user : null);

		$user->fill($input)->save();

		return redirect('/panel/user');
	}

	function delete(Request $request, $id)
	{
		$user = UserModel::find($id);

		$this->authorize('user-delete', $user);

		$user->delete();

		return redirect('/panel/user');
	}

	function enable(Request $request, $id)
	{
		$user = UserModel::withTrashed()->find($id);

		$this->authorize('user-enable', $user);

		$user->restore();

		return redirect('/panel/user');
	}
}
