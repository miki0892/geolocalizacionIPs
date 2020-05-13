<?php


namespace App\Service;
use App\Entity\Geolocalizacion;
use App\Entity\Moneda;
use App\Entity\Ubicacion;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\HttpClient\HttpClient;

class Geolocalizador
{

    private $client;
    private $params;
    private $entityManager;
    private $cotizador;

    public function __construct(ParameterBagInterface $params, EntityManagerInterface $entityManager, Cotizador $cotizador)
    {
        $this->params = $params;
        $this->entityManager = $entityManager;
        $this->client = HttpClient::create();
        $this->cotizador = $cotizador;
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
        if ($codigoIsoPais == null || $codigoIsoPais == ""){
            return $geolocalizacion;
        }

        $geolocalizacionRepository = $this->entityManager->getRepository(Geolocalizacion::class);
        $geolocalizacion = $geolocalizacionRepository->findOneByCodigoIsoPais($codigoIsoPais);

        if ($geolocalizacion == null) {
            $geolocalizacion = $this->buscarInformacionPais($codigoIsoPais);
        }
        $geolocalizacion->setUltimaIpConsultada($ip);
        $geolocalizacion->aumentarCantidadInvocaciones();
        $this->entityManager->persist($geolocalizacion);
        $this->entityManager->flush();
        return $geolocalizacion;
    }

    public function calcularDistanciaEntreCoordenadas(Ubicacion $ubicacionOrigen, Ubicacion $ubicacionDestino){
        $radioPlanetaTierra = 6371; //radio tierra en kilometros

        $latitudOrigen = deg2rad($ubicacionOrigen->getLatitud());
        $longitudOrigen = deg2rad($ubicacionOrigen->getLongitud());
        $latitudDestino = deg2rad($ubicacionDestino->getLatitud());
        $longitudDestino = deg2rad($ubicacionDestino->getLongitud());

        $deltaLatitud = $latitudDestino - $latitudOrigen;
        $deltaLongitud = $longitudDestino - $longitudOrigen;

        $angulo = 2 * asin(sqrt(pow(sin($deltaLatitud / 2), 2) +
                cos($latitudOrigen) * cos($latitudDestino) * pow(sin($deltaLongitud / 2), 2)));
        return $angulo * $radioPlanetaTierra;
    }

    private function buscarInformacionPais($codigoIsoPais){
        $response = $this->client->request("GET", $this->params->get("endpoint_info_pais_por_codigo_iso") . $codigoIsoPais);
        $statusCode = $response->getStatusCode();
        $geolocalizacion = null;
        if ($statusCode != 200) return $geolocalizacion;
        $infoPais = $response->toArray();
        $geolocalizacion = new Geolocalizacion();
        $geolocalizacion->cargarInformacionPais($infoPais);
        foreach ($infoPais['currencies'] as $moneda){
            $codigoMoneda = $moneda['code'];
            $cotizacionEnUSD = $this->cotizador->obtenerCotizacion($codigoMoneda, 'USD');
            $geolocalizacion->getPais()->addMoneda(new Moneda($codigoMoneda, $cotizacionEnUSD));
        }
        $ubicacionBsAs = new Ubicacion($this->params->get('latitud_buenos_aires'), $this->params->get('longitud_buenos_aires'));
        $distanciaDesdeBsAs = $this->calcularDistanciaEntreCoordenadas($ubicacionBsAs, $geolocalizacion->getPais()->getUbicacion());
        $geolocalizacion->setDistanciaDesdeBsAs($distanciaDesdeBsAs);
        return $geolocalizacion;
    }
}
