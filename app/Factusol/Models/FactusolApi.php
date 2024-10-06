<?php

namespace App\Factusol\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Http;

class FactusolApi extends Model
{
    use HasFactory;

    /**
     * Generates a bearer token from the Factusol API
     * 
     * @return string $response['resultado'] returns the bearer token
     */
    public static function getBearerToken($credential)
    {
        $data = '{"codigoFabricante":"'.$credential->codigoFabricante.'","codigoCliente":"'.$credential->codigoCliente.'","baseDatosCliente":"'.$credential->baseDatosCliente.'","password":"'.$credential->password.'"}';
        
        $response = Http::withOptions([
            'verify' => false,
        ])->withBody(
           $data, 'application/json'
        )->post('https://api.sdelsol.com/login/Autenticar');

        return $response['resultado'];
    }
}