<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FactusolProduct extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'CODART', // CODE
        'DESART', // DESCRIPTION
        'STOART', // STOCK
        'PESART', // WEIGTH
        'REFART', // REFERENCE
        'OBSART', // OBSERVATION
        'PCOART', // COSTO DEL ARTÍCULO
        'ACTSTO', // CODE
        'EANART',
        'EQUART',
        'CCOART',
        'FAMART',
        'DEEART',
        'DETART',
        'PHAART',
        'TIVART',
        'DT0ART',
        'DT1ART',
        'DT2ART',
        'FALART',
        'MDAART',
        'UBIART',
        'UELART',
        'UPPART',
        'DIMART',
        'MEMART',
        'NPUART',
        'NIAART',
        'COMART',
        'CP1ART',
        'CP2ART',
        'CP3ART',
        'DLAART',
        'IPUART',
        'NCCART',
        'CUCART',
        'CANART',
        'IMGART',
        'SUWART',
        'DELART',
        'DEWART',
        'MEWART',
        'CSTART',
        'IMWART',
        'FUMART',
        'FTEART',
        'ACOART',
        'GARART',
        'UMEART',
        'TMOART',
        'CONART',
        'TIV2ART',
        'DE1ART',
        'DE2ART',
        'DE3ART',
        'DFIART',
        'RPUART',
        'RPFART',
        'RCUART',
        'RCFART',
        'MECART',
        'DSCART',
        'AMAART',
        'CAEART',
        'UFSART',
        'IMFART',
        'PFIART',
        'MPTART',
        'CP4ART',
        'CP5ART',
        'ORDART',
        'UEQART',
        'DCOART',
        'FAVART',
        'DSTART',
        'VEWART',
        'URAART',
        'VMPART',
        'UR1ART',
        'UR2ART',
        'UR3ART',
        'CN8ART',
        'OCUART',
        'RSVART',
        'NVSART',
        'DEPART',
        'SDEART',
        'CASART',
        'HALART',
        'UALART',
        'HUMART',
        'UUMART',
    ];

    // CODART: Código del artículo.
    // EANART: Código de barras EAN del artículo.
    // DESART: Descripción del artículo.
    // FAMART: Código de familia del artículo.
    // PCOART: Precio de coste del artículo.
    // PHAART: Código de fase o etapa del artículo.
    // TIVART: Tipo de IVA del artículo.
    // FALART: Fecha de alta del artículo.
    // OBSART: Observaciones del artículo.
    // REFART: Referencia del artículo.
    // CSTART: Código de estado del artículo.
    // FUMART: Fecha de última modificación del artículo.
    // TMOART: Tipo de moneda del artículo.
    // CONART: Contenido del artículo o código de configuración.
    // STOART: Stock disponible del artículo.
    // PESART: Peso del artículo.
    // ORDART: Orden del artículo.
    // FAVART: Indicador de favorito o activo (por ejemplo, "N" para no).
}
