<?php

namespace App\Policies;

use App\Models\UserModel;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserTypePolicy
{
	use HandlesAuthorization;

	public function list(UserModel $user) {
		return in_array($user->userType->level, [99, 1]);
	}

	public function form(UserModel $user) {
		return in_array($user->userType->level, [99, 1]);
	}

	public function save(UserModel $user) {
		return in_array($user->userType->level, [99, 1]);
	}

	public function delete(UserModel $user) {
		return in_array($user->userType->level, [99, 1]);
	}

	public function enable(UserModel $user) {
		return in_array($user->userType->level, [99, 1]);
	}
}
