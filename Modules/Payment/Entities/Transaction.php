<?php

namespace Modules\Payment\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Modules\Meeting\Entities\Meeting;
use Modules\Payment\Database\factories\TransactionFactory;

/**
 * @property string resnumber
 * @property string verify_code
 * @property int amount
 */
class Transaction extends Model
{
    use HasFactory;

    protected $guarded = ['created_at', 'updated_at'];

    protected static function newFactory()
    {
        return TransactionFactory::new();
    }

    public function transaction_able(): MorphTo
    {
        return $this->morphTo('transaction_able', 'transaction_able_type', 'transaction_able_id');
    }

    public function getMeeting()
    {
        return $this->transaction_able_type == Meeting::class ? $this->transaction_able : null;
    }
}

