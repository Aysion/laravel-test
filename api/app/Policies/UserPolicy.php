<?php

namespace App\Policies;

use App\Models\UserModel;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
	use HandlesAuthorization;

	public function before($payload, $action) {
		return in_array($payload->user->level, [101, 1]) ? true : null;
	}

	public function viewAny($payload)
	{
		return false;
	}

	public function view($payload, UserModel $userModel)
	{
		return $userModel->id == $payload->user->id || $userModel->user_id == $payload->user->id;
	}

	public function create($payload)
	{
		return false;
	}

	public function update($payload, UserModel $userModel)
	{
		return false;
	}

	public function delete($payload, UserModel $userModel)
	{
		return false;
	}

	public function restore($payload, UserModel $userModel)
	{
		return false;
	}
}
