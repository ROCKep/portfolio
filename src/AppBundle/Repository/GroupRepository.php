<?php

namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;

class GroupRepository extends EntityRepository
{
    public function getGroupWithDepartment($id)
    {
        $dql = 'SELECT g, d FROM AppBundle:Group g
                JOIN g.department d
                WHERE g.id = :id';
        $query = $this->getEntityManager()->createQuery($dql)->setParameter('id', $id);
        return $query->getOneOrNullResult();
    }

    public function getGroupWithStudents($id)
    {
        $dql = 'SELECT g, s, a, d, f FROM AppBundle:Group g
                LEFT JOIN g.students s
                LEFT JOIN s.account a
                JOIN g.department d
                JOIN d.faculty f
                WHERE g.id = :id
                ORDER BY s.lastName ASC, s.firstName ASC';
        $query = $this->getEntityManager()->createQuery($dql)->setParameter('id', $id);
        return $query->getOneOrNullResult();
    }
}
