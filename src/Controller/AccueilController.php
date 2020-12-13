<?php

namespace App\Controller;

use App\Entity\Auteur;
use App\Entity\Categorie;
use App\Entity\Editeur;
use App\Entity\Livre;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin")
 */
class AccueilController extends AbstractController
{
    /**
     * @Route("/accueil", name="accueil")
     */
    public function index()
    {

        $nbAuteurs= count($this->getDoctrine()->getRepository(Auteur::class)->findAll());
        $nbLivres=count($this->getDoctrine()->getRepository(Livre::class)->findAll());
        $nbEditeurs=count($this->getDoctrine()->getRepository(Editeur::class)->findAll());
        $nbCategories=count($this->getDoctrine()->getRepository(Categorie::class)->findAll());
        return $this->render('accueil/index.html.twig', [
            'titre'=>'Accueil',
            'soustitre'=>'',
            'lien'=>$this->generateUrl('accueil'),
            'nbAuteurs' =>  $nbAuteurs,
            'nbLivres'=>$nbLivres,
            'nbEditeurs'=>$nbEditeurs,
            'nbCategories'=>$nbCategories,
        ]);
    }
}
