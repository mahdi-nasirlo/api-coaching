<?php

namespace Modules\Blog\Admin\Resources;

use Ariaieboy\FilamentJalaliDatetime\JalaliDateTimeColumn;
use Ariaieboy\FilamentJalaliDatetimepicker\Forms\Components\JalaliDatePicker;
use Filament\Forms;
use Filament\Forms\Components\SpatieTagsInput;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Modules\Blog\Admin\Resources\PostResource\Pages;
use Modules\Blog\Entities\BlogCategory;
use Modules\Blog\Entities\Post;
use Mohamedsabil83\FilamentFormsTinyeditor\Components\TinyEditor;
use Morilog\Jalali\Jalalian;

class PostResource extends Resource
{
    public static ?string $slug = 'blog/posts';
    protected static ?string $model = Post::class;
    protected static ?string $recordTitleAttribute = 'title';

    protected static ?string $navigationGroup = 'بلاگ';

    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    // protected static ?int $navigationSort = 0;

    // protected static ?string $inverseRelationship = 'section';

    public static function getModelLabel(): string
    {
        return "مقاله";
    }

    public static function getPluralModelLabel(): string
    {
        return "مقالات";
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('image')
                    ->label('عکس شاخص'),

                Tables\Columns\TextColumn::make('title')
                    ->label("عنوان")
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('view')
                    ->label("بازدید")
                    ->sortable(),
                Tables\Columns\TextColumn::make('slug')
                    ->label("نامک")
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('user.name')
                    ->label("نویسنده")
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('category.name')
                    ->label("دسته بندی")
                    ->searchable()
                    ->sortable(),
                JalaliDateTimeColumn::make('published_at')->date()
                    ->sortable()
                    ->label("تاریخ انتشار")
                    ->date(),
                JalaliDateTimeColumn::make('created_at')->date()
                    ->sortable()
                    ->label("تاریخ ثبت")
                    ->date(),
            ])
            ->filters([
                Tables\Filters\Filter::make('published_at')
                    ->form([
                        JalaliDatePicker::make('published_from')
                            ->label("منتشر شده از")
                            ->placeholder(fn($state): string => Jalalian::now()->format("d M, Y")),
                        JalaliDatePicker::make('published_until')
                            ->label("منتشر شده_تا")
                            ->placeholder(fn($state): string => Jalalian::now()->format("d M, Y")),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['published_from'],
                                fn(Builder $query, $date): Builder => $query->whereDate('published_at', '>=', $date),
                            )
                            ->when(
                                $data['published_until'],
                                fn(Builder $query, $date): Builder => $query->whereDate('published_at', '<=', $date),
                            );
                    }),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Card::make()
                    ->schema([
                        Forms\Components\TextInput::make('title')
                            ->label("عنوان")
                            ->required()
                            ->reactive()
                            ->afterStateUpdated(fn($state, callable $set) => $set('slug', $state == null ? "" : $state)),
                        Forms\Components\TextInput::make('slug')
                            ->label("نامک (URL)")
                            ->disabled()
                            ->required()
                            ->unique(Post::class, 'slug', fn($record) => $record),

                        Forms\Components\TextInput::make('read_time')
                            ->label("زمان مطالعه")
                            ->numeric()
                            ->rule('min:1')
                            ->required(),
                        // ->gt('zero'),

                        Forms\Components\Select::make('blog_category_id')
                            ->preload()
                            ->label("دسته بندی")
                            ->options(function (callable $get) {
                                return BlogCategory::all()->pluck("name", "id")->toArray();
                            })
                            ->relationship("category", "name")
                            ->createOptionForm([
                                Forms\Components\Grid::make()
                                    ->schema([
                                        Forms\Components\TextInput::make('name')
                                            ->label('عنوان')
                                            ->required()
                                            ->reactive()
                                            ->afterStateUpdated(fn($state, callable $set) => $set('slug', SlugService::createSlug(BlogCategory::class, 'slug', $state == null ? "" : $state))),
                                        Forms\Components\TextInput::make('slug')
                                            ->label('نامک')
                                            ->disabled()
                                            ->required()
                                            ->unique(BlogCategory::class, 'slug', fn($record) => $record),
                                    ]),
                                Forms\Components\Select::make('parent_id')
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
                            ->searchable()
                            ->required(),
                        JalaliDatePicker::make('published_at')
                            ->label('تاریخ انتشار')
                            ->default(now())
                            ->required(),
                        SpatieTagsInput::make('tags')
                            ->hint("تاثیرگذار در سئو")
                            ->label('تگ ها')
                            ->required(),
                        TinyEditor::make('content')
                            ->label("محتوا")
                            ->required()
                            ->columnSpan([
                                'sm' => 2,
                            ]),
                    ])
                    ->columns([
                        'sm' => 2,
                    ])
                    ->columnSpan([
                        'sm' => 2,
                    ]),
                Forms\Components\Card::make()
                    ->schema([

                        Forms\Components\FileUpload::make('image')
                            ->required()
                            ->label('عکس شاخص')
                            ->image(),
//                        SEO::make(),

                        Forms\Components\Placeholder::make('created_at')
                            ->label('ساخته شده :')
                            ->content(fn(?Post $record): string => $record ? $record->created_at->diffForHumans() : '-'),
                        Forms\Components\Placeholder::make('updated_at')
                            ->label('بروزرسانی شده:')
                            ->content(fn(?Post $record): string => $record ? $record->updated_at->diffForHumans() : '-'),
                    ])
                    ->columnSpan(1),
            ])
            ->columns([
                'md' => 3,
                'lg' => null,
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
            'index' => Pages\ListPosts::route('/'),
            'create' => Pages\CreatePost::route('/create'),
            'edit' => Pages\EditPost::route('/{record}/edit'),
        ];
    }
}
