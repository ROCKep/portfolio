<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="departments")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\DepartmentRepository")
 */
class Department
{
    /**
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(name="name", type="string", unique=true)
     */
    private $name;

    /**
     * @ORM\Column(name="number", type="string")
     */
    private $number;


    /**
     * @ORM\ManyToOne(targetEntity="Faculty", inversedBy="departments")
     * @ORM\JoinColumn(name="faculty_id", referencedColumnName="id")
     */
    private $faculty;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Group", mappedBy="department")
     */
    private $groups;


    public function __construct()
    {
        $this->groups = new \Doctrine\Common\Collections\ArrayCollection();
    }

    public function getId()
    {
        return $this->id;
    }

    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    public function getName()
    {
        return $this->name;
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


    public function setFaculty(\AppBundle\Entity\Faculty $faculty = null)
    {
        $this->faculty = $faculty;
        return $this;
    }

    public function getFaculty()
    {
        return $this->faculty;
    }

    public function addGroup(\AppBundle\Entity\Group $group)
    {
        $this->groups[] = $group;
        return $this;
    }

    public function removeGroup(\AppBundle\Entity\Group $group)
    {
        $this->groups->removeElement($group);
    }

    public function getGroups()
    {
        return $this->groups;
    }
}