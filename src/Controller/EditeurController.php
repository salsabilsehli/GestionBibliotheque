<?php

namespace App\Controller;

use App\Entity\Editeur;
use App\Form\EditeurType;
use App\Repository\EditeurRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin//editeur")
 */
class EditeurController extends AbstractController
{
    /**
     * @Route("/", name="editeur_index", methods={"GET"})
     */
    public function index(EditeurRepository $editeurRepository): Response
    {
        return $this->render('editeur/index.html.twig', [
            'titre'=>'Editeur',
            'soustitre'=>'Index',
            'lien'=>$this->generateUrl('editeur_index'),
            'editeurs' => $editeurRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="editeur_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $editeur = new Editeur();
        $form = $this->createForm(EditeurType::class, $editeur);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($editeur);
            $entityManager->flush();

            return $this->redirectToRoute('editeur_index');
        }

        return $this->render('editeur/new.html.twig', [
            'titre'=>'Editeur',
            'soustitre'=>'Nouveau',
            'lien'=>$this->generateUrl('editeur_index'),
            'editeur' => $editeur,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="editeur_show", methods={"GET"})
     */
    public function show(Editeur $editeur): Response
    {
        return $this->render('editeur/show.html.twig', [
            'titre'=>'Editeur',
            'soustitre'=>'',
            'lien'=>$this->generateUrl('editeur_index'),
            'editeur' => $editeur,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="editeur_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Editeur $editeur): Response
    {
        $form = $this->createForm(EditeurType::class, $editeur);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('editeur_index');
        }

        return $this->render('editeur/edit.html.twig', [
            'titre'=>'Editeur',
            'soustitre'=>'Editer',
            'lien'=>$this->generateUrl('editeur_index'),
            'editeur' => $editeur,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="editeur_delete", methods={"DELETE"})
     */
    public function delete(Request $request, int $id =-1): Response
    {
        if ($id >0) {
            $repEditeur =$this->getDoctrine()->getRepository(Editeur::class);
            $editeur=$repEditeur->findOneBy(['id' => $id]);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($editeur);
            $entityManager->flush();
        }

        return $this->redirectToRoute('editeur_index');
    }
}
