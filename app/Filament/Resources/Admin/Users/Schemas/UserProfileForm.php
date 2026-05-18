<?php

namespace App\Filament\Resources\Admin\Users\Schemas;


use App\Enums\GenderType;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Image;
use Filament\Schemas\Schema;

class UserProfileForm
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
                Select::make('gender')
                    ->label('جنسیت')
                    ->options(GenderType::labels()),

                TextInput::make('national_code')
                    ->label('کد ملی'),

                DatePicker::make('birth_date')
                    ->jalali()
                    ->label('تاریخ تولد'),

            ]),


            FileUpload::make('avatar')
                ->image()
                ->directory('users/avatar')
                ->label('عکس پروفایل')
                ->imageEditor(),



        ];
    }

}
