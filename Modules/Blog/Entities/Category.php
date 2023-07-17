<?php

namespace Modules\Blog\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Kalnoy\Nestedset\NodeTrait;

class Category extends Model
{
    use HasFactory, NodeTrait;

    protected $fillable = [];

    protected static function newFactory()
    {
        return \Modules\Blog\Database\factories\CategoryFactory::new();
    }
}
