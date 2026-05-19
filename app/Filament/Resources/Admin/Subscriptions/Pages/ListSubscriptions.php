<?php

namespace App\Filament\Resources\Admin\Subscriptions\Pages;

use App\Enums\SubscriptionStatuses;
use App\Filament\Resources\Admin\Subscriptions\SubscriptionResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use Filament\Schemas\Components\Tabs\Tab;
use Illuminate\Database\Eloquent\Builder;

class ListSubscriptions extends ListRecords
{
    protected static string $resource = SubscriptionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }

    public function getTabs(): array
    {
        return [
            'all' => Tab::make('همه'),
            'active' => Tab::make('فعال')
                ->modifyQueryUsing(fn (Builder $query) => $query->where('activity_status', SubscriptionStatuses::ACTIVE->value)),
            'expired' => Tab::make('منقضی شده')
                ->modifyQueryUsing(fn (Builder $query) => $query->where('activity_status', SubscriptionStatuses::EXPIRED->value)),
            'cancelled' => Tab::make('لغو شده')
                ->modifyQueryUsing(fn (Builder $query) => $query->where('activity_status', SubscriptionStatuses::CANCELLED->value)),
        ];
    }


}
