<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="jobs")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\JobRepository")
 */
class Job
{
    /**
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(name="name", type="string")
     */
    private $name;

    /**
     * @ORM\Column(name="occupation", type="string")
     */
    private $occupation;

    /**
     * @ORM\Column(name="start_date", type="date")
     */
    private $startDate;

    /**
     * @ORM\Column(name="end_date", type="date", nullable=true)
     */
    private $endDate;


    /**
     * @ORM\ManyToOne(targetEntity="Student", inversedBy="jobs")
     * @ORM\JoinColumn(onDelete="CASCADE")
     */
    private $student;


    public function getId()
    {
        return $this->id;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setOccupation($occupation)
    {
        $this->occupation = $occupation;
    }

    public function getOccupation()
    {
        return $this->occupation;
    }

    public function setStartDate($startDate)
    {
        $this->startDate = $startDate;
    }

    public function getStartDate()
    {
        return $this->startDate;
    }

    public function setEndDate($endDate)
    {
        $this->endDate = $endDate;
    }

    public function getEndDate()
    {
        return $this->endDate;
    }

    public function setStudent(Student $student = null)
    {
        $this->student = $student;
    }

    public function getStudent()
    {
        return $this->student;
    }
}
