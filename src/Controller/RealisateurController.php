<?php

namespace App\Controller;

use App\Entity\Realisateur;
use App\Form\RealisateurType;
use App\Repository\RealisateurRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

/**
 * @Route("/realisateur")

 */
class RealisateurController extends AbstractController
{
    /**
     * @Route("/", name="realisateur_index", methods={"GET"})

     */
    public function index(RealisateurRepository $realisateurRepository): Response
    {
        return $this->render('realisateur/index.html.twig', [
            'realisateurs' => $realisateurRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="realisateur_new", methods={"GET","POST"})

     */
    public function new(Request $request): Response
    {
        $realisateur = new Realisateur();
        $form = $this->createForm(RealisateurType::class, $realisateur);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($realisateur);
            $entityManager->flush();

            return $this->redirectToRoute('realisateur_index');
        }

        return $this->render('realisateur/new.html.twig', [
            'realisateur' => $realisateur,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="realisateur_show", methods={"GET"})

     */
    public function show(Realisateur $realisateur): Response
    {
        return $this->render('realisateur/show.html.twig', [
            'realisateur' => $realisateur,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="realisateur_edit", methods={"GET","POST"})

     */
    public function edit(Request $request, Realisateur $realisateur): Response
    {
        $form = $this->createForm(RealisateurType::class, $realisateur);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('realisateur_index');
        }

        return $this->render('realisateur/edit.html.twig', [
            'realisateur' => $realisateur,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="realisateur_delete", methods={"DELETE"})

     */
    public function delete(Request $request, Realisateur $realisateur): Response
    {
        if ($this->isCsrfTokenValid('delete'.$realisateur->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($realisateur);
            $entityManager->flush();
        }

        return $this->redirectToRoute('realisateur_index');
    }
}
