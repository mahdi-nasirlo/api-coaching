<?php

namespace Modules\Meeting\Entities;

use App\Models\User;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Modules\Meeting\Database\factories\CoachFactory;
use Modules\Meeting\Enums\CoachStatusEnum;
use Modules\Meeting\Observers\CoachObserver;

/**
 * @property int $id
 * @property int $user_id
 * @property string $name
 * @property string $user_name
 * @property string $avatar
 * @property integer $hourly_price
 * @property string $uuid
 * @property CoachStatusEnum $status
 * @method static join(string $string, string $string1, string $string2, string $string3)
 * @method static create()
 * @method acceptedStatus()
 */
class Coach extends Model
{
    use HasFactory;

    use Sluggable;

    protected $guarded = ['created_at', 'updated_at'];
    protected $casts = ['status' => CoachStatusEnum::class];
    protected $observables = [];

    protected static function booted(): void
    {
//        static::addGlobalScope(new AcceptedCoachScope());
        self::observe(CoachObserver::class);
    }

    protected static function newFactory(): CoachFactory
    {
        return CoachFactory::new();
    }

    public function getRouteKeyName(): string
    {
        return 'uuid';
    }

    public function sluggable(): array
    {
        return [
            'user_name' => [
                'source' => 'name'
            ]
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(CoachCategory::class, 'category_coach', 'category_id', 'coach_id');
    }

    public function coachInfo(): BelongsTo
    {
        return $this->belongsTo(CoachInfo::class, 'info_id');
    }

    public function meeting(): HasMany
    {
        return $this->hasMany(Meeting::class);
    }

    public function ScopeAcceptedStatus($query)
    {
        return $query->whereIn('status', [CoachStatusEnum::ACCEPTED, CoachStatusEnum::ACTIVE]);
    }
}
