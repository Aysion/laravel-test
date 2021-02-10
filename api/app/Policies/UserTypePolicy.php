<?php

namespace App\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;

class UserTypePolicy
{
	use HandlesAuthorization;

	public function before($payload) {
		return $payload->user->level == 1 ? null : false;
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
