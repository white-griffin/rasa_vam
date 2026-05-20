<?php

namespace App\Filament\Resources\Admin\LoanAds;

use App\Filament\Resources\Admin\LoanAds\Pages\CreateLoanAd;
use App\Filament\Resources\Admin\LoanAds\Pages\EditLoanAd;
use App\Filament\Resources\Admin\LoanAds\Pages\ListLoanAds;
use App\Filament\Resources\Admin\LoanAds\Schemas\LoanAdForm;
use App\Filament\Resources\Admin\LoanAds\Tables\LoanAdsTable;
use App\Models\LoanAd;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class LoanAdResource extends Resource
{
    protected static ?string $model = LoanAd::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::ClipboardDocumentList;

    protected static ?string $navigationLabel = 'آگهی های وام';

    protected static ?string $modelLabel = 'آگهی وام';
    protected static ?string $pluralModelLabel = 'آگهی های وام';
    protected static ?int $navigationSort = 6;


    public static function form(Schema $schema): Schema
    {
        return LoanAdForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return LoanAdsTable::configure($table);
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
            'index' => ListLoanAds::route('/'),
            'create' => CreateLoanAd::route('/create'),
            'edit' => EditLoanAd::route('/{record}/edit'),
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
