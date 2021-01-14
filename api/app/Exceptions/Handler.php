<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;

class Handler extends ExceptionHandler
{
	/**
	* A list of the exception types that are not reported.
	*
	* @var array
	*/
	protected $dontReport = [
		//
	];

	/**
	* A list of the inputs that are never flashed for validation exceptions.
	*
	* @var array
	*/
	protected $dontFlash = [
		'password',
		'password_confirmation',
	];

	/**
	* Register the exception handling callbacks for the application.
	*
	* @return void
	*/
	public function register() {
		$this->renderable(function (Exception $e, $request) {
			if (method_exists($e, 'getStatusCode')) {
				$statusCode = $e->getStatusCode();

				switch ($statusCode) {
					case 403: $msg = 'Esta ação não é autorizada.';
						break;
					default: $msg = $e->getMessage();
						break;
				}

			} else {
				$msg = "{$e->getMessage()} \n Line: {$e->getLine()} \nFiles {$e->getFile()}";
				$statusCode = 500;
			}

			return response()->json([ 'errors' => [ $msg ] ], $statusCode);
		});
	}
}
