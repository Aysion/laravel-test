<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ConfigMenuModel extends Model
{
	use HasFactory, SoftDeletes;

	static public $rules = [
		'name' => [ 'required', 'min:3', 'max:64' ],
	];

	protected $table = 'config_menu';

	protected $fillable = [
		'user_type_id',
		'user_id',
		'name',
		'title',
		'subtitle',
		'icon',
	];
}
