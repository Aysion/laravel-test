<?php

namespace App\Policies;

use App\Models\UserModel;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserTypePolicy
{
	use HandlesAuthorization;

	public function list(UserModel $user) {
		return $this->ruleDefault($user);
	}

	public function form(UserModel $user) {
		return $this->ruleDefault($user);
	}

	public function save(UserModel $user) {
		return $this->ruleDefault($user);
	}

	public function delete(UserModel $user) {
		return $this->ruleDefault($user);
	}

	public function enable(UserModel $user) {
		return $this->ruleDefault($user);
	}

	private function ruleDefault(UserModel $user) {
		return in_array($user->userType->level, [99, 1]);
	}
}
