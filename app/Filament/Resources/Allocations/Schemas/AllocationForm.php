<?php

namespace App\Filament\Resources\Allocations\Schemas;

use App\Models\Allocation;
use App\Models\Campaign;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class AllocationForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([

            Select::make('campaign_id')
                ->label('Campaign / Program')
                ->options(function () {
                    return Campaign::whereIn('status', ['completed', 'telah_disalurkan'])
                        ->orderBy('title')
                        ->pluck('title', 'campaign_id');
                })
                ->searchable()
                ->required()
                ->live()
                ->helperText('Pilih campaign yang sudah selesai (100% terpenuhi atau lebih).'),

            // --- Informasi Saldo Reaktif ---
            Placeholder::make('info_dana_terkumpul')
                ->label('💰 Dana Terkumpul')
                ->content(function ($get): string {
                    $campaignId = $get('campaign_id');
                    if (!$campaignId) return '—';
                    $campaign = Campaign::find($campaignId);
                    if (!$campaign) return '—';
                    return 'Rp ' . number_format($campaign->current_amount, 0, ',', '.');
                }),

            Placeholder::make('info_sudah_dialokasikan')
                ->label('📤 Sudah Dialokasikan')
                ->content(function ($get): string {
                    $campaignId = $get('campaign_id');
                    if (!$campaignId) return '—';
                    // Hitung total alokasi yang sudah tercatat untuk campaign ini
                    $totalAlokasi = Allocation::where('campaign_id', $campaignId)
                        ->sum('amount_used');
                    return 'Rp ' . number_format($totalAlokasi, 0, ',', '.');
                }),

            Placeholder::make('info_saldo_tersisa')
                ->label('✅ Sisa Saldo Belum Dialokasikan')
                ->content(function ($get): string {
                    $campaignId = $get('campaign_id');
                    if (!$campaignId) return '—';
                    $campaign = Campaign::find($campaignId);
                    if (!$campaign) return '—';
                    $totalAlokasi = Allocation::where('campaign_id', $campaignId)
                        ->sum('amount_used');
                    $sisa = $campaign->current_amount - $totalAlokasi;
                    $label = $sisa >= 0
                        ? 'Rp ' . number_format($sisa, 0, ',', '.')
                        : '⚠️ Melebihi saldo! Rp ' . number_format(abs($sisa), 0, ',', '.');
                    return $label;
                })
                ->columnSpanFull(),

            // --- Field Input Alokasi ---
            Select::make('metode')
                ->label('Metode Penyaluran')
                ->options([
                    'cash'     => 'Cash (Tunai)',
                    'transfer' => 'Transfer Bank',
                    'lainnya'  => 'Lainnya',
                ])
                ->required()
                ->default('cash'),

            TextInput::make('penerima')
                ->label('Nama Penerima')
                ->required()
                ->maxLength(255)
                ->placeholder('Masukkan nama penerima dana'),

            TextInput::make('amount_used')
                ->label('Jumlah Dana Dialokasikan (Rp)')
                ->numeric()
                ->required()
                ->minValue(1)
                ->maxValue(function ($get, $record): float {
                    $campaignId = $get('campaign_id');
                    if (!$campaignId) return 0;
                    $campaign = Campaign::find($campaignId);
                    if (!$campaign) return 0;

                    // Hitung alokasi lain untuk campaign ini (abaikan record saat ini jika edit)
                    $query = Allocation::where('campaign_id', $campaignId);
                    if ($record) {
                        $query->where('allocation_id', '!=', $record->allocation_id);
                    }
                    $totalAlokasi = $query->sum('amount_used');

                    return max(0.0, (float) ($campaign->current_amount - $totalAlokasi));
                })
                ->validationMessages([
                    'max' => 'Jumlah dana dialokasikan melebihi sisa saldo campaign yang tersedia.',
                ])
                ->prefix('Rp')
                ->placeholder('0'),

            Textarea::make('description')
                ->label('Keterangan / Deskripsi')
                ->nullable()
                ->rows(4)
                ->placeholder('Tuliskan keterangan terkait penyaluran dana ini...')
                ->columnSpanFull(),

        ]);
    }
}
