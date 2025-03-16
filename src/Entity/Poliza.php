<?php

namespace App\Entity;

use App\Entity\Cliente;
use App\Repository\PolizaRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PolizaRepository::class)]
class Poliza
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $numero = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $fechaVencimiento = null;

    #[ORM\Column(length: 255)]
    private ?string $tipoSeguro = null;

    #[ORM\ManyToOne(inversedBy: 'polizas')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Cliente $cliente = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNumero(): ?string
    {
        return $this->numero;
    }

    public function setNumero(string $numero): static
    {
        $this->numero = $numero;

        return $this;
    }

    public function getFechaVencimiento(): ?\DateTimeInterface
    {
        return $this->fechaVencimiento;
    }

    public function setFechaVencimiento(\DateTimeInterface $fechaVencimiento): static
    {
        $this->fechaVencimiento = $fechaVencimiento;

        return $this;
    }

    public function getTipoSeguro(): ?string
    {
        return $this->tipoSeguro;
    }

    public function setTipoSeguro(string $tipoSeguro): static
    {
        $this->tipoSeguro = $tipoSeguro;

        return $this;
    }

    public function getCliente(): ?Cliente
    {
        return $this->cliente;
    }

    public function setCliente(?Cliente $cliente): static
    {
        $this->cliente = $cliente;

        return $this;
    }
}
