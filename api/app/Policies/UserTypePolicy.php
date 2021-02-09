<?php

namespace App\Policies;

use App\Models\UserTypeModel;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Support\Facades\Request;

class UserTypePolicy
{
	use HandlesAuthorization;

	public function before($payload, $action) {
		if ($payload->user->level == 101) {
			return true;
		} elseif ($payload->user->level == 1) {
			return null;
		} else {
			return false;
		}
	}

	public function viewAny($payload, $model)
	{
		$model->where('level', '!=', '101');

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
