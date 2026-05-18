<?php

namespace App\Filament\Resources\Admin\LearningVideos\Pages;

use App\Filament\Resources\Admin\LearningVideos\LearningVideosResource;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\CreateRecord;

class CreateLearningVideos extends CreateRecord
{
    protected static string $resource = LearningVideosResource::class;

    public function getCreatedNotification():?Notification
    {
        return Notification::make()
            ->success()
            ->title('ایجاد ویدیو آموزشی')
            ->body('ویدیو آموزشی با موفقیت ایجاد شد');
    }

    public function getRedirectUrl():string
    {
        return $this->getResourceUrl('index');
    }
}
