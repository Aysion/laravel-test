<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class JWTApi
{
	/**
	* Handle an incoming request.
	*
	* @param  \Illuminate\Http\Request  $request
	* @param  \Closure  $next
	* @return mixed
	*/
	public function handle(Request $request, Closure $next)
	{
		$gpToken = $request->headers->get('gp-token');

		if (empty($gpToken)) {
			return response()->json([
				'errors' => [
					'Token não informado',
				]
			], 401);
		}

		return response()->json([], 401);

		return $next($request);
	}
}
