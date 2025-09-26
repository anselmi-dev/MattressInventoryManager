<?php

namespace App\Services;

use Carbon\Carbon;
use GuzzleHttp\Client;
use Illuminate\Http\Client\RequestException;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use App\Exceptions\GetStockExceptions;
class FactusolService
{
    protected $client;

    protected $baseUrl;

    protected $apiKey;

    protected $secret;

    protected $fabricanteCode;

    protected $clienteCode;

    protected $database;

    protected $intent = false;

    public function __construct()
    {
        $this->baseUrl = config('services.factusol.url');

        $this->secret = base64_encode(config('services.factusol.secret'));

        $this->fabricanteCode = config('services.factusol.code');

        $this->clienteCode = config('services.factusol.client_code');

        $this->database = config('services.factusol.database');

        $this->apiKey = Cache::remember('factusol:key', 1010, function () {
            return $this->getBearerToken();
        });

        $this->client = new Client([
            'base_uri' => $this->baseUrl,
            'headers' => [
                'Authorization' => 'Bearer ' . $this->apiKey,
                'Content-Type' => 'application/json',
                'Accept' => 'application/json',
            ],
        ]);
    }

    protected function initToken()
    {
        Cache::forget('factusol:key');

        $this->apiKey = Cache::remember('factusol:key', 1010, function () {
            return $this->getBearerToken();
        });
    }

    protected function getBearerToken()
    {
        $data = '{"codigoFabricante":"'.$this->fabricanteCode.'","codigoCliente":"'.$this->clienteCode.'","baseDatosCliente":"'.$this->database.'","password":"'.$this->secret.'"}';

        $response = Http::baseUrl($this->baseUrl)->withOptions([
            'verify' => true,
        ])->withBody(
            $data, 'application/json'
        )->post('/login/Autenticar');

        return $response['resultado'];
    }

    public function query ($query)
    {
        try {
            $data = json_encode([
                'ejercicio' => '2025',
                'consulta' => $query
            ]);

            $response = Http::withOptions([
                'verify' => false,
            ])->withToken($this->apiKey)
            ->withBody($data, 'application/json')
            ->post($this->baseUrl . '/admin/LanzarConsulta')
            ->throw();

            return $response['resultado'];

        } catch (RequestException $e) {
            if ($e->response->status() === 401) {
                if (!$this->intent) {

                    $this->intent = true;

                    $this->initToken();

                    return $this->query($query);
                }
            }

            throw $e;
        }
    }

    public function last_updated_date_of_products ()
    {
        $data = json_encode([
            'ejercicio' => '2025',
            'consulta' => "SELECT MAX(FUMART) FROM F_ART"
        ]);

        try {

            $response = Http::withOptions([
                'verify' => false,
            ])
            ->withToken($this->apiKey)
            ->withBody($data, 'application/json')
            ->post($this->baseUrl . '/admin/LanzarConsulta')
            ->throw();

            return Carbon::parse($response['resultado'][0][0]['dato']);

        } catch (RequestException $e) {
            if ($e->response->status() === 401) {
                if (!$this->intent) {
                    $this->intent = true;

                    $this->initToken();

                    return $this->last_updated_date_of_products ();
                }
            }

            throw $e;
        }
    }

