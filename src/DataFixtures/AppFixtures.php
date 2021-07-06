<?php

namespace App\DataFixtures;
use App\Entity\Realisateur;
use App\Entity\Categorie;
use App\Entity\Salle;
use App\Entity\Film;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\ORM\EntityManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    { $this->Categorieload($manager);
        $this->Realisateurload($manager);
        $this->Salleload($manager);
        $this->Filmload($manager);
        $manager->flush();
    }
    public function Categorieload(ObjectManager $manager)
    {
        for($i=1; $i<=7; $i++)
        { $categorie=new Categorie();
            $categorie->setNom("categorie$i");
            $this->addReference("categorie$i",$categorie);
            $manager->persist($categorie);
        }
        $manager->flush();
    }

    public function Filmload(ObjectManager $manager)
    {
        for($i=1; $i<=7; $i++)
        { $film=new Film();
            $film->setTitre("film$i");
            $film->setAnnee(rand(1970,2020));
            $film->setDuree(rand(0.0,3.9));
            $film->setCouverture("images\livre.png");
            $cat = $this->getReference("categorie" . rand(1,7));
            $film->setCategorie($cat);
            $n=rand(1,4);
            for($j=1; $j<=$n; $j++)
            {
                $real=$this->getReference("realisateur". rand(1,7));
                $film->addRealisateur($real);
            }
            $manager->persist($film);
        }
        $manager->flush();
    }
    public function Realisateurload(ObjectManager $manager)
    {
        for($i=1; $i<=7; $i++)
        { $realisateur=new Realisateur();
            $realisateur->setNom("realisateur $i");
            $realisateur->setPrenom("realisateur $i");
            $this->addReference("realisateur$i",$realisateur);
            $manager->persist($realisateur);
        }
        $manager->flush();
    }
    public function Salleload(ObjectManager $manager)
    {
        for($i=1; $i<=7; $i++)
        {  $salle=new Salle();
            $this->addReference("salle$i",$salle);
            $manager->persist($salle);
        }
        $manager->flush();
    }

}
