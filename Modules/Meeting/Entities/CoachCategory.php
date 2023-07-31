<?php

namespace Modules\Meeting\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Modules\Meeting\Database\factories\CoachCategoryFactory;

/**
 * @property string name
 * @property string slug
 * @property boolean is_active
 */
class CoachCategory extends Model
{
    use HasFactory;

    protected $fillable = [];

    protected static function newFactory()
    {
        return CoachCategoryFactory::new();
    }
}
