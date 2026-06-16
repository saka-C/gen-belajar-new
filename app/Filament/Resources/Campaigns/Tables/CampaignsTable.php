<?php

namespace App\Filament\Resources\Campaigns\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class CampaignsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title')
                    ->label('Nama Program')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('target_amount')
                    ->label('Target Dana')
                    ->money('IDR')
                    ->sortable(),

                TextColumn::make('current_amount')
                    ->label('Dana Terkumpul')
                    ->money('IDR')
                    ->sortable(),

                TextColumn::make('progress_percentage')
                    ->label('Persentase Progress')
                    ->getStateUsing(function ($record) {
                        if ($record->target_amount <= 0) {
                            return '0%';
                        }

                        return round(
                            ($record->current_amount / $record->target_amount) * 100,
                            1
                        ) . '%';
                    }),

                TextColumn::make('status')
                    ->label('Status Program')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'active' => 'success',
                        'completed' => 'gray',
                        'draft' => 'warning',
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
