<?php

namespace App\Services;

use Carbon\Carbon;
use GuzzleHttp\Psr7\Response;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Client\PendingRequest;
use Illuminate\Http\Client\RequestException;
use Exception;

class FactusolHttpService
{
    CONST CACHE_KEY_TOKEN = 'factusol:token';

    CONST URL_CONSULTA = '/admin/LanzarConsulta';

    CONST URL_CARGATABLA = '/admin/CargaTabla';

    CONST URL_ACTUALIZARREGISTRO = '/admin/ActualizarRegistro';

    protected Carbon $expiresAt;

    protected string $ejercicio;

    protected $client;

    protected ?string $token;

    public function __construct()
    {
        $this->ejercicio = date('Y');

        $this->setToken(Cache::get(self::CACHE_KEY_TOKEN));

        $this->client = Http::withOptions([
            'verify' => true,
        ])
        ->withHeaders([
            'Content-Type' => 'application/json',
            'Accept' => 'application/json'
        ])
        ->baseUrl(
            config('services.factusol.baseUrl')
        );
    }

    public function getCredentials(bool $encode = false): mixed
    {
        $credentials = config('services.factusol.credentials');

        $credentials['password'] = base64_encode($credentials['password']);

        return !$encode ? $credentials : json_encode($credentials);
    }

    public function setToken(?string $token): self
    {
        $this->token = $token;

        Cache::forget(self::CACHE_KEY_TOKEN);

        Cache::put(self::CACHE_KEY_TOKEN, $token);

        try {

            $explode_token = explode('.', $token);

            $payload = json_decode(base64_decode($explode_token[1]), true);

            $this->expiresAt = Carbon::createFromTimestamp($payload['exp']);

        } catch (\Exception $e) {

            report($e);

            Cache::forget(self::CACHE_KEY_TOKEN);

            $this->token = null;
        }

        return $this;
    }

    private function generateBearToken(): string
    {
        $credentials = $this->getCredentials(true);

        $response = Http::withOptions([
                'verify' => true,
            ])
            ->withHeaders([
                'Content-Type' => 'application/json',
                'Accept' => 'application/json'
            ])
            ->baseUrl(
                config('services.factusol.baseUrl')
            )
            ->withBody(
                $credentials, 'application/json'
            )
            ->post('/login/Autenticar')
            ->throw()
            ->object();

        if ($response->respuesta != 'OK') {
            throw new \Exception('Error al obtener el token: ' . $response->mensaje);
        }

        return $response->resultado;
    }

    public function getToken(): ?string
    {
        return $this->token;
    }

    public function getExpiresAt()
    {
        return $this->expiresAt;
    }

    public function getExpiresAtSeconds()
    {
        return $this->expiresAt instanceof Carbon ? $this->expiresAt->diffInSeconds(Carbon::now()) : 0;
    }

    public function getNewToken(): string
    {
        $this->setToken($this->generateBearToken());

        return $this->token;
    }

    private function request(string $method, string $url, array $data = [])
    {
        $data['ejercicio'] = $this->ejercicio;

        $body = json_encode($data);

        $response = $this->client
            ->withToken($this->getToken() ?? $this->getNewToken())
            ->withBody($body, 'application/json')
            ->retry(2, 5, function (Exception $exception, PendingRequest $request) {
                if (! $exception instanceof RequestException || $exception->response->status() !== 401) {
                    return false;
                }

                $request->withToken($this->getNewToken());

                return true;
            })
            ->$method($url)
            ->throw();

        return $response;
    }

    public function consultaQuery (string $query): Object
    {
        $response = $this->request(
            method: 'POST',
            url: self::URL_CONSULTA,
            data: [
                'consulta' => $query
            ]
        )
        ->object();

        return $response;
    }

    public function actualizarRegistro(array $registro): Object
    {
        $response = $this->request(
            method: 'POST',
            url: self::URL_ACTUALIZARREGISTRO,
            data: $registro
        )
        ->object();

        return $response;
    }
}

