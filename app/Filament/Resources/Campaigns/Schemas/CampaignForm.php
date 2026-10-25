<?php

namespace App\Filament\Resources\Campaigns\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

class CampaignForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Campaign Essentials')
                    ->schema([
                        TextInput::make('title')
                            ->label('Campaign Title')
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
                        Select::make('category_id')
                            ->relationship('category', 'name')
                            ->searchable()
                            ->preload()
                            ->required()
                            ->label('Cause Category'),
                        TextInput::make('goal_amount')
                            ->label('Funding Target Goal')
                            ->numeric()
                            ->prefix('₹')
                            ->minValue(1)
                            ->required(),
                        Select::make('status')
                            ->options([
                                'draft' => 'Draft (Hidden)',
                                'active' => 'Active (Accepting Donations)',
                                'completed' => 'Completed / Goal Reached',
                                'paused' => 'Paused',
                            ])
                            ->default('active')
                            ->required(),
                        DatePicker::make('start_date')
                            ->label('Campaign Launch Date')
                            ->default(now())
                            ->required(),
                        DatePicker::make('end_date')
                            ->label('Target Deadline Date'),
                        Toggle::make('is_urgent')
                            ->label('Mark as Urgent Cause')
                            ->default(false),
                        Toggle::make('is_featured')
                            ->label('Featured on Homepage')
                            ->default(false),
                    ])->columns(2),

                Section::make('Story & Media')
                    ->schema([
                        Textarea::make('short_description')
                            ->label('Brief Summary Tagline')
                            ->helperText('Appears on campaign cards and directory listings.')
                            ->rows(2)
                            ->maxLength(500)
                            ->required()
                            ->columnSpanFull(),
                        RichEditor::make('full_story')
                            ->label('Detailed Cause Story')
                            ->helperText('Full narrative of the situation, emergency, and expected ground impact.')
                            ->required()
                            ->columnSpanFull(),
                        FileUpload::make('thumbnail_image')
                            ->label('Main Banner / Card Thumbnail')
                            ->disk('public')
                            ->directory('campaigns/thumbnails')
                            ->image()
                            ->maxSize(2048)
                            ->required(fn (string $operation): bool => $operation === 'create')
                            ->dehydrated(fn ($state) => filled($state)),
                        FileUpload::make('gallery_images')
                            ->label('Photo Gallery / Impact Proof')
                            ->disk('public')
                            ->directory('campaigns/galleries')
                            ->multiple()
                            ->image()
                            ->maxSize(2048),
                    ])->columns(2),
            ]);
    }
}
