<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
	use HasFactory;

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		'name',
		'prefix',
		'color'
	];

	/**
	 * Disabel timestamps fields
	 */
	public $timestamps = false;

	/**
	 * Get child Artices
	 */
	public function articles()
	{
		return $this->hasMany(Article::class);
	}
}
