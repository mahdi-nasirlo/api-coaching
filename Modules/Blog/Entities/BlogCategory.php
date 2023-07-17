<?php

namespace Modules\Blog\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Kalnoy\Nestedset\NodeTrait;
use Modules\Blog\Database\factories\BlogCategoryFactory;

class BlogCategory extends Model
{
    use HasFactory, NodeTrait;

    protected $guarded = ['created_at', 'updated_at'];

    public $table = 'blog_categories';

    protected static function newFactory(): BlogCategoryFactory
    {
        return BlogCategoryFactory::new();
    }
}
