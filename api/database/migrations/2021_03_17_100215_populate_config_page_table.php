<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class PopulateConfigPageTable extends Migration
{
	/**
	* Run the migrations.
	*
	* @return void
	*/
	public function up()
	{
		DB::table('config_page')->updateOrInsert(['name' => 'userType'], [
			'title' => 'Tipo de Usuário',
			'subtitle' => null,
			'description' => null,
			'icon' => 'school',
		]);

		DB::table('config_page')->updateOrInsert(['name' => 'user'], [
			'title' => 'Usuário',
			'subtitle' => null,
			'description' => null,
			'icon' => 'school',
		]);
	}

	/**
	* Reverse the migrations.
	*
	* @return void
	*/
	public function down()
	{

	}
}
