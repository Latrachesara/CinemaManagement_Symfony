<?php

namespace App\Entity;

use App\Repository\FilmRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=FilmRepository::class)
 */
class Film
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $titre;

    /**
     * @ORM\Column(type="integer")
     */
    private $annee;

    /**
     * @ORM\Column(type="float")
     */
    private $duree;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $couverture;

    /**
     * @ORM\ManyToOne(targetEntity=Categorie::class, inversedBy="films")
     * @ORM\JoinColumn(nullable=false)
     */
    private $categorie;

    /**
     * @ORM\ManyToMany(targetEntity=Realisateur::class, inversedBy="films")
     */
    private $realisateurs;

    /**
     * @ORM\ManyToMany(targetEntity=Salle::class, mappedBy="films")
     */
    private $salles;

    public function __construct()
    {
        $this->realisateurs = new ArrayCollection();
        $this->salles = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitre(): ?string
    {
        return $this->titre;
    }

    public function setTitre(string $titre): self
    {
        $this->titre = $titre;

        return $this;
    }

    public function getAnnee(): ?int
    {
        return $this->annee;
    }

    public function setAnnee(int $annee): self
    {
        $this->annee = $annee;

        return $this;
    }

    public function getDuree(): ?float
    {
        return $this->duree;
    }

    public function setDuree(float $duree): self
    {
        $this->duree = $duree;

        return $this;
    }

    public function getCouverture(): ?string
    {
        return $this->couverture;
    }

    public function setCouverture($couverture): self
    {
        $this->couverture = $couverture;

        return $this;
    }

    public function getCategorie(): ?Categorie
    {
        return $this->categorie;
    }

    public function setCategorie(?Categorie $categorie): self
    {
        $this->categorie = $categorie;

        return $this;
    }

    /**
     * @return Collection|Realisateur[]
     */
    public function getRealisateurs(): Collection
    {
        return $this->realisateurs;
    }

    public function addRealisateur(Realisateur $realisateur): self
    {
        if (!$this->realisateurs->contains($realisateur)) {
            $this->realisateurs[] = $realisateur;
        }

        return $this;
    }

    public function removeRealisateur(Realisateur $realisateur): self
    {
        $this->realisateurs->removeElement($realisateur);

        return $this;
    }

    /**
     * @return Collection|Salle[]
     */
    public function getSalles(): Collection
    {
        return $this->salles;
    }

    public function addSalle(Salle $salle): self
    {
        if (!$this->salles->contains($salle)) {
            $this->salles[] = $salle;
            $salle->addFilm($this);
        }

        return $this;
    }

    public function removeSalle(Salle $salle): self
    {
        if ($this->salles->removeElement($salle)) {
            $salle->removeFilm($this);
        }

        return $this;
    }
}
