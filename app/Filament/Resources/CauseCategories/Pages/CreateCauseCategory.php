<?php

namespace App\Filament\Resources\CauseCategories\Pages;

use App\Filament\Resources\CauseCategories\CauseCategoryResource;
use Filament\Resources\Pages\CreateRecord;

class CreateCauseCategory extends CreateRecord
{
    protected static string $resource = CauseCategoryResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
