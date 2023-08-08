<?php

namespace App\Entity;

use App\Repository\ZamowieniaRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ZamowieniaRepository::class)]

class Zamowienia
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $data = null;

    #[ORM\Column]
    private ?float $wartosc = null;

    #[ORM\Column(length: 255)]
    private ?string $produkt = null;

    #[ORM\Column]
    private ?int $ileProduktow = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getData(): ?string
    {
        return $this->data;
    }

    public function setData(string $data): static
    {
        $this->data = $data;

        return $this;
    }

    public function getWartosc(): ?float
    {
        return $this->wartosc;
    }

    public function setWartosc(float $wartosc): static
    {
        $this->wartosc = $wartosc;

        return $this;
    }

    public function getProdukt(): ?string
    {
        return $this->produkt;
    }

    public function setProdukt(string $produkt): static
    {
        $this->produkt = $produkt;

        return $this;
    }

    public function getIleProduktow(): ?int
    {
        return $this->ileProduktow;
    }

    public function setIleProduktow(int $ileProduktow): static
    {
        $this->ileProduktow = $ileProduktow;

        return $this;
    }
}
