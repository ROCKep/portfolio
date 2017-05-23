<?php

namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;

class StudentRepository extends EntityRepository
{
    public function getAllInfoAboutStudent($id)
    {
        $dql = 'SELECT s, g, c, d, f, j, a, orig, thumb
                FROM AppBundle:Student s
                JOIN s.group g
                JOIN g.course c
                JOIN g.department d
                JOIN d.faculty f
                LEFT JOIN s.jobs j
                LEFT JOIN s.avatar a
                LEFT JOIN a.original orig
                LEFT JOIN a.thumbnail thumb
                WHERE s.id = :id';
        $query = $this->getEntityManager()->createQuery($dql)->setParameter('id', $id);
        return $query->getOneOrNullResult();
    }

    public function getMembersOfCommunity($id)
    {
        $dql = 'SELECT s FROM AppBundle:Student s
                JOIN s.memberships m
                JOIN m.community c
                WHERE c.id = :id';
        $query = $this->getEntityManager()->createQuery($dql)->setParameter('id', $id);
        return $query->getResult();
    }

    public function getStudentWithMemberships($id)
    {
        $dql = 'SELECT s, m, c FROM AppBundle:Student s
                LEFT JOIN s.memberships m
                LEFT JOIN m.community c
                WHERE s.id = :id
                ORDER BY c.name ASC';
        $query = $this->getEntityManager()->createQuery($dql)->setParameter('id', $id);
        return $query->getOneOrNullResult();
    }

    public function getStudentWithGroup($id)
    {
        $dql = 'SELECT s, g FROM AppBundle:Student s
                JOIN s.group g
                WHERE s.id = :id';
        $query = $this->getEntityManager()->createQuery($dql)->setParameter('id', $id);
        return $query->getOneOrNullResult();
    }

    public function getInactiveStudents()
    {
        $dql = 'SELECT s FROM AppBundle:Student s
                WHERE s.isActive = FALSE
                ORDER BY s.signupDate ASC';
        $query = $this->getEntityManager()->createQuery($dql);
        return $query->getResult();
    }

    public function getStudentsLike($name)
    {
        $dql = 'SELECT s FROM AppBundle:Student s
                WHERE CONCAT(s.lastName, \' \', s.firstName) LIKE :name';
        $query = $this->getEntityManager()->createQuery($dql)->setParameter('name', $name);
        return $query->getResult();
    }
}