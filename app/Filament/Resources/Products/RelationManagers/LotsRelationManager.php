<?php

namespace App\Filament\Resources\Products\RelationManagers;

use Filament\Actions\AssociateAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\DissociateAction;
use Filament\Actions\DissociateBulkAction;
use Filament\Actions\EditAction;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use App\Filament\Resources\ProductLots\Schemas\ProductLotForm;
use App\Filament\Resources\ProductLots\Tables\ProductLotsTable;
use App\Filament\Resources\ProductLots\ProductLotResource;
use Illuminate\Database\Eloquent\Model;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DateTimePicker;
use Filament\Schemas\Components\Section;
use Illuminate\Database\Eloquent\Builder;

class LotsRelationManager extends RelationManager
{
    protected static string $relationship = 'lots';

    public static function getTitle(Model $ownerRecord, string $pageClass): string
    {
        return ProductLotResource::getPluralModelLabel();
    }

    public function form(Schema $schema): Schema
    {
        $schema = ProductLotForm::configure($schema);

        $schema->getComponent('reference')
            ->relationship(
                name: 'product',
                titleAttribute: 'reference',
                modifyQueryUsing: fn (Builder $query) => $query->whereNotCombinations()->orderBy('name', 'asc')
            );

        $relatedLots = $schema->getComponent('relatedLots');
        if ($relatedLots) {
            $relatedLots->minItems(0)->hidden();
        }

        $schema->getComponent('reference')
            ->searchable(false)
            ->disabled()
            ->default($this->getOwnerRecord()->reference);

        return $schema;
    }

    public function formByRecord(Schema $schema, $record): Schema
    {
        return $schema
            ->components([
                Section::make(false)
                    ->description(false)
                    ->schema([
                        TextInput::make('name')
                            ->label(__('filament.resources.name'))
                            ->required(),
                        Select::make('reference')
                            ->relationship('product', 'reference')
                            ->label(__('filament.resources.reference'))
                            ->searchable()
                            ->preload()
                            ->required(),
                        TextInput::make('quantity')
                            ->label(__('filament.resources.quantity'))
                            ->required()
                            ->minValue(0)
                            ->numeric(),
                        DateTimePicker::make('created_at')
                            ->label(__('filament.resources.created_at'))
                            ->default(now())
                            ->required(),
                    ])
            ]);
    }

    public function table(Table $table): Table
    {
        $productLotsTable = ProductLotsTable::configure($table);

        $productLotsTable->getColumn('related_lots_count')
            ->hidden();

        return $productLotsTable
            ->heading('Lotes del Producto ' . $this->getOwnerRecord()->reference)
            ->description($this->getOwnerRecord()->name)
            ->headerActions([
                CreateAction::make()
                    ->label('Crear Lote')
                    ->modalHeading('Crear Lote')
                    ->modalDescription('Seleccione los datos del lote del producto')
                    ->slideOver()
                    ->modalWidth('xl'),
            ])
            ->recordActions([
                EditAction::make()
                    ->modalHeading('Editar Lote')
                    ->modalDescription('Seleccione los datos del lote del producto')
                    ->slideOver()
                    ->modalWidth('xl'),
                // DissociateAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    // DissociateBulkAction::make(),
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
