<?php

namespace App\Entity;

use App\Repository\ConcertArtistRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ConcertArtistRepository::class)
 */
class ConcertArtist
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $last_name;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $pseudo;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $picture;

    /**
     * @ORM\Column(type="string", length=1000, nullable=true)
     */
    private $biography;

    /**
     * @ORM\ManyToMany(targetEntity=ConcertConcert::class, mappedBy="artist_invited")
     */
    private $invitedArtists;

    public function __construct()
    {
        $this->invitedArtists = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->last_name;
    }

    public function setLastName(?string $last_name): self
    {
        $this->last_name = $last_name;

        return $this;
    }

    public function getPseudo(): ?string
    {
        return $this->pseudo;
    }

    public function setPseudo(string $pseudo): self
    {
        $this->pseudo = $pseudo;

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

    public function getBiography(): ?string
    {
        return $this->biography;
    }

    public function setBiography(?string $biography): self
    {
        $this->biography = $biography;

        return $this;
    }

    /**
     * @return Collection|ConcertConcert[]
     */
    public function getInvitedArtists(): Collection
    {
        return $this->invitedArtists;
    }

    public function addInviedArtist(ConcertConcert $inviedArtist): self
    {
        if (!$this->invitedArtists->contains($inviedArtist)) {
            $this->invitedArtists[] = $inviedArtist;
            $inviedArtist->addArtistInvited($this);
        }

        return $this;
    }

    public function removeInviedArtist(ConcertConcert $inviedArtist): self
    {
        if ($this->invitedArtists->removeElement($inviedArtist)) {
            $inviedArtist->removeArtistInvited($this);
        }

        return $this;
    }
}
