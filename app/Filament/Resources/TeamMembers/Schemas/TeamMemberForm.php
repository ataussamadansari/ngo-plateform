<?php

namespace App\Filament\Resources\TeamMembers\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\KeyValue;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class TeamMemberForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Profile Information')
                    ->description('Details of trustees, directors, advisors, and core operations leaders.')
                    ->schema([
                        TextInput::make('name')
                            ->label('Full Name')
                            ->required()
                            ->maxLength(150),
                        TextInput::make('role')
                            ->label('Role / Title')
                            ->placeholder('e.g. Founder & Executive Director, Head of Medical Relief')
                            ->required()
                            ->maxLength(100),
                        TextInput::make('sort_order')
                            ->label('Sort / Display Order')
                            ->numeric()
                            ->default(0),
                        Toggle::make('is_active')
                            ->label('Show on About Us Page')
                            ->default(true),
                        FileUpload::make('photo')
                            ->label('Profile Photograph')
                            ->disk('public')
                            ->directory('team/members')
                            ->image()
                            ->maxSize(2048)
                            ->dehydrated(fn ($state) => filled($state)),
                        Textarea::make('bio')
                            ->label('Brief Biography / Background')
                            ->rows(3)
                            ->placeholder('Summary of achievements, background and dedication to social service...')
                            ->columnSpanFull(),
                        KeyValue::make('social_links')
                            ->label('Social Profiles')
                            ->keyLabel('Platform (e.g. linkedin, twitter)')
                            ->valueLabel('Profile URL')
                            ->columnSpanFull(),
                    ])->columns(2),
            ]);
    }
}
