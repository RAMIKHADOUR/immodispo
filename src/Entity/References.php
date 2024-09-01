<?php

namespace App\Entity;

use App\Repository\ReferencesRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ReferencesRepository::class)]
#[ORM\Table(name: '`references`')]
class References
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $code_ref = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCodeRef(): ?string
    {
        return $this->code_ref;
    }

    public function setCodeRef(string $code_ref): static
    {
        $this->code_ref = $code_ref;

        return $this;
    }
}
