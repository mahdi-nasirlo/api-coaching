<?php

namespace Modules\Meeting\Enums;

use App\Traits\RandomEnum;

enum CoachStatusEnum: int
{
    use RandomEnum;

    case PENDING = 0;
    case ACCEPT = 1;
    case REJECT = 2;
    case ACTIVE = 3;
    case INACTIVE = 4;

}
