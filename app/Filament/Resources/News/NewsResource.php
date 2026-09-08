<?php

namespace App\Filament\Resources\News;

use App\Filament\Resources\News\Pages\ManageNews;
use App\Models\News;
use BackedEnum;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class NewsResource extends Resource
{
    protected static ?string $model = News::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('title')
                    ->label('Заголовок')
                    ->required()
                    ->maxLength(255)
                    ->live(onBlur: true)
                    ->afterStateUpdated(fn ($state, callable $set) => $set('slug', Str::slug($state))),
                TextInput::make('slug')
                    ->label('URL (slug)')
                    ->required()
                    ->unique(ignoreRecord: true)
                    ->maxLength(255),
                TextInput::make('tag')
                    ->label('Тег')
                    ->default('Новина')
                    ->maxLength(50),
                Textarea::make('excerpt')
                    ->label('Короткий опис')
                    ->columnSpanFull(),
                RichEditor::make('body')
                    ->label('Текст новини')
                    ->required()
                    ->columnSpanFull()
                    ->toolbarButtons(['bold', 'italic', 'underline', 'link', 'bulletList', 'orderedList', 'undo', 'redo']),
                FileUpload::make('cover_image')
                    ->label('Обкладинка')
                    ->image()
                    ->directory('news')
                    ->disk('public')
                    ->maxSize(4096)
                    ->columnSpanFull(),
                Toggle::make('is_published')
                    ->label('Опубліковано')
                    ->default(true),
                DateTimePicker::make('published_at')
                    ->label('Дата публікації')
                    ->default(now()),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('cover_image')
                    ->label('Обкладинка')
                    ->disk('public')
                    ->circular(),
                TextColumn::make('title')
                    ->label('Заголовок')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('tag')
                    ->label('Тег')
                    ->badge(),
                IconColumn::make('is_published')
                    ->label('Опубліковано')
                    ->boolean(),
                TextColumn::make('published_at')
                    ->label('Дата')
                    ->dateTime('d.m.Y')
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => ManageNews::route('/'),
        ];
    }
}
