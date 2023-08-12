<?php

namespace Modules\Shop\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Modules\Shop\Database\factories\CourceProductEpisodeFactory;

class CourseProductEpisode extends Model
{
    use HasFactory;

    protected $fillable = [];

    protected static function newFactory()
    {
        return CourceProductEpisodeFactory::new();
    }
}
