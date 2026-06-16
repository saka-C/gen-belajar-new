<?php

namespace App\Filament\Resources\Allocations;

use App\Filament\Resources\Allocations\Pages\CreateAllocation;
use App\Filament\Resources\Allocations\Pages\EditAllocation;
use App\Filament\Resources\Allocations\Pages\ListAllocations;
use App\Filament\Resources\Allocations\Schemas\AllocationForm;
use App\Filament\Resources\Allocations\Tables\AllocationsTable;
use App\Models\Allocation;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class AllocationResource extends Resource
{
    protected static ?string $model = Allocation::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedBanknotes;

    protected static ?string $navigationLabel = 'Alokasi Dana';

    protected static ?string $modelLabel = 'Alokasi';

    protected static ?string $pluralModelLabel = 'Alokasi Dana';

    public static function getNavigationGroup(): ?string
    {
        return 'Manajemen Keuangan';
    }

    public static function getNavigationSort(): ?int
    {
        return 3;
    }
    public static function form(Schema $schema): Schema
    {
        return AllocationForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return AllocationsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function canViewAny(): bool
    {
        return auth()->check() && auth()->user()->role === 'admin';
    }

    public static function canCreate(): bool
    {
        return auth()->check() && auth()->user()->role === 'admin';
    }

    public static function canEdit($record): bool
    {
        return auth()->check() && auth()->user()->role === 'admin';
    }

    public static function canDelete($record): bool
    {
        return auth()->check() && auth()->user()->role === 'admin';
    }

    public static function getPages(): array
    {
        return [
            'index'  => ListAllocations::route('/'),
            'create' => CreateAllocation::route('/create'),
            'edit'   => EditAllocation::route('/{record}/edit'),
        ];
    }
}
