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
     * @ORM\Column(name="semester", type="integer")
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
     * @ORM\OneToMany(targetEntity="Student", mappedBy="group")
     */
    private $students;

    /**
     * @ORM\ManyToOne(targetEntity="Department", inversedBy="groups")
     */
    private $department;

    /**
     * @ORM\ManyToOne(targetEntity="Course")
     * @ORM\JoinColumn(onDelete="SET NULL")
     */
    private $course;


    public function __construct()
    {
        $this->students = new \Doctrine\Common\Collections\ArrayCollection();
    }

    public function getId()
    {
        return $this->id;
    }

    public function setNumber($number)
    {
        $this->number = $number;
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
    }

    public function getStartYear()
    {
        return $this->startYear;
    }

    public function setEndYear($endYear)
    {
        $this->endYear = $endYear;
    }

    public function getEndYear()
    {
        return $this->endYear;
    }


    public function setDepartment(Department $department = null)
    {
        $this->department = $department;
    }

    public function getDepartment()
    {
        return $this->department;
    }

    public function addStudent(Student $student)
    {
        $this->students[] = $student;
    }

    public function removeStudent(Student $student)
    {
        $this->students->removeElement($student);
    }

    public function getStudents()
    {
        return $this->students;
    }

    public function setCourse(Course $course = null)
    {
        $this->course = $course;
    }

    public function getCourse()
    {
        return $this->course;
    }
}
