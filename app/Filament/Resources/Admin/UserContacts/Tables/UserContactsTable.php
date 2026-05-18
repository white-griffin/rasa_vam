<?php

namespace App\Filament\Resources\Admin\UserContacts\Tables;

use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class UserContactsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label('نام و نام خانوادگی')
                    ->searchable(),
                TextColumn::make('mobile')
                    ->label('موبایل')
                    ->searchable(),
                TextColumn::make('subject')
                    ->label('موضوع')
                    ->searchable(),
                TextColumn::make('message')
                    ->label('پیام')
                    ->limit(50),
                TextColumn::make('created_at')
                    ->label('تاریخ')
                    ->jalaliDateTime()
                    ->sortable(),
            ])
            ->defaultSort('created_at', 'desc')

            ->filters([
                //
            ])
            ->recordActions([
                Action::make('viewMessage')
                    ->label('مشاهده پیام')
                    ->icon('heroicon-o-eye')
                    ->modalHeading(fn ($record) => 'پیام از ' . $record->name)
                    ->modalContent(fn ($record) => view('components.modals.user-contact-message', [
                        'record' => $record
                    ]))
                    ->modalSubmitAction(false)
                    ->modalCancelActionLabel('بستن'),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function canCreate(): bool
    {
        return false;
    }
}
