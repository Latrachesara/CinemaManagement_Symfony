<?php

namespace App\Controller;
use App\Entity\Categorie;
use App\Form\CategorieType;
use App\Entity\Film;
use App\Form\FilmType;
use App\Repository\CategorieRepository;
use App\Repository\FilmRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;


class AccueilController extends AbstractController
{
    /**
     * @Route("/accueil", name="accueil")

     */
    public function index(CategorieRepository $categorieRepository)
    {
        return $this->render('accueil/index.html.twig', [
            'categories' => $categorieRepository->findAll(),
        ]);
    }


    /**
     * @Route("/filmparcat/{id}", name="filmparcat")

     */
    public function filmparcat(Categorie $categorie)
    {
        return $this->render('accueil/filmparcat.html.twig', [
            'categorie' => $categorie,
        ]);
    }


    /**
     * @Route("/allmovies", name="allmovies")

     */
    public function allmovies(FilmRepository $filmRepository, Request $request, PaginatorInterface $paginator)
    {
        $films = $paginator->paginate(
            $filmRepository->findAllFilms(),
            $request->query->getInt('page', 1),
            4
        );
        return $this->render('accueil/allmovies.html.twig', [
            'films' => $films
        ]);
    }

    /**
     * @Route("/findbytitre", name="findbytitre")

     */
    public function findByTitre(FilmRepository $filmRepository, Request $request)
    {
        $films = [];
        $titre ="";
        $etat = false;
        if ($request->getMethod() == "POST")
        {
            $titre = $request->request->get("titre");
            $films = $filmRepository->findByTitre($titre);
            $etat = true;

        }
        return $this->render('accueil/findbytitre.html.twig', [
            "films"=> $films,
            "titre" => $titre,
            "etat" => $etat

        ]);
    }

    /**
     * @Route("/findbyannee", name="findbyannee")
     */
    public function findByAnnee(FilmRepository $filmRepository, Request $request)
    {
        $films = [];
        $annee ="";
        $etat = false;
        if ($request->getMethod() == "POST")
        {
            $annee = $request->request->get("annee");
            $films = $filmRepository->findByAnnee($annee);
            $etat = true;

        }
        return $this->render('accueil/findbyannee.html.twig', [
            "films"=> $films,
            "annee" => $annee,
            "etat" => $etat,
            "annee_courante" => date('Y')

        ]);
    }



}
