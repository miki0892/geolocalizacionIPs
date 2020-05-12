<?php


namespace App\Service;
use App\Entity\ConsultaGeolocalizacion;
use Doctrine\ORM\EntityManager;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\HttpClient\HttpClient;

class Geolocalizador
{

    private $client;
    private $params;
    private $entityManager;

    public function __construct(ParameterBagInterface $params, EntityManager $entityManager)
    {
        $this->params = $params;
        $this->entityManager = $entityManager;
        $this->client = HttpClient::create();
    }

    public function getGeolocalizacion($ip)
    {
        $response = $this->client->request("GET", $this->params->get("endpoint_geolocalizacion_ips") . $ip);
        $statusCode = $response->getStatusCode();
        $geolocalizacion = null;
        if ($statusCode != 200){
            return $geolocalizacion;
        }
        $codigoIsoPais = $response->toArray()['countryCode'];

        $geolocalizacionRepository = $this->entityManager->getRepository(ConsultaGeolocalizacion::class);
        $geolocalizacion = $geolocalizacionRepository->findOneByCodigoIsoPais($codigoIsoPais);

        if ($geolocalizacion == null){
            $geolocalizacion = $this->buscarInformacionPais($codigoIsoPais);
        }
        // actualizar ip y cantidad invocaciones

        return $geolocalizacion;
    }

    public function calcularDistanciaEntreCoordenadas($ubicacionOrigen, $ubicacionDestino){

    }

    private function buscarInformacionPais($codigoIsoPais){
        $response = $this->client->request("GET", $this->params->get("endpoint_info_pais_por_codigo_iso") . $codigoIsoPais);
        $statusCode = $response->getStatusCode();
        $geolocalizacion = null;
        if ($statusCode != 200){
            return $geolocalizacion;
        }
        $infoPais = $response->toArray();
        $geolocalizacion = new ConsultaGeolocalizacion();
        $geolocalizacion->cargarInformacionPais($infoPais);
        obtenerCotizacion();

        //Cargar moneda
        //Calcular distancia (servicio)
        // Llamar servicio pais y guardar todo en base
    }

    private function obtenerCotizacion(){

    }


}
