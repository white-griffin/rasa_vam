<?php

namespace App\Filament\Resources\Admin\Admins\Pages;

use App\Filament\Resources\Admin\Admins\AdminResource;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\CreateRecord;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Schema;

class CreateAdmin extends CreateRecord
{
    protected static string $resource = AdminResource::class;


    public function getCreatedNotification():?Notification
    {
        return Notification::make()
            ->success()
            ->title('ایجاد مدیر')
            ->body('مدیر با موفقیت ایجاد شد');
    }

    public function getRedirectUrl():string
    {
        return $this->getResourceUrl('index');
    }
}
