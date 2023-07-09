<?php

namespace Modules\Meeting\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;
use Modules\Meeting\Enums\CoachStatusEnum;

class AcceptedCoachScope implements Scope
{
    public function apply(Builder $builder, Model $model): void
    {
        $builder->where('status', CoachStatusEnum::ACCEPT->value);
    }
}
