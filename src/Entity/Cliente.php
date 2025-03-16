<?php

namespace App\Entity;

use App\Repository\ClienteRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ClienteRepository::class)]
class Cliente
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nombre = null;

    #[ORM\Column(length: 255)]
    private ?string $email = null;

    #[ORM\Column(length: 255)]
    private ?string $telefono = null;

    #[ORM\Column(length: 255)]
    private ?string $direccion = null;

    /**
     * @var Collection<int, Poliza>
     */
    #[ORM\OneToMany(targetEntity: Poliza::class, mappedBy: 'cliente', orphanRemoval: true)]
    private Collection $polizas;

    #[ORM\OneToOne(mappedBy: 'cliente', cascade: ['persist', 'remove'])]
    private ?Usuario $clienteUsuario = null;

    public function __construct()
    {
        $this->polizas = new ArrayCollection();
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNombre(): ?string
    {
        return $this->nombre;
    }

    public function setNombre(string $nombre): static
    {
        $this->nombre = $nombre;

        return $this;
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

    public function getTelefono(): ?string
    {
        return $this->telefono;
    }

    public function setTelefono(string $telefono): static
    {
        $this->telefono = $telefono;

        return $this;
    }

    public function getDireccion(): ?string
    {
        return $this->direccion;
    }

    public function setDireccion(string $direccion): static
    {
        $this->direccion = $direccion;

        return $this;
    }

    /**
     * @return Collection<int, Poliza>
     */
    public function getPolizas(): Collection
    {
        return $this->polizas;
    }

    public function addPoliza(Poliza $poliza): static
    {
        if (!$this->polizas->contains($poliza)) {
            $this->polizas->add($poliza);
            $poliza->setCliente($this);
        }

        return $this;
    }

    public function removePoliza(Poliza $poliza): static
    {
        if ($this->polizas->removeElement($poliza)) {
            // set the owning side to null (unless already changed)
            if ($poliza->getCliente() === $this) {
                $poliza->setCliente(null);
            }
        }

        return $this;
    }

    public function getClienteUsuario(): ?Usuario
    {
        return $this->clienteUsuario;
    }

    public function setClienteUsuario(Usuario $clienteUsuario): static
    {
        // set the owning side of the relation if necessary
        if ($clienteUsuario->getCliente() !== $this) {
            $clienteUsuario->setCliente($this);
        }

        $this->clienteUsuario = $clienteUsuario;

        return $this;
    }

}
