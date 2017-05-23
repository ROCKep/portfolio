<?php

namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;

class MessageRepository extends EntityRepository
{
    public function getChats($id)
    {

        $dql = 'SELECT s FROM AppBundle:Student s
                LEFT JOIN s.messagesSent ms
                LEFT JOIN s.messagesReceived mr
                WHERE ms.receiver = :id OR mr.sender = :id';
        $query = $this->getEntityManager()->createQuery($dql)
            ->setParameter('id', $id);
        return $query->getResult();
    }

    public function getAllMessagesWithFellow($student_id, $fellow_id)
    {
        $dql = 'SELECT m, s, sa, sat, r, ra, rat FROM AppBundle:Message m
                JOIN m.sender s
                LEFT JOIN s.avatar sa
                LEFT JOIN sa.thumbnail sat
                JOIN m.receiver r
                LEFT JOIN r.avatar ra
                LEFT JOIN ra.thumbnail rat
                WHERE (s.id = :student_id AND r.id = :fellow_id)
                OR (s.id = :fellow_id AND r.id = :student_id)
                ORDER BY m.time ASC';
        $query = $this->getEntityManager()->createQuery($dql)
            ->setParameter('student_id', $student_id)
            ->setParameter('fellow_id', $fellow_id);
        return $query->getResult();
    }
}
