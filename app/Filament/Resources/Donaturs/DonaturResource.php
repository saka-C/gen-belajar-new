<?php

namespace App\Filament\Resources\Donaturs;

use App\Filament\Resources\Donaturs\Pages\CreateDonatur;
use App\Filament\Resources\Donaturs\Pages\EditDonatur;
use App\Filament\Resources\Donaturs\Pages\ListDonaturs;
use App\Filament\Resources\Donaturs\Schemas\DonaturForm;
use App\Filament\Resources\Donaturs\Tables\DonatursTable;
use App\Models\Donatur;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class DonaturResource extends Resource
{
    protected static ?string $model = Donatur::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedUsers;

    protected static ?string $navigationLabel = 'Donatur';

    protected static ?string $modelLabel = 'Donatur';

    protected static ?string $pluralModelLabel = 'Donatur';

    protected static ?string $recordTitleAttribute = 'nama';

    public static function form(Schema $schema): Schema
    {
        return DonaturForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return DonatursTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [];
    }

    /**
     * Hanya Admin yang dapat melihat menu Donatur
     */
    public static function canViewAny(): bool
    {
        return auth()->user()->role === 'admin';
    }

    /**
     * Hanya Admin yang dapat menambah Donatur
     */
    public static function canCreate(): bool
    {
        return auth()->user()->role === 'admin';
    }

    /**
     * Hanya Admin yang dapat mengedit Donatur
     */
    public static function canEdit($record): bool
    {
        return auth()->user()->role === 'admin';
    }

    /**
     * Hanya Admin yang dapat menghapus Donatur
     */
    public static function canDelete($record): bool
    {
        return auth()->user()->role === 'admin';
    }

    public static function getPages(): array
    {
        return [
            'index' => ListDonaturs::route('/'),
            'create' => CreateDonatur::route('/create'),
            'edit' => EditDonatur::route('/{record}/edit'),
        ];
    }
}
