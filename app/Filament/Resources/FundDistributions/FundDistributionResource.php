<?php

namespace App\Filament\Resources\FundDistributions;

use App\Filament\Resources\FundDistributions\Pages\CreateFundDistribution;
use App\Filament\Resources\FundDistributions\Pages\EditFundDistribution;
use App\Filament\Resources\FundDistributions\Pages\ListFundDistributions;
use App\Filament\Resources\FundDistributions\Schemas\FundDistributionForm;
use App\Filament\Resources\FundDistributions\Tables\FundDistributionsTable;
use App\Models\FundDistribution;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;
use UnitEnum;

class FundDistributionResource extends Resource
{
    protected static ?string $model = FundDistribution::class;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-document-text';

    protected static ?string $navigationLabel = 'Fund Distributions';

    protected static ?string $modelLabel = 'Fund Distribution';

    protected static ?string $pluralModelLabel = 'Fund Distributions';

    protected static UnitEnum|string|null $navigationGroup = 'Finances & Ledger';

    protected static ?int $navigationSort = 2;

    protected static ?string $recordTitleAttribute = 'title';

    public static function form(Schema $schema): Schema
    {
        return FundDistributionForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return FundDistributionsTable::configure($table);
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
            'index' => ListFundDistributions::route('/'),
            'create' => CreateFundDistribution::route('/create'),
            'edit' => EditFundDistribution::route('/{record}/edit'),
        ];
    }
}
