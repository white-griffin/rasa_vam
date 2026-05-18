<?php

namespace App\Filament\Resources\Admin\ServicePrices\Pages;

use App\Filament\Resources\Admin\ServicePrices\ServicePriceResource;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\CreateRecord;

class CreateServicePrice extends CreateRecord
{
    protected static string $resource = ServicePriceResource::class;

    public function getCreatedNotification():?Notification
    {
        return Notification::make()
            ->success()
            ->title('ایجاد تعرفه')
            ->body('تعرفه با موفقیت ایجاد شد');
    }

    public function getRedirectUrl():string
    {
        return $this->getResourceUrl('index');
    }
}
