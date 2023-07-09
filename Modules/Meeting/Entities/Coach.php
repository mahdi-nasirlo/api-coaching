<?php

namespace Modules\Meeting\Entities;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Modules\Meeting\Database\factories\CoachFactory;
use Modules\Meeting\Enums\CoachStatusEnum;
use Modules\Meeting\Scopes\AcceptedCoachScope;

/**
 * @property int $id
 * @property int $user_id
 * @property string $name
 * @property string $user_name
*/

class Coach extends Model
{
    use HasFactory;

    protected $guarded = ['created_at', 'updated_at'];

    protected $casts = ['status' => CoachStatusEnum::class];

    protected $observables = [];

    protected static function booted(): void
    {
        static::addGlobalScope(new AcceptedCoachScope());
        self::observe(\CoachObserver::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function coachInfo(): BelongsTo
    {
        return $this->belongsTo(CoachInfo::class);
    }

    protected static function newFactory(): CoachFactory
    {
        return CoachFactory::new();
    }
}
