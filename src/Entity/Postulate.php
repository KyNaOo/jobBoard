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
    private ?User $userId = null;

    #[ORM\ManyToOne(inversedBy: 'postulates')]
    private ?Advertisement $advertisementId = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $emailSent = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $date = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUserId(): ?User
    {
        return $this->userId;
    }

    public function setUserId(?User $userId): static
    {
        $this->userId = $userId;

        return $this;
    }

    public function getAdvertisementId(): ?Advertisement
    {
        return $this->advertisementId;
    }

    public function setAdvertisementId(?Advertisement $advertisementId): static
    {
        $this->advertisementId = $advertisementId;

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
}
