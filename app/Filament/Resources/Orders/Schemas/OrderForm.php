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
                    ->description('Detail pesanan dan status transaksi')
                    ->components([
                        Grid::make(['default' => 1, 'md' => 2])
                            ->components([
                                TextInput::make('order_number')
                                    ->label('Nomor Pesanan')
                                    ->helperText('Nomor unik transaksi.')
                                    ->disabled(),

                                TextInput::make('total_amount')
                                    ->label('Total Pembayaran')
                                    ->prefix('Rp')
                                    ->numeric()
                                    ->helperText('Nominal yang harus dibayar pembeli.')
                                    ->disabled(),
                            ]),

                        Select::make('product_id')
                            ->label('Produk / Akun Game')
                            ->relationship('product', 'title')
                            ->helperText('Akun game yang dipesan oleh pembeli.')
                            ->disabled(),

                        Grid::make(['default' => 1, 'md' => 2])
                            ->components([
                                Select::make('payment_status')
                                    ->label('Status Pembayaran')
                                    ->options([
                                        'pending' => 'Pending (Menunggu Pembayaran)',
                                        'paid' => 'Paid (Lunas)',
                                        'failed' => 'Failed (Gagal)',
                                        'expired' => 'Expired (Kedaluwarsa)',
                                    ])
                                    ->helperText('Pilih "Paid" jika uang transfer sudah masuk.')
                                    ->required(),

                                Select::make('order_status')
                                    ->label('Status Pesanan')
                                    ->options([
                                        'pending' => 'Pending',
                                        'processing' => 'Processing (Diproses)',
                                        'completed' => 'Completed (Selesai)',
                                        'cancelled' => 'Cancelled (Dibatalkan)',
                                    ])
                                    ->helperText('Pilih "Completed" jika data akun sudah diserahkan ke pembeli.')
                                    ->required(),
                            ]),
                    ]),

                Section::make('Data Pembeli')
                    ->description('Kontak pembeli untuk konfirmasi & penyerahan akun')
                    ->components([
                        Grid::make(['default' => 1, 'sm' => 2, 'lg' => 3])
                            ->components([
                                TextInput::make('buyer_name')
                                    ->label('Nama Pembeli')
                                    ->placeholder('Nama pembeli')
                                    ->required(),

                                TextInput::make('buyer_email')
                                    ->label('Email')
                                    ->placeholder('contoh@email.com')
                                    ->email()
                                    ->required(),

                                TextInput::make('buyer_phone')
                                    ->label('Nomor WhatsApp')
                                    ->placeholder('08xxxxxxxxxx')
                                    ->helperText('Nomor WA aktif untuk kirim data akun.')
                                    ->required(),
                            ]),

                        Textarea::make('notes')
                            ->label('Catatan Pesanan')
                            ->placeholder('Catatan pembeli atau catatan khusus admin...')
                            ->rows(3),
                    ]),
            ]);
    }
}
