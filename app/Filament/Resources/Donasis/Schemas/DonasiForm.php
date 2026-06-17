<?php

namespace App\Filament\Resources\Donasis\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class DonasiForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            Select::make('campaign_id')
                ->relationship('campaign', 'title')
                ->required()
                ->label('Campaign / Program'),

            Select::make('user_id')
                ->relationship('donatur', 'username')
                ->nullable()
                ->label('Registered Donatur'),

            TextInput::make('guest_name')
                ->label('Guest Name (Optional)'),

            TextInput::make('amount')
                ->numeric()
                ->required()
                ->label('Nominal'),

            Textarea::make('message')
                ->label('Pesan & Doa Donatur')
                ->placeholder('Donatur tidak mengisi pesan.')
                ->rows(3)
                ->nullable()
                ->columnSpanFull(),

            TextInput::make('payment_method')
                ->default('qris')
                ->required()
                ->label('Payment Method'),

            TextInput::make('transaction_id')
                ->required()
                ->label('Transaction ID'),

            Select::make('payment_status')
                ->options([
                    'pending' => 'Pending',
                    'success' => 'Success',
                    'failed'  => 'Failed',
                ])
                ->default('pending')
                ->required()
                ->label('Payment Status'),

            Toggle::make('is_anonymous')
                ->label('Anonymous Donation'),
        ]);
    }
}
