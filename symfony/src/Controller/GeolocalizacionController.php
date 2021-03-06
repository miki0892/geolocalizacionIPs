<?php


namespace App\Controller;

use App\Entity\Geolocalizacion;
use App\Entity\Ubicacion;
use App\Form\GeolocalizacionType;
use App\Service\Geolocalizador;
use DateTime;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class GeolocalizacionController
 * @package App\Controller
 * @Route("/geolocalizacion")
 */
class GeolocalizacionController extends AbstractController
{

    /**
     * @Route("/")
     */
    public function index(Request $request, Geolocalizador $geolocalizador){
        $form = $this->createForm(GeolocalizacionType::class, new Geolocalizacion());
        $geolocalizacion = null;
        $form->handleRequest($request);
        $ipNoEncontrada = false;
        if ($form->isSubmitted() && $form->isValid()) {
            $ip = $form->getData()->getUltimaIpConsultada();
            $geolocalizacion = $geolocalizador->getGeolocalizacion($ip);
            $ipNoEncontrada = $geolocalizacion == null;
        }

        return $this->render('geolocalizacion/index.html.twig', [
            'form' => $form->createView(),
            'ipNoEncontrada' => $ipNoEncontrada,
            'geolocalizacion' => $geolocalizacion,
            'fechaActual' => new Datetime(),
            'ubicacionBuenosAires' => new Ubicacion($this->getParameter('latitud_buenos_aires'), $this->getParameter('longitud_buenos_aires'))
        ]);
    }

    /**
     * @Route("/estadisticas")
     */
    public function verEstadisticas(){
        $entityManager = $this->getDoctrine()->getManager();
        $geolocalizacionRepository = $entityManager->getRepository(Geolocalizacion::class);
        $geolocalizacionConMaximaDistanciaDesdeBsAs = $geolocalizacionRepository->obtenerGeolocalizacionMaximaDistancia();
        $geolocalizacionConMinimaDistanciaDesdeBsAs = $geolocalizacionRepository->obtenerGeolocalizacionMinimaDistancia();

        $ningunaGeolocalizacion = $geolocalizacionConMinimaDistanciaDesdeBsAs == null && $geolocalizacionConMaximaDistanciaDesdeBsAs == null;
        $promedioDistancia = 0;
        if (!$ningunaGeolocalizacion){
            $paisDistMinima = $geolocalizacionConMinimaDistanciaDesdeBsAs->getPais();
            $distanciaMinima = $geolocalizacionConMinimaDistanciaDesdeBsAs->getDistanciaDesdeBsAs();
            $cantidadInvocacionesDistMinima = $geolocalizacionConMinimaDistanciaDesdeBsAs->getCantidadInvocaciones();

            $paisDistMaxima = $geolocalizacionConMaximaDistanciaDesdeBsAs->getPais();
            $distanciaMaxima = $geolocalizacionConMaximaDistanciaDesdeBsAs->getDistanciaDesdeBsAs();
            $cantidadInvocacionesDistMaxima = $geolocalizacionConMaximaDistanciaDesdeBsAs->getCantidadInvocaciones();

            $cantidadTotalInvocaciones = $cantidadInvocacionesDistMinima +  $cantidadInvocacionesDistMaxima;
            $promedioDistancia = (($distanciaMinima * $cantidadInvocacionesDistMinima) + ($distanciaMaxima * $cantidadInvocacionesDistMaxima)) / $cantidadTotalInvocaciones;
        }


        return $this->render('geolocalizacion/estadisticas.html.twig', [
            'geolocalizacionMinimaDistancia' => $geolocalizacionConMinimaDistanciaDesdeBsAs,
            'geolocalizacionMaximaDistancia' => $geolocalizacionConMaximaDistanciaDesdeBsAs,
            'promedioDistancia' => $promedioDistancia
        ]);
    }
}