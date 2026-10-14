<?php

namespace App\Filament\Resources\Categories\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

class CategoryForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Informasi Kategori Game')
                    ->description('Kelola nama game dan logo untuk etalase website')
                    ->components([
                        Grid::make(['default' => 1, 'md' => 2])
                            ->components([
                                TextInput::make('name')
                                    ->label('Nama Kategori / Game')
                                    ->placeholder('Misal: Mobile Legends, Valorant')
                                    ->helperText('Nama game yang muncul di menu & filter web.')
                                    ->required()
                                    ->maxLength(255)
                                    ->live(onBlur: true)
                                    ->afterStateUpdated(fn ($set, ?string $state) => $set('slug', Str::slug($state ?? ''))),

                                TextInput::make('slug')
                                    ->label('Slug URL')
                                    ->placeholder('mobile-legends')
                                    ->helperText('Dibuat otomatis dari nama game untuk link URL.')
                                    ->required()
                                    ->maxLength(255)
                                    ->unique(ignoreRecord: true),
                            ]),

                        FileUpload::make('icon')
                            ->label('Ikon / Logo Game')
                            ->helperText('Upload logo game (format gambar, rasio persegi).')
                            ->image()
                            ->directory('categories')
                            ->imageEditor(),

                        Textarea::make('description')
                            ->label('Deskripsi Singkat')
                            ->placeholder('Deskripsi ringkas mengenai kategori ini...')
                            ->rows(3),

                        Toggle::make('is_active')
                            ->label('Tampilkan di Website (Aktif)')
                            ->helperText('Jika aktif, game ini akan muncul di etalase toko untuk pembeli.')
                            ->default(true),
                    ]),
            ]);
    }
}
