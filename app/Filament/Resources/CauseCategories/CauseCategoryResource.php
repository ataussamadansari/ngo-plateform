<?php

namespace App\Filament\Resources\CauseCategories;

use App\Filament\Resources\CauseCategories\Pages\CreateCauseCategory;
use App\Filament\Resources\CauseCategories\Pages\EditCauseCategory;
use App\Filament\Resources\CauseCategories\Pages\ListCauseCategories;
use App\Filament\Resources\CauseCategories\Schemas\CauseCategoryForm;
use App\Filament\Resources\CauseCategories\Tables\CauseCategoriesTable;
use App\Models\CauseCategory;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;
use UnitEnum;

class CauseCategoryResource extends Resource
{
    protected static ?string $model = CauseCategory::class;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-tag';

    protected static ?string $navigationLabel = 'Cause Categories';

    protected static ?string $modelLabel = 'Cause Category';

    protected static ?string $pluralModelLabel = 'Cause Categories';

    protected static UnitEnum|string|null $navigationGroup = 'Campaigns & Causes';

    protected static ?int $navigationSort = 2;

    protected static ?string $recordTitleAttribute = 'name';

    public static function form(Schema $schema): Schema
    {
        return CauseCategoryForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return CauseCategoriesTable::configure($table);
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
            'index' => ListCauseCategories::route('/'),
            'create' => CreateCauseCategory::route('/create'),
            'edit' => EditCauseCategory::route('/{record}/edit'),
        ];
    }
}
