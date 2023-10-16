<?php

namespace App\Entity;

use App\Repository\AdvertisementRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Metadata\ApiResource;

#[ORM\Entity(repositoryClass: AdvertisementRepository::class)]
#[ApiResource]
class Advertisement
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $title = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $description = null;

    #[ORM\Column(length: 255)]
    private ?string $location = null;

    #[ORM\Column(length: 255)]
    private ?string $adress = null;

    #[ORM\ManyToOne(inversedBy: 'advertisements')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Company $companyId = null;

    #[ORM\OneToMany(mappedBy: 'advertisementId', targetEntity: Postulate::class)]
    private Collection $postulates;

    #[ORM\Column(length: 255)]
    private ?string $wages = null;

    #[ORM\Column(length: 255)]
    private ?string $contract = null;

    #[ORM\Column(length: 255)]
    private ?string $workingTime = null;

    #[ORM\ManyToOne(inversedBy: 'advertisements')]
    private ?User $userId = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $datePub = null;

    public function __construct()
    {
        $this->postulates = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): static
    {
        $this->title = $title;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getLocation(): ?string
    {
        return $this->location;
    }

    public function setLocation(string $location): static
    {
        $this->location = $location;

        return $this;
    }

    public function getAdress(): ?string
    {
        return $this->adress;
    }

    public function setAdress(string $adress): static
    {
        $this->adress = $adress;

        return $this;
    }

    public function getCompanyId(): ?Company
    {
        return $this->companyId;
    }

    public function setCompanyId(?Company $companyId): static
    {
        $this->companyId = $companyId;

        return $this;
    }

    /**
     * @return Collection<int, Postulate>
     */
    public function getPostulates(): Collection
    {
        return $this->postulates;
    }

    public function addPostulate(Postulate $postulate): static
    {
        if (!$this->postulates->contains($postulate)) {
            $this->postulates->add($postulate);
            $postulate->setAdvertisementId($this);
        }

        return $this;
    }

    public function removePostulate(Postulate $postulate): static
    {
        if ($this->postulates->removeElement($postulate)) {
            // set the owning side to null (unless already changed)
            if ($postulate->getAdvertisementId() === $this) {
                $postulate->setAdvertisementId(null);
            }
        }

        return $this;
    }

    public function getWages(): ?string
    {
        return $this->wages;
    }

    public function setWages(string $wages): static
    {
        $this->wages = $wages;

        return $this;
    }

    public function getContract(): ?string
    {
        return $this->contract;
    }

    public function setContract(string $contract): static
    {
        $this->contract = $contract;

        return $this;
    }

    public function getWorkingTime(): ?string
    {
        return $this->workingTime;
    }

    public function setWorkingTime(string $workingTime): static
    {
        $this->workingTime = $workingTime;

        return $this;
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

    public function getDatePub(): ?\DateTimeInterface
    {
        return $this->datePub;
    }

    public function setDatePub(?\DateTimeInterface $datePub): static
    {
        $this->datePub = $datePub;

        return $this;
    }

}
