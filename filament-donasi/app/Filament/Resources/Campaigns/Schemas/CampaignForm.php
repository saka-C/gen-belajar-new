<?php

namespace App\Filament\Resources\Campaigns\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\DatePicker;
use Filament\Schemas\Schema;

class CampaignForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([

                TextInput::make('judul')
                    ->required(),

                Textarea::make('deskripsi_singkat')
                    ->rows(3),

                TextInput::make('target_donasi')
                    ->numeric()
                    ->required(),

                TextInput::make('dana_terkumpul')
                    ->numeric()
                    ->default(0),

                TextInput::make('donatur_count')
                    ->numeric()
                    ->default(0),

                FileUpload::make('gambar')
                    ->image()
                    ->directory('campaigns'),

                DatePicker::make('deadline'),

                Select::make('status')
                    ->options([
                        'aktif' => 'Aktif',
                        'selesai' => 'Selesai',
                    ])
                    ->default('aktif')
                    ->required(),

                Toggle::make('is_featured')
                    ->label('Tampilkan di Beranda'),
                    
            ]);
    }
}