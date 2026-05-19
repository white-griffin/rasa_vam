<?php

namespace App\Filament\Resources\Admin\Subscriptions\Schemas;

use App\Enums\ActivityStatus;
use App\Enums\SubscriptionStatuses;
use App\Helpers\Format\Date;
use App\Models\Plan;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\Select;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Schema;

class SubscriptionForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Grid::make(2)
                    ->schema([
                        Select::make('user_id')
                            ->label('کاربر')
                            ->relationship('user', 'mobile')
                            ->placeholder('شماره کاربر را وارد کنید')
                            ->searchable()
                            ->required(),

                        Select::make('plan_id')
                            ->label('طرح اشتراک')
                            ->relationship('plan', 'title')
                            ->searchable()
                            ->required()
                            ->reactive()
                            ->afterStateUpdated(function ($state, callable $set) {
                                if ($state) {
                                    $plan = Plan::query()
                                        ->find($state);
                                    if ($plan) {
                                        $set('ends_at', now()->addDays($plan->duration_days)->format('Y-m-d'));
                                    }
                                }
                            }),


                    ])->columnSpanFull(),

                Grid::make(3)
                    ->schema([

                        DatePicker::make('starts_at')
                            ->label('تاریخ شروع')
                            ->jalali()
                            ->required(),


                        DatePicker::make('ends_at')
                            ->label('تاریخ پایان')
                            ->jalali()
                            ->required(),

                        Radio::make('activity_status')
                            ->label('وضعیت')
                            ->options(SubscriptionStatuses::labels())
                            ->default(ActivityStatus::ACTIVE->value)
                            ->inline(),
                    ])->columnSpanFull()


            ]);
    }
}
