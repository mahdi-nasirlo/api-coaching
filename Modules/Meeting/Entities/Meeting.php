<?php

namespace Modules\Meeting\Entities;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Modules\Meeting\Database\factories\MeetingFactory;
use Modules\Meeting\Enums\MeetingStatusEnums;

/**
 * @property int id
 * @property string body
 * @property string date
 * @property string start_time
 * @property string end_time
 * @property int coach_id
 * @property MeetingStatusEnums status
 * @method  activeStatus()
 */
class Meeting extends Model
{
    use HasFactory;

    protected $guarded = ['created_at', 'updated_at'];

    protected $casts = ['status' => MeetingStatusEnums::class];

    protected static function newFactory(): MeetingFactory
    {
        return MeetingFactory::new();
    }

    public function ScopeActiveStatus($query)
    {
        return $query->where('status', MeetingStatusEnums::ACTIVE->value);
    }

    public function ScopeAvailableDate($query)
    {
        return $query->where('date', '>', Carbon::now()->subDays(7));
    }

    public function coach(): BelongsTo
    {
        return $this->belongsTo(Coach::class);
    }

}
