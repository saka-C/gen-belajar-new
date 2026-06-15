<?php

namespace App\Filament\Resources\Donasis\Schemas;

use App\Models\Campaign;
use App\Models\Donatur;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class DonasiForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            Select::make('campaign_id')
                ->relationship('campaign', 'judul')
                ->required(),

            Select::make('donatur_id')
                ->relationship('donatur', 'nama')
                ->required(),

            TextInput::make('nominal')
                ->numeric()
                ->required(),
        ]);
    }
}