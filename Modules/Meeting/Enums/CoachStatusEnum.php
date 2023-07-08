<?php

namespace Modules\Meeting\Enums;

enum CoachStatusEnum: int
{
    case PENDING = 0;
    case ACCEPT = 1;
    case REJECT = 2;
    case ACTIVE = 3;
    case INACTIVE = 4;

}
