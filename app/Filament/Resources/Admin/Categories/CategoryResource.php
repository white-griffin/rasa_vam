<?php

namespace App\Filament\Resources\Admin\Categories;

use App\Filament\Resources\Admin\Categories\Pages\CreateCategory;
use App\Filament\Resources\Admin\Categories\Pages\EditCategory;
use App\Filament\Resources\Admin\Categories\Pages\ListCategories;
use App\Filament\Resources\Admin\Categories\Schemas\CategoryForm;
use App\Filament\Resources\Admin\Categories\Tables\CategoriesTable;
use App\Models\Category;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class CategoryResource extends Resource
{
    protected static ?string $model = Category::class;

    protected static ?string $navigationLabel = 'دسته بندی ها';

    protected static ?string $pluralLabel = 'دسته بندی ها';

    protected static ?string $modelLabel = 'دسته بندی';

    protected static ?int $navigationSort = 3;
    protected static string|BackedEnum|null $navigationIcon = Heroicon::ChartPie;

    public static function form(Schema $schema): Schema
    {
        return CategoryForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return CategoriesTable::configure($table);
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
            'index' => ListCategories::route('/'),
            'create' => CreateCategory::route('/create'),
            'edit' => EditCategory::route('/{record}/edit'),
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
