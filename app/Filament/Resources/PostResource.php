<?php

declare(strict_types=1);

namespace App\Filament\Resources;

use App\Filament\Resources\PostResource\Pages\CreatePost;
use App\Filament\Resources\PostResource\Pages\EditPost;
use App\Filament\Resources\PostResource\Pages\ListPosts;
use App\Models\Post;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Table;
use Filament\Tables\Filters\Filter;
use Illuminate\Database\Eloquent\Builder;

final class PostResource extends Resource
{
    protected static ?string $model = Post::class;
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public const int INPUT_MAX_LENGTH = 255;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('title')
                    ->required()
                    ->maxLength(self::INPUT_MAX_LENGTH),
                TextInput::make('slug')
                    ->required()
                    ->maxLength(self::INPUT_MAX_LENGTH)
                    ->unique(Post::class, 'slug', ignoreRecord: true),
                TextInput::make('legacy_id')
                    ->numeric(),
                Textarea::make('body')
                    ->required()
                    ->columnSpanFull(),
                Textarea::make('more_inside')
                    ->columnSpanFull(),
                TextInput::make('state')
                    ->required()
                    ->maxLength(self::INPUT_MAX_LENGTH),
                Select::make('subsite_id')
                    ->relationship('subsite', 'name')
                    ->required(),
                Select::make('user_id')
                    ->relationship('user', 'name')
                    ->searchable()
                    ->preload()
                    ->required(),
                TextInput::make('uuid')
                    ->label('UUID')
                    ->maxLength(36),
                DateTimePicker::make('published_at'),
                Toggle::make('is_published')
                    ->required(),
                Toggle::make('is_current')
                    ->required(),
                TextInput::make('publisher_type')
                    ->maxLength(self::INPUT_MAX_LENGTH),
                TextInput::make('publisher_id')
                    ->numeric(),
            ]);
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->withDrafts();
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title')
                    ->searchable()
                    ->sortable()
                    ->limit(50),
                TextColumn::make('slug')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                IconColumn::make('is_published')
                    ->boolean()
                    ->label('Published')
                    ->sortable(),
                TextColumn::make('state')
                    ->badge()
                    ->searchable()
                    ->sortable(),
                TextColumn::make('subsite.name')
                    ->label('Subsite')
                    ->sortable(),
                TextColumn::make('user.name')
                    ->label('Author')
                    ->sortable(),
                TextColumn::make('published_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Filter::make('hide_drafts')
                    ->label('Hide drafts')
                    ->baseQuery(fn(Builder $query): Builder => $query->withoutDrafts())
                    ->default(true),
            ])
            ->actions([
                EditAction::make(),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
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
            'index' => ListPosts::route('/'),
            'create' => CreatePost::route('/create'),
            'edit' => EditPost::route('/{record}/edit'),
        ];
    }
}
