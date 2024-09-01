<?php

namespace App\Entity;

use App\Repository\UsersRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity(repositoryClass: UsersRepository::class)]
#[ORM\UniqueConstraint(name: 'UNIQ_IDENTIFIER_EMAIL', fields: ['email'])]
#[UniqueEntity(fields: ['email'], message: 'There is already an account with this email')]
class Users implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 180)]
    private ?string $email = null;

    /**
     * @var list<string> The user roles
     */
    #[ORM\Column]
    private array $roles = [];

    /**
     * @var string The hashed password
     */
    #[ORM\Column]
    private ?string $password = null;

    #[ORM\Column(length: 50)]
    #[Assert\NotBlank()]
    #[Assert\Length(min:2,max:50)]
    private ?string $prenom = null;

    #[ORM\Column(length: 50)]
    #[Assert\NotBlank()]
    #[Assert\Length(min:2,max:50)]
    private ?string $nom = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $createdAt = null;

    /**
     * @var Collection<int, Annonces>
     */
    #[ORM\OneToMany(targetEntity: Annonces::class, mappedBy: 'userId')]
    private Collection $annonces;

    /**
     * @var Collection<int, Contacts>
     */
    #[ORM\OneToMany(targetEntity: Contacts::class, mappedBy: 'users')]
    private Collection $userId;

    /**
     * @var Collection<int, Messages>
     */
    #[ORM\OneToMany(targetEntity: Messages::class, mappedBy: 'users')]
    private Collection $messageId;

    #[ORM\Column]
    private bool $isVerified = false;

    public function __construct()
    {
        $this->annonces = new ArrayCollection();
        $this->userId = new ArrayCollection();
        $this->messageId = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     *
     * @return list<string>
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    /**
     * @param list<string> $roles
     */
    public function setRoles(array $roles): static
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials(): void
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): static
    {
        $this->prenom = $prenom;

        return $this;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): static
    {
        $this->nom = $nom;

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

    /**
     * @return Collection<int, Annonces>
     */
    public function getAnnonces(): Collection
    {
        return $this->annonces;
    }

    public function addAnnonce(Annonces $annonce): static
    {
        if (!$this->annonces->contains($annonce)) {
            $this->annonces->add($annonce);
            $annonce->setUserId($this);
        }

        return $this;
    }

    public function removeAnnonce(Annonces $annonce): static
    {
        if ($this->annonces->removeElement($annonce)) {
            // set the owning side to null (unless already changed)
            if ($annonce->getUserId() === $this) {
                $annonce->setUserId(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Contacts>
     */
    public function getUserId(): Collection
    {
        return $this->userId;
    }

    public function addUserId(Contacts $userId): static
    {
        if (!$this->userId->contains($userId)) {
            $this->userId->add($userId);
            $userId->setUsers($this);
        }

        return $this;
    }

    public function removeUserId(Contacts $userId): static
    {
        if ($this->userId->removeElement($userId)) {
            // set the owning side to null (unless already changed)
            if ($userId->getUsers() === $this) {
                $userId->setUsers(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Messages>
     */
    public function getMessageId(): Collection
    {
        return $this->messageId;
    }

    public function addMessageId(Messages $messageId): static
    {
        if (!$this->messageId->contains($messageId)) {
            $this->messageId->add($messageId);
            $messageId->setUsers($this);
        }

        return $this;
    }

    public function removeMessageId(Messages $messageId): static
    {
        if ($this->messageId->removeElement($messageId)) {
            // set the owning side to null (unless already changed)
            if ($messageId->getUsers() === $this) {
                $messageId->setUsers(null);
            }
        }

        return $this;
    }

    public function isVerified(): bool
    {
        return $this->isVerified;
    }

    public function setVerified(bool $isVerified): static
    {
        $this->isVerified = $isVerified;

        return $this;
    }
}
