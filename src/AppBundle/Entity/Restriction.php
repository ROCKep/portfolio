<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Restriction
 *
 * @ORM\Table(name="restriction")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\RestrictionRepository")
 */
class Restriction
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
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Material", mappedBy="restriction")
     */
    private $materials;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Category", mappedBy="restriction")
     */
    private $categories;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\User", mappedBy="restriction")
     */
    private $users;
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->materials = new \Doctrine\Common\Collections\ArrayCollection();
        $this->categories = new \Doctrine\Common\Collections\ArrayCollection();
        $this->users = new \Doctrine\Common\Collections\ArrayCollection();
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
     * @return Restriction
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
     * Add material
     *
     * @param \AppBundle\Entity\Material $material
     *
     * @return Restriction
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
     * Add category
     *
     * @param \AppBundle\Entity\Category $category
     *
     * @return Restriction
     */
    public function addCategory(\AppBundle\Entity\Category $category)
    {
        $this->categories[] = $category;

        return $this;
    }

    /**
     * Remove category
     *
     * @param \AppBundle\Entity\Category $category
     */
    public function removeCategory(\AppBundle\Entity\Category $category)
    {
        $this->categories->removeElement($category);
    }

    /**
     * Get categories
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getCategories()
    {
        return $this->categories;
    }

    /**
     * Add user
     *
     * @param \AppBundle\Entity\User $user
     *
     * @return Restriction
     */
    public function addUser(\AppBundle\Entity\User $user)
    {
        $this->users[] = $user;

        return $this;
    }

    /**
     * Remove user
     *
     * @param \AppBundle\Entity\User $user
     */
    public function removeUser(\AppBundle\Entity\User $user)
    {
        $this->users->removeElement($user);
    }

    /**
     * Get users
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getUsers()
    {
        return $this->users;
    }
}
