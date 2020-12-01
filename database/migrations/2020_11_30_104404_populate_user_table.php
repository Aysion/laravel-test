<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;

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

		DB::table('user')->updateOrInsert(['id' => 2], [
			'name' => 'Thalia - Diretor',
			'email' => 'diretor@email.com',
			'password' => Hash::make('123'),
			'user_type_id' => 2,
		]);

		DB::table('user')->updateOrInsert(['id' => 3], [
			'name' => 'Ana - Gerente',
			'email' => 'gerente@email.com',
			'password' => Hash::make('123'),
			'user_type_id' => 3,
			'user_id' => 2,
		]);

		DB::table('user')->updateOrInsert(['id' => 4], [
			'name' => 'Paula - Gerente',
			'email' => 'gerente2@email.com',
			'password' => Hash::make('123'),
			'user_type_id' => 3,
			'user_id' => 2,
		]);

		DB::table('user')->updateOrInsert(['id' => 5], [
			'name' => 'Maria - Vendedora',
			'email' => 'vendedor@email.com',
			'password' => Hash::make('123'),
			'user_type_id' => 4,
			'user_id' => 3,
		]);

		DB::table('user')->updateOrInsert(['id' => 6], [
			'name' => 'Suzana - Vendedora',
			'email' => 'vendedor2@email.com',
			'password' => Hash::make('123'),
			'user_type_id' => 4,
			'user_id' => 4,
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
