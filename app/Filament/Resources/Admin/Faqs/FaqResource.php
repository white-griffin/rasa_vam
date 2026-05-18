<?php

namespace App\Filament\Resources\Admin\Faqs;

use App\Filament\Resources\Admin\Faqs\Pages\CreateFaq;
use App\Filament\Resources\Admin\Faqs\Pages\EditFaq;
use App\Filament\Resources\Admin\Faqs\Pages\ListFaqs;
use App\Filament\Resources\Admin\Faqs\Schemas\FaqForm;
use App\Filament\Resources\Admin\Faqs\Tables\FaqsTable;
use App\Models\Faq;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class FaqResource extends Resource
{
    protected static ?string $model = Faq::class;

    protected static ?string $navigationLabel = 'سوالات متداول';

    protected static ?string $pluralLabel = 'سوالات متداول';

    protected static ?string $modelLabel = 'سوالات متداول';

    protected static ?int $navigationSort = 8;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::QuestionMarkCircle;

    public static function form(Schema $schema): Schema
    {
        return FaqForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return FaqsTable::configure($table);
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
            'index' => ListFaqs::route('/'),
            'create' => CreateFaq::route('/create'),
            'edit' => EditFaq::route('/{record}/edit'),
        ];
    }
}
