<?php

namespace App\Filament\Resources\Admin\LearningVideos\Pages;

use App\Filament\Resources\Admin\LearningVideos\LearningVideosResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListLearningVideos extends ListRecords
{
    protected static string $resource = LearningVideosResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
