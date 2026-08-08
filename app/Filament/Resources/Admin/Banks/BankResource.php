<?php

namespace App\Filament\Resources\Admin\Banks;

use App\Filament\Resources\Admin\Banks\Pages\CreateBank;
use App\Filament\Resources\Admin\Banks\Pages\EditBank;
use App\Filament\Resources\Admin\Banks\Pages\ListBanks;
use App\Filament\Resources\Admin\Banks\Schemas\BankForm;
use App\Filament\Resources\Admin\Banks\Tables\BanksTable;
use App\Models\Bank;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class BankResource extends Resource
{
    protected static ?string $model = Bank::class;

    protected static ?string $navigationLabel = 'بانک ها';

    protected static ?string $pluralLabel = 'بانک ها';

    protected static ?string $modelLabel = 'بانک';

    protected static ?int $navigationSort = 3;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::BuildingOffice;

    public static function form(Schema $schema): Schema
    {
        return BankForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return BanksTable::configure($table);
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
            'index' => ListBanks::route('/'),
            'create' => CreateBank::route('/create'),
            'edit' => EditBank::route('/{record}/edit'),
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
