<?php

namespace Modules\Meeting\Admin\Resources;

use Exception;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Builder;
use Modules\Meeting\Admin\Resources\CoachResource\Pages;
use Modules\Meeting\Entities\Coach;
use Modules\Meeting\Enums\CoachStatusEnum;

class CoachResource extends Resource
{
    protected static ?string $model = \Modules\Meeting\Entities\Coach::class;

    protected static ?string $navigationIcon = 'heroicon-o-collection';

    protected static ?string $slug = '/coach';

    public static function getEloquentQuery() : Builder
    {
        return parent::getEloquentQuery();
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Card::make()
                    ->columns(2)
                    ->schema([
                        TextInput::make('name')
                            ->disabled()
                            ->label('نام و نام خانوادگی'),
                        TextInput::make('user_name')
                            ->disabled()
                            ->label('نام کاربری'),
                        TextInput::make('hourly_price')
                            ->disabled()
                            ->label('هزینه هر ساعت مشاوره'),
                        Select::make('status')
                            ->hint("**قابل ویرایش**")
                            ->hintColor('primary')
                            ->hintIcon('heroicon-s-pencil')
                            ->label('وضعیت')
                            ->options(CoachStatusEnum::reverseCases())
                    ]),
                Section::make('اطلاعات تکمیلی')
                    ->label('اطلاعات تکمیلی')
                    ->schema([
                        Textarea::make('about_me')
                            ->disabled()
                            ->label('درباره من'),
                        Textarea::make('resume')
                            ->disabled()
                            ->label('رزومه'),
                        Textarea::make('job_experience')
                            ->disabled()
                            ->label('سوابق شغلی'),
                        Textarea::make('education_recorde')
                            ->disabled()
                            ->label('سوابق تحصیلی'),
                    ])
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

                TextColumn::make('user_name')
                    ->wrap()
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
                    }),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\Action::make('meet')
                    ->color('secondary')
                    ->label('جلسات')
                    ->url(fn(Coach $record): string => self::getUrl('meeting', $record)),
                Tables\Actions\ViewAction::make()
                    ->color('primary')
                    ->label('تغییر وضعیت')
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCoaches::route('/'),
            'create' => Pages\CreateCoach::route('/create'),
            'edit' => Pages\EditCoach::route('/{record}/edit'),
            'view' => Pages\ViewCoach::route('/{record}'),
            'meeting' => Pages\MeetingCoach::route('/{record}/meet')
        ];
    }
}
