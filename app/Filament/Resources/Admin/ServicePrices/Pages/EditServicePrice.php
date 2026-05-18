<?php

namespace App\Filament\Resources\Admin\ServicePrices\Pages;

use App\Filament\Resources\Admin\ServicePrices\ServicePriceResource;
use Filament\Actions\DeleteAction;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\EditRecord;

class EditServicePrice extends EditRecord
{
    protected static string $resource = ServicePriceResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }

    public function getSavedNotification():?Notification
    {
        return Notification::make()
            ->success()
            ->title('ویرایش تعرفه')
            ->body('تعرفه با موفقیت ویرایش شد');
    }

    public function getRedirectUrl():string
    {
        return $this->getResourceUrl('index');
    }
}
