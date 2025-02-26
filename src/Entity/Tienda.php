<?php

namespace App\Entity;

use App\Repository\TiendaRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TiendaRepository::class)]
class Tienda
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $Nombre = null;

    #[ORM\Column(type: "decimal", precision: 10, scale: 7)]
    private ?float $Latitud = null;

    #[ORM\Column(type: "decimal", precision: 10, scale: 7)]
    private ?float $Longitud = null;


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNombre(): ?string
    {
        return $this->Nombre;
    }

    public function setNombre(string $Nombre): static
    {
        $this->Nombre = $Nombre;

        return $this;
    }

    public function getLatitud(): ?float
    {
        return $this->Latitud;
    }
    
    public function setLatitud(float $Latitud): static
    {
        $this->Latitud = $Latitud;
        return $this;
    }
    
    public function getLongitud(): ?float
    {
        return $this->Longitud;
    }
    
    public function setLongitud(float $Longitud): static
    {
        $this->Longitud = $Longitud;
        return $this;
    }
    
}
