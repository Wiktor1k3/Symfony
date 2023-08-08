<?php

namespace App\Entity;

use App\Repository\PersonalDateRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PersonalDateRepository::class)]
class PersonalDate
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id;

    #[ORM\OneToOne(targetEntity: User::class)]
    #[ORM\JoinColumn(name: 'user', referencedColumnName: 'id')]
    private ?User $user;

    #[ORM\Column(length: 255)]
    private ?string $Name;

    #[ORM\Column(length: 255)]
    private ?string $Lastname;

    #[ORM\Column(length: 255)]
    private ?string $PostalCode;

    #[ORM\Column(length: 255)]
    private ?string $city;

    #[ORM\Column(length: 255)]
    private ?string $StreetAndNumberHouse;

    #[ORM\Column(length: 255)]
    private ?string $Country;

    #[ORM\Column]
    private ?int $MobileNumber;


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->Name;
    }

    public function setName(string $Name): static
    {
        $this->Name = $Name;

        return $this;
    }

    public function getLastname(): ?string
    {
        return $this->Lastname;
    }

    public function setLastname(string $Lastname): static
    {
        $this->Lastname = $Lastname;

        return $this;
    }

    public function getPostalCode(): ?string
    {
        return $this->PostalCode;
    }

    public function setPostalCode(string $PostalCode): static
    {
        $this->PostalCode = $PostalCode;

        return $this;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(string $city): static
    {
        $this->city = $city;

        return $this;
    }

    public function getStreetAndNumberHouse(): ?string
    {
        return $this->StreetAndNumberHouse;
    }

    public function setStreetAndNumberHouse(string $StreetAndNumberHouse): static
    {
        $this->StreetAndNumberHouse = $StreetAndNumberHouse;

        return $this;
    }

    public function getCountry(): ?string
    {
        return $this->Country;
    }

    public function setCountry(string $Country): static
    {
        $this->Country = $Country;

        return $this;
    }

    public function getMobileNumber(): ?int
    {
        return $this->MobileNumber;
    }

    public function setMobileNumber(int $MobileNumber): static
    {
        $this->MobileNumber = $MobileNumber;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }
}
