<?php

namespace Modules\Meeting\Admin\Resources;

use App\Models\Coach;
use Exception;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Builder;
use Modules\Meeting\Admin\Resources\CoachResource\Pages;
use Modules\Meeting\Enums\CoachStatusEnum;

class CoachResource extends Resource
{
    protected static ?string $model = \Modules\Meeting\Entities\Coach::class;

    protected static ?string $navigationIcon = 'heroicon-o-collection';

    protected static ?string $slug = '/coach';

    public static function getEloquentQuery() : Builder
    {
        return parent::getEloquentQuery()->withoutGlobalScopes();
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
            ]);
    }

    /**
     * @throws Exception
     */
    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('avatar')
                    ->circular()
                    ->label('پروفایل'),

                TextColumn::make('name')
                    ->label('نام'),

                TextColumn::make('user.name')
                    ->label('نام کاربری'),

                TextColumn::make('category.name')
                    ->label('حوزه فعالیت'),

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
                Tables\Actions\ViewAction::make()
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
            'view' => Pages\ViewCoach::route('/{record}/view'),
        ];
    }
}
