<?php

namespace Modules\Blog\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\Tags\HasTags;

class Post extends Model
{
    use HasFactory, HasTags;

    protected $guarded = ['created_at', 'updated_at'];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'blog_category_id');
    }

    protected static function newFactory()
    {
        return \Modules\Blog\Database\factories\PostFactory::new();
    }
}
