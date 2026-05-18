<?php

namespace App\Filament\Resources\Admin\LearningVideos\Pages;

use App\Filament\Resources\Admin\LearningVideos\LearningVideosResource;
use Filament\Actions\DeleteAction;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\EditRecord;

class EditLearningVideos extends EditRecord
{
    protected static string $resource = LearningVideosResource::class;

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
            ->title('ویرایش ویدیو آموزشی')
            ->body('ویدیو آموزشی با موفقیت ویرایش شد');
    }

    public function getRedirectUrl():string
    {
        return $this->getResourceUrl('index');
    }
}
