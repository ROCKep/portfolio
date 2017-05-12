<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Table(name="groups")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\GroupRepository")
 */
class Group
{
    /**
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(name="number", type="string")
     */
    private $number;

    /**
     * @ORM\Column(name="semester", type="integer", nullable=true)
     */
    private $semester;

    /**
     * @ORM\Column(name="start_year", type="date")
     */
    private $startYear;

    /**
     * @ORM\Column(name="end_year", type="date")
     */
    private $endYear;


    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\User", mappedBy="group")
     */
    private $users;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Department", inversedBy="groups")
     * @ORM\JoinColumn(name="department_id", referencedColumnName="id")
     */
    private $department;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Course", inversedBy="groups")
     * @ORM\JoinColumn(name="course_id", referencedColumnName="id")
     */
    private $course;


    public function __construct()
    {
        $this->users = new \Doctrine\Common\Collections\ArrayCollection();
    }

    public function getId()
    {
        return $this->id;
    }

    public function setNumber($number)
    {
        $this->number = $number;

        return $this;
    }

    public function getNumber()
    {
        return $this->number;
    }

    public function getSemester()
    {
        return $this->semester;
    }

    public function setSemester($semester)
    {
        $this->semester = $semester;
    }

    public function setStartYear($startYear)
    {
        $this->startYear = $startYear;

        return $this;
    }

    public function getStartYear()
    {
        return $this->startYear;
    }

    public function setEndYear($endYear)
    {
        $this->endYear = $endYear;

        return $this;
    }

    public function getEndYear()
    {
        return $this->endYear;
    }


    public function setDepartment(\AppBundle\Entity\Department $department = null)
    {
        $this->department = $department;

        return $this;
    }

    public function getDepartment()
    {
        return $this->department;
    }

    public function addUser(\AppBundle\Entity\User $user)
    {
        $this->users[] = $user;

        return $this;
    }

    public function removeUser(\AppBundle\Entity\User $user)
    {
        $this->users->removeElement($user);
    }

    public function getUsers()
    {
        return $this->users;
    }

    public function setCourse(\AppBundle\Entity\Course $course = null)
    {
        $this->course = $course;

        return $this;
    }

    public function getCourse()
    {
        return $this->course;
    }
}
