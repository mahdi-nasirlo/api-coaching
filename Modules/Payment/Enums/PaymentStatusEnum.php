<?php

namespace Modules\Payment\Enums;

enum PaymentStatusEnum: int
{
    case UNPAID = 0;
    case  PAID = 1;
    case UNSUCCESSFUL = 2;


    public function isPaid(): bool
    {
        return $this->value === self::PAID->value;
    }
}
