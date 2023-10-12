<?php

namespace App\Entity;

use App\Repository\PostulateRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PostulateRepository::class)]
class Postulate
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'postulates')]
    private ?User $idUser = null;

    #[ORM\ManyToOne(inversedBy: 'postulates')]
    private ?Advertisement $advertisement = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $emailSent = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $date = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $userEmail = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $userTel = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $userName = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $userLastName = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdUser(): ?User
    {
        return $this->idUser;
    }

    public function setIdUser(?User $idUser): static
    {
        $this->idUser = $idUser;

        return $this;
    }

    public function getAdvertisement(): ?Advertisement
    {
        return $this->advertisement;
    }

    public function setAdvertisement(?Advertisement $advertisement): static
    {
        $this->advertisement = $advertisement;

        return $this;
    }

    public function getEmailSent(): ?string
    {
        return $this->emailSent;
    }

    public function setEmailSent(?string $emailSent): static
    {
        $this->emailSent = $emailSent;

        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): static
    {
        $this->date = $date;

        return $this;
    }

    public function getUserEmail(): ?string
    {
        return $this->userEmail;
    }

    public function setUserEmail(?string $userEmail): static
    {
        $this->userEmail = $userEmail;

        return $this;
    }

    public function getUserTel(): ?string
    {
        return $this->userTel;
    }

    public function setUserTel(?string $userTel): static
    {
        $this->userTel = $userTel;

        return $this;
    }

    public function getUserName(): ?string
    {
        return $this->userName;
    }

    public function setUserName(?string $userName): static
    {
        $this->userName = $userName;

        return $this;
    }

    public function getUserLastName(): ?string
    {
        return $this->userLastName;
    }

    public function setUserLastName(?string $userLastName): static
    {
        $this->userLastName = $userLastName;

        return $this;
    }
}
