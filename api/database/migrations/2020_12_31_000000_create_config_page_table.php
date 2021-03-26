<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateConfigPageTable extends Migration
{
	/**
	* Run the migrations.
	*
	* @return void
	*/
	public function up()
	{
		Schema::create('config_page', function (Blueprint $table) {
			$table->id();

			// $table->foreignId('user_id')->constrained('user')->onDelete('cascade')->nullable();
			// $table->foreignId('user_type_id')->constrained('user_type')->onDelete('cascade')->nullable();

			$table->string('name', 32)->nullable();
			$table->string('title', 32)->nullable();
			$table->string('subtitle', 32)->nullable();
			$table->string('icon', 16)->nullable();
			$table->string('description', 1024)->nullable();

			$table->timestamps();
			$table->softDeletes();
		});
	}

	/**
	* Reverse the migrations.
	*
	* @return void
	*/
	public function down()
	{
		Schema::dropIfExists('config_page');
	}
}
