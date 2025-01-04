<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Category;

/**
 * @method static find($id)
 * @method static create(array $validated)
 * @method static findOrFail($id)
 */
class Article extends Model
{

    // Specify the fillable properties
    protected $fillable = [
        'title',
        'content',
        'published_by',
        'user_id',
        'category_id',
        'visible',
        'image',// Add this line
    ];

    // Specify casts for attributes
    protected $casts = [
        'visible' => 'boolean',
    ];
    protected $guarded = [];


    public function category(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Category::class);
    }
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
}


