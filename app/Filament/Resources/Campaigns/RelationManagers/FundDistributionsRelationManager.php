<?php

namespace App\Filament\Resources\Campaigns\RelationManagers;

use App\Models\Campaign;
use App\Models\FundDistribution;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Table;

class FundDistributionsRelationManager extends RelationManager
{
    protected static string $relationship = 'fundDistributions';

    protected static ?string $title = 'Campaign Outflows (Disbursements & Bills)';

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('title')
                    ->label('Disbursement Title / Purpose')
                    ->required()
                    ->maxLength(255),

                TextInput::make('beneficiary_name')
                    ->label('Beneficiary / Vendor Name')
                    ->required()
                    ->maxLength(255),

                TextInput::make('amount_spent')
                    ->label('Amount Disbursed (INR)')
                    ->numeric()
                    ->prefix('₹')
                    ->required()
                    ->minValue(0.01),

                DatePicker::make('distribution_date')
                    ->label('Date of Disbursement')
                    ->default(now())
                    ->required(),

                Toggle::make('is_public')
                    ->label('Show on Public Transparency Ledger')
                    ->default(true),

                Textarea::make('description')
                    ->label('Ground Impact & Expense Notes')
                    ->rows(2)
                    ->columnSpanFull(),

                FileUpload::make('proof_bill_image')
                    ->label('Official Bill / Voucher / Receipt Image')
                    ->disk('public')
                    ->directory('distributions/bills')
                    ->image()
                    ->maxSize(2048),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('title')
            ->columns([
                TextColumn::make('distribution_date')
                    ->label('Date')
                    ->date('d M Y')
                    ->sortable(),

                TextColumn::make('title')
                    ->label('Disbursement Title')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),

                TextColumn::make('beneficiary_name')
                    ->label('Beneficiary / Vendor')
                    ->searchable(),

                TextColumn::make('amount_spent')
                    ->label('Amount Disbursed')
                    ->money('INR')
                    ->sortable()
                    ->weight('bold'),

                ToggleColumn::make('is_public')
                    ->label('Public Ledger'),

                ImageColumn::make('proof_bill_image')
                    ->disk('public')
                    ->square()
                    ->label('Bill'),
            ])
            ->headerActions([
                CreateAction::make()
                    ->label('Record Ground Disbursement')
                    ->after(function (FundDistribution $record) {
                        if ($record->campaign_id) {
                            Campaign::where('id', $record->campaign_id)->increment('distributed_amount', (float) $record->amount_spent);
                        }
                    }),
            ])
            ->actions([
                EditAction::make(),
                DeleteAction::make()->before(function (FundDistribution $record) {
                    if ($record->campaign_id) {
                        Campaign::where('id', $record->campaign_id)->decrement('distributed_amount', (float) $record->amount_spent);
                    }
                }),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('distribution_date', 'desc');
    }
}
