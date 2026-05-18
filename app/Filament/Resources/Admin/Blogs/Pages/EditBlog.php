<?php

namespace App\Filament\Resources\Admin\Blogs\Pages;

use App\Filament\Resources\Admin\Blogs\BlogResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ForceDeleteAction;
use Filament\Actions\RestoreAction;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\EditRecord;

class EditBlog extends EditRecord
{
    protected static string $resource = BlogResource::class;

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
            ->title('ویرایش بلاگ')
            ->body('بلاگ با موفقیت ویرایش شد');
    }

    public function getRedirectUrl():string
    {
        return $this->getResourceUrl('index');
    }
}
