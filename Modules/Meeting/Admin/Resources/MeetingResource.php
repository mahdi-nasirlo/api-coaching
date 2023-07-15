<?php

namespace Modules\Meeting\Admin\Resources;

use Ariaieboy\FilamentJalaliDatetime\JalaliDateTimeColumn;
use Ariaieboy\FilamentJalaliDatetimepicker\Forms\Components\JalaliDatePicker;
use Auth;
use Carbon\Carbon;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TimePicker;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Columns\TextColumn;
use Modules\Meeting\Admin\Resources\MeetingResource\Pages;
use Modules\Meeting\Admin\Resources\MeetingResource\RelationManagers;
use Modules\Meeting\Entities\Meeting;

class MeetingResource extends Resource
{
    protected static ?string $model = Meeting::class;

    protected static ?string $slug = 'meetings';

    protected static ?string $navigationIcon = 'heroicon-o-collection';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Card::make()
                    ->columns(2)
                    ->schema([
                        Select::make('coach_id')
                            ->searchable()
                            ->label('مربی')
                            ->default('تایید نشده')
                            ->relationship('coach', 'name'),
                        JalaliDatePicker::make('date')
                            ->label('تاریخ')
                            ->format('Y-m-D'),
                        TimePicker::make('start_time')
                            ->label('زمان شروع'),
                        TimePicker::make('end_time')
                            ->label('زمان پایان'),
                        Select::make('status')
                            ->label('وضعیت')
                            ->options([
                                '1' => 'رزور نشده',
                                '0' => 'رزرو شده',
                            ]),
                    ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('coach.name')
                    ->url(fn(Meeting $record): string => $record->coach?->id ? CoachResource::getUrl('view', $record->coach?->id) : "")
                    ->getStateUsing(fn(Meeting $record) => $record->coach->name ?? 'تایید نشده')
                    ->color('primary')
                    ->label('مربی'),
                JalaliDateTimeColumn::make('date')
                    ->date()
                    ->sortable()
                    ->searchable()
                    ->label('تاریخ')
                    ->date(),
                TextColumn::make('start_time')
                    ->sortable()
                    ->label('زمان جلسه')
                    ->getStateUsing(fn(Meeting $record) => Carbon::parse($record->start_time)->format('H:i') . "-" . Carbon::parse($record->end_time)->format("H:i")),
                BadgeColumn::make('status')
                    ->label('وضعیت')
                    ->enum([
                        '1' => 'رزور نشده',
                        '0' => 'رزرو شده',
                    ]),
            ])
            ->defaultSort('date')
            ->bulkActions([])
            ->actions([
                ViewAction::make()
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListMeetings::route('/'),
            'create' => Pages\CreateMeeting::route('/create'),
            'edit' => Pages\EditMeeting::route('/{record}/edit'),
            'view' => Pages\ViewMeeting::route('/{record}/view'),
        ];
    }
}
