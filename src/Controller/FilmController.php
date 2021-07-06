<?php

namespace App\Controller;

use App\Entity\Film;

use App\Form\FilmType;
use App\Repository\FilmRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

/**
 * @Route("/film")

 */
class FilmController extends AbstractController
{
    /**
     * @Route("/", name="film_index", methods={"GET"})

     */
    public function index(FilmRepository $filmRepository): Response
    {
        return $this->render('film/index.html.twig', [
            'films' => $filmRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="film_new", methods={"GET","POST"})

     */
    public function new(Request $request): Response
    {
        $film = new Film();
        $form = $this->createForm(FilmType::class, $film);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if ($film->getCouverture()=="")
                $film->setCouverture("no_livre.jpg");
            else {
                $file = new File($film->getCouverture());
                $fileName= md5(uniqid()).'.'.$file->guessExtension();
                $file->move($this->getParameter('upload_directory'), $fileName);
                $film->setCouverture($fileName);
            }
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($film);
            $entityManager->flush();

            return $this->redirectToRoute('film_index');
        }

        return $this->render('film/new.html.twig', [
            'film' => $film,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="film_show", methods={"GET"})

     */
    public function show(Film $film): Response
    {
        return $this->render('film/show.html.twig', [
            'film' => $film,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="film_edit", methods={"GET","POST"})

     */
    public function edit(Request $request, Film $film): Response
    {
        $name= $film->getCouverture();
        $form = $this->createForm(FilmType::class, $film);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if ($film->getCouverture()=="")
                $film->setCouverture($name);
            else {
                $file = new File ($film->getCouverture());
                $fileName= md5(uniqid()).'.'.$file->guessExtension();
                $file->move($this->getParameter('upload_directory'), $fileName);
                $film->setCouverture($fileName);
                if ($name!="no_livre.jpg")
                if ( file_exists( "tures/".$name))
                    unlink("tures/".$name);
            }

            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('film_index');
        }

        return $this->render('film/edit.html.twig', [
            'film' => $film,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="film_delete", methods={"DELETE"})

     */
    public function delete(Request $request, Film $film): Response
    {
        if ($this->isCsrfTokenValid('delete'.$film->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($film);
            $entityManager->flush();
        }

        return $this->redirectToRoute('film_index');
    }
}
