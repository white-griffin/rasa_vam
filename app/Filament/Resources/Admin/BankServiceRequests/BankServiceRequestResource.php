<?php

namespace App\Filament\Resources\Admin\BankServiceRequests;

use App\Filament\Resources\Admin\BankServiceRequests\Pages\ListBankServiceRequests;
use App\Filament\Resources\Admin\BankServiceRequests\Pages\ViewBankServiceRequest;
use App\Filament\Resources\Admin\BankServiceRequests\Schemas\BankServiceRequestForm;
use App\Filament\Resources\Admin\BankServiceRequests\Schemas\BankServiceRequestInfolist;
use App\Filament\Resources\Admin\BankServiceRequests\Tables\BankServiceRequestsTable;
use App\Models\BankServiceRequest;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class BankServiceRequestResource extends Resource
{
    protected static ?string $model = BankServiceRequest::class;

    protected static ?string $navigationLabel = 'درخواست ها';

    protected static ?string $pluralLabel = 'درخواست ها';

    protected static ?string $modelLabel = 'درخواست ';
    protected static ?int $navigationSort = 4;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    public static function form(Schema $schema): Schema
    {
        return BankServiceRequestForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return BankServiceRequestInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return BankServiceRequestsTable::configure($table);
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
            'index' => ListBankServiceRequests::route('/'),
            'view' => ViewBankServiceRequest::route('/{record}'),
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
