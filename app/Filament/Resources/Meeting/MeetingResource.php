<?php

namespace App\Filament\Resources\Meeting;

use App\Filament\App\Resources\MeetingResource\Pages;
use App\Filament\App\Resources\MeetingResource\RelationManagers;
use App\Filament\Resources\Meeting\MeetingResource\Pages\CreateMeeting;
use App\Filament\Resources\Meeting\MeetingResource\Pages\EditMeeting;
use App\Filament\Resources\Meeting\MeetingResource\Pages\ListMeetings;
use Ariaieboy\FilamentJalaliDatetime\JalaliDateTimeColumn;
use Ariaieboy\FilamentJalaliDatetimepicker\Forms\Components\JalaliDatePicker;
use Carbon\Carbon;
use Carbon\CarbonInterval;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TimePicker;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Modules\Meeting\Entities\Meeting;

class MeetingResource extends Resource
{
    protected static ?string $model = Meeting::class;

    protected static ?string $slug = 'meetings';

    protected static ?string $navigationIcon = 'heroicon-m-phone-arrow-down-left';

    protected static ?string $recordTitleAttribute = 'date';

    protected static ?string $navigationGroup = 'Meeting';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make()
                    ->columns(2)
                    ->schema([
                        Select::make('coach_id')
                            ->required()
                            ->preload()
                            ->searchable()
//                            ->label('مربی')
                            ->relationship('coach', 'name'),
                        JalaliDatePicker::make('date')
//                            ->label('تاریخ')
                            ->after(now())
                            ->required()
                            ->format('Y-m-D'),
                        TimePicker::make('start_time')
                            ->required()
                            ->datalist(self::getDayTimesWith30Interval())
                            ->minutesStep(15)
                            ->seconds(false),
//                            ->label('زمان شروع'),
                        TimePicker::make('end_time')
                            ->required()
                            ->datalist(self::getDayTimesWith30Interval())
                            ->minutesStep(15)
                            ->seconds(false),
//                            ->label('زمان پایان'),
                        Select::make('status')
//                            ->label('وضعیت')
                            ->required()
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
//                    ->url(fn(Meeting $record): string => $record->coach?->id ? CoachResource::getUrl('view', $record->coach?->id) : "")
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
                TextColumn::make('status')
                    ->badge()
                    ->label('وضعیت')
                    ,
            ])
            ->defaultSort('date')
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

    public static function getDayTimesWith30Interval(): array
    {

        $start = Carbon::createFromTime(8, 0);
        $end = Carbon::createFromTime(23, 0);
        $interval = CarbonInterval::minutes(30);

        $times = [];

        while ($start <= $end) {
            $times[] = $start->format('H:i');
            $start->add($interval);
        }

        return $times;
    }

    public static function getPages(): array
    {
        return [
            'index' => ListMeetings::route('/'),
            'create' => CreateMeeting::route('/create'),
            'edit' => EditMeeting::route('/{record}/edit'),
        ];
    }
}
