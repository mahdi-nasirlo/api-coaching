<?php

namespace Modules\Meeting\Enums;

enum MeetingStatusEnums: int
{
    case DEACTIVATE = 0;
    case ACTIVE = 1;

    case RESERVED = 2;

    public function isActive(): bool
    {
        return $this->value == self::ACTIVE->value;
    }

    public function isReserved(): bool|null
    {
        return $this->value == self::DEACTIVATE ? null : $this->value == self::RESERVED->value;
    }
}
