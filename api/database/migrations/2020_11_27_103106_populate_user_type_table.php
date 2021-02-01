<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class PopulateUserTypeTable extends Migration
{
	/**
	* Run the migrations.
	*
	* @return void
	*/
	public function up()
	{
		DB::table('user_type')->updateOrInsert([ 'id' => 1 ], [ 'name' => 'Administrador', 'level' => 101 ]);
		DB::table('user_type')->updateOrInsert([ 'id' => 2 ], [ 'name' => 'Diretor', 'level' => 1 ]);
		DB::table('user_type')->updateOrInsert([ 'id' => 3 ], [ 'name' => 'Gerente', 'level' => 2 ]);
		DB::table('user_type')->updateOrInsert([ 'id' => 4 ], [ 'name' => 'Vendedor', 'level' => 3 ]);
	}

	/**
	* Reverse the migrations.
	*
	* @return void
	*/
	public function down()
	{
		DB::table('user_type')->whereIn('id', [1,2,3,4])->delete();
	}
}
