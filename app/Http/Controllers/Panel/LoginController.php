<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Models\UsersType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller {

	public function view() {
		return view('panel.pages.login.view');
	}

	public function authenticate(Request $request) {
		if (Auth::attempt($request->only('email', 'password'))) {
			return redirect()->intended('panel');
		}

		return redirect()->back();
	}

	public function logout() {
		Auth::logout();

		return redirect()->route('panel.login');
	}

}