<?php

namespace App\Filament\Resources\Admin\LoanAds\Pages;

use App\Filament\Resources\Admin\LoanAds\LoanAdResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListLoanAds extends ListRecords
{
    protected static string $resource = LoanAdResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
