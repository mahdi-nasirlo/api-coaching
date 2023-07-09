<?php

namespace Modules\Meeting\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Modules\Meeting\Database\factories\CoachFactory;
use Modules\Meeting\Enums\CoachStatusEnum;
use Modules\Meeting\Scopes\AcceptedCoachScope;

class Coach extends Model
{
    use HasFactory;

    protected $guarded = ['created_at', 'updated_at'];

    protected $casts = ['status' => CoachStatusEnum::class];

    protected static function booted(): void
    {
        static::addGlobalScope(new AcceptedCoachScope());
    }

    public function coachInfo(): HasOne
    {
        return $this->hasOne(CoachInfo::class);
    }

    protected static function newFactory(): CoachFactory
    {
        return CoachFactory::new();
    }
}
