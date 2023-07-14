<?php

namespace Modules\Meeting\Entities;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property mixed $start_time
 * @property mixed $end_time
 * @property Coach $coach
 */
class Meeting extends Model
{
    use HasFactory;
    use HasUuids;

    protected $guarded = ['created_at', 'updated_at'];

    public function coach(): BelongsTo
    {
        return $this->belongsTo(Coach::class);
    }

    protected static function newFactory()
    {
        return \Modules\Meeting\Database\factories\MeetingFactory::new();
    }
}
