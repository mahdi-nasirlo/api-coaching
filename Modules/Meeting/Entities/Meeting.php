<?php

namespace Modules\Meeting\Entities;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Modules\Meeting\Database\factories\MeetingFactory;
use Modules\Meeting\Enums\MeetingStatusEnums;
use Modules\Payment\Entities\Transaction;

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
        return $query->whereIn('status', [MeetingStatusEnums::ACTIVE->value, MeetingStatusEnums::RESERVED->value]);
    }

    public function ScopeAvailableDate($query)
    {
        return $query->where('date', '>', Carbon::now());
    }

    public function coach(): BelongsTo
    {
        return $this->belongsTo(Coach::class);
    }

    public function booking(): HasOne
    {
        return $this->hasOne(BookingMeeting::class);
    }

    public function transaction(): MorphOne
    {
        return $this->morphOne(Transaction::class, 'transaction_able');
    }
}
