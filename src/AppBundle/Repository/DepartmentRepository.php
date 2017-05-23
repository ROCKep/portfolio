<?php

namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;

class DepartmentRepository extends EntityRepository
{
    public function getDepartmentWithFaculty($id)
    {
        $dql = 'SELECT d, f FROM AppBundle:Department d
                JOIN d.faculty f
                WHERE d.id = :id';
        $query = $this->getEntityManager()->createQuery($dql)->setParameter('id', $id);
        return $query->getOneOrNullResult();
    }

    public function getDepartmentWithGroupsAndFaculty($id)
    {
        $dql = 'SELECT d, g, f FROM AppBundle:Department d
                LEFT JOIN d.groups g
                JOIN d.faculty f
                WHERE d.id = :id
                ORDER BY g.semester ASC, g.number ASC';
        $query = $this->getEntityManager()->createQuery($dql)->setParameter('id', $id);
        return $query->getOneOrNullResult();
    }
}
