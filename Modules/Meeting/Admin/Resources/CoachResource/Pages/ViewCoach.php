<?php

namespace Modules\Meeting\Admin\Resources\CoachResource\Pages;

use Filament\Pages\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;
use Modules\Meeting\Admin\Resources\CoachResource;
use Modules\Meeting\Entities\CoachInfo;

class ViewCoach extends ViewRecord
{
    protected static string $resource = CoachResource::class;

    protected function mutateFormDataBeforeFill(array $data): array
    {
        $coachInfo = CoachInfo::find($data['info_id'])->toArray();

        return array_merge($data, $coachInfo);
    }

    protected function getActions(): array
    {
        return [
            EditAction::make()
                ->label('تعیین وضعیت')
        ];
    }
}
