<?php


namespace App\Service;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\HttpClient\HttpClient;

class Cotizador
{
    private $client;
    private $params;

    public function __construct(ParameterBagInterface $params)
    {
        $this->params = $params;
        $this->client = HttpClient::create();
    }

    public function obtenerCotizacion($codigoMonedaBase, $codigoMonedaCotizacion)
    {
        $response = $this->client->request("GET", $this->params->get("endpoint_ultima_cotizacion") . '&format=1&symbols=' . $codigoMonedaCotizacion . '&base=' . $codigoMonedaBase);
        $statusCode = $response->getStatusCode();
        if ($statusCode != 200) return null;
        $informacionCotizacion = $response->toArray();
        if (!$informacionCotizacion["success"]) return null;
        return $informacionCotizacion['rates'][$codigoMonedaCotizacion];
    }
}