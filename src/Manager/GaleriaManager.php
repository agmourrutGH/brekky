<?php

namespace App\Manager;
use App\Entity\Comentario;
use App\Entity\User;
use App\Entity\Galeria;
use App\Entity\Calificacion;
use Doctrine\ORM\EntityManagerInterface;

class GaleriaManager
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function saveGaleria(Galeria $galeria): void
    {
        $this->entityManager->persist($galeria);
        $this->entityManager->flush();
    }

    public function addCalificacion(Calificacion $calificacion): void
    {
        $this->entityManager->persist($calificacion);
        $this->entityManager->flush();
    }

    public function getGalerias(): array
    {
        return $this->entityManager->getRepository(Galeria::class)->findAll();
    }

    public function getCalificaciones(Galeria $galeria): array
    {
        return $this->entityManager->getRepository(Calificacion::class)->findBy(['galeria' => $galeria]);
    }
    public function getGaleriaById(int $id): ?Galeria
    {
        return $this->entityManager->getRepository(Galeria::class)->find($id);
    }
    public function getCalificacionUsuarioEntity(Galeria $galeria, User $user): ?Calificacion
    {
        return $this->entityManager->getRepository(Calificacion::class)
            ->findOneBy(['galeria' => $galeria, 'user' => $user]);
    }

    public function addComentario(Comentario $comentario): void
    {
        $this->entityManager->persist($comentario);
        $this->entityManager->flush();
    }

    public function getComentarios(Galeria $galeria): array
    {
        return $this->entityManager->getRepository(Comentario::class)->findBy(
            ['galeria' => $galeria],
            ['fechaPublicacion' => 'ASC']
        );
    }

    public function eliminarGaleria(Galeria $galeria): void
    {
        // Eliminar las calificaciones relacionadas con la galería
        $calificaciones = $galeria->getCalificaciones();
        foreach ($calificaciones as $calificacion) {
            $this->entityManager->remove($calificacion);
        }
    
        // Luego eliminar los comentarios relacionados con la galería
        $comentarios = $galeria->getComentarios();
        foreach ($comentarios as $comentario) {
            $this->entityManager->remove($comentario);
        }
    
        // Finalmente eliminar la galería
        $this->entityManager->remove($galeria);
        $this->entityManager->flush();
    }
    

    
}
