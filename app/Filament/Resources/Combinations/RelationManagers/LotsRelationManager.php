<?php

namespace App\Filament\Resources\Combinations\RelationManagers;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables\Table;
use App\Filament\Resources\ProductLots\Schemas\ProductLotForm;
use App\Filament\Resources\ProductLots\Tables\ProductLotsTable;
use App\Filament\Resources\ProductLots\ProductLotResource;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class LotsRelationManager extends RelationManager
{
    protected static string $relationship = 'lots';

    protected static bool $isLazy = false;

    public static function getTitle(Model $ownerRecord, string $pageClass): string
    {
        return ProductLotResource::getPluralModelLabel();
    }

    public function form(Schema $schema): Schema
    {
        $schema = ProductLotForm::configure($schema)->columns(1);

        $schema->getComponent('reference')
            ->searchable(false)
            ->hidden()
            ->disabled()
            ->relationship(
                name: 'product',
                titleAttribute: 'reference',
                modifyQueryUsing: fn (Builder $query) => $query->whereCombinations()->orderBy('name', 'asc')
            )
            ->label(__('Referencia del Colchón'))
            ->default($this->getOwnerRecord()->reference);

        $schema->getComponent('quantity')->hidden();

        return $schema;
    }

    public function table(Table $table): Table
    {
        return ProductLotsTable::configure($table)
            ->heading('Lotes del Colchón ' . $this->getOwnerRecord()->reference)
            ->description($this->getOwnerRecord()->name)
            ->headerActions([
                CreateAction::make()
                    ->label('Crear Lote')
                    ->modalHeading('Crear Lote')
                    ->modalDescription('Seleccione los datos del lote del colchón')
                    ->slideOver()
                    ->modalWidth('xl'),
            ])
            ->recordActions([
                EditAction::make()
                    ->modalHeading('Editar Lote')
                    ->modalDescription('Seleccione los datos del lote del colchón')
                    ->slideOver()
                    ->modalWidth('xl'),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
