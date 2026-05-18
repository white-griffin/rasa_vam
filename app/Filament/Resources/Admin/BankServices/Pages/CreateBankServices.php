<?php

namespace App\Filament\Resources\Admin\BankServices\Pages;

use App\Filament\Resources\Admin\BankServices\BankServicesResource;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\CreateRecord;

class CreateBankServices extends CreateRecord
{
    protected static string $resource = BankServicesResource::class;

    public function getCreatedNotification():?Notification
    {
        return Notification::make()
            ->success()
            ->title('ایجاد خدمات بانکی')
            ->body('خدمت بانکی با موفقیت ایجاد شد');
    }

    public function getRedirectUrl():string
    {
        return $this->getResourceUrl('index');
    }
}
