<?php

namespace Modules\Meeting\Admin\Resources;

use App\Models\Coach;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Columns\TextColumn;
use Modules\Food\Enums\FoodStatusEnum;
use Modules\Meeting\Admin\Resources\CoachResource\Pages;
use Modules\Meeting\Admin\Resources\CoachResource\RelationManagers;
use Modules\Meeting\Enums\CoachStatusEnum;

class CoachResource extends Resource
{
    protected static ?string $model = \Modules\Meeting\Entities\Coach::class;

    protected static ?string $navigationIcon = 'heroicon-o-collection';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label('نام'),
                TextColumn::make('user.name'),
                TextColumn::make('hourly_price')
                    ->formatStateUsing(fn($state) => number_format($state) . ' تومان ')
                    ->label('هزینه هر ساعت مشاوره'),
                BadgeColumn::make('status')
                    ->label('وضعیت')
                    ->enum(CoachStatusEnum::reverseCasesWithLang())
                    ->color(function ($record): string {

                        return match ($record->status) {
                            CoachStatusEnum::PENDING => 'secondary',
                            CoachStatusEnum::ACCEPTED => 'success',
                            CoachStatusEnum::REJECTED => 'danger',
                            default => 'primary',
                        };
                    })
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCoaches::route('/'),
            'create' => Pages\CreateCoach::route('/create'),
            'edit' => Pages\EditCoach::route('/{record}/edit'),
        ];
    }
}
