<?php

use Illuminate\Support\Facades\Route;
use App\Services\FactusolHttpService;

Route::get('/FactusolHttpService', function () {

    $code = 'PACKVS';

    $response = (new FactusolHttpService())->get("SELECT CODART, STOART FROM F_ART WHERE CODART = '$code'");

    return $response;
});
