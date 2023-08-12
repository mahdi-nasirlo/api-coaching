<?php

namespace Modules\Shop\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Modules\Shop\Database\factories\CourceProductFactory;

class CourseProduct extends Model
{
    use HasFactory;

    protected $fillable = [];

    protected static function newFactory()
    {
        return CourceProductFactory::new();
    }
}
