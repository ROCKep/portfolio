<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Category
 *
 * @ORM\Table(name="category")
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
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\User", inversedBy="categories")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    private $user;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Community", inversedBy="categories")
     * @ORM\JoinColumn(name="community_id", referencedColumnName="id")
     */
    private $community;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Material", mappedBy="category")
     */
    private $materials;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Restriction", inversedBy="categories")
     * @ORM\JoinColumn(name="restriction_id", referencedColumnName="id")
     */
    private $restriction;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Category", mappedBy="parent")
     */
    private $children;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Category", inversedBy="children")
     * @ORM\JoinColumn(name="parent_id", referencedColumnName="id")
     */
    private $parent;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->materials = new \Doctrine\Common\Collections\ArrayCollection();
        $this->children = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return Category
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set user
     *
     * @param \AppBundle\Entity\User $user
     *
     * @return Category
     */
    public function setUser(\AppBundle\Entity\User $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \AppBundle\Entity\User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set community
     *
     * @param \AppBundle\Entity\Community $community
     *
     * @return Category
     */
    public function setCommunity(\AppBundle\Entity\Community $community = null)
    {
        $this->community = $community;

        return $this;
    }

    /**
     * Get community
     *
     * @return \AppBundle\Entity\Community
     */
    public function getCommunity()
    {
        return $this->community;
    }

    /**
     * Add material
     *
     * @param \AppBundle\Entity\Material $material
     *
     * @return Category
     */
    public function addMaterial(\AppBundle\Entity\Material $material)
    {
        $this->materials[] = $material;

        return $this;
    }

    /**
     * Remove material
     *
     * @param \AppBundle\Entity\Material $material
     */
    public function removeMaterial(\AppBundle\Entity\Material $material)
    {
        $this->materials->removeElement($material);
    }

    /**
     * Get materials
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getMaterials()
    {
        return $this->materials;
    }

    /**
     * Set restriction
     *
     * @param \AppBundle\Entity\Restriction $restriction
     *
     * @return Category
     */
    public function setRestriction(\AppBundle\Entity\Restriction $restriction = null)
    {
        $this->restriction = $restriction;

        return $this;
    }

    /**
     * Get restriction
     *
     * @return \AppBundle\Entity\Restriction
     */
    public function getRestriction()
    {
        return $this->restriction;
    }

    /**
     * Add child
     *
     * @param \AppBundle\Entity\Category $child
     *
     * @return Category
     */
    public function addChild(\AppBundle\Entity\Category $child)
    {
        $this->children[] = $child;

        return $this;
    }

    /**
     * Remove child
     *
     * @param \AppBundle\Entity\Category $child
     */
    public function removeChild(\AppBundle\Entity\Category $child)
    {
        $this->children->removeElement($child);
    }

    /**
     * Get children
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getChildren()
    {
        return $this->children;
    }

    /**
     * Set parent
     *
     * @param \AppBundle\Entity\Category $parent
     *
     * @return Category
     */
    public function setParent(\AppBundle\Entity\Category $parent = null)
    {
        $this->parent = $parent;

        return $this;
    }

    /**
     * Get parent
     *
     * @return \AppBundle\Entity\Category
     */
    public function getParent()
    {
        return $this->parent;
    }
}
