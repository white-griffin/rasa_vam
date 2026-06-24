<?php

namespace App\Filament\Resources\Admin\BankServiceRequests\Tables;

use App\Enums\BankServiceRequestStatuses;
use App\Enums\OrderStatuses;
use Filament\Actions\Action;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\KeyValue;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Infolists\Components\KeyValueEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\EmptyState;
use Filament\Schemas\Components\Section;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class BankServiceRequestsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->defaultSort('id', 'desc')

            ->columns([

                TextColumn::make('user.name')
                    ->label('کاربر')
                    ->searchable(),

                TextColumn::make('user.mobile')
                    ->label('موبایل')
                    ->searchable(),

                TextColumn::make('bankService.title')
                    ->label('سرویس بانکی'),

                TextColumn::make('bank_service_price_title')
                    ->label('عنوان درخواست'),

                TextColumn::make('bank_service_price_amount')
                    ->label('مبلغ')
                    ->formatStateUsing(fn ($state) => number_format($state).' تومان')
                    ->sortable(),

                TextColumn::make('order.status')
                    ->label('وضعیت پرداخت')
                    ->badge()
                    ->placeholder('بدون پرداخت')
                    ->formatStateUsing(fn ($state) => $state ? OrderStatuses::label($state) : 'بدون پرداخت'),

                TextColumn::make('status')
                    ->label('وضعیت')
                    ->badge()
                    ->colors([
                        'warning' => BankServiceRequestStatuses::PENDING->value,
                        'info' => BankServiceRequestStatuses::IN_REVIEW->value,
                        'primary' => BankServiceRequestStatuses::IN_PROCESS->value,
                        'success' => BankServiceRequestStatuses::DONE->value,
                        'danger' => BankServiceRequestStatuses::FAILED->value,
                        'gray' => BankServiceRequestStatuses::CANCELLED->value,
                    ])
                    ->formatStateUsing(fn ($state) => BankServiceRequestStatuses::label($state)),
            ])

            ->filters([

                SelectFilter::make('status')
                    ->label('وضعیت')
                    ->options([
                        'warning' => BankServiceRequestStatuses::PENDING->value,
                        'info' => BankServiceRequestStatuses::IN_REVIEW->value,
                        'primary' => BankServiceRequestStatuses::IN_PROCESS->value,
                        'success' => BankServiceRequestStatuses::DONE->value,
                        'danger' => BankServiceRequestStatuses::FAILED->value,
                        'gray' => BankServiceRequestStatuses::CANCELLED->value,
                    ]),

            ])

            ->recordActions([

                Action::make('view')
                    ->label('بررسی درخواست')
                    ->modalWidth('3xl')
                    ->fillForm(fn ($record) => $record->toArray())
                    ->schema([
                        Section::make('اطلاعات کاربر')
                            ->columns(2)
                            ->schema([
                                TextInput::make('user.name')
                                ->label('نام')
                                    ->disabled()
                                    ->formatStateUsing(fn ($record) => $record->user->name),
                                TextInput::make('user.mobile')
                                    ->label('موبایل')
                                    ->disabled()
                                    ->formatStateUsing(fn ($record) => $record->user->mobile),
                            ]),

                        Section::make('اطلاعات سرویس')
                            ->columns(2)
                            ->schema([
                                TextInput::make('bankService.title')
                                    ->label('سرویس')
                                    ->disabled()
                                    ->formatStateUsing(fn ($record) => $record->bankService->title),
                                TextInput::make('bank_service_price_title')
                                    ->label('عنوان درخواست')
                                    ->disabled(),
                                TextInput::make('bank_service_price_amount')
                                    ->label('مبلغ')
                                    ->disabled()
                                    ->formatStateUsing(fn ($state) => number_format($state) . ' تومان'),
                                TextInput::make('status')
                                    ->label('وضعیت')
                                    ->disabled()
                                    ->formatStateUsing(fn ($state) => BankServiceRequestStatuses::label($state)),
                            ]),

                        Section::make('اطلاعات پرداخت')
                            ->columns(2)
                            ->schema(function ($record) {
                                if (!$record->order) {
                                    return [
                                        EmptyState::make('پرداخت نشده')
                                            ->description('کاربر پرداخت را انجام نداده')
                                        ->columnSpanFull()
                                    ];
                                }

                                return [
                                    TextInput::make('order.total_amount')
                                        ->label('مبلغ پرداختی')
                                        ->disabled(),

                                    TextInput::make('order.order_number')
                                        ->label('شناسه پرداخت')
                                        ->disabled()
                                        ->formatStateUsing(fn ($record) => $record->order->order_number),

                                    TextInput::make('order.order_status')
                                        ->label('وضعیت پرداخت')
                                        ->disabled()
                                        ->formatStateUsing(fn ($state) => $state ? OrderStatuses::label($state) : 'بدون پرداخت'),

                                    DatePicker::make('order.paid_at')
                                        ->label('تاریخ پرداخت')
                                        ->jalali()
                                        ->disabled(),
                                ];
                            }),



                        Section::make('اطلاعات اضافی')
                            ->schema(function ($record) {

                                if (empty($record->additional_data) || !is_array($record->additional_data)) {
                                    return [

                                        TextInput::make('no_data')
                                            ->label('داده‌ای وجود ندارد')
                                            ->disabled()
                                    ];
                                }

                                $fields = [];
                                foreach ($record->additional_data as $index => $item) {
                                    if (empty($item)) continue;

                                    $title = $item['title'] ?? $item["'title'"] ?? null;
                                    $value = $item['value'] ?? $item["'value'"] ?? null;

                                    if (!$title && !$value) continue;

                                    $fields[] = TextInput::make("title_{$index}")
                                        ->label('عنوان')
                                        ->formatStateUsing(fn() => $title ?? 'بدون عنوان')
                                        ->disabled()
                                        ->dehydrated(false);

                                    $fields[] = TextInput::make("value_{$index}")
                                        ->label('مقدار')
                                        ->formatStateUsing(fn() => $value ?? '-')
                                        ->disabled()
                                        ->dehydrated(false);
                                }

                                return $fields ?: [
                                    TextInput::make('no_data')->label('داده‌ای وجود ندارد')->disabled()
                                ];
                            })
                            ->columns(2),


                        Section::make('دلیل رد')
                            ->schema([
                                Textarea::make('reject_reason')
                                    ->label('دلیل')
                                    ->disabled()
                                    ->formatStateUsing(fn ($state) => $state ?? '-'),
                            ]),
                    ])
                    ->modalSubmitAction(false)
                    ->modalCancelActionLabel('بستن')
                    ->extraModalFooterActions([
                        Action::make('changeStatus')
                            ->label('تغییر وضعیت')
                            ->icon('heroicon-o-pencil')
                            ->form([
                                Select::make('status')
                                    ->label('وضعیت')
                                    ->options([
                                        BankServiceRequestStatuses::PENDING->value => 'در انتظار',
                                        BankServiceRequestStatuses::IN_REVIEW->value => 'در حال بررسی',
                                        BankServiceRequestStatuses::IN_PROCESS->value => 'در حال انجام',
                                        BankServiceRequestStatuses::DONE->value => 'انجام شده',
                                        BankServiceRequestStatuses::FAILED->value => 'ناموفق',
                                        BankServiceRequestStatuses::CANCELLED->value => 'لغو شده',
                                    ])
                                    ->required()
                                    ->reactive(),
                                Textarea::make('reject_reason')
                                    ->label('دلیل رد')
                                    ->visible(fn ($get) => in_array($get('status'), [
                                        BankServiceRequestStatuses::FAILED->value,
                                        BankServiceRequestStatuses::CANCELLED->value,
                                    ])),
                            ])
                            ->action(function ($record, $data) {
                                $record->update([
                                    'status' => $data['status'],
                                    'reject_reason' => $data['reject_reason'] ?? null,
                                ]);
                            }),
                    ])

            ])->recordActionsColumnLabel('عملیات')

            ->headerActions([])
            ->toolbarActions([]);
    }
}
