<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class photos extends Model
{
    use HasFactory;
    protected $table = 'photos';
    protected $fillable = [
		'path', 'actor_id', 'movie_id', 'series_id', 'season_id', 'blog_id',
	];
}
