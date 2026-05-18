<?php

namespace App\Filament\Resources\Admin\Newsletters;

use App\Filament\Resources\Admin\Newsletters\Pages\CreateNewsletter;
use App\Filament\Resources\Admin\Newsletters\Pages\EditNewsletter;
use App\Filament\Resources\Admin\Newsletters\Pages\ListNewsletters;
use App\Filament\Resources\Admin\Newsletters\Schemas\NewsletterForm;
use App\Filament\Resources\Admin\Newsletters\Tables\NewslettersTable;
use App\Models\NewsLetter;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class NewsletterResource extends Resource
{
    protected static ?string $model = Newsletter::class;

    protected static ?string $navigationLabel = 'ایمیل های خبرنامه';

    protected static ?string $pluralLabel = 'ایمیل های خبرنامه';

    protected static ?string $modelLabel = 'ایمیل های خبرنامه ';
    protected static string|BackedEnum|null $navigationIcon = Heroicon::EnvelopeOpen;

    protected static ?int $navigationSort = 9;
    protected static ?string $recordTitleAttribute = 'خبرنامه';

    public static function form(Schema $schema): Schema
    {
        return NewsletterForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return NewslettersTable::configure($table);
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
            'index' => ListNewsletters::route('/'),
            'create' => CreateNewsletter::route('/create'),
            'edit' => EditNewsletter::route('/{record}/edit'),
        ];
    }
}
