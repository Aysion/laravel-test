<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Models\UsersType;
use Illuminate\Http\Request;

class UsersTypeController extends Controller {
	
	function list(Request $request) {
		return view('panel.pages.usersType.list', [
			'table' => UsersType::orderBy('name')->withTrashed()->get(),
		]);
	}
	
	function form(Request $request, $id = null) {
		return view('panel.pages.usersType.form', [
			'form' => is_null($id) ? null : UsersType::find($id),
		]);
	}
	
	function save(Request $request) {
		$usersType = new UsersType;
		
		if ($request->get('id')) {
			$usersType = UsersType::find($request->get('id'));
		}

		$usersType->fill($request->all())->save();
		
		return redirect('/panel/users_type');
	}
	
	function delete(Request $request, $id) {
		UsersType::find($id)->delete();
		
		return redirect('/panel/users_type');
	}
	
	function enable(Request $request, $id) {
		UsersType::withTrashed()->find($id)->restore();
		
		return redirect('/panel/users_type');
	}
}
