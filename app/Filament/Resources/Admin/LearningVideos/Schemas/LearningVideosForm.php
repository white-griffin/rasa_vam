<?php

namespace App\Filament\Resources\Admin\LearningVideos\Schemas;

use App\Enums\ActivityStatus;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Schema;

class LearningVideosForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Grid::make()
                    ->columns(3)
                    ->schema([

                        TextInput::make('title')
                            ->label('عنوان ')
                            ->required(),

                        Radio::make('activity_status')
                            ->label('وضعیت')
                            ->options(ActivityStatus::labels())
                            ->default(ActivityStatus::ACTIVE->value)
                            ->inline(),

                    ])->columnSpanFull(),

                Grid::make()
                    ->columns()
                    ->schema([

                        FileUpload::make('thumbnail')
                            ->image()
                            ->directory('learning-videos/thumbnails')
                            ->label('تصویر بنر')
                            ->imageEditor(),

                        FileUpload::make('video_url') // نام این فیلد باید با نام ستون در دیتابیس یکی باشد
                        ->label('انتخاب ویدیو')
                            ->acceptedFileTypes(['video/mp4', 'video/mov', 'video/avi', 'video/mpeg']) // فرمت‌های مجاز ویدیو
                            ->directory('learning-videos/videos') // پوشه‌ای که فایل‌ها در آن آپلود می‌شوند (در storage/app/)
                            ->preserveFilenames() // نام اصلی فایل را نگه می‌دارد (اختیاری)
                            ->maxSize(102400) // حداکثر حجم فایل به کیلوبایت (مثلا ۱۰۰ مگابایت)
                            ->required(), // اجباری بودن فیلد

                    ])->columnSpanFull(),

            ]);
    }
}
