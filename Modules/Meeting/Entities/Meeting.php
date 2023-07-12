<?php

namespace Modules\Meeting\Entities;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Meeting extends Model
{
    use HasFactory;
    use HasUuids;

    protected $guarded = ['created_at', 'updated_at'];

    protected static function newFactory()
    {
        return \Modules\Meeting\Database\factories\MeetingFactory::new();
    }
}
