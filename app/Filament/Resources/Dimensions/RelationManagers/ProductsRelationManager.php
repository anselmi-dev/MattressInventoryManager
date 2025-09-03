<?php

namespace App\Filament\Resources\Dimensions\RelationManagers;

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
use App\Filament\Resources\Products\Tables\ProductsTable;
use App\Filament\Resources\Products\Schemas\ProductForm;

class ProductsRelationManager extends RelationManager
{
    protected static string $relationship = 'products';

    protected static ?string $title = "Productos relacionados";

    protected static ?string $label = "Productos";

    protected static ?string $modelLabel = 'Producto';

    protected static ?string $pluralLabel = "Productos";

    protected static ?string $pluralModelLabel = 'Productos';

    public function form(Schema $schema): Schema
    {
        return ProductForm::configure($schema);
    }

    public function table(Table $table): Table
    {
        return ProductsTable::configure($table);
    }
}
