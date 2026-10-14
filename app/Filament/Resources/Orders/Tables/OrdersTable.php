<?php

namespace App\Filament\Resources\Orders\Tables;

use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class OrdersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('order_number')
                    ->label('No. Pesanan')
                    ->description(fn ($record) => $record->buyer_name . ' • ' . ($record->product?->title ?? 'Akun Game'))
                    ->searchable()
                    ->copyable()
                    ->weight('bold')
                    ->sortable()
                    ->wrap(),

                TextColumn::make('buyer_name')
                    ->label('Pembeli')
                    ->description(fn ($record) => $record->buyer_phone ?: $record->buyer_email)
                    ->searchable()
                    ->sortable()
                    ->visibleFrom('md'),

                TextColumn::make('product.title')
                    ->label('Akun Game')
                    ->description(fn ($record) => $record->product?->category?->name)
                    ->limit(25)
                    ->searchable()
                    ->visibleFrom('lg'),

                TextColumn::make('total_amount')
                    ->label('Total')
                    ->money('IDR', locale: 'id')
                    ->weight('bold')
                    ->sortable(),

                TextColumn::make('payment_status')
                    ->label('Status Bayar')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'paid' => 'success',
                        'pending' => 'warning',
                        'failed', 'expired' => 'danger',
                        default => 'gray',
                    })
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'paid' => 'LUNAS',
                        'pending' => 'MENUNGGU QRIS',
                        'failed' => 'GAGAL',
                        'expired' => 'KEDALUWARSA',
                        default => strtoupper($state),
                    }),

                TextColumn::make('order_status')
                    ->label('Status Order')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'completed' => 'success',
                        'processing' => 'info',
                        'pending' => 'warning',
                        'cancelled' => 'danger',
                        default => 'gray',
                    })
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'completed' => 'Selesai (Kredensial Terkirim)',
                        'processing' => 'Diproses',
                        'pending' => 'Menunggu Pembayaran',
                        'cancelled' => 'Dibatalkan',
                        default => ucfirst($state),
                    })
                    ->visibleFrom('md'),

                TextColumn::make('created_at')
                    ->label('Waktu Pesan')
                    ->dateTime('d M Y, H:i')
                    ->sortable()
                    ->visibleFrom('lg'),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                SelectFilter::make('payment_status')
                    ->label('Filter Pembayaran')
                    ->options([
                        'pending' => 'Menunggu QRIS (Pending)',
                        'paid' => 'Sudah Lunas (Paid)',
                        'failed' => 'Gagal (Failed)',
                        'expired' => 'Kedaluwarsa (Expired)',
                    ]),

                SelectFilter::make('order_status')
                    ->label('Filter Status Pesanan')
                    ->options([
                        'pending' => 'Menunggu (Pending)',
                        'processing' => 'Diproses (Processing)',
                        'completed' => 'Selesai (Completed)',
                        'cancelled' => 'Dibatalkan (Cancelled)',
                    ]),
            ])
            ->recordActions([
                Action::make('chatBuyer')
                    ->label('WA')
                    ->tooltip('Hubungi pembeli lewat WhatsApp')
                    ->icon('heroicon-o-chat-bubble-left-ellipsis')
                    ->color('success')
                    ->url(fn ($record) => !empty($record->buyer_phone) 
                        ? 'https://wa.me/' . preg_replace('/[^0-9]/', '', preg_replace('/^0/', '62', $record->buyer_phone)) . '?text=' . urlencode('Halo kak ' . $record->buyer_name . ', saya admin ANDRA JB terkait pesanan akun game #' . $record->order_number . '.') 
                        : '#', shouldOpenInNewTab: true)
                    ->visible(fn ($record) => !empty($record->buyer_phone)),

                Action::make('markAsPaid')
                    ->label('Setujui Lunas')
                    ->icon('heroicon-o-check-circle')
                    ->color('primary')
                    ->requiresConfirmation()
                    ->modalHeading('Verifikasi Manual Pembayaran QRIS')
                    ->modalDescription('Pastikan saldo pembayaran sudah benar-benar masuk ke akun Anda. Setelah disetujui, akun game akan ditandai Terjual dan kredensial login otomatis dibuka untuk pembeli.')
                    ->modalSubmitActionLabel('Ya, Setujui Lunas')
                    ->visible(fn ($record) => $record->payment_status === 'pending')
                    ->action(function ($record) {
                        $record->update([
                            'payment_status' => 'paid',
                            'order_status' => 'completed',
                            'paid_at' => now(),
                            'notes' => 'Pembayaran QRIS diverifikasi dan disetujui secara manual oleh Admin.',
                        ]);
                        if ($record->product) {
                            $record->product->update(['status' => 'sold']);
                        }
                    }),

                EditAction::make()->label('Rincian'),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
