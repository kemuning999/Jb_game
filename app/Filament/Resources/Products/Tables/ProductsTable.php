<?php

namespace App\Filament\Resources\Products\Tables;

use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class ProductsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('thumbnail')
                    ->label('Foto')
                    ->size(46)
                    ->rounded()
                    ->defaultImageUrl(asset('favicon.ico')),

                TextColumn::make('title')
                    ->label('Nama Akun')
                    ->description(fn ($record) => ($record->category?->name ?? 'Game') . ' • Rp ' . number_format($record->price, 0, ',', '.'))
                    ->searchable()
                    ->sortable()
                    ->weight('bold')
                    ->wrap(),

                TextColumn::make('category.name')
                    ->label('Game')
                    ->badge()
                    ->color('info')
                    ->sortable()
                    ->visibleFrom('md'),

                TextColumn::make('price')
                    ->label('Harga')
                    ->money('IDR', locale: 'id')
                    ->sortable()
                    ->weight('bold')
                    ->visibleFrom('md'),

                TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'available' => 'Tersedia',
                        'sold' => 'Terjual',
                        default => $state,
                    })
                    ->color(fn (string $state): string => match ($state) {
                        'available' => 'success',
                        'sold' => 'danger',
                        default => 'gray',
                    })
                    ->sortable(),

                TextColumn::make('created_at')
                    ->label('Diposting')
                    ->dateTime('d M Y, H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('category_id')
                    ->label('Filter Game')
                    ->relationship('category', 'name'),

                SelectFilter::make('status')
                    ->label('Filter Status')
                    ->options([
                        'available' => 'Tersedia',
                        'sold' => 'Terjual',
                    ]),
            ])
            ->recordActions([
                Action::make('viewInShop')
                    ->label('Lihat')
                    ->tooltip('Buka halaman akun di website toko')
                    ->icon('heroicon-o-arrow-top-right-on-square')
                    ->color('gray')
                    ->url(fn ($record) => route('products.show', $record->slug), shouldOpenInNewTab: true),

                EditAction::make()
                    ->label('Edit')
                    ->successNotificationTitle('Data akun game berhasil diperbarui!'),
                DeleteAction::make()
                    ->label('Hapus')
                    ->successNotificationTitle('Akun game berhasil dihapus!'),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make()
                        ->successNotificationTitle('Data yang dipilih berhasil dihapus!'),
                ]),
            ]);
    }
}
