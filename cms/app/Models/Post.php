<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'content',
        'cover',
        'category_id',
        'slug',
        'status'
    ];

    public function Category() {
        return $this->belongsTo('App\Models\PostCategory', 'category');
    }
}