    public function products ()
    {
        try {
            return Cache::remember('factusol:products', 10, function () {
                $response = Http::withOptions([
                    'verify' => false,
                ])->withToken($this->apiKey)
                ->withBody(
                    '{
                        "ejercicio": "2025",
                        "consulta": "SELECT top 4 F_ART.CODART, F_ART.DESART, F_ART.FUMART, F_ART.FALART, F_STO.ACTSTO as ACTSTO FROM F_ART JOIN F_STO ON F_ART.CODART = F_STO.ARTSTO ORDER BY F_ART.FUMART DESC"
                    }', 'application/json'
                )->post($this->baseUrl . '/admin/LanzarConsulta');

                return $response['resultado'];
            });
        } catch (RequestException $e) {
            if ($e->response->status() === 401) {
                if (!$this->intent) {

                    $this->intent = true;

                    $this->initToken();

                    return $this->products();
                }
            }

            throw $e;
        }
    }

    public function getProducts()
    {
        try {
            return Cache::remember('factusol:products', 10, function () {
                $response = Http::withOptions([
                    'verify' => false,
                ])->withToken($this->apiKey)
                ->withBody(
                    '{
                        "ejercicio": "2025",
                        "tabla": "F_ART",
                        "filtro": "CODART != \'\'"
                    }', 'application/json'
                )->post($this->baseUrl . '/admin/CargaTabla');

                return $response['resultado'];
            });

        } catch (RequestException $e) {
            if ($e->response->status() === 401) {
                if (!$this->intent) {

                    $this->intent = true;

                    $this->initToken();

                    return $this->getProducts();

                }

                return [
                    'error' => 'Autenticación'
                ];
            }
        } catch (\Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }

    public function sales ()
    {
        try {
            return Cache::remember('factusol:sales:2025', 10100, function () {
                $response = Http::withOptions([
                    'verify' => false,
                ])->withToken($this->apiKey)
                ->withBody(
                    '{
                        "ejercicio": "2025",
                        "consulta": "SELECT F_LFA.ARTLFA, F_LFA.CANLFA, F_FAC.ESTFAC, F_FAC.FECFAC, F_FAC.CLIFAC, F_FAC.CNOFAC, F_FAC.CODFAC, F_FAC.TOTFAC FROM F_LFA JOIN F_FAC ON F_LFA.CODLFA = F_FAC.CODFAC"
                    }', 'application/json'
                )->post($this->baseUrl . '/admin/LanzarConsulta');

                return $response['resultado'];
            });
        } catch (RequestException $e) {
            report($e->getMessage());

            if ($e->response->status() === 401) {
                if (!$this->intent) {

                    $this->intent = true;

                    $this->initToken();

                    return $this->sales();
                }

                return [
                    'error' => 'Autenticación'
                ];
            }
        } catch (\Exception $e) {
            report($e);
            return [];
        }
    }

    public function get_F_ART_STOCK (string $code): array
    {
        try {

            $data = json_encode([
                'ejercicio' => '2025',
                'consulta' => "SELECT CODART, STOART FROM F_ART WHERE CODART = '$code'"
            ]);

            $response = Http::withOptions([
                'verify' => false,
            ])
            ->withToken($this->apiKey)
            ->withBody($data, 'application/json')
            ->post($this->baseUrl . '/admin/LanzarConsulta')
            ->throw();

            if ($response['respuesta'] !== 'OK') {
                throw new GetStockExceptions($response['respuesta']);
            }

            if (isset($response['resultado'][0])) {
                return $response['resultado'][0];
            }

            throw new GetStockExceptions('No se encontro el producto');

        } catch (RequestException $e) {

            if ($e->response->status() === 401) {
                if (!$this->intent) {

                    $this->intent = true;

                    $this->initToken();

                    return $this->get_F_ART_STOCK ($code);
                }
            }

            report($e);

            throw new GetStockExceptions($e->getMessage());

        } catch (\Exception $e) {

            report($e);

            throw new GetStockExceptions($e->getMessage());
        }
    }

    public function update_stock (string $code, int $quantity, bool $force = false): bool
    {
        try {

            $F_STOC = $this->get_F_ART_STOCK($code);

            $F_STOC[1]['dato'] = $quantity;

            $data = json_encode([
                "ejercicio" => "2025",
                "tabla" =>  "F_ART",
                "registro" => $F_STOC
            ]);

            $response = Http::withOptions([
                'verify' => false,
            ])
            ->withToken($this->apiKey)
            ->withBody($data, 'application/json')
            ->post($this->baseUrl . '/admin/ActualizarRegistro')
            ->throw();

            $dataResponse = $response->json();

            return $dataResponse['respuesta'] == 'OK';

        } catch (RequestException $e) {

            if ($e->response->status() === 401) {
                if (!$this->intent) {

                    $this->intent = true;

                    $this->initToken();

                    return $this->update_stock ($code, $quantity, $force);
                }
            }

            report($e);

            return false;

        } catch (\Exception $e) {

            report($e);

            return false;
        }
    }

}
