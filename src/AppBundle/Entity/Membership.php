<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="memberships")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\MembershipRepository")
 */
class Membership
{
    /**
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(name="entry_date", type="date")
     */
    private $entryDate;

    /**
     * @ORM\ManyToOne(targetEntity="Student", inversedBy="memberships")
     * @ORM\JoinColumn(onDelete="CASCADE")
     */
    private $student;

    /**
     * @ORM\ManyToOne(targetEntity="Community", inversedBy="memberships")
     * @ORM\JoinColumn(onDelete="CASCADE")
     */
    private $community;


    public function getId()
    {
        return $this->id;
    }

    public function setEntryDate()
    {
        $this->entryDate = new \DateTime();
    }

    public function getEntryDate()
    {
        return $this->entryDate;
    }


    public function setStudent(Student $student = null)
    {
        $this->student = $student;
    }

    public function getStudent()
    {
        return $this->student;
    }

    public function setCommunity(Community $community = null)
    {
        $this->community = $community;
    }

    public function getCommunity()
    {
        return $this->community;
    }
}
