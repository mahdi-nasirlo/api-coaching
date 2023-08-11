<?php

namespace Modules\Payment\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Modules\Meeting\Entities\Meeting;
use Modules\Payment\Database\factories\TransactionFactory;
use Modules\Payment\Enums\PaymentStatusEnum;

/**
 * @property string resnumber
 * @property string verify_code
 * @property int amount
 */
class Transaction extends Model
{
    protected $guarded = ['created_at', 'updated_at'];

    protected $casts = ['status' => PaymentStatusEnum::class];

    public function getMeeting(): ?MorphTo
    {
        return $this->transaction_able_type == Meeting::class ? $this->transaction_able() : null;
    }

    public function transaction_able(): MorphTo
    {
        return $this->morphTo('transaction_able', 'transaction_able_type', 'transaction_able_id');
    }
}

