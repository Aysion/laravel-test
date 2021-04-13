<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateConfigMenuTable extends Migration
{
	/**
	* Run the migrations.
	*
	* @return void
	*/
	public function up()
	{
		Schema::create('config_menu', function (Blueprint $table) {
			$table->id();

			$table->foreignId('user_type_id')
			->nullable()
			->constrained('user_type')
			->onDelete('cascade');

			$table->foreignId('user_id')
			->nullable()
			->constrained('user')
			->onDelete('cascade');

			$table->foreignId('config_page_id')
			->nullable()
			->constrained('config_page')
			->onDelete('cascade');

			$table->timestamps();
		});
	}

	/**
	* Reverse the migrations.
	*
	* @return void
	*/
	public function down()
	{
		Schema::dropIfExists('config_menu');
	}
}
