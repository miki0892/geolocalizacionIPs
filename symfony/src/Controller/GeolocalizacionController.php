<?php


namespace App\Controller;

use App\Entity\ConsultaGeolocalizacion;
use App\Form\ConsultaGeolocalizacionType;
use App\Service\Geolocalizador;
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
    public function index(Geolocalizador $geolocalizador, Request $request){
        $consultaGeolocalizacion = new ConsultaGeolocalizacion();
        $form = $this->createForm(ConsultaGeolocalizacionType::class, $consultaGeolocalizacion);
        $geolocalizacion = null;
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            // $form->getData() holds the submitted values
            // but, the original `$task` variable has also been updated
            $ip = $form->getData()->getUltimaIpConsultada();

            $geolocalizacion = $geolocalizador->getGeolocalizacion($ip);

            // ... perform some action, such as saving the task to the database
            // for example, if Task is a Doctrine entity, save it!
            // $entityManager = $this->getDoctrine()->getManager();
            // $entityManager->persist($task);
            // $entityManager->flush();

            //$geolocalizacion = new ConsultaGeolocalizacion();
        }

        return $this->render('geolocalizacion/index.html.twig', [
            'form' => $form->createView(),
            'geolocalizacion' => $geolocalizacion
        ]);
    }

    /**
     * @Route("/estadisticas")
     */
    public function verEstadisticas(){
        return $this->render('geolocalizacion/estadisticas.html.twig');
    }
}