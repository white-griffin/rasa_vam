<?php

namespace App\Filament\Resources\Admin\BankServices\Pages;

use App\Filament\Resources\Admin\BankServices\BankServicesResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListBankServices extends ListRecords
{
    protected static string $resource = BankServicesResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
