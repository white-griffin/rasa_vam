<?php

namespace App\Filament\Resources\Admin\Faqs\Pages;

use App\Filament\Resources\Admin\Faqs\FaqResource;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\CreateRecord;

class CreateFaq extends CreateRecord
{
    protected static string $resource = FaqResource::class;

    public function getCreatedNotification():?Notification
    {
        return Notification::make()
            ->success()
            ->title('ایجاد سوالات متداول')
            ->body('سوال با موفقیت ایجاد شد');
    }

    public function getRedirectUrl():string
    {
        return $this->getResourceUrl('index');
    }
}
