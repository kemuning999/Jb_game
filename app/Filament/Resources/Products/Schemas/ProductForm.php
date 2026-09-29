<?php

namespace App\Filament\Resources\Products\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Set;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

class ProductForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Informasi Akun Game')
                    ->description('Detail umum akun yang akan ditampilkan di etalase')
                    ->components([
                        Grid::make(2)
                            ->components([
                                Select::make('category_id')
                                    ->label('Game / Kategori')
                                    ->relationship('category', 'name')
                                    ->searchable()
                                    ->preload()
                                    ->required(),

                                Select::make('status')
                                    ->label('Status Akun')
                                    ->options([
                                        'available' => 'Tersedia',
                                        'sold' => 'Terjual (Sold Out)',
                                    ])
                                    ->default('available')
                                    ->required(),
                            ]),

                        TextInput::make('title')
                            ->label('Judul Produk / Akun')
                            ->placeholder('Contoh: Akun MLBB Mythic Glory Full Skin Collector')
                            ->required()
                            ->maxLength(255)
                            ->live(onBlur: true)
                            ->afterStateUpdated(fn (Set $set, ?string $state) => $set('slug', Str::slug($state ?? '') . '-' . Str::random(4))),

                        Grid::make(2)
                            ->components([
                                TextInput::make('slug')
                                    ->label('Slug URL')
                                    ->required()
                                    ->maxLength(255)
                                    ->unique(ignoreRecord: true),

                                TextInput::make('price')
                                    ->label('Harga Jual (Rp)')
                                    ->numeric()
                                    ->prefix('Rp')
                                    ->required(),
                            ]),

                        Textarea::make('short_description')
                            ->label('Ringkasan Singkat')
                            ->placeholder('Contoh: Level 120, Skin 150+, WR 70%, Siap Push Rank')
                            ->rows(2),

                        RichEditor::make('description')
                            ->label('Deskripsi Lengkap / Spesifikasi Akun')
                            ->placeholder('Jelaskan detail hero, skin, emblem, history rank, dll...'),
                    ]),

                Section::make('Tangkapan Layar & Gambar')
                    ->description('Foto bukti akun game untuk menarik pembeli')
                    ->components([
                        FileUpload::make('thumbnail')
                            ->label('Foto Utama (Thumbnail)')
                            ->image()
                            ->directory('products/thumbnails')
                            ->imageEditor()
                            ->required(),

                        FileUpload::make('images')
                            ->label('Galeri Screenshot Akun (Bisa pilih banyak)')
                            ->image()
                            ->multiple()
                            ->directory('products/gallery')
                            ->reorderable(),
                    ]),

                Section::make('Data Kredensial Akun Game (Sangat Rahasia)')
                    ->description('Data ini TIDAK AKAN PERNAH muncul di publik. Hanya otomatis diberikan kepada pembeli yang telah melunasi pembayaran.')
                    ->components([
                        Grid::make(2)
                            ->components([
                                TextInput::make('account_username')
                                    ->label('Username / ID / Email Akun')
                                    ->helperText('Hanya terlihat oleh pembeli sah setelah lunas'),

                                TextInput::make('account_password')
                                    ->label('Password Akun Game')
                                    ->helperText('Hanya terlihat oleh pembeli sah setelah lunas'),
                            ]),

                        Textarea::make('account_additional_info')
                            ->label('Informasi Tambahan / Panduan Bind Akun')
                            ->placeholder('Contoh: Akun login via Moonton ID. Email pemulihan dan nomor HP belum terkait (Clean Bind). Hubungi WA admin jika butuh kode OTP perubahan email.')
                            ->rows(3),
                    ]),
            ]);
    }
}
