<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class JoelController extends Controller {

	function joel(Request $request) {
		return view('joel', [ 'name' => 'Teste', 'age' => 18, 'records' => 1 ]);
	}
}
