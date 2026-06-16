<?php

namespace App\Filament\Resources\Donasis\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class DonasisTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('campaign.title')
                    ->label('Campaign / Program')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('donatur_name')
                    ->label('Donatur')
                    ->getStateUsing(function ($record) {
                        if ($record->donatur) {
                            return $record->donatur->username;
                        }
                        return $record->guest_name ?? 'Anonymous';
                    }),

                TextColumn::make('amount')
                    ->label('Nominal')
                    ->money('IDR')
                    ->sortable(),

                TextColumn::make('payment_status')
                    ->label('Status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'success' => 'success',
                        'pending' => 'warning',
                        'failed' => 'danger',
                        default => 'gray',
                    })
                    ->sortable(),

                TextColumn::make('transaction_id')
                    ->label('Transaction ID')
                    ->searchable(),
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
