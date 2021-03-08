<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;

class Animation extends Model
{
	use HasFactory,
		SoftDeletes;
	
	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		'name',
		'start_at',
		'finish_at'
	];

	/**
	 * The attributes that should be hidden for arrays.
	 *
	 * @var array
	 */
	protected $hidden = [
		'animatable_type',
		'animatable_id',
	];

	/**
	 * The attributes that should be cast to native types.
	 *
	 * @var array
	 */
	protected $casts = [
		'start_at' => 'datetime',
		'finish_at' => 'datetime'
	];

	public static function byDate()
	{
		return self::get()->filter(function($value, $key) {
			return !$value->start_at->isPast();
		})->groupBy(function($date) {
			return $date->start_at->isToday() ? 'today' : $date->start_at->format('d-m-Y');
		});
	}

	public function user()
	{
		return $this->belongsTo(User::class);
	}

	public function target()
	{
		return $this->morphTo();
	}
}
