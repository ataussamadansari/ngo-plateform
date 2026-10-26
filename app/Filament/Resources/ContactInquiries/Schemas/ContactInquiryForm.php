<?php

namespace App\Filament\Resources\ContactInquiries\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class ContactInquiryForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Visitor Details')
                    ->description('Contact particulars submitted via the public contact form.')
                    ->schema([
                        TextInput::make('name')
                            ->label('Sender Name')
                            ->disabled(),
                        TextInput::make('email')
                            ->label('Email Address')
                            ->disabled(),
                        TextInput::make('phone')
                            ->label('Phone Number')
                            ->disabled(),
                        Select::make('status')
                            ->label('Status')
                            ->options([
                                'pending' => 'Pending Review',
                                'read' => 'Read',
                                'replied' => 'Replied',
                            ])
                            ->required(),
                    ])->columns(2),

                Section::make('Message Particulars')
                    ->schema([
                        TextInput::make('subject')
                            ->label('Subject')
                            ->disabled()
                            ->columnSpanFull(),
                        Textarea::make('message')
                            ->label('Message Body')
                            ->rows(6)
                            ->disabled()
                            ->columnSpanFull(),
                    ]),
            ]);
    }
}
