<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="AppBundle\Repository\FacultyRepository")
 * @ORM\Table(name="faculties")
 */
class Faculty
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(type="string")
     * @Assert\NotBlank()
     */
    private $name;

    /**
     * @ORM\Column(type="string")
     */
    private $abbr;


    /**
     * @ORM\OneToMany(targetEntity="Department", mappedBy="faculty", cascade={"remove"})
     */
    private $departments;


    public function __construct()
    {
        $this->departments = new ArrayCollection();
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

    public function setAbbr($abbr)
    {
        $this->abbr = $abbr;
    }

    public function getAbbr()
    {
        return $this->abbr;
    }


    public function addDepartment(Department $department)
    {
        $this->departments[] = $department;
    }

    public function removeDepartment(Department $department)
    {
        $this->departments->removeElement($department);
    }

    public function getDepartments()
    {
        return $this->departments;
    }
}