<?php

namespace Modules\Meeting\Enums;

enum MeetingStatusEnums: int
{
    case DEACTIVATE = 0;
    case ACTIVE = 1;

    public function isActive(): bool
    {
        return $this->value == self::ACTIVE->value;
    }
}
