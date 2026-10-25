<?php

namespace App\Filament\Resources\Donations\Pages;

use App\Filament\Resources\Donations\DonationResource;
use App\Services\DonationVerificationService;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;

class CreateDonation extends CreateRecord
{
    protected static string $resource = DonationResource::class;

    protected function handleRecordCreation(array $data): Model
    {
        return app(DonationVerificationService::class)->createDirectVerified($data, auth()->id());
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
