<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Models\UserTypeModel;
use Illuminate\Http\Request;

class UserTypeController extends Controller {

	function list(Request $request) {
		$this->authorize('userType-list');

		return view('panel.pages.userType.list', [
			'table' => UserTypeModel::orderBy('name')->withTrashed()->get(),
		]);
	}

	function form(Request $request, $id = null) {
		$this->authorize('userType-form');

		return view('panel.pages.userType.form', [
			'form' => is_null($id) ? null : UserTypeModel::find($id),
		]);
	}

	function save(Request $request) {
		$userType = new UserTypeModel;

		if ($request->get('id')) {
			$userType = UserTypeModel::find($request->get('id'));
		}

		$this->authorize('userType-save', $request->get('id') ? $userType : null);

		$userType->fill($request->all())->save();

		return redirect('/panel/users_type');
	}

	function delete(Request $request, $id) {
		$this->authorize('userType-delete');

		UserTypeModel::find($id)->delete();

		return redirect('/panel/users_type');
	}

	function enable(Request $request, $id) {
		$this->authorize('userType-enable');

		UserTypeModel::withTrashed()->find($id)->restore();

		return redirect('/panel/users_type');
	}
}
