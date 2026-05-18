<?php

namespace App\Filament\Resources\Admin\Admins\Pages;

use App\Filament\Resources\Admin\Admins\AdminResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ForceDeleteAction;
use Filament\Actions\RestoreAction;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\EditRecord;

class EditAdmin extends EditRecord
{
    protected static string $resource = AdminResource::class;

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
            ->title('ویرایش مدیر')
            ->body('مدیر با موفقیت ویرایش شد');
    }

    public function getRedirectUrl():string
    {
        return $this->getResourceUrl('index');
    }
}
