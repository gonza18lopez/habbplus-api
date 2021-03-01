<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Hootlex\Moderation\Moderatable;

class Article extends Model
{
	use HasFactory,
		SoftDeletes,
		Moderatable;

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		'title',
		'description',
		'body',
		'image',
		'user_id',
		'category_id',
		'moderated_at',
		'status'
	];

	public function user()
	{
		return $this->belongsTo(User::class);
	}

	public function category()
	{
		return $this->belongsTo(Category::class);
	}

	public function comments()
	{
		return $this->morphMany(Comment::class, 'comment');
	}
}
