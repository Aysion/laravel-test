<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ConfigPageModel extends Model
{
	use HasFactory, SoftDeletes;

	static public $rules = [
		'name' => [ 'required', 'min:3', 'max:32' ],
		'title' => [ 'required', 'min:3', 'max:32' ],
	];

	protected $table = 'config_page';

	protected $fillable = [
		'name',
		'title',
		'subtitle',
		'icon',
		'description',
	];
}
