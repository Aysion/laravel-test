<?php

namespace App\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Database\Eloquent\Builder;

class ConfigPagePolicy
{
	use HandlesAuthorization;

	public function before($payload,$action) {
		switch ($payload->user->level) {
			case 1: return null;
			case 2: return $action == 'configPage-viewAny' ? null : false;
			default: return false;
		}
	}

	public function viewAny($payload, Builder $model)
	{
		// $model->where('level', '!=', '101');

		// if ($payload->user->level != 1) {
		// 	$model->whereNotIn('level', [ 1, 2 ]);
		// }

		return true;
	}

	public function view($payload, Builder $model)
	{
		return true;
	}

	public function create($payload)
	{
		return true;
	}

	public function update($payload, Builder $model)
	{
		return true;
	}

	public function delete($payload, Builder $model)
	{
		return true;
	}

	public function restore($payload, Builder $model)
	{
		return true;
	}

	public function forceDelete($payload, Builder $model)
	{
		return true;
	}
}
