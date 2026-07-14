<?php

namespace App\Filament\Resources\Admin\BankServices\Schemas;

use App\Enums\ActivityStatus;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Schema;

class BankServicesForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Grid::make()
                    ->columns(3)
                    ->schema([
                        TextInput::make('title')
                            ->label('عنوان خدمت')
                            ->required(),

                        TextInput::make('slug')
                            ->label('اسلاگ')
                            ->required(),

                        Textarea::make('short_description')
                            ->label('توضیح کوتاه')
                            ->required(),

                    ])->columnSpanFull(),

                Grid::make()
                    ->columns(3)
                    ->schema([

                        TextInput::make('description_title')
                            ->label('عنوان توضیح')
                            ->required(),

                        Textarea::make('description_text')
                            ->label('متن توضیح')
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


                        TextInput::make('meta_title')
                            ->label('متا تایتل')
                            ->required(),

                        TextInput::make('meta_description')
                            ->label('متا دسکریپشن')
                            ->required(),


                    ])->columnSpanFull(),


                Grid::make()
                    ->columns(3)
                    ->schema([


                        FileUpload::make('image')
                            ->image()
                            ->directory('bank-services/images')
                            ->label('تصویر اصلی')
                            ->imageEditor(),

                        FileUpload::make('slider_image')
                            ->label('تصویر اسلایدر')
                            ->directory('bank-services/slider_image')
                            ->image(),

                        FileUpload::make('icon')
                            ->image()
                            ->directory('bank-services/images')
                            ->label('ایکون')
                            ->imageEditor(),


                    ])->columnSpanFull(),

                Repeater::make('levels')
                    ->label('مراحل')
                    ->schema([
                        TextInput::make('title')
                            ->label('عنوان')
                            ->required(),

                        TextInput::make('description')
                            ->label('توضیح'),

                        FileUpload::make('image')
                            ->label('تصویر')
                            ->directory('bank-services/levels/images')
                            ->image(),

                    ])
                    ->collapsible() // اختیاری
                    ->defaultItems(1) // اگر خواستی حداقل یک آیتم از اول باشد
                    ->createItemButtonLabel('افزودن مرحله')
                    ->columns(3)
                    ->columnSpanFull(),

                Repeater::make('form_fields')
                    ->label('فیلدهای درخواست')
                    ->schema([
                        Select::make('type')
                            ->label('نوع فیلد')
                            ->options([
                                'text' => 'متن',
                                'textarea' => 'متن چند خطی',
                                'number' => 'عدد',
                                'email' => 'ایمیل',
                                'select' => 'انتخاب (دراپ‌داون)',
                                'radio' => 'رادیو باتن',
                                'checkbox' => 'چک‌باکس',
                                'date' => 'تاریخ',
                                'calculation' => 'محاسبه',
                            ])
                            ->required()
                            ->reactive()
                            ->afterStateUpdated(function ($state, callable $set) {
                                if ($state === 'calculation') {
                                    $set('name', 'formula');
                                }
                            }),

                        TextInput::make('name')
                            ->label('نام فیلد')
                            ->required()
                            ->visible(fn ($get) => $get('type') !== 'calculation')
                            ->helperText('نام فیلد در دیتابیس (مثلا: first_name)'),

                        TextInput::make('label')
                            ->label('برچسب فیلد')
                            ->required()
                            ->helperText('برچسبی که به کاربر نمایش داده می‌شود'),

                        TextInput::make('description')
                            ->label('توضیح فیلد')
                            ->required()
                            ->helperText('توضیحی که به کاربر نمایش داده می‌شود'),

                        Textarea::make('options')
                            ->label('گزینه‌ها')
                            ->helperText('هر گزینه در یک خط (برای select، radio، checkbox)')
                            ->rows(4)
                            ->visible(fn ($get) => in_array($get('type'), ['select', 'radio', 'checkbox'])),

                        TextInput::make('formula')
                            ->label('فرمول محاسبه')
                            ->helperText('مثال: price * quantity')
                            ->visible(fn ($get) => $get('type') === 'calculation')
                            ->required(fn ($get) => $get('type') === 'calculation'),

                        Select::make('required')
                            ->label('اجباری')
                            ->visible(fn ($get) => $get('type') !== 'calculation')
                            ->options([
                                true => 'بله',
                                false => 'خیر',
                            ])
                            ->default(false),
                    ])
                    ->columns(2)
                    ->collapsible()
                    ->itemLabel(fn (array $state): ?string => $state['label'] ?? $state['name'] ?? null)
                    ->addActionLabel('افزودن فیلد جدید')
                    ->defaultItems(0)
                    ->columnSpanFull(),


                Repeater::make('prices')
                    ->relationship('prices') // اگر relation اسمش prices باشه
                    ->schema([
                        TextInput::make('title')
                            ->label('عنوان')
                            ->required()
                            ->maxLength(255),

                        TextInput::make('price')
                            ->label('قیمت')
                            ->required()
                            ->numeric()
                            ->prefix('تومان')
                            ->minValue(0),

                    ])
                    ->columns(2)
                    ->collapsible()
                    ->defaultItems(1)
                    ->addActionLabel('افزودن قیمت جدید')
                    ->label('قیمت‌ها')
                    ->columnSpanFull()

            ]);
    }
}
