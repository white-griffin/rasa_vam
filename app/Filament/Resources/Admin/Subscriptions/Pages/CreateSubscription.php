<?php

namespace App\Filament\Resources\Admin\Subscriptions\Pages;

use App\Filament\Resources\Admin\Subscriptions\SubscriptionResource;
use Filament\Resources\Pages\CreateRecord;

class CreateSubscription extends CreateRecord
{
    protected static string $resource = SubscriptionResource::class;
}
