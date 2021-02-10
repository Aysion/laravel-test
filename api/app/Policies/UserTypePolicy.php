<?php

namespace App\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;

class UserTypePolicy
{
	use HandlesAuthorization;

	public function before($payload, $action) {
		switch ($payload->user->level) {
			case 1: return null;
			case 2: return $action == 'userType-viewAny' ? null : false;
			default: return false;
		}
	}

	public function viewAny($payload, $model)
	{
		$model->where('level', '!=', '101');

		if ($payload->user->level != 1) {
			$model->whereNotIn('level', [ 1, 2 ]);
		}

		return true;
	}

	public function view($payload, $model)
	{
		return true;
	}

	public function create($payload)
	{
		return true;
	}

	public function update($payload, $model)
	{
		return true;
	}

	public function delete($payload, $model)
	{
		return true;
	}

	public function restore($payload, $model)
	{
		return true;
	}

	public function forceDelete($payload, $model)
	{
		return true;
	}
}
