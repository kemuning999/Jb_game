<?php

namespace App\Filament\Resources\Users\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class UserForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Informasi Pengguna')
                    ->components([
                        Grid::make(2)
                            ->components([
                                TextInput::make('name')
                                    ->label('Nama Lengkap')
                                    ->required()
                                    ->maxLength(255),

                                TextInput::make('email')
                                    ->label('Alamat Email')
                                    ->email()
                                    ->required()
                                    ->unique(ignoreRecord: true),
                            ]),

                        Grid::make(2)
                            ->components([
                                TextInput::make('phone')
                                    ->label('Nomor WhatsApp')
                                    ->tel()
                                    ->maxLength(20),

                                Select::make('role')
                                    ->label('Hak Akses (Role)')
                                    ->options([
                                        'customer' => 'Customer (Pembeli)',
                                        'admin' => 'Administrator',
                                    ])
                                    ->default('customer')
                                    ->required(),
                            ]),

                        TextInput::make('password')
                            ->label('Password')
                            ->password()
                            ->dehydrated(fn ($state) => filled($state))
                            ->required(fn (string $operation): bool => $operation === 'create'),
                    ]),
            ]);
    }
}
