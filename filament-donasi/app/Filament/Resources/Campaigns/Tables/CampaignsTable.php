<?php

namespace App\Filament\Resources\Campaigns\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class CampaignsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([

                TextColumn::make('judul')
                    ->label('Nama Program')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('target_donasi')
                    ->label('Target Dana')
                    ->money('IDR')
                    ->sortable(),

                TextColumn::make('dana_terkumpul')
                    ->label('Dana Terkumpul')
                    ->money('IDR')
                    ->sortable(),

                TextColumn::make('donatur_count')
                    ->label('Jumlah Donatur')
                    ->sortable(),

                TextColumn::make('progress_percentage')
                    ->label('Persentase Progress')
                    ->getStateUsing(function ($record) {

                        if ($record->target_donasi <= 0) {
                            return '0%';
                        }

                        return round(
                            ($record->dana_terkumpul / $record->target_donasi) * 100,
                            1
                        ) . '%';
                    }),

                TextColumn::make('status')
                    ->label('Status Program')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'aktif' => 'success',
                        'selesai' => 'gray',
                        default => 'warning',
                    }),

            ])

            ->filters([
                //
            ])

            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
            ])

            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}