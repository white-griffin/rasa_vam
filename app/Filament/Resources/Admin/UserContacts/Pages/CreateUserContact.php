<?php

namespace App\Filament\Resources\Admin\UserContacts\Pages;

use App\Filament\Resources\Admin\UserContacts\UserContactResource;
use Filament\Resources\Pages\CreateRecord;

class CreateUserContact extends CreateRecord
{
    protected static string $resource = UserContactResource::class;
}
