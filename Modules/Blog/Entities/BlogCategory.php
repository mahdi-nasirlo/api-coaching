<?php

namespace Modules\Blog\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Modules\Blog\Database\factories\BlogCategoryFactory;

//use Kalnoy\Nestedset\NodeTrait;

class BlogCategory extends Model
{
    use HasFactory;

//        , NodeTrait;

    public $table = 'blog_categoriess';
    protected $guarded = ['created_at', 'updated_at'];

    protected static function newFactory(): BlogCategoryFactory
    {
        return BlogCategoryFactory::new();
    }
}
