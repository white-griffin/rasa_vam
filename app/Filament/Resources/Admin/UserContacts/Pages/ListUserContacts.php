<?php

namespace App\Filament\Resources\Admin\UserContacts\Pages;

use App\Filament\Resources\Admin\UserContacts\UserContactResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListUserContacts extends ListRecords
{
    protected static string $resource = UserContactResource::class;

    protected function getHeaderActions(): array
    {
        return [

        ];
    }
}
