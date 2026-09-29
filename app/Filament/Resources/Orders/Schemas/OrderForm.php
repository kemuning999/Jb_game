<?php

namespace App\Filament\Resources\Orders\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class OrderForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Informasi Transaksi')
                    ->components([
                        Grid::make(2)
                            ->components([
                                TextInput::make('order_number')
                                    ->label('Nomor Pesanan')
                                    ->disabled(),

                                TextInput::make('total_amount')
                                    ->label('Total Pembayaran')
                                    ->prefix('Rp')
                                    ->numeric()
                                    ->disabled(),
                            ]),

                        Select::make('product_id')
                            ->label('Produk / Akun Game')
                            ->relationship('product', 'title')
                            ->disabled(),

                        Grid::make(2)
                            ->components([
                                Select::make('payment_status')
                                    ->label('Status Pembayaran')
                                    ->options([
                                        'pending' => 'Pending (Menunggu Pembayaran)',
                                        'paid' => 'Paid (Lunas)',
                                        'failed' => 'Failed (Gagal)',
                                        'expired' => 'Expired (Kedaluwarsa)',
                                    ])
                                    ->required(),

                                Select::make('order_status')
                                    ->label('Status Pesanan')
                                    ->options([
                                        'pending' => 'Pending',
                                        'processing' => 'Processing (Diproses)',
                                        'completed' => 'Completed (Selesai)',
                                        'cancelled' => 'Cancelled (Dibatalkan)',
                                    ])
                                    ->required(),
                            ]),
                    ]),

                Section::make('Data Pembeli')
                    ->components([
                        Grid::make(3)
                            ->components([
                                TextInput::make('buyer_name')
                                    ->label('Nama Pembeli')
                                    ->required(),

                                TextInput::make('buyer_email')
                                    ->label('Email')
                                    ->email()
                                    ->required(),

                                TextInput::make('buyer_phone')
                                    ->label('Nomor WhatsApp')
                                    ->required(),
                            ]),

                        Textarea::make('notes')
                            ->label('Catatan Pesanan')
                            ->rows(2),
                    ]),
            ]);
    }
}
