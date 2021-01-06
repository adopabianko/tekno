<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PostCategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'parent',
    ];

    public function parentCategory() {
        return $this->belongsTo('App\Models\PostCategory', 'parent');
    }

    public function Post() {
        $this->hasMany('App\Models\Post', 'category_id', 'id');
    }
}
