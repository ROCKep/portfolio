<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="categories")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\CategoryRepository")
 */
class Category
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
     * @ORM\Column(name="created_date", type="date")
     */
    private $createdDate;


    /**
     * @ORM\ManyToOne(targetEntity="Student", inversedBy="categories")
     */
    private $student;

    /**
     * @ORM\ManyToOne(targetEntity="Community", inversedBy="categories")
     * @ORM\JoinColumn(onDelete="SET NULL")
     */
    private $community;

    /**
     * @ORM\OneToMany(targetEntity="Material", mappedBy="category", cascade={"remove"})
     */
    private $materials;

    /**
     * @ORM\ManyToOne(targetEntity="Restriction")
     */
    private $restriction;

    /**
     * @ORM\OneToMany(targetEntity="Category", mappedBy="parent", cascade={"remove"})
     */
    private $children;

    /**
     * @ORM\ManyToOne(targetEntity="Category", inversedBy="children")
     */
    private $parent;


    public function __construct()
    {
        $this->materials = new ArrayCollection();
        $this->children = new ArrayCollection();
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

    public function getCreatedDate()
    {
        return $this->createdDate;
    }

    public function setCreatedDate()
    {
        $this->createdDate = new \DateTime();
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

    public function addMaterial(Material $material)
    {
        $this->materials[] = $material;
    }

    public function removeMaterial(Material $material)
    {
        $this->materials->removeElement($material);
    }

    public function getMaterials()
    {
        return $this->materials;
    }

    public function setRestriction(Restriction $restriction = null)
    {
        $this->restriction = $restriction;
    }

    public function getRestriction()
    {
        return $this->restriction;
    }

    public function addChild(Category $child)
    {
        $this->children[] = $child;
    }

    public function removeChild(Category $child)
    {
        $this->children->removeElement($child);
    }

    public function getChildren()
    {
        return $this->children;
    }

    public function setParent(Category $parent = null)
    {
        $this->parent = $parent;
    }

    public function getParent()
    {
        return $this->parent;
    }
}