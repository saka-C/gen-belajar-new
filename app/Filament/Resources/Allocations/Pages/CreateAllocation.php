<?php

namespace App\Filament\Resources\Allocations\Pages;

use App\Filament\Resources\Allocations\AllocationResource;
use App\Models\Campaign;
use Filament\Resources\Pages\CreateRecord;

class CreateAllocation extends CreateRecord
{
    protected static string $resource = AllocationResource::class;

    /**
     * Setelah alokasi berhasil disimpan, paksa update status campaign
     * menjadi 'telah_disalurkan'. Ini sebagai mekanisme eksplisit
     * selain observer di model.
     */
    protected function afterCreate(): void
    {
        $campaignId = $this->record->campaign_id;

        Campaign::where('campaign_id', $campaignId)
            ->whereIn('status', ['completed', 'telah_disalurkan'])
            ->update(['status' => 'telah_disalurkan']);
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
