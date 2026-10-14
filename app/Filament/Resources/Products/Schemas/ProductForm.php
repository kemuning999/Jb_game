<?php

namespace App\Filament\Resources\Products\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
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
                    ->description('Detail umum akun yang akan ditampilkan di etalase toko')
                    ->components([
                        Grid::make(['default' => 1, 'md' => 2])
                            ->components([
                                Select::make('category_id')
                                    ->label('Game / Kategori')
                                    ->relationship('category', 'name')
                                    ->searchable()
                                    ->preload()
                                    ->helperText('Pilih jenis game dari akun ini (MLBB, FF, dll).')
                                    ->required(),

                                Select::make('status')
                                    ->label('Status Akun')
                                    ->options([
                                        'available' => 'Tersedia (Bisa Dibeli)',
                                        'sold' => 'Terjual (Habis / Sold Out)',
                                    ])
                                    ->default('available')
                                    ->helperText('Pilih Tersedia agar langsung tampil di web.')
                                    ->required(),
                            ]),

                        TextInput::make('title')
                            ->label('Judul Produk / Akun Game')
                            ->placeholder('Contoh: Akun MLBB Mythic Glory Full Skin Collector')
                            ->helperText('Beri judul yang menarik agar cepat laku.')
                            ->required()
                            ->maxLength(255)
                            ->live(onBlur: true)
                            ->afterStateUpdated(fn ($set, ?string $state) => $set('slug', Str::slug($state ?? '') . '-' . Str::random(4))),

                        Grid::make(['default' => 1, 'md' => 2])
                            ->components([
                                TextInput::make('slug')
                                    ->label('Link URL (Slug)')
                                    ->helperText('Otomatis dibuat dari judul akun.')
                                    ->required()
                                    ->maxLength(255)
                                    ->unique(ignoreRecord: true),

                                TextInput::make('price')
                                    ->label('Harga Jual (Rp)')
                                    ->numeric()
                                    ->prefix('Rp')
                                    ->minValue(1000)
                                    ->placeholder('Contoh: 50000')
                                    ->helperText('Ketik angka saja tanpa titik (min Rp 1.000).')
                                    ->required(),
                            ]),

                        Textarea::make('short_description')
                            ->label('Ringkasan Singkat')
                            ->placeholder('Contoh: Level 120, Skin 150+, WR 70%, Siap Push Rank')
                            ->helperText('Akan muncul di kartu etalase pada tampilan HP.')
                            ->rows(2),

                        RichEditor::make('description')
                            ->label('Deskripsi Lengkap / Spesifikasi Akun')
                            ->placeholder('Jelaskan detail hero, skin, emblem, history rank, dll...')
                            ->helperText('Tuliskan rincian akun selengkap mungkin untuk meyakinkan pembeli.'),
                    ]),

                Section::make('Tangkapan Layar & Gambar')
                    ->description('Foto bukti akun game untuk menarik minat calon pembeli')
                    ->components([
                        FileUpload::make('thumbnail')
                            ->label('Foto Sampul Utama (Thumbnail)')
                            ->image()
                            ->directory('products/thumbnails')
                            ->imageEditor()
                            ->helperText('Foto yang pertama kali dilihat pembeli di katalog.')
                            ->nullable(),

                        FileUpload::make('images')
                            ->label('Galeri Screenshot Akun (Bisa pilih banyak)')
                            ->image()
                            ->multiple()
                            ->directory('products/gallery')
                            ->reorderable()
                            ->helperText('Screenshot profil, daftar hero/skin, statistik rank.'),
                    ]),

                Section::make('Data Kredensial Akun Game (Sangat Rahasia 🔒)')
                    ->description('Data ini 100% AMAN & RAHASIA. Hanya otomatis diberikan kepada pembeli yang telah melunasi pembayaran QRIS.')
                    ->components([
                        Grid::make(['default' => 1, 'md' => 2])
                            ->components([
                                TextInput::make('account_username')
                                    ->label('Username / ID / Email Login Game')
                                    ->placeholder('Contoh: user123@gmail.com')
                                    ->helperText('Hanya terlihat oleh pembeli sah setelah lunas'),

                                TextInput::make('account_password')
                                    ->label('Password / Kata Sandi Game')
                                    ->placeholder('Contoh: password_rahasia_123')
                                    ->helperText('Hanya terlihat oleh pembeli sah setelah lunas'),
                            ]),

                        Textarea::make('account_additional_info')
                            ->label('Panduan Login & Serah Terima Akun')
                            ->placeholder('Contoh: Akun login via Moonton. Email pemulihan dan no HP belum terkait (Clean Bind). Hubungi WA admin jika butuh bantuan OTP.')
                            ->helperText('Instruksi langkah login yang dibaca pembeli setelah pesanan lunas.')
                            ->rows(3),
                    ]),
            ]);
    }
}
