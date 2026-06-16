<?php

namespace App\Filament\Resources\Allocations\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class AllocationsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('campaign.title')
                    ->label('Campaign / Program')
                    ->searchable()
                    ->sortable()
                    ->wrap(),

                TextColumn::make('penerima')
                    ->label('Penerima')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('metode')
                    ->label('Metode')
                    ->badge()
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'cash'     => 'Cash (Tunai)',
                        'transfer' => 'Transfer Bank',
                        'lainnya'  => 'Lainnya',
                        default    => ucfirst($state),
                    })
                    ->color(fn (string $state): string => match ($state) {
                        'cash'     => 'success',
                        'transfer' => 'info',
                        'lainnya'  => 'warning',
                        default    => 'gray',
                    }),

                TextColumn::make('amount_used')
                    ->label('Dana Disalurkan')
                    ->money('IDR')
                    ->sortable(),

                TextColumn::make('description')
                    ->label('Keterangan')
                    ->limit(60)
                    ->wrap()
                    ->placeholder('—'),

                TextColumn::make('campaign.status')
                    ->label('Status Campaign')
                    ->badge()
                    ->formatStateUsing(fn (?string $state): string => match ($state) {
                        'telah_disalurkan' => 'Telah Disalurkan',
                        'completed'        => 'Selesai',
                        'active'           => 'Aktif',
                        'draft'            => 'Draft',
                        default            => $state ?? '—',
                    })
                    ->color(fn (?string $state): string => match ($state) {
                        'telah_disalurkan' => 'info',
                        'completed'        => 'gray',
                        'active'           => 'success',
                        default            => 'warning',
                    }),

                TextColumn::make('created_at')
                    ->label('Tanggal Dicatat')
                    ->dateTime('d M Y, H:i')
                    ->sortable(),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                SelectFilter::make('metode')
                    ->label('Filter Metode')
                    ->options([
                        'cash'     => 'Cash (Tunai)',
                        'transfer' => 'Transfer Bank',
                        'lainnya'  => 'Lainnya',
                    ]),
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
