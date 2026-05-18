<?php

namespace App\Filament\Resources\Admin\Newsletters\Pages;

use App\Filament\Resources\Admin\Newsletters\NewsletterResource;
use Filament\Resources\Pages\CreateRecord;

class CreateNewsletter extends CreateRecord
{
    protected static string $resource = NewsletterResource::class;
}
