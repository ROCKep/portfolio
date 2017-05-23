<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
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
     */
    private $faculty;

    /**
     * @ORM\OneToMany(targetEntity="Group", mappedBy="department", cascade={"remove"})
     */
    private $groups;


    public function __construct()
    {
        $this->groups = new ArrayCollection();
    }

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

    public function setNumber($number)
    {
        $this->number = $number;
    }

    public function getNumber()
    {
        return $this->number;
    }


    public function setFaculty(Faculty $faculty = null)
    {
        $this->faculty = $faculty;
    }

    public function getFaculty()
    {
        return $this->faculty;
    }

    public function addGroup(Group $group)
    {
        $this->groups[] = $group;
    }

    public function removeGroup(Group $group)
    {
        $this->groups->removeElement($group);
    }

    public function getGroups()
    {
        return $this->groups;
    }
}