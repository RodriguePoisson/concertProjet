<?php

namespace App\Entity;

use App\Repository\ConcertBandRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ConcertBandRepository::class)
 */
class ConcertBand
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
    private $name;

    /**
     * @ORM\ManyToMany(targetEntity=ConcertArtist::class)
     */
    private $artist;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $picture;

    /**
     * @ORM\Column(type="string", length=1000)
     */
    private $description;

    /**
     * @ORM\ManyToMany(targetEntity=ConcertConcert::class, mappedBy="band_in")
     */
    private $bands;

    public function __construct()
    {
        $this->artist = new ArrayCollection();
        $this->bands = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return Collection|ConcertArtist[]
     */
    public function getArtist(): Collection
    {
        return $this->artist;
    }

    public function addArtist(ConcertArtist $artist): self
    {
        if (!$this->artist->contains($artist)) {
            $this->artist[] = $artist;
        }

        return $this;
    }

    public function removeArtist(ConcertArtist $artist): self
    {
        $this->artist->removeElement($artist);

        return $this;
    }

    public function getPicture(): ?string
    {
        return $this->picture;
    }

    public function setPicture(?string $picture): self
    {
        $this->picture = $picture;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return Collection|ConcertConcert[]
     */
    public function getBands(): Collection
    {
        return $this->bands;
    }

    public function addBand(ConcertConcert $band): self
    {
        if (!$this->bands->contains($band)) {
            $this->bands[] = $band;
            $band->addBandIn($this);
        }

        return $this;
    }

    public function removeBand(ConcertConcert $band): self
    {
        if ($this->bands->removeElement($band)) {
            $band->removeBandIn($this);
        }

        return $this;
    }
}
