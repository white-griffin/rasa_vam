<?php

namespace App\Filament\Resources\Admin\Faqs\Schemas;

use App\Models\BankService;
use Filament\Forms\Components\ColorPicker;
use Filament\Forms\Components\MorphToSelect;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class FaqForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                MorphToSelect::make('faqable')
                    ->types([
                        MorphToSelect\Type::make(BankService::class)
                            ->label('خدمات بانکی')
                            ->titleAttribute('title'),
                    ])
                    ->label('ارتباط با بخش/رکورد'),

                ColorPicker::make('priority_color')
                ->label('رنگ '),

                TextInput::make('question')
                ->required()
                ->label('سوال')
                ->columnSpanFull(),

                Textarea::make('answer')
                ->required()
                ->label('پاسخ')
                    ->columnSpanFull(),


            ]);
    }
}
