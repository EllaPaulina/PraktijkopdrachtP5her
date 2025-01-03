<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Category;

class Article extends Model
{
    use HasFactory;

    // Specify the fillable properties
    protected $fillable = [
        'title',
        'content',
        'published_by',
        'user_id',
        'category_id',
        'visible', // Add this line
    ];

    // Specify casts for attributes
    protected $casts = [
        'visible' => 'boolean',
    ];

    public function category(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Category::class);
    }
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
}


