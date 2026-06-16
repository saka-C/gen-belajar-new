<?php

namespace App\Filament\Resources\Campaigns\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class CampaignForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('title')
                    ->label('Judul Program')
                    ->required()
                    ->maxLength(255),

                Textarea::make('description')
                    ->label('Deskripsi Program')
                    ->required()
                    ->rows(5)
                    ->columnSpanFull(),

                FileUpload::make('image')
                    ->label('Gambar Program')
                    ->image()
                    ->imageEditor()
                    ->disk('public')
                    ->directory('campaigns')
                    ->visibility('public')
                    ->maxSize(2048)
                    ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/webp'])
                    ->helperText('Format: JPG, PNG, WEBP. Maks. 2MB.')
                    ->columnSpanFull(),

                TextInput::make('target_amount')
                    ->label('Target Dana')
                    ->numeric()
                    ->required(),

                TextInput::make('current_amount')
                    ->label('Dana Terkumpul')
                    ->numeric()
                    ->default(0.00),

                Select::make('status')
                    ->options([
                        'draft' => 'Draft',
                        'active' => 'Aktif',
                        'completed' => 'Selesai',
                    ])
                    ->default('draft')
                    ->required(),
            ]);
    }
}
