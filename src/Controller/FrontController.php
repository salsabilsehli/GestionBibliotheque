<?php

namespace App\Controller;

use App\Entity\Auteur;
use App\Entity\Categorie;
use App\Entity\Editeur;
use App\Entity\Livre;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FrontController extends AbstractController
{
    /**
     * @Route("/", name="front")
     */
    public function index(): Response
    {
        $repCategorie = $this->getDoctrine()->getRepository(Categorie::class);
        $categories=$repCategorie->findAll();
        return $this->render('Front.html.twig',[
            'categories'=>$categories
        ]);
    }


    /**
     * @Route("/listeDesLivres", name="booklist")
     */
    public function booklist(): Response
    {
        $repLivre = $this->getDoctrine()->getRepository(Livre::class);
        $livres=$repLivre->findAll();
        return $this->render('front/booklist.html.twig',[
            'livres'=>$livres
        ]);
    }

    /**
     * @Route("/detailsLivre/{id}", name="bookdetails")
     */
    public function bookdetails(int $id): Response
    {
        $repLivre = $this->getDoctrine()->getRepository(Livre::class);
        $livre=$repLivre->findOneBy(['id'=>$id]);
        return $this->render('front/bookdetails.html.twig',[
            'livre'=>$livre
        ]);
    }

    /**
     * @Route("/chercherParAuteur", name ="chercher_auteur")
     */
    public function chercher_auteur(Request $request)
    {
        $auteur = $request->request->get('auteur');

        if ($auteur == NULL)
            return $this->redirectToRoute('front');
        else {
            $repAuteur = $this->getDoctrine()->getRepository(Auteur::class);
            $Auteurs = $repAuteur->findBy(['nom' => $auteur]);
            $em = $this->getDoctrine()->getManager();


            $query=$em->createQuery(
                'SELECT l
    FROM App\Entity\Livre l , App\Entity\Auteur a
    WHERE a.id IN (:auteursids) '
            )->setParameter('auteursids',$Auteurs);

            $livres = $query->getResult();

            return $this->render('front/booklistsearch.html.twig', [
                'livres'=>$livres,

            ]);
        }


    }

    /**
     * @Route("/chercherParNomLivre", name ="chercher_livre")
     */
    public function chercher_livre(Request $request)
    {
        $nomLivre = $request->request->get('livre');

        if ($nomLivre == NULL)
            return $this->redirectToRoute('front');
        else {
            $repLivre = $this->getDoctrine()->getRepository(Livre::class);
            $livres = $repLivre->findBy(['titre' => $nomLivre]);


            return $this->render('front/booklistsearch.html.twig', [
                'livres'=>$livres,

            ]);
        }


    }
    /**
     * @Route("/chercherParEditeur", name ="chercher_editeur")
     */
    public function chercher_editeur(Request $request)
    {
        $nomediteur = $request->request->get('editeur');

        if ($nomediteur == NULL)
            return $this->redirectToRoute('front');
        else {
            $repEditeur = $this->getDoctrine()->getRepository(Editeur::class);
            $repLivre = $this->getDoctrine()->getRepository(Livre::class);
            $editeur=$repEditeur->findBy(['nomEditeur'=>$nomediteur]);
            $livres = $repLivre->findByEditeur($editeur);


            return $this->render('front/booklistsearch.html.twig', [
                'livres'=>$livres,

            ]);
        }


    }
    /**
     * @Route("/Categories/{nom}", name ="chercher_categorie")
     */
    public function chercher_Categories(string $nom,Request $request)
    {

            $repCategorie = $this->getDoctrine()->getRepository(Categorie::class);
            $repLivre = $this->getDoctrine()->getRepository(Livre::class);
            $categorie=$repCategorie->findBy(['designation'=>$nom]);
            $livres = $repLivre->findByCategorie($categorie);


            return $this->render('front/booklistsearch.html.twig', [
                'livres'=>$livres,

            ]);
        }




}
