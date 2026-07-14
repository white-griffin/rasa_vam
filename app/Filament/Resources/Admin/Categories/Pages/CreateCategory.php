<?php

namespace App\Filament\Resources\Admin\Categories\Pages;

use App\Filament\Resources\Admin\Categories\CategoryResource;
use Filament\Resources\Pages\CreateRecord;

class CreateCategory extends CreateRecord
{
    protected static string $resource = CategoryResource::class;
}
