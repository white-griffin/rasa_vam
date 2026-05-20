<?php

namespace App\Filament\Resources\Admin\LoanAds\Schemas;

use App\Enums\ActivityStatus;
use App\Enums\LoanStatuses;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Schema;

class LoanAdForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Grid::make(3)
                    ->schema([
                        Select::make('user_id')
                            ->label('کاربر')
                            ->relationship('user', 'mobile')
                            ->placeholder('شماره کاربر را وارد کنید')
                            ->searchable()
                            ->required(),

                        Select::make('bank_id')
                            ->label('بانک')
                            ->relationship('bank', 'title')
                            ->searchable()
                            ->required(),

                        Select::make('city_id')
                            ->label('شهر')
                            ->relationship('city', 'name')
                            ->searchable()
                            ->required(),

                    ])->columnSpanFull(),

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
                        TextInput::make('amount')
                            ->label('مقدار')
                            ->numeric()
                            ->required(),

                        TextInput::make('interest')
                            ->label('نرخ بهره')
                            ->numeric()
                            ->required(),

                        TextInput::make('price')
                            ->label('قیمت')
                            ->numeric()
                            ->required(),

                    ])->columnSpanFull(),

                Radio::make('activity_status')
                    ->label('وضعیت')
                    ->options(LoanStatuses::labels())
                    ->default(LoanStatuses::ACTIVE->value)
                    ->inline(),
            ]);
    }
}
