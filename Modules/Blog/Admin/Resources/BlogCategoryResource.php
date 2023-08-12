<?php

namespace Modules\Blog\Admin\Resources;

use Ariaieboy\FilamentJalaliDatetime\JalaliDateTimeColumn;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Tables\Columns\IconColumn;
use Illuminate\Database\Eloquent\Builder;
use Modules\Blog\Admin\Resources\BlogCategoryResource\Pages;
use Modules\Blog\Entities\BlogCategory;
use Mohamedsabil83\FilamentFormsTinyeditor\Components\TinyEditor;

class BlogCategoryResource extends Resource
{
    protected static ?string $model = BlogCategory::class;

    protected static ?string $slug = 'shop/categories';

    protected static ?string $recordTitleAttribute = 'name';

    protected static ?string $navigationGroup = 'بلاگ';

    protected static ?string $navigationIcon = 'heroicon-o-collection';

    protected static ?int $navigationSort = 6;

    public static function getModelLabel(): string
    {
        return "دسته بندی بلاگ";
    }

    public static function getPluralModelLabel(): string
    {
        return "دسته بندی های بلاگ";
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Card::make()
                    ->schema([
                        Forms\Components\Grid::make()
                            ->schema([
                                Forms\Components\TextInput::make('name')
                                    ->label('عنوان')
                                    ->required()
                                    ->reactive()
                                    ->afterStateUpdated(fn($state, callable $set) => $set('slug', $state == null ? "" : $state)),
                                Forms\Components\TextInput::make('slug')
                                    ->label('نامک')
                                    ->disabled()
                                    ->required()
                                    ->unique(BlogCategory::class, 'slug', fn($record) => $record),
                            ])
                            ->columnSpan([
                                'sm' => 2,
                            ]),
                        Forms\Components\Select::make('parent_id')
                            ->columnSpan([
                                'sm' => 2,
                            ])
                            ->searchable()
                            ->preload()
                            ->label('دسته بندی پدر')
                            ->relationship('parent', 'name', fn(Builder $query, ?BlogCategory $record) => $query->whereNot('id', $record ? $record->id : null)),
                        Forms\Components\Toggle::make('is_visible')
                            ->label('قابل نمایش برای کاربران.')
                            ->onIcon('heroicon-s-eye')
                            ->offIcon('heroicon-s-eye-off')
                            ->default(true),
                        TinyEditor::make('description')
                            ->label("محتوا")
                            ->columnSpan([
                                'sm' => 2,
                            ]),
                    ])
                    ->columnSpan([
                        'sm' => 2,
                    ]),
                Forms\Components\Card::make()
                    ->schema([
                        Forms\Components\Placeholder::make('created_at')
                            ->label('ساخته شده :')
                            ->content(fn(?BlogCategory $record): string => $record ? $record->created_at->diffForHumans() : '-'),
                        Forms\Components\Placeholder::make('updated_at')
                            ->label('بروزرسانی شده:')
                            ->content(fn(?BlogCategory $record) => $record ? $record->updated_at->diffForHumans() : '-')
                    ])
                    ->columnSpan(1),
            ])
            ->columns([
                'sm' => 3,
                'lg' => null,
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('عنوان')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('parent.name')
                    ->label('دسته بندی اصلی')
                    ->searchable()
                    ->sortable(),
                IconColumn::make('is_visible')
                    ->boolean()
                    ->label('عمومی')
                    ->sortable(),
                JalaliDateTimeColumn::make('updated_at')->date()
                    ->label('بروزرسانی در')
                    ->date()
                    ->sortable(),
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
            'index' => Pages\ListBlogCategories::route('/'),
            'create' => Pages\CreateBlogCategory::route('/create'),
            'edit' => Pages\EditBlogCategory::route('/{record}/edit'),
        ];
    }
}
