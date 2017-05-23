<?php

namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;

class FacultyRepository extends EntityRepository
{
    public function getFaculties()
    {
        $dql = 'SELECT f FROM AppBundle:Faculty f
                ORDER BY f.name ASC';
        $query = $this->getEntityManager()->createQuery($dql);
        return $query->getResult();
    }

    public function getFacultyWithDepartments($id)
    {
        $dql = 'SELECT f, d FROM AppBundle:Faculty f
                LEFT JOIN f.departments d
                WHERE f.id = :id
                ORDER BY d.number ASC';
        $query = $this->getEntityManager()->createQuery($dql)->setParameter('id', $id);
        return $query->getOneOrNullResult();
    }
}
