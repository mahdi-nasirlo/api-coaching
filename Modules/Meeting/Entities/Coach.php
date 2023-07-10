<?php

namespace Modules\Meeting\Entities;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Modules\Category\Entities\Category;
use Modules\Meeting\Database\factories\CoachFactory;
use Modules\Meeting\Enums\CoachStatusEnum;
use Modules\Meeting\Observers\CoachObserver;
use Modules\Meeting\Scopes\AcceptedCoachScope;

/**
 * @property int $id
 * @property int $user_id
 * @property string $name
 * @property string $user_name
 * @property string $avatar
 * @property integer $hourly_price
 * @property CoachStatusEnum $status
 * @method static join(string $string, string $string1, string $string2, string $string3)
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
        self::observe(CoachObserver::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function category(): MorphMany
    {
        return $this->morphMany(Category::class,'categoryable');
    }

    public function coachInfo(): BelongsTo
    {
        return $this->belongsTo(CoachInfo::class,'info_id');
    }

    protected static function newFactory(): CoachFactory
    {
        return CoachFactory::new();
    }
}
