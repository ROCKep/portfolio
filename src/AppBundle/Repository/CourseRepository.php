<?php

namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;

class CourseRepository extends EntityRepository
{
    public function getCourses()
    {
        $dql = 'SELECT c from AppBundle:Course c
                ORDER BY c.name ASC';
        $query = $this->getEntityManager()->createQuery($dql);
        return $query->getResult();
    }
}
