<?php


namespace App\Controller;

use App\Entity\ConsultaGeolocalizacion;
use App\Form\ConsultaGeolocalizacionType;
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
    public function index(Request $request){
        $consultaGeolocalizacion = new ConsultaGeolocalizacion();
        $form = $this->createForm(ConsultaGeolocalizacionType::class, $consultaGeolocalizacion);
        $consultaGeolocalizacion = null;
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            // $form->getData() holds the submitted values
            // but, the original `$task` variable has also been updated
            $task = $form->getData();

            // ... perform some action, such as saving the task to the database
            // for example, if Task is a Doctrine entity, save it!
            // $entityManager = $this->getDoctrine()->getManager();
            // $entityManager->persist($task);
            // $entityManager->flush();

            $consultaGeolocalizacion = new ConsultaGeolocalizacion();
        }

        return $this->render('geolocalizacion/index.html.twig', [
            'form' => $form->createView(),
            'resultados' => $consultaGeolocalizacion
        ]);
    }

    /**
     * @Route("/estadisticas")
     */
    public function verEstadisticas(){
        return $this->render('geolocalizacion/estadisticas.html.twig');
    }
}