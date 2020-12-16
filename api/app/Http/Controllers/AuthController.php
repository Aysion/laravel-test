<?php

namespace App\Http\Controllers;

use App\Models\UserModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;
use JWTHelper;

class AuthController extends Controller {

	public function auth(Request $request) {
		$input = $request->all();

		$userData = UserModel::where('email', $input['email'])->first();

		if ($userData && Hash::check($request->password, $userData->makeVisible(['password'])->password)) {
			return Crypt::encrypt((new JWTHelper())->build([
				'user' => [
					'id' => $userData->id,
					'company' => 1,
				],
			]));
		}

		return false;
	}

}