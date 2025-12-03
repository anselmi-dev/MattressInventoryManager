<?php

namespace App\Models;

use App\Events\ProductSaleImportCompletedEvent;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class ProductSaleImport extends Model
{
    use HasFactory;

    public const STATUS_PENDING = 'pending';

    public const STATUS_PROCESSING = 'processing';

    public const STATUS_PROCESSED = 'processed';

    public const STATUS_ERROR = 'error';

    protected $fillable = [
        'documento',
        'codigo',
        'fecha',
        'prov_cli',
        'serie_lote',
        'articulo',
        'unidades',
        'fabr_env',
        'cons_pref',
        'serie_lot',
        'status',
    ];

    public const STATUS_OPTIONS = [
        self::STATUS_PENDING => 'Pendiente',
        self::STATUS_PROCESSING => 'Procesando',
        self::STATUS_PROCESSED => 'Procesado',
        self::STATUS_ERROR => 'Error',
    ];

    public function getStatusLabelAttribute(): string
    {
        return match ($this->status) {
            static::STATUS_PENDING => 'Pendiente',
            static::STATUS_PROCESSING => 'Procesando',
            static::STATUS_PROCESSED => 'Procesado',
            static::STATUS_ERROR => 'Error',
        };
    }

    public function scopeWhereStatusPending(Builder $query): Builder
    {
        return $query->where('status', static::STATUS_PENDING);
    }

    public function scopeWhereStatusProcessing(Builder $query): Builder
    {
        return $query->where('status', static::STATUS_PROCESSING);
    }

    public function scopeWhereStatusProcessed(Builder $query): Builder
    {
        return $query->where('status', static::STATUS_PROCESSED);
    }

    public function scopeWhereStatusError(Builder $query): Builder
    {
        return $query->where('status', static::STATUS_ERROR);
    }

    public function isError(): bool
    {
        return $this->status === static::STATUS_ERROR;
    }

    public function setStatusPending(): void
    {
        $this->update([
            'status' => static::STATUS_PENDING,
        ]);
    }

    public function setStatusProcessing(): void
    {
        $this->update([
            'status' => static::STATUS_PROCESSING,
        ]);
    }

    public function setStatusProcessed(): void
    {
        $this->update([
            'status' => static::STATUS_PROCESSED,
        ]);
    }

    public function setStatusError(): void
    {
        $this->update([
            'status' => static::STATUS_ERROR,
        ]);
    }

    public function runProcess (?bool $force = false): bool
    {
        if ($this->status !== static::STATUS_PENDING && !$force) {
            throw new \Exception('La importación de ventas ' . $this->id . ' ya ha sido procesada o no está pendiente de procesar.');
        }

        $this->setStatusPending();

        $productLot = ProductLot::whereName($this->serie_lote)->first();

        if ($productLot) {

            ProductLot::withoutEvents(fn () => $productLot->decrementProductLotStock($this->unidades));

            $this->setStatusProcessed();

            return true;

        } else {

            $this->setStatusError();

            throw new \Exception('No se pudo procesar la importación. El lote [' . $this->serie_lote . '] no existe.');
        }
    }
}

