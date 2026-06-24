<?php

namespace App\Filament\Resources\Admin\BankServiceRequests\Pages;

use App\Filament\Resources\Admin\BankServiceRequests\BankServiceRequestResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListBankServiceRequests extends ListRecords
{
    protected static string $resource = BankServiceRequestResource::class;

    protected function getHeaderActions(): array
    {
        return [

        ];
    }
}
