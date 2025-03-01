<?php

namespace App\Entity;

use App\Repository\CalificacionRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CalificacionRepository::class)]
class Calificacion
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'calificacion')]
    private ?User $user = null;

    #[ORM\ManyToOne(inversedBy: 'calificacion')]
    private ?Galeria $galeria = null;

    #[ORM\Column]
    private ?int $puntuacion = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): static
    {
        $this->user = $user;

        return $this;
    }

    public function getGaleria(): ?Galeria
    {
        return $this->galeria;
    }

    public function setGaleria(?Galeria $galeria): static
    {
        $this->galeria = $galeria;

        return $this;
    }

    public function getPuntuacion(): ?int
    {
        return $this->puntuacion;
    }

    public function setPuntuacion(int $puntuacion): self
    {
        if ($puntuacion < 1 || $puntuacion > 5) {
            throw new \InvalidArgumentException("La puntuación debe estar entre 1 y 5.");
        }
        $this->puntuacion = $puntuacion;
        return $this;
    }
}
