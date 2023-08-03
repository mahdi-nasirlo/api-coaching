<?php

namespace Modules\Meeting\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Modules\Meeting\Database\factories\BookingMeetingFactory;

class BookingMeeting extends Model
{
    use HasFactory;

    protected $guarded = ['create_at', 'updated_at'];

    protected static function newFactory()
    {
        return BookingMeetingFactory::new();
    }

    public function meeting(): HasOne
    {
        return $this->hasOne(Meeting::class);
    }
}
