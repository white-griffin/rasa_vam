<?php

namespace App\Filament\Resources\Admin\ServicePrices;

use App\Filament\Resources\Admin\ServicePrices\Pages\CreateServicePrice;
use App\Filament\Resources\Admin\ServicePrices\Pages\EditServicePrice;
use App\Filament\Resources\Admin\ServicePrices\Pages\ListServicePrices;
use App\Filament\Resources\Admin\ServicePrices\Schemas\ServicePriceForm;
use App\Filament\Resources\Admin\ServicePrices\Tables\ServicePricesTable;
use App\Models\ServicePrice;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class ServicePriceResource extends Resource
{
    protected static ?string $model = ServicePrice::class;

    protected static ?string $navigationLabel = 'تعرفه خدمات';

    protected static ?string $pluralLabel = 'تعرفه خدمات';

    protected static ?string $modelLabel = 'تعرفه ';

    protected static ?int $navigationSort = 5;
    protected static string|BackedEnum|null $navigationIcon = Heroicon::Banknotes;

    public static function form(Schema $schema): Schema
    {
        return ServicePriceForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return ServicePricesTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListServicePrices::route('/'),
            'create' => CreateServicePrice::route('/create'),
            'edit' => EditServicePrice::route('/{record}/edit'),
        ];
    }
}
