<?php

namespace App\Entity;

use App\Repository\GaleriaRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: GaleriaRepository::class)]
class Galeria
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'galerias')]
    private ?User $user = null;

    #[ORM\Column(length: 255)]
    private ?string $imagen = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $descripcion = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $fechaPublicacion = null;

    /**
     * @var Collection<int, Calificacion>
     */
    #[ORM\OneToMany(targetEntity: Calificacion::class, mappedBy: 'galeria')]
    private Collection $calificacion;

    /**
     * @var Collection<int, Comentario>
     */
    #[ORM\OneToMany(targetEntity: Comentario::class, mappedBy: 'galeria')]
    private Collection $comentarios;



    public function __construct()
    {
        $this->calificacion = new ArrayCollection();
        $this->comentarios = new ArrayCollection();
    }

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

    public function getImagen(): ?string
    {
        return $this->imagen;
    }

    public function setImagen(string $imagen): static
    {
        $this->imagen = $imagen;

        return $this;
    }

    public function getDescripcion(): ?string
    {
        return $this->descripcion;
    }

    public function setDescripcion(string $descripcion): static
    {
        $this->descripcion = $descripcion;

        return $this;
    }

    public function getFechaPublicacion(): ?\DateTimeInterface
    {
        return $this->fechaPublicacion;
    }

    public function setFechaPublicacion(\DateTimeInterface $fechaPublicacion): static
    {
        $this->fechaPublicacion = $fechaPublicacion;

        return $this;
    }

    /**
     * @return Collection<int, Calificacion>
     */
    public function getCalificaciones(): Collection
    {
        return $this->calificacion;
    }

    public function addCalificacion(Calificacion $calificacion): self
    {
        if (!$this->calificacion->contains($calificacion)) {
            $this->calificacion[] = $calificacion;
            $calificacion->setGaleria($this);
        }
        return $this;
    }

    public function removeCalificacion(Calificacion $calificacion): self
    {
        if ($this->calificacion->removeElement($calificacion)) {
            if ($calificacion->getGaleria() === $this) {
                $calificacion->setGaleria(null);
            }
        }
        return $this;
    }

    /**
     * @return Collection<int, Comentario>
     */
    public function getComentarios()
    {
        return $this->comentarios;
    }

    public function addComentario(Comentario $comentario): static
    {
        if (!$this->comentarios->contains($comentario)) {
            $this->comentarios->add($comentario);
            $comentario->setGaleria($this);
        }

        return $this;
    }

    public function removeComentario(Comentario $comentario): static
    {
        if ($this->comentarios->removeElement($comentario)) {
            if ($comentario->getGaleria() === $this) {
                $comentario->setGaleria(null);
            }
        }

        return $this;
    }
}
