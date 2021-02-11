<?php

namespace Database\Seeders;

use App\Models\UserModel;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
	/**
	* Run the database seeds.
	*
	* @return void
	*/
	public function run()
	{
		UserModel::factory()
			->count(1000)
			->state(new Sequence (
				['user_type_id' => 3],
				['user_type_id' => 4],
				['user_type_id' => 5],
				['user_type_id' => 6],
			))
			->create();
	}
}
