<?php

namespace App\Filament\Resources\Donasis;

use App\Filament\Resources\Donasis\Pages\CreateDonasi;
use App\Filament\Resources\Donasis\Pages\EditDonasi;
use App\Filament\Resources\Donasis\Pages\ListDonasis;
use App\Filament\Resources\Donasis\Schemas\DonasiForm;
use App\Filament\Resources\Donasis\Tables\DonasisTable;
use App\Models\Donasi;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class DonasiResource extends Resource
{
    protected static ?string $model = Donasi::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'id';

    public static function form(Schema $schema): Schema
    {
        return DonasiForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return DonasisTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    /**
     * Hanya Admin yang dapat melihat menu Donasi
     */
    public static function canViewAny(): bool
    {
        return auth()->check() && auth()->user()->role === 'admin';
    }

    /**
     * Hanya Admin yang dapat membuat Donasi
     */
    public static function canCreate(): bool
    {
        return auth()->check() && auth()->user()->role === 'admin';
    }

    /**
     * Hanya Admin yang dapat mengedit Donasi
     */
    public static function canEdit($record): bool
    {
        return auth()->check() && auth()->user()->role === 'admin';
    }

    /**
     * Hanya Admin yang dapat menghapus Donasi
     */
    public static function canDelete($record): bool
    {
        return auth()->check() && auth()->user()->role === 'admin';
    }

    public static function getPages(): array
    {
        return [
            'index' => ListDonasis::route('/'),
            'create' => CreateDonasi::route('/create'),
            'edit' => EditDonasi::route('/{record}/edit'),
        ];
    }
}
