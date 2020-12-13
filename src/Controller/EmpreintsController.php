<?php

namespace App\Controller;

use App\Entity\Categorie;
use App\Entity\Empreinte;
use App\Entity\Livre;
use App\Entity\User;
use App\Form\EmpreinteType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class EmpreintsController extends AbstractController
{
    /**
     * @Route("/empreints/{userId}/{livreId}", name="empreints")
     */
    public function index(Request $request,int $userId, int $livreId): Response
    {
        $em = $this->getDoctrine()->getManager();

        $repLivre = $this->getDoctrine()->getRepository(Livre::class);
        $repUser = $this->getDoctrine()->getRepository(User::class);

        $empreinte = new Empreinte();
        $form = $this->createForm(EmpreinteType::class, $empreinte);
        $form->handleRequest($request);
        $livre=$repLivre->findOneBy(['id'=>$livreId]);
        $user=$repUser->findOneBy(['id'=>$userId]);

        if ($form->isSubmitted() && $form->isValid()) {

            $empreinte->setLivre($livre);
            $empreinte->setUser($user);

            $em->persist($empreinte);
            $em->flush();

            return $this->redirectToRoute('front',[


            ]);
        }
        return $this->render('empreints/new.html.twig', [
            'form' => $form->createView(),
        ]);


    }

    /**
     * @Route("//admin/empreints", name="Liste_Empreintes", methods={"GET"})
     */
    public function ListeEmpreints(): Response
    {

        $repEmpreint = $this->getDoctrine()->getRepository(Empreinte::class);

        $empreints = $repEmpreint->findAll();

        return $this->render('empreints/empreintslist.html.twig', [
            'titre'=>'Empreints',
            'soustitre'=>'Index',
            'lien'=>$this->generateUrl('Liste_Empreintes'),
            'empreints' => $empreints,
        ]);
    }
}
