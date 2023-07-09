<?php

namespace Modules\Meeting\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Modules\Meeting\Database\factories\CoachInfoFactory;

class CoachInfo extends Model
{
    use HasFactory;

    protected $guarded = ['updated_at', 'created_at'];

    public function coach(): BelongsTo
    {
        return $this->belongsTo(Coach::class);
    }

    protected static function newFactory(): CoachInfoFactory
    {
        return CoachInfoFactory::new();
    }
}
