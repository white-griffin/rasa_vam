<?php

namespace App\Filament\Resources\Admin\Users\Schemas;

use App\Enums\ActivityStatus;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Schema;

class UserForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components(self::components());
    }

    public static function components(): array
    {
        return[
            Grid::make()
                ->columns(3)
                ->schema([
                    TextInput::make('first_name')
                        ->label('نام')
                        ->required(),

                    TextInput::make('last_name')
                        ->label('نام خانوادگی')
                        ->required(),

                    TextInput::make('mobile')
                        ->label('شماره موبایل')
                        ->unique(ignoreRecord: true)
                        ->required(),

                ])->columnSpanFull(),


            Grid::make()
                ->columns(2)
                ->schema([

                    TextInput::make('email')
                        ->label('آدرس ایمیل')
                        ->email()
                        ->unique(ignoreRecord: true)
                        ->default(null),

                    TextInput::make('password')
                        ->label('رمز عبور')
                        ->password()
                        ->revealable()
                        ->minLength(6)
                        ->required(fn (string $context) => $context === 'create') // فقط موقع ساخت
                        ->dehydrated(fn ($state) => filled($state)), // فقط وقتی چیزی وارد شده ذخیره کنه

                ])->columnSpanFull(),

            Radio::make('activity_status')
                ->label('وضعیت')
                ->options(ActivityStatus::labels())
                ->default(ActivityStatus::ACTIVE->value)
                ->inline(),
        ];
    }
}
