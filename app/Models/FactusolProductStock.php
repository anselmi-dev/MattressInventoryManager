<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FactusolProductStock extends Model
{
    protected $table = 'factusol_product_stocks';

    protected $fillable = [
        'ARTSTO',
        'ALMSTO',
        'MINSTO',
        'MAXSTO',
        'ACTSTO',
        'DISSTO',
        'UBISTO',
    ];

    public function product()
    {
        return $this->belongsTo(FactusolProduct::class, 'ARTSTO', 'CODART');
    }
}
