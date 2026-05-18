<?php

namespace App\Filament\Resources\Admin\BankServices;

use App\Filament\Resources\Admin\BankServices\Pages\CreateBankServices;
use App\Filament\Resources\Admin\BankServices\Pages\EditBankServices;
use App\Filament\Resources\Admin\BankServices\Pages\ListBankServices;
use App\Filament\Resources\Admin\BankServices\Schemas\BankServicesForm;
use App\Filament\Resources\Admin\BankServices\Tables\BankServicesTable;
use App\Models\BankService;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class BankServicesResource extends Resource
{
    protected static ?string $model = BankService::class;

    protected static ?string $navigationLabel = 'خدمات بانکی';

    protected static ?string $pluralLabel = 'خدمات بانکی';

    protected static ?string $modelLabel = 'خدمت بانکی';

    protected static ?int $navigationSort = 3;
    protected static string|BackedEnum|null $navigationIcon = Heroicon::BuildingLibrary;


    public static function form(Schema $schema): Schema
    {
        return BankServicesForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return BankServicesTable::configure($table);
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
            'index' => ListBankServices::route('/'),
            'create' => CreateBankServices::route('/create'),
            'edit' => EditBankServices::route('/{record}/edit'),
        ];
    }

    public static function getRecordRouteBindingEloquentQuery(): Builder
    {
        return parent::getRecordRouteBindingEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }
}
