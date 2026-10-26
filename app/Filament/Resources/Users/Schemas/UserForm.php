<?php

namespace App\Filament\Resources\Users\Schemas;

use App\Models\User;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Illuminate\Support\Facades\Hash;

class UserForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('User Account Particulars')
                    ->description('Administrative staff credentials, role-based access permissions, and account status.')
                    ->schema([
                        TextInput::make('name')
                            ->label('Full Name')
                            ->required()
                            ->maxLength(255),

                        TextInput::make('email')
                            ->label('Email Address')
                            ->email()
                            ->required()
                            ->unique(User::class, 'email', ignoreRecord: true)
                            ->maxLength(255),

                        TextInput::make('phone')
                            ->label('Contact Phone')
                            ->tel()
                            ->maxLength(20),

                        Select::make('role')
                            ->label('Administrative Role')
                            ->options([
                                'super_admin' => 'Super Administrator (Full System & Financial Authority)',
                                'manager' => 'Program Manager / Staff (Operational & Campaign Access)',
                            ])
                            ->default('manager')
                            ->required(),

                        TextInput::make('password')
                            ->label('Account Password')
                            ->password()
                            ->revealable()
                            ->required(fn (string $operation): bool => $operation === 'create')
                            ->dehydrated(fn (?string $state): bool => filled($state))
                            ->dehydrateStateUsing(fn (string $state): string => Hash::make($state))
                            ->helperText('Leave empty during editing to keep the existing password intact.'),

                        Toggle::make('is_active')
                            ->label('Active Account (Permit Admin Panel Access)')
                            ->default(true)
                            ->helperText('When disabled, user will be immediately blocked from signing into the admin panel.'),
                    ])
                    ->columns(2),
            ]);
    }
}
