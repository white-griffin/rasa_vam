<?php

namespace App\Filament\Resources\Admin\LoanAds\Pages;

use App\Filament\Resources\Admin\LoanAds\LoanAdResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ForceDeleteAction;
use Filament\Actions\RestoreAction;
use Filament\Resources\Pages\EditRecord;

class EditLoanAd extends EditRecord
{
    protected static string $resource = LoanAdResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
            ForceDeleteAction::make(),
            RestoreAction::make(),
        ];
    }
}
