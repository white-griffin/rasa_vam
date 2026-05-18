<?php

namespace App\Filament\Resources\Admin\LearningVideos;

use App\Filament\Resources\Admin\LearningVideos\Pages\CreateLearningVideos;
use App\Filament\Resources\Admin\LearningVideos\Pages\EditLearningVideos;
use App\Filament\Resources\Admin\LearningVideos\Pages\ListLearningVideos;
use App\Filament\Resources\Admin\LearningVideos\Schemas\LearningVideosForm;
use App\Filament\Resources\Admin\LearningVideos\Tables\LearningVideosTable;
use App\Models\LearningVideo;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class LearningVideosResource extends Resource
{
    protected static ?string $model = LearningVideo::class;

    protected static ?string $navigationLabel = 'ویدیو های آموزشی';

    protected static ?string $pluralLabel = 'ویدیو های آموزشی';

    protected static ?string $modelLabel = 'ویدیو آموزشی';

    protected static ?int $navigationSort = 5;
    protected static string|BackedEnum|null $navigationIcon = Heroicon::VideoCamera;


    public static function form(Schema $schema): Schema
    {
        return LearningVideosForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return LearningVideosTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListLearningVideos::route('/'),
            'create' => CreateLearningVideos::route('/create'),
            'edit' => EditLearningVideos::route('/{record}/edit'),
        ];
    }
}
