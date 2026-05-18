<?php

namespace App\Filament\Resources\Admin\UserContacts;


use App\Filament\Resources\Admin\UserContacts\Pages\ListUserContacts;
use App\Filament\Resources\Admin\UserContacts\Pages\ViewUserContact;
use App\Filament\Resources\Admin\UserContacts\Schemas\UserContactForm;
use App\Filament\Resources\Admin\UserContacts\Schemas\UserContactInfolist;
use App\Filament\Resources\Admin\UserContacts\Tables\UserContactsTable;
use App\Models\UserContact;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class UserContactResource extends Resource
{
    protected static ?string $model = UserContact::class;

    protected static ?string $navigationLabel = 'ارتباط کاربران';

    protected static ?string $pluralLabel = 'ارتباط کاربران';

    protected static ?string $modelLabel = 'ارتباط کاربران ';

    protected static ?int $navigationSort = 8;
    protected static string|BackedEnum|null $navigationIcon = Heroicon::Envelope;

    public static function form(Schema $schema): Schema
    {
        return UserContactForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return UserContactInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return UserContactsTable::configure($table);
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
            'index' => ListUserContacts::route('/'),
            'view' => ViewUserContact::route('/{record}'),
        ];
    }

    public static function canCreate(): bool
    {
        return false;
    }
}
