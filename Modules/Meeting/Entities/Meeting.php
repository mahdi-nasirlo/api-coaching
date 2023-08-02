<?php

namespace Modules\Meeting\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Modules\Meeting\Database\factories\MeetingFactory;

/**
 * @property int id
 * @property string body
 * @property string date
 * @property string start_time
 * @property string end_time
 * @property int coach_id
 * @property status
 */
class Meeting extends Model
{
    use HasFactory;

    protected $guarded = ['created_at', 'updated_at'];

    protected static function newFactory()
    {
        return MeetingFactory::new();
    }

    public function coache()
    {
        return $this->belongsTo(Coach::class);
    }
}
