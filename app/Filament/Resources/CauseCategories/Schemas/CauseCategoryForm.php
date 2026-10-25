<?php

namespace App\Filament\Resources\CauseCategories\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

class CauseCategoryForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Category Information')
                    ->schema([
                        TextInput::make('name')
                            ->label('Category Name')
                            ->required()
                            ->maxLength(100)
                            ->live(onBlur: true)
                            ->afterStateUpdated(function (string $operation, ?string $state, Set $set) {
                                if ($operation === 'create') {
                                    $set('slug', Str::slug($state ?? ''));
                                }
                            }),
                        TextInput::make('slug')
                            ->label('URL Slug')
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->maxLength(120),
                        TextInput::make('icon')
                            ->label('Icon Identifier')
                            ->placeholder('e.g. heroicon-o-heart, fa-graduation-cap')
                            ->maxLength(100),
                        Toggle::make('is_active')
                            ->label('Active for Causes')
                            ->default(true),
                    ])->columns(2),
            ]);
    }
}
