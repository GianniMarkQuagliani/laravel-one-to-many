<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Post extends Model
{
    use HasFactory;

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class)->withPivot('vote');
    }

    protected $fillable = [
        'title',
        'category_id',
        'slug',
        'date',
        'reading_time',
        'text',
        'image',
        'image_original_name'
    ];
}
