<?php

namespace App\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Database\Eloquent\Builder;

class UserPolicy
{
	use HandlesAuthorization;

	public function before($payload, $action) {
		return in_array($action, [ 'user-viewAny' ]) ? null : ($payload->user->level == 1 ? true : null);
	}

	public function viewAny($payload, Builder $model)
	{
		$model->whereHas('userType', function($query) {
			$query->where('level', '!=', '101');
		});

		if ($payload->user->level != 1) {
			$model->where('id', $payload->user->id)->orWhere('user_id', $payload->user->id);
		}

		return true;
	}

	public function view($payload, Builder $model)
	{
		return $model->id == $payload->user->id || $model->user_id == $payload->user->id;
	}

	public function create($payload)
	{
		return true;
	}

	public function update($payload, Builder $model)
	{
		return $model->id == $payload->user->id || $model->user_id == $payload->user->id;
	}

	public function delete($payload, Builder $model)
	{
		return $model->user_id == $payload->user->id;
	}

	public function restore($payload, Builder $model)
	{
		return $model->id == $payload->user->id || $model->user_id == $payload->user->id;
	}
}
