<?php

namespace App\Policies;

use App\Models\UserModel;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
	use HandlesAuthorization;

	public function before($payload, $action) {
		if ($payload->user->level == 101) {
			return true;
		} else {
			return null;
		}
	}

	public function viewAny($payload, $model)
	{
		$model->whereHas('userType', function($query) {
			$query->where('level', '!=', '101');
		});

		if ($payload->user->level != 1) {
			$model->where('id', $payload->user->id)->orWhere('user_id', $payload->user->id);
		}

		return true;
	}

	public function view($payload, $model)
	{
		return $model->id == $payload->user->id || $model->user_id == $payload->user->id;
	}

	public function create($payload)
	{
		return false;
	}

	public function update($payload, $model)
	{
		return false;
	}

	public function delete($payload, $model)
	{
		return false;
	}

	public function restore($payload, $model)
	{
		return false;
	}
}
