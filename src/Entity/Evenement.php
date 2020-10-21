<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;


/**
 * @ApiResource()
 * @ORM\Entity(repositoryClass="App\Repository\EvenementRepository")
 */
class Evenement
{
    /**
     * @Groups({"event"})
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @Groups({"event"})
     * @ORM\Column(type="string", length=255)
     */
    private $libelle;

    /**
     * @Groups({"event"})
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $descriptif;

    /**
     * @Groups({"event"})
     * @ORM\Column(type="date")
     */
    private $datedebut;

    /**
     * @Groups({"event"})
     * @ORM\Column(type="time", nullable=true)
     */
    private $heuredebut;

    /**
     * @Groups({"event"})
     * @ORM\Column(type="time", nullable=true)
     */
    private $heurefin;


    /**
     * @Groups({"event"})
     * @ORM\ManyToOne(targetEntity="App\Entity\Groupe", inversedBy="evenements")
     */
    private $groupe;

   

    /**
     * @ORM\Column(type="string", length=20)
     */
    private $frequence;

    /**
     * @Groups({"event"})
     * @ORM\ManyToOne(targetEntity="App\Entity\Enfant", inversedBy="evenements")
     * @ORM\JoinColumn(name="enfant_id", referencedColumnName="id")
     */
    private $enfant;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $user;


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLibelle(): ?string
    {
        return $this->libelle;
    }

    public function setLibelle(string $libelle): self
    {
        $this->libelle = $libelle;

        return $this;
    }

    public function getDescriptif(): ?string
    {
        return $this->descriptif;
    }

    public function setDescriptif(?string $descriptif): self
    {
        $this->descriptif = $descriptif;

        return $this;
    }

    public function getDatedebut(): ?\DateTimeInterface
    {
        return $this->datedebut;
    }

    public function setDatedebut(\DateTimeInterface $datedebut): self
    {
        $this->datedebut = $datedebut;

        return $this;
    }


    public function getHeuredebut(): ?\DateTimeInterface
    {
        return $this->heuredebut;
    }

    public function setHeuredebut(?\DateTimeInterface $heuredebut): self
    {
        $this->heuredebut = $heuredebut;

        return $this;
    }

    public function getHeurefin(): ?\DateTimeInterface
    {
        return $this->heurefin;
    }

    public function setHeurefin(?\DateTimeInterface $heurefin): self
    {
        $this->heurefin = $heurefin;

        return $this;
    }

    public function getGroupe(): ?Groupe
    {
        return $this->groupe;
    }

    public function setGroupe(?Groupe $groupe): self
    {
        $this->groupe = $groupe;

        return $this;
    }


    public function getFrequence(): ?string
    {
        return $this->frequence;
    }

    public function setFrequence(string $frequence): self
    {
        $this->frequence = $frequence;

        return $this;
    }

    public function getEnfant(): ?Enfant
    {
        return $this->enfant;
    }

    public function setEnfant(?Enfant $enfant): self
    {
        $this->enfant = $enfant;

        return $this;
    }

    public function getUser(): ?int
    {
        return $this->user;
    }

    public function setUser(?int $user): self
    {
        $this->user = $user;

        return $this;
    }

}
