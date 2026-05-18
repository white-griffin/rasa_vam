<?php

namespace App\Filament\Resources\Admin\UserContacts\Pages;

use App\Filament\Resources\Admin\UserContacts\UserContactResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewUserContact extends ViewRecord
{
    protected static string $resource = UserContactResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
