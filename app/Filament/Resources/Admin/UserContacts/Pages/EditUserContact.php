<?php

namespace App\Filament\Resources\Admin\UserContacts\Pages;

use App\Filament\Resources\Admin\UserContacts\UserContactResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditUserContact extends EditRecord
{
    protected static string $resource = UserContactResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}
