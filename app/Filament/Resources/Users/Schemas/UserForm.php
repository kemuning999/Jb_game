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
                    ->description('Kelola data akun pembeli atau akun admin toko')
                    ->components([
                        Grid::make(['default' => 1, 'md' => 2])
                            ->components([
                                TextInput::make('name')
                                    ->label('Nama Lengkap')
                                    ->placeholder('Nama lengkap pengguna')
                                    ->required()
                                    ->maxLength(255),

                                TextInput::make('email')
                                    ->label('Alamat Email')
                                    ->placeholder('user@email.com')
                                    ->helperText('Digunakan untuk login ke website.')
                                    ->email()
                                    ->required()
                                    ->unique(ignoreRecord: true),
                            ]),

                        Grid::make(['default' => 1, 'md' => 2])
                            ->components([
                                TextInput::make('phone')
                                    ->label('Nomor WhatsApp')
                                    ->placeholder('08xxxxxxxxxx')
                                    ->helperText('Nomor WA aktif untuk konfirmasi & transaksi.')
                                    ->tel()
                                    ->maxLength(20),

                                Select::make('role')
                                    ->label('Hak Akses (Role)')
                                    ->options([
                                        'customer' => 'Customer (Pembeli)',
                                        'admin' => 'Administrator',
                                    ])
                                    ->helperText('Admin: Akses penuh ke panel ini. Customer: Hanya belanja.')
                                    ->default('customer')
                                    ->required(),
                            ]),

                        TextInput::make('password')
                            ->label('Password')
                            ->placeholder('Masukkan password baru...')
                            ->helperText('Kosongkan jika tidak ingin mengubah password.')
                            ->password()
                            ->dehydrated(fn ($state) => filled($state))
                            ->required(fn (string $operation): bool => $operation === 'create'),
                    ]),
            ]);
    }
}
