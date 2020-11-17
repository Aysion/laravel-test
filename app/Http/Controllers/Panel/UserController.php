<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\UsersType;
use Illuminate\Http\Request;

class UserController extends Controller {
	
	function list(Request $request) {
		return view('panel.pages.user.list', [
			'table' => User::withTrashed()->with('usersType')->orderBy('name')->get(),
		]);
	}
	
	function form(Request $request, $id = null) {
		return view('panel.pages.user.form', [
			'form' => is_null($id) ? null : User::find($id),
			'selectBox' => [
				'usersType' => UsersType::orderBy('name')->get(),
			]
		]);
	}
	
	function save(Request $request) {
		$user = new User;
		
		if ($request->get('id')) {
			$user = User::find($request->get('id'));
		}

		$user->fill($request->all())->save();
		
		return redirect('/panel/user');
	}
	
	function delete(Request $request, $id) {
		User::find($id)->delete();
		
		return redirect('/panel/user');
	}
	
	function enable(Request $request, $id) {
		User::withTrashed()->find($id)->restore();
		
		return redirect('/panel/user');
	}
}
