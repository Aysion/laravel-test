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
			return true;
		}
	}

	public function viewAny($payload, UserTypeModel $userTypeModel)
	{
		$userTypeModel->where('level', '!=', '101');

		echo ($userTypeModel->name);
		return true;
	}

	public function view($payload, UserTypeModel $userTypeModel)
	{
		return true;
	}

	public function create($payload)
	{
		return true;
	}

	public function update($payload, UserTypeModel $userTypeModel)
	{
		return true;
	}

	public function delete($payload, UserTypeModel $userTypeModel)
	{
		return true;
	}

	public function restore($payload, UserTypeModel $userTypeModel)
	{
		return true;
	}

	public function forceDelete($payload, UserTypeModel $userTypeModel)
	{
		return true;
	}
}
