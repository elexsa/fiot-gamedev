<?php

namespace App\Filament\Resources\Programs;

use App\Filament\Resources\Programs\Pages\ManagePrograms;
use App\Models\Program;
use BackedEnum;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class ProgramResource extends Resource
{
    protected static ?string $model = Program::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->label('Назва')
                    ->required()
                    ->live(onBlur: true)
                    ->afterStateUpdated(fn ($state, callable $set) => $set('slug', Str::slug($state))),
                TextInput::make('slug')
                    ->label('URL (slug)')
                    ->required()
                    ->unique(ignoreRecord: true),
                TextInput::make('specialty_code')
                    ->label('Спеціальність')
                    ->placeholder('121 «Інженерія програмного забезпечення»'),
                TextInput::make('degree')
                    ->label('Ступінь')
                    ->placeholder('Бакалавр'),
                Textarea::make('description')
                    ->label('Опис')
                    ->columnSpanFull(),
                FileUpload::make('image')
                    ->label('Зображення')
                    ->image()
                    ->directory('programs')
                    ->disk('public')
                    ->visibility('public'),
                Toggle::make('is_published')
                    ->label('Опубліковано')
                    ->default(true),
                TextInput::make('sort_order')
                    ->label('Порядок')
                    ->numeric()
                    ->default(0),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label('Назва')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('specialty_code')
                    ->label('Спеціальність'),
                TextColumn::make('degree')
                    ->label('Ступінь')
                    ->badge(),
                TextColumn::make('disciplines_count')
                    ->counts('disciplines')
                    ->label('Дисциплін'),
                IconColumn::make('is_published')
                    ->label('Опубліковано')
                    ->boolean(),
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
            'index' => ManagePrograms::route('/'),
        ];
    }
}
