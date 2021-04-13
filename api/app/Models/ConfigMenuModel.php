<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ConfigMenuModel extends Model
{
	static public $rules = [];

	protected $table = 'config_menu';

	protected $fillable = [
		'user_type_id',
		'user_id',
		'config_page_id',
	];

	function configPage() {
		return $this->hasOne('App\Models\ConfigPageModel', 'id', 'config_page_id');
	}
}
