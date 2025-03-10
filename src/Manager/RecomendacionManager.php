<?php

namespace App\Manager;

use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Recomendacion;

class RecomendacionManager
{
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function obtenerRecomendaciones($tipo = null, $categoria = null, $dias = null)
    {
        $qb = $this->em->getRepository(Recomendacion::class)->createQueryBuilder('r');
    
        if ($tipo) {
            $qb->andWhere('r.tipo = :tipo')
                ->setParameter('tipo', $tipo);
        }
    
        if ($categoria) {
            $qb->andWhere('r.categoria = :categoria')
                ->setParameter('categoria', $categoria);
        }
    
        
        if ($tipo === 'ejercicio' && $dias !== null) {
            $qb->andWhere('r.dias = :dias')
                ->setParameter('dias', $dias);
        }
    
        return $qb->getQuery()->getResult();
    }
    

}
