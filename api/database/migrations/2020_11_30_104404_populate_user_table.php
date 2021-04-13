<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class PopulateUserTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		DB::table('user')->updateOrInsert(['id' => 1], [
			'name' => 'Administrador',
			'email' => 'admin@email.com',
			'password' => Hash::make('123'),
			'user_type_id' => 1,
		]);
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		DB::table('user_type')->whereIn('id', [1, 2, 3, 4, 5, 6])->delete();
	}
}
