<?php

namespace App\Filament\Resources\Admin\ServicePrices\Pages;

use App\Filament\Resources\Admin\ServicePrices\ServicePriceResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListServicePrices extends ListRecords
{
    protected static string $resource = ServicePriceResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
