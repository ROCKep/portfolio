<?php

namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query\ResultSetMapping;

class CategoryRepository extends EntityRepository
{
    public function findRootByUserId($id)
    {
        $query = $this->getEntityManager()
            ->createQuery(
                'SELECT c, u FROM AppBundle:Category c
                  JOIN c.user u
                  WHERE u.id = :id AND c.parent IS NULL'
            )->setParameter('id', $id);
        try
        {
            return $query->getSingleResult();
        }
        catch (\Doctrine\ORM\NoResultException $e)
        {
            return null;
        }
    }

    public function getBreadcrumbs($id)
    {
        $rsm = new ResultSetMapping();
        $rsm->addEntityResult('AppBundle:Category', 'c');
        $rsm->addFieldResult('c', 'id', 'id');
        $rsm->addFieldResult('c', 'name', 'name');

        $query = $this->getEntityManager()->createNativeQuery("
            WITH RECURSIVE tree(id, name, parent_id) AS (
                SELECT c.id, c.name, c.parent_id
                FROM categories c
                WHERE c.id = ?
                UNION ALL
                SELECT c.id, c.name, c.parent_id
                FROM categories c
                JOIN tree t ON (c.id = t.parent_id)
            )
            SELECT id, name
            FROM tree;", $rsm);
        $query->setParameter(1, $id);
        $result = $query->getResult();
        return array_reverse($result);
    }
}
