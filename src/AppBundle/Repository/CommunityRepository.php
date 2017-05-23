<?php

namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;

class CommunityRepository extends EntityRepository
{
    public function getAllInfoAboutCommunity($id)
    {
        $dql = 'SELECT c, cr, p, t, o FROM AppBundle:Community c
                LEFT JOIN c.creator cr
                LEFT JOIN c.photo p
                LEFT JOIN p.thumbnail t
                LEFT JOIN p.original o
                WHERE c.id = :id';
        $query = $this->getEntityManager()->createQuery($dql)->setParameter('id', $id);
        return $query->getOneOrNullResult();
    }

    public function getCommunityWithMembers($id)
    {
        $dql = 'SELECT c, m, s FROM AppBundle:Community c
                JOIN c.memberships m
                JOIN m.student s
                WHERE c.id = :id';
        $query = $this->getEntityManager()->createQuery($dql)->setParameter('id', $id);
        return $query->getOneOrNullResult();
    }

    public function getCommunities()
    {
        $dql = 'SELECT c, cr FROM AppBundle:Community c
                LEFT JOIN c.creator cr
                ORDER BY c.creationDate DESC';

        $query = $this->getEntityManager()->createQuery($dql);
        return $query->getResult();
    }

    public function getCommunitiesLike($name)
    {
        $dql = 'SELECT c FROM AppBundle:Community c
                WHERE c.name LIKE :name';
        $query = $this->getEntityManager()->createQuery($dql)->setParameter('name', $name);
        return $query->getResult();
    }
}
