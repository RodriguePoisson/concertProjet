<?php

namespace App\Entity;

use App\Repository\ConcertConcertRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ConcertConcertRepository::class)
 */
class ConcertConcert
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToMany(targetEntity=ConcertArtist::class, inversedBy="inviedArtists")
     */
    private $artist_invited;

    /**
     * @ORM\ManyToMany(targetEntity=ConcertBand::class, inversedBy="bands")
     */
    private $band_in;

    /**
     * @ORM\Column(type="string", length=1000)
     */
    private $description;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $picture;

    /**
     * @ORM\Column(type="date")
     */
    private $date;

    /**
     * @ORM\Column(type="integer")
     */
    private $duration;

    public function __construct()
    {
        $this->artist_invited = new ArrayCollection();
        $this->band_in = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection|ConcertArtist[]
     */
    public function getArtistInvited(): Collection
    {
        return $this->artist_invited;
    }

    public function addArtistInvited(ConcertArtist $artistInvited): self
    {
        if (!$this->artist_invited->contains($artistInvited)) {
            $this->artist_invited[] = $artistInvited;
        }

        return $this;
    }

    public function removeArtistInvited(ConcertArtist $artistInvited): self
    {
        $this->artist_invited->removeElement($artistInvited);

        return $this;
    }

    /**
     * @return Collection|ConcertBand[]
     */
    public function getBandIn(): Collection
    {
        return $this->band_in;
    }

    public function addBandIn(ConcertBand $bandIn): self
    {
        if (!$this->band_in->contains($bandIn)) {
            $this->band_in[] = $bandIn;
        }

        return $this;
    }

    public function removeBandIn(ConcertBand $bandIn): self
    {
        $this->band_in->removeElement($bandIn);

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

    public function getPicture(): ?string
    {
        return $this->picture;
    }

    public function setPicture(?string $picture): self
    {
        $this->picture = $picture;

        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getDuration(): ?int
    {
        return $this->duration;
    }

    public function setDuration(int $duration): self
    {
        $this->duration = $duration;

        return $this;
    }
}
