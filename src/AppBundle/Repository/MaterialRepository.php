<?php

namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;

class MaterialRepository extends EntityRepository
{
    public function getMaterialWithAuthor($id)
    {
        $dql = 'SELECT m, a FROM AppBundle:Material m
                JOIN m.author a
                WHERE m.id = :id';
        $query = $this->getEntityManager()->createQuery($dql)->setParameter('id', $id);
        return $query->getOneOrNullResult();
    }
}