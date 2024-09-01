<?php

namespace App\Entity;

use App\Repository\MediasRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MediasRepository::class)]
class Medias
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    private ?string $type_media = null;

    #[ORM\Column(length: 255)]
    private ?string $file_path = null;

    #[ORM\ManyToOne(inversedBy: 'mediaId')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Annonces $annonces = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTypeMedia(): ?string
    {
        return $this->type_media;
    }

    public function setTypeMedia(string $type_media): static
    {
        $this->type_media = $type_media;

        return $this;
    }

    public function getFilePath(): ?string
    {
        return $this->file_path;
    }

    public function setFilePath(string $file_path): static
    {
        $this->file_path = $file_path;

        return $this;
    }

    public function getAnnonces(): ?Annonces
    {
        return $this->annonces;
    }

    public function setAnnonces(?Annonces $annonces): static
    {
        $this->annonces = $annonces;

        return $this;
    }
}
