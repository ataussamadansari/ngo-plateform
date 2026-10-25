<?php

namespace App\Filament\Resources\Events\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\TimePicker;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

class EventForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Event Essentials')
                    ->description('Primary event title, schedule, capacity and public status.')
                    ->schema([
                        TextInput::make('title')
                            ->label('Event Title')
                            ->required()
                            ->maxLength(255)
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
                            ->maxLength(255),
                        DatePicker::make('event_date')
                            ->label('Event Date')
                            ->required(),
                        TimePicker::make('start_time')
                            ->label('Start Time')
                            ->required(),
                        TimePicker::make('end_time')
                            ->label('End Time')
                            ->required(),
                        TextInput::make('max_participants')
                            ->label('Capacity / Max Attendees')
                            ->numeric()
                            ->minValue(1)
                            ->placeholder('e.g. 100'),
                        Select::make('status')
                            ->label('Event Status')
                            ->options([
                                'upcoming' => 'Upcoming',
                                'ongoing' => 'Ongoing',
                                'completed' => 'Completed',
                                'cancelled' => 'Cancelled',
                            ])
                            ->default('upcoming')
                            ->required(),
                        FileUpload::make('banner_image')
                            ->label('Event Banner Image')
                            ->disk('public')
                            ->directory('events/banners')
                            ->image()
                            ->maxSize(2048)
                            ->required(fn (string $operation): bool => $operation === 'create')
                            ->dehydrated(fn ($state) => filled($state)),
                    ])->columns(2),

                Section::make('Venue & Location')
                    ->description('Physical location coordinates and street address.')
                    ->schema([
                        TextInput::make('location_name')
                            ->label('Venue / Hall Name')
                            ->placeholder('e.g. Community Center Hall, Ward 12')
                            ->required()
                            ->maxLength(255),
                        TextInput::make('address')
                            ->label('Street Address')
                            ->placeholder('e.g. Near Old Shiva Temple, Assi Ghat Road, Varanasi')
                            ->required()
                            ->maxLength(255),
                        TextInput::make('google_map_link')
                            ->label('Google Maps Link')
                            ->url()
                            ->placeholder('https://maps.google.com/?q=25.2819,82.9995')
                            ->columnSpanFull(),
                    ])->columns(2),

                Section::make('Event Description')
                    ->description('Detailed overview of event schedule, volunteer roles, and purpose.')
                    ->schema([
                        Textarea::make('description')
                            ->label('Description & Schedule')
                            ->rows(5)
                            ->required()
                            ->columnSpanFull(),
                    ]),
            ]);
    }
}
