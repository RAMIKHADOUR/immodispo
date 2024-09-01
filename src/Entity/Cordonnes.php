<?php

namespace App\Entity;

use App\Repository\CordonnesRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CordonnesRepository::class)]
class Cordonnes
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    private ?string $civilite = null;

    #[ORM\Column(length: 100)]
    private ?string $prenom_nom = null;

    #[ORM\Column(length: 255)]
    private ?string $email = null;

    #[ORM\Column(length: 100)]
    private ?string $tele_mobile = null;

    #[ORM\Column(length: 100, nullable: true)]
    private ?string $tele_fixe = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCivilite(): ?string
    {
        return $this->civilite;
    }

    public function setCivilite(string $civilite): static
    {
        $this->civilite = $civilite;

        return $this;
    }

    public function getPrenomNom(): ?string
    {
        return $this->prenom_nom;
    }

    public function setPrenomNom(string $prenom_nom): static
    {
        $this->prenom_nom = $prenom_nom;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    public function getTeleMobile(): ?string
    {
        return $this->tele_mobile;
    }

    public function setTeleMobile(string $tele_mobile): static
    {
        $this->tele_mobile = $tele_mobile;

        return $this;
    }

    public function getTeleFixe(): ?string
    {
        return $this->tele_fixe;
    }

    public function setTeleFixe(?string $tele_fixe): static
    {
        $this->tele_fixe = $tele_fixe;

        return $this;
    }
}
