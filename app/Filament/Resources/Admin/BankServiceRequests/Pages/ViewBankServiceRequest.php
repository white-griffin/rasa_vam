<?php

namespace App\Filament\Resources\Admin\BankServiceRequests\Pages;

use App\Filament\Resources\Admin\BankServiceRequests\BankServiceRequestResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewBankServiceRequest extends ViewRecord
{
    protected static string $resource = BankServiceRequestResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
