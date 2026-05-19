<?php

namespace App\Filament\Resources\Admin\Subscriptions\Tables;

use App\Enums\ActivityStatus;
use App\Enums\SubscriptionStatuses;
use App\Helpers\Format\Date;
use App\Models\Subscription;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\DatePicker;
use Filament\Notifications\Notification;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Morilog\Jalali\Jalalian;

class SubscriptionsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([

                TextColumn::make('user.name')
                    ->label('کاربر')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('plan.title')
                    ->label('پلن')
                    ->sortable(),

                TextColumn::make('starts_at')
                    ->label('تاریخ شروع')
                    ->jalaliDate('Y/m/d')
                    ->sortable(),

                TextColumn::make('ends_at')
                    ->label('تاریخ پایان')
                    ->jalaliDate('Y/m/d')
                    ->sortable(),

                TextColumn::make('activity_status')
                    ->label('وضعیت')
                    ->formatStateUsing(fn ($state) => ActivityStatus::label((string) $state) ?? '—')
                    ->badge()
                    ->colors([
                        'success'   => fn ($record) => (string) $record->activity_status === ActivityStatus::ACTIVE->value,
                        'danger' => fn ($record) => (string) $record->activity_status === ActivityStatus::INACTIVE->value,
                    ]),
            ])
            ->filters([
                SelectFilter::make('activity_status')
                    ->label('وضعیت')
                    ->options([
                        SubscriptionStatuses::ACTIVE->value => 'فعال',
                        SubscriptionStatuses::EXPIRED->value => 'منقضی شده',
                        SubscriptionStatuses::CANCELLED->value => 'لغو شده',
                    ]),

                SelectFilter::make('plan_id')
                    ->label('پلن')
                    ->relationship('plan', 'title'),

                Filter::make('created_at')
                    ->form([
                        DatePicker::make('created_from')
                            ->jalali()
                            ->label('از تاریخ'),
                        DatePicker::make('created_until')
                            ->jalali()
                            ->label('تا تاریخ'),
                    ])
                    ->query(function ($query, array $data) {
                        return $query
                            ->when($data['created_from'], fn ($q, $date) => $q->whereDate('created_at', '>=', $date))
                            ->when($data['created_until'], fn ($q, $date) => $q->whereDate('created_at', '<=', $date));
                    }),
            ])
            ->recordActions([
                EditAction::make(),

                Action::make('renew')
                    ->label('تمدید')
                    ->icon('heroicon-o-arrow-path')
                    ->color('success')
                    ->visible(fn (Subscription $record) =>
                        $record->activity_status === SubscriptionStatuses::ACTIVE->value || $record->activity_status === SubscriptionStatuses::EXPIRED->value
                    )
                    ->requiresConfirmation()
                    ->modalHeading('تمدید اشتراک')
                    ->modalDescription('آیا مطمئن هستید که می‌خواهید این اشتراک را تمدید کنید؟')
                    ->action(function (Subscription $record) {
                        $record->renew();

                        Notification::make()
                            ->success()
                            ->title('اشتراک با موفقیت تمدید شد')
                            ->send();
                    }),

                Action::make('cancel')
                    ->label('لغو')
                    ->icon('heroicon-o-x-circle')
                    ->color('danger')
                    ->visible(fn (Subscription $record) =>
                        $record->activity_status === SubscriptionStatuses::ACTIVE->value
                    )
                    ->requiresConfirmation()
                    ->modalHeading('لغو اشتراک')
                    ->modalDescription('آیا مطمئن هستید که می‌خواهید این اشتراک را لغو کنید?')
                    ->action(function (Subscription $record) {
                        $record->cancel();

                        Notification::make()
                            ->success()
                            ->title('اشتراک با موفقیت لغو شد')
                            ->send();
                    }),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ])->defaultSort('created_at', 'desc');
    }
}
