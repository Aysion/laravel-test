<?php

namespace App\Policies;

use App\Models\UserTypeModel;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Support\Facades\Request;

class UserTypePolicy
{
	use HandlesAuthorization;

	public function before($payload, $action) {
		return in_array($payload->user->level, [99, 1]);
	}

	public function viewAny($payload)
	{
		return false;
	}

	public function view($payload, UserTypeModel $userTypeModel)
	{
		return false;
	}

	public function create($payload)
	{
		return false;
	}

	public function update($payload, UserTypeModel $userTypeModel)
	{
		return false;
	}

	public function delete($payload, UserTypeModel $userTypeModel)
	{
		return false;
	}

	public function restore($payload, UserTypeModel $userTypeModel)
	{
		return false;
	}

	public function forceDelete($payload, UserTypeModel $userTypeModel)
	{
		return false;
	}
}
