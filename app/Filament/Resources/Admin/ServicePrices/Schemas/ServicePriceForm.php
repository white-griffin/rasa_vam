<?php

namespace App\Filament\Resources\Admin\ServicePrices\Schemas;

use App\Enums\ActivityStatus;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Schema;

class ServicePriceForm
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

                        TextInput::make('slug')
                            ->label('اسلاگ')
                            ->required(),

                        Radio::make('activity_status')
                            ->label('وضعیت')
                            ->options(ActivityStatus::labels())
                            ->default(ActivityStatus::ACTIVE->value)
                            ->inline(),

                    ])->columnSpanFull(),

                Repeater::make('items')
                    ->label('آیتم ها')
                    ->schema([
                        TextInput::make('title')
                            ->label('عنوان')
                            ->required(),

                        TextInput::make('price')
                            ->label('قیمت')
                            ->required(),
                    ])
                    ->collapsible() // اختیاری
                    ->defaultItems(1) // اگر خواستی حداقل یک آیتم از اول باشد
                    ->createItemButtonLabel('افزودن آیتم')
                    ->columns()
                    ->columnSpanFull()
            ]);
    }
}
