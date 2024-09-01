<?php

namespace App\Entity;

use App\Repository\AnnoncesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AnnoncesRepository::class)]
class Annonces
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50, nullable: true)]
    private ?string $title = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $updatedAt = null;

    #[ORM\ManyToOne(inversedBy: 'annonces')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Users $userId = null;

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?Descriptions $descriptionId = null;

    #[ORM\ManyToOne(inversedBy: 'annonces')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Categorys $categoryId = null;

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?Adresses $adresseId = null;

    #[ORM\ManyToOne(inversedBy: 'annonces')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Types $typeId = null;

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?Cordonnes $cordId = null;

    /**
     * @var Collection<int, Medias>
     */
    #[ORM\OneToMany(targetEntity: Medias::class, mappedBy: 'annonces')]
    private Collection $mediaId;

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?References $refId = null;

    public function __construct()
    {
        $this->mediaId = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(?string $title): static
    {
        $this->title = $title;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): static
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(\DateTimeImmutable $updatedAt): static
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    public function getUserId(): ?Users
    {
        return $this->userId;
    }

    public function setUserId(?Users $userId): static
    {
        $this->userId = $userId;

        return $this;
    }

    public function getDescriptionId(): ?Descriptions
    {
        return $this->descriptionId;
    }

    public function setDescriptionId(Descriptions $descriptionId): static
    {
        $this->descriptionId = $descriptionId;

        return $this;
    }

    public function getCategoryId(): ?Categorys
    {
        return $this->categoryId;
    }

    public function setCategoryId(?Categorys $categoryId): static
    {
        $this->categoryId = $categoryId;

        return $this;
    }

    public function getAdresseId(): ?Adresses
    {
        return $this->adresseId;
    }

    public function setAdresseId(Adresses $adresseId): static
    {
        $this->adresseId = $adresseId;

        return $this;
    }

    public function getTypeId(): ?Types
    {
        return $this->typeId;
    }

    public function setTypeId(?Types $typeId): static
    {
        $this->typeId = $typeId;

        return $this;
    }

    public function getCordId(): ?Cordonnes
    {
        return $this->cordId;
    }

    public function setCordId(Cordonnes $cordId): static
    {
        $this->cordId = $cordId;

        return $this;
    }

    /**
     * @return Collection<int, Medias>
     */
    public function getMediaId(): Collection
    {
        return $this->mediaId;
    }

    public function addMediaId(Medias $mediaId): static
    {
        if (!$this->mediaId->contains($mediaId)) {
            $this->mediaId->add($mediaId);
            $mediaId->setAnnonces($this);
        }

        return $this;
    }

    public function removeMediaId(Medias $mediaId): static
    {
        if ($this->mediaId->removeElement($mediaId)) {
            // set the owning side to null (unless already changed)
            if ($mediaId->getAnnonces() === $this) {
                $mediaId->setAnnonces(null);
            }
        }

        return $this;
    }

    public function getRefId(): ?References
    {
        return $this->refId;
    }

    public function setRefId(References $refId): static
    {
        $this->refId = $refId;

        return $this;
    }
}
