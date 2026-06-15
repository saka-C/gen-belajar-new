<?php

namespace App\Filament\Resources\Donaturs\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class DonaturForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            TextInput::make('nama')
                ->required(),

            TextInput::make('email')
                ->email()
                ->required(),

            TextInput::make('telepon'),

            Textarea::make('alamat'),
        ]);
    }
}