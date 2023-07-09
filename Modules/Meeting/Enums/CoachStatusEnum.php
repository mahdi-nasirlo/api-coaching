<?php

namespace Modules\Meeting\Enums;

use App\Traits\RandomEnum;
use App\Traits\ReverseCases;

enum CoachStatusEnum: int
{
    use RandomEnum;
    use ReverseCases;

    case PENDING = 0;
    case ACCEPTED = 1;
    case REJECTED = 2;
    case ACTIVE = 3;
    case INACTIVE = 4;

}
