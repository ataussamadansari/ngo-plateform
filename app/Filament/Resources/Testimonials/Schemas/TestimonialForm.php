<?php

namespace App\Filament\Resources\Testimonials\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class TestimonialForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Testimonial Particulars')
                    ->description('Beneficiary, donor, or volunteer quotes and impact feedback.')
                    ->schema([
                        TextInput::make('name')
                            ->label('Person Name')
                            ->required()
                            ->maxLength(150),
                        TextInput::make('role')
                            ->label('Role / Relation to NGO')
                            ->placeholder('e.g. Beneficiary, Parent, Community Member, Donor, Volunteer')
                            ->maxLength(100),
                        Select::make('rating')
                            ->label('Star Rating')
                            ->options([
                                5 => '⭐⭐⭐⭐⭐ (5 Stars)',
                                4 => '⭐⭐⭐⭐ (4 Stars)',
                                3 => '⭐⭐⭐ (3 Stars)',
                                2 => '⭐⭐ (2 Stars)',
                                1 => '⭐ (1 Star)',
                            ])
                            ->default(5)
                            ->required(),
                        TextInput::make('sort_order')
                            ->label('Display Order')
                            ->numeric()
                            ->default(0),
                        Toggle::make('is_active')
                            ->label('Published on Public Website')
                            ->default(true),
                        FileUpload::make('avatar')
                            ->label('Profile Photo / Avatar')
                            ->disk('public')
                            ->directory('testimonials/avatars')
                            ->image()
                            ->maxSize(2048)
                            ->dehydrated(fn ($state) => filled($state)),
                        Textarea::make('quote')
                            ->label('Testimonial / Quote')
                            ->placeholder('Share their personal story or feedback on the NGO impact...')
                            ->required()
                            ->rows(4)
                            ->columnSpanFull(),
                    ])->columns(2),
            ]);
    }
}
