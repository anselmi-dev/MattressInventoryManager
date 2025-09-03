<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use App\Mail\OrderShipped;
use Illuminate\Support\Facades\Mail;

class Order extends Model
{
    use HasFactory, LogsActivity, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'message',
        'status',
        'email',
    ];
    // 'pending', 'canceled', 'shipped', 'processed', 'error'

    public function sentEmail(): BelongsTo
    {
        return $this->belongsTo(SentEmail::class);
    }

    public function order_products(): HasMany
    {
        return $this->hasMany(OrderProduct::class);
    }

    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class, OrderProduct::class)->withTimestamps();
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly($this->fillable)
            ->logOnlyDirty();
    }

    /**
     * Retrieve the model for a bound value.
     *
     * @param  mixed  $value
     * @param  string|null  $field
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function resolveRouteBinding($value, $field = null)
    {
        return $this->resolveRouteBindingQuery($this->withTrashed(), $value, $field)->first();
    }

    /**
     * Status is 'pending'
     *
     * @return boolean
     */
    public function getIsPendingAttribute ():bool
    {
        return $this->status == 'pending';
    }

    /**
     * Status is 'canceled'
     *
     * @return boolean
     */
    public function getIsCanceledAttribute ():bool
    {
        return $this->status == 'canceled';
    }

    /**
     * Status is 'shipped'
     *
     * @return boolean
     */
    public function getIsShippedAttribute ():bool
    {
        return $this->status == 'shipped';
    }

    /**
     * Status is 'processed'
     *
     * @return boolean
     */
    public function getIsProcessedAttribute ():bool
    {
        return $this->status == 'processed';
    }

    public function scopeRawProducts (Builder $query)
    {
        return $query
            ->withCount([
                'products as products_count' => function($query) {
                    $query->selectRaw('count(*)');
                },
            ])
            ->withSum([
                'products as products_quantity' => function($query) {
                    $query->select(\DB::raw("SUM(quantity)"));
                },
            ], 'quantity');
    }

    /**
     * Enviar por correo la orden
     *
     * @return void
     */
    public function sendEmail (): void
    {
        if (!$this->getIsPendingAttribute()) {
            throw new \Exception('La orden no está pendiente');
        }

        if (settings()->get('notification', true)) {
            Mail::to($this->email)->queue(new OrderShipped($this));
        }

        $this->status = 'shipped';

        $this->save();
    }

    /**
     * Confirmar envío
     *
     * @param string $loteName
     * @return void
     */
    public function confirmDelivery (string $loteName): void
    {
        if (!$this->getIsShippedAttribute()) {
            throw new \Exception('La orden no está enviada');
        }

        $this->order_products->map(fn ($order_product) => ProductLot::create([
            'name' => $loteName,
            'reference' => $order_product->product->reference,
            'quantity' => $order_product->quantity,
        ]));

        $this->status = 'processed';

        $this->save();
    }
}
