<?php

namespace App\Filament\Resources\Admin\Faqs\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\ColorPicker;
use Filament\Tables\Columns\ColorColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class FaqsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
              TextColumn::make('question')
                ->label('سوال')
                ->searchable(),

                TextColumn::make('faqable_type')
                ->label('نوع مرتبط')
                    ->formatStateUsing(function ($state) {
                        return class_basename($state);
                    }),

                TextColumn::make('faqable.title')
                ->label('عنوان رکورد'),

                ColorColumn::make('priority_color')
                    ->label('رنگ')
            ])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make(),
                DeleteAction::make()
            ])->recordActionsColumnLabel('عملیات')
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
