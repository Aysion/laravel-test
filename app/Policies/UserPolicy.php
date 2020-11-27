<?php

namespace App\Policies;

use App\Models\UserModel;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy {
	use HandlesAuthorization;

	public function list(UserModel $user) {
		return in_array($user->userType->level, [99, 1, 2]);
	}

	public function form(UserModel $user, UserModel $data = null) {
		return (in_array($user->userType->level, [99, 1]) ? true : (is_null($data) ? false : $user->id == $data->id || $user->id == $data->user_id));
	}

	public function save(UserModel $user, UserModel $data = null) {
		return (in_array($user->userType->level, [99, 1]) ? true : (is_null($data) ? false : $user->id == $data->id || $user->id == $data->user_id));
	}

	public function delete(UserModel $user, UserModel $data = null) {
		return (in_array($user->userType->level, [99, 1]) ? true : (is_null($data) ? false : $user->id == $data->user_id));
	}

	public function enable(UserModel $user, UserModel $data = null) {
		return (in_array($user->userType->level, [99, 1]) ? true : (is_null($data) ? false : $user->id == $data->user_id));
	}

}
