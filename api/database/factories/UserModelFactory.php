<?php

namespace Database\Factories;

use App\Models\UserModel;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class UserModelFactory extends Factory
{
	/**
	* The name of the factory's corresponding model.
	*
	* @var string
	*/
	protected $model = UserModel::class;

	/**
	* Define the model's default state.
	*
	* @return array
	*/
	public function definition()
	{
		return [
			'name' => $this->faker->name,
			'email' => $this->faker->unique()->safeEmail,
			'email_verified_at' => now(),
			'password' => '$2y$10$JC9P1rTeZ7/0VzEz1LPwIez2TUQcjH3ametik8D.DjWjteb1zkBee', // 123
			'remember_token' => Str::random(10),
		];
	}
}
