<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request as HttpFoundationRequest;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

class ApiController extends AbstractController
{
    /**
     * @Route("/listeRegion", name="listeRegion", methods={"GET"})
     */
    public function listeRegion()
    {
        $mesRegions = file_get_contents('https://geo.api.gouv.fr/regions');
        // $mesRegions = $serializer->deserialize($mesRegions, 'App\Entity\Region[]', 'json');
        $maRégion = json_decode($mesRegions);
        return $this->render('api/index.html.twig', [
            'maRégion' => $maRégion
        ]);
    }

    /**
     * @Route("/listeDepsParRegion", name="listeDepsParRegion", methods={"GET"})
     */
    public function listeDepsParRegion(HttpFoundationRequest $request, SerializerInterface $serializer)
    {
        // je récupère la région selectionné dans le formulaire 
      $codeRegion = $request->query->get('region');
      //je récupère les régions
      $mesRegions = file_get_contents('https://geo.api.gouv.fr/regions');
      $maRégion = json_decode($mesRegions);

      //Je récupère la liste des départements
        if ($codeRegion == null || $codeRegion =="Toutes"){
            $mesDeps = file_get_contents('https://geo.api.gouv.fr/departements');
        }else{
            $mesDeps = file_get_contents('https://geo.api.gouv.fr/regions/'.$codeRegion.'/departements');
        }

        // décodage du format json 
        $mesDeps = json_decode($mesDeps) ;

        return $this->render('api/listeDépartement.html.twig', [
            'maRégion' => $maRégion,
            'mesDeps' => $mesDeps
        ]);
    }
}
    