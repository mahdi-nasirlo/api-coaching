<?php

namespace App\Filament\Resources\Meeting;


use App\Filament\App\Resources\Meeting;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Modules\Meeting\Entities\Coach;
use Modules\Meeting\Enums\CoachStatusEnum;

class CoachResource extends Resource
{
    protected static ?string $model = Coach::class;

    protected static ?string $navigationIcon = 'heroicon-o-academic-cap';

    protected static ?string $slug = '/coach';

    protected static ?string $recordTitleAttribute = 'date';

    protected static ?string $navigationGroup = "Meeting";

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make()
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

                TextColumn::make('status')
                    ->badge()
                    ->label('وضعیت')
//                    ->enum(CoachStatusEnum::reverseCasesWithLang())
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
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->emptyStateActions([
                Tables\Actions\CreateAction::make(),
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
            'index' => \App\Filament\Resources\Meeting\CoachResource\Pages\ListCoaches::route('/'),
            'create' => \App\Filament\Resources\Meeting\CoachResource\Pages\CreateCoach::route('/create'),
            'edit' => \App\Filament\Resources\Meeting\CoachResource\Pages\EditCoach::route('/{record}/edit'),
            'meeting' => \App\Filament\Resources\Meeting\CoachResource\Pages\CalenderCoach::route('/{record}/meet')
        ];
    }
}
