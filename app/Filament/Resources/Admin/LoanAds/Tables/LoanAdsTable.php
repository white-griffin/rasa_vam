<?php

namespace App\Filament\Resources\Admin\LoanAds\Tables;

use App\Enums\ActivityStatus;
use App\Enums\LoanStatuses;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ForceDeleteBulkAction;
use Filament\Actions\RestoreBulkAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;

class LoanAdsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('user.name')->label('کاربر')->searchable()->sortable(),
                TextColumn::make('title')->label('عنوان'),
                TextColumn::make('price')->label('قیمت'),
                TextColumn::make('price')->label('قیمت'),
                TextColumn::make('activity_status')
                    ->label('وضعیت')
                    ->formatStateUsing(fn ($state) => LoanStatuses::label((string) $state) ?? '—')
                    ->badge()
                    ->colors([
                        'success'   => fn ($record) => (string) $record->activity_status === LoanStatuses::ACTIVE->value,
                        'info' => fn ($record) => (string) $record->activity_status === LoanStatuses::PENDING->value,
                        'secondary' => fn ($record) => (string) $record->activity_status === LoanStatuses::SOLD->value,
                        'danger' => fn ($record) => (string) $record->activity_status === LoanStatuses::CANCELLED->value,
                        'primary' => fn ($record) => (string) $record->activity_status === LoanStatuses::EXPIRED->value,
                    ]),
            ])
            ->filters([
                TrashedFilter::make(),
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                    ForceDeleteBulkAction::make(),
                    RestoreBulkAction::make(),
                ]),
            ]);
    }
}
