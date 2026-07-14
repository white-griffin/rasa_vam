<?php

namespace App\Filament\Resources\Admin\Blogs\Schemas;

use App\Enums\ActivityStatus;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Schema;

class BlogForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Grid::make()
                    ->columns(2)
                    ->schema([
                        TextInput::make('title')
                            ->label('عنوان ')
                            ->required(),
                    ])->columnSpanFull(),

                Grid::make()
                    ->columns(2)
                    ->schema([
                        FileUpload::make('image')
                            ->image()
                            ->directory('blogs/images')
                            ->label('تصویر')
                            ->imageEditor(),

                        Radio::make('activity_status')
                            ->label('وضعیت')
                            ->options(ActivityStatus::labels())
                            ->default(ActivityStatus::ACTIVE->value)
                            ->inline(),

                    ])->columnSpanFull(),

                Grid::make()
                    ->columns()
                    ->schema([


                        TextInput::make('meta_title')
                            ->label('متا تایتل')
                            ->required(),

                        TextInput::make('meta_description')
                            ->label('متا دسکریپشن')
                            ->required(),


                    ])->columnSpanFull(),

                RichEditor::make('content')
                    ->label('محتوا')
                    ->columnSpanFull(),
            ]);
    }
}
