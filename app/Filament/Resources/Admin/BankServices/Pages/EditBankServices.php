<?php

namespace App\Filament\Resources\Admin\BankServices\Pages;

use App\Filament\Resources\Admin\BankServices\BankServicesResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ForceDeleteAction;
use Filament\Actions\RestoreAction;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\EditRecord;

class EditBankServices extends EditRecord
{
    protected static string $resource = BankServicesResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
            ForceDeleteAction::make(),
            RestoreAction::make(),
        ];
    }

    public function getSavedNotification():?Notification
    {
        return Notification::make()
            ->success()
            ->title('ویرایش خدمات بانکی')
            ->body('خدمت بانکی با موفقیت ویرایش شد');
    }

    public function getRedirectUrl():string
    {
        return $this->getResourceUrl('index');
    }
}
