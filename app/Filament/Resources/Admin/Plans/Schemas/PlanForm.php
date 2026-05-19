<?php

namespace App\Filament\Resources\Admin\Plans\Schemas;

use App\Enums\ActivityStatus;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Schema;

class PlanForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Grid::make(3)
                    ->schema([
                        TextInput::make('title')
                            ->label('عنوان')
                            ->required(),

                        TextInput::make('slug')
                            ->label('اسلاگ')
                            ->required()
                            ->unique(ignoreRecord: true),

                        Textarea::make('description')->label('توضیحات'),
                    ])->columnSpanFull(),

                Grid::make(3)
                    ->schema([
                        TextInput::make('price')
                            ->label('قیمت')
                            ->numeric()
                            ->required(),

                        TextInput::make('duration_days')
                            ->label('مدت زمان (روز)')
                            ->numeric()
                            ->required(),

                        Radio::make('activity_status')
                            ->label('وضعیت')
                            ->options(ActivityStatus::labels())
                            ->default(ActivityStatus::ACTIVE->value)
                            ->inline(),
                    ])->columnSpanFull()


            ]);
    }
}
