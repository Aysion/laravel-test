<?php

use App\Models\ConfigPageModel;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class PopulateConfigMenuTable extends Migration
{
	/**
	* Run the migrations.
	*
	* @return void
	*/
	public function up()
	{
		DB::table('config_menu')
		->updateOrInsert([
			'user_type_id' => '1',
			'config_page_id' => ConfigPageModel::where('name', 'userType')->first()->id,
		], []);

		DB::table('config_menu')
		->updateOrInsert([
			'user_type_id' => '1',
			'config_page_id' => ConfigPageModel::where('name', 'user')->first()->id,
		], []);
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
