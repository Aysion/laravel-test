<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;

class User extends Authenticatable
{
	use HasFactory, Notifiable, SoftDeletes;

	/**
	* The attributes that are mass assignable.
	*
	* @var array
	*/
	protected $fillable = [
		'name',
		'email',
		'password',
		'users_type_id',
	];

	protected $appends = [ 'userType' ];

	/**
	* The attributes that should be hidden for arrays.
	*
	* @var array
	*/
	protected $hidden = [
		'password',
		'remember_token',
	];

	/**
	* The attributes that should be cast to native types.
	*
	* @var array
	*/
	protected $casts = [
		'email_verified_at' => 'datetime',
	];

	protected function getUserTypeAttribute() {
		return UsersType::find($this->attributes['users_type_id']);
	}

	protected function setPasswordAttribute($value) {
		$this->attributes['password'] = Hash::make($value);
	}

	public function usersType() {
		return $this->belongsTo('App\Models\UsersType');
	}
}
