<?php

// src/Entity/Recomendacion.php
namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
class Recomendacion
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id = null;

    #[ORM\Column(type: 'string', length: 50)]
    private string $tipo;

    #[ORM\Column(type: 'text')]
    private string $contenido;

    #[ORM\Column(length: 255)]
    private ?string $categoria = null;

    #[ORM\Column]
    private ?int $dias = null;

    // Getters y setters
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTipo(): string
    {
        return $this->tipo;
    }

    public function setTipo(string $tipo): self
    {
        $this->tipo = $tipo;
        return $this;
    }

    public function getContenido(): string
    {
        return $this->contenido;
    }

    public function setContenido(string $contenido): self
    {
        $this->contenido = $contenido;
        return $this;
    }

    public function getCategoria(): ?string
    {
        return $this->categoria;
    }

    public function setCategoria(string $categoria): static
    {
        $this->categoria = $categoria;

        return $this;
    }

    public function getDias(): ?int
    {
        return $this->dias;
    }

    public function setDias(int $dias): static
    {
        $this->dias = $dias;

        return $this;
    }
}